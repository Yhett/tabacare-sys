<?php

namespace Tests\Feature;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReportGenerateTest extends TestCase
{
    use RefreshDatabase;

    private function workerSession(): array
    {
        return [
            'user' => 'juan',
            'id' => 1,
            'role' => 'health_worker',
            'barangay' => 'Agnas',
        ];
    }

    private function makeWorker(): User
    {
        return User::create([
            'name' => 'Juan Dela Cruz',
            'username' => 'juan',
            'email' => 'juan@tabacare.local',
            'password' => 'secret-password',
            'role' => 'health_worker',
            'barangay' => 'Agnas',
        ]);
    }

    public function test_create_page_loads(): void
    {
        $this->withSession($this->workerSession())
            ->get(route('reports.create'))
            ->assertOk()
            ->assertSee('Generate barangay report');
    }

    public function test_generate_monthly_report_shows_preview(): void
    {
        $worker = $this->makeWorker();

        Patient::create([
            'patient_code' => 'P-001',
            'disease' => 'Influenza',
            'date_onset' => now()->toDateString(),
            'address' => 'Agnas',
            'age' => 25,
            'age_unit' => 'years',
            'gender' => 'Male',
            'added_by' => $worker->id,
        ]);

        $this->withSession($this->workerSession())
            ->post(route('reports.generate'), [
                'prepared_by' => 'Juan Dela Cruz',
                'period_type' => 'monthly',
                'month' => now()->month,
            ])
            ->assertOk()
            ->assertSee('report generated successfully')
            ->assertSee('1 case(s) found');
    }

    public function test_generate_requires_prepared_by(): void
    {
        $this->withSession($this->workerSession())
            ->from(route('reports.create'))
            ->post(route('reports.generate'), [
                'period_type' => 'monthly',
                'month' => now()->month,
            ])
            ->assertRedirect(route('reports.create'))
            ->assertSessionHasErrors('prepared_by');
    }

    public function test_download_excel_contains_mso_freeze_panes(): void
    {
        $response = $this->withSession($this->workerSession())->post(route('reports.download'), [
            'prepared_by' => 'Juan Dela Cruz',
            'period_type' => 'monthly',
            'month' => now()->month,
        ]);

        $response->assertOk()
            ->assertHeader('Content-Type', 'application/vnd.ms-excel; charset=UTF-8')
            ->assertHeader('Content-Disposition')
            ->assertSee('<x:Selected/>', false)
            ->assertSee('<x:FreezePanes/>', false)
            ->assertSee('FHSIS REPORT for the', false)
            ->assertSee(strtoupper(now()->format('F')), false);
    }

    public function test_download_excel_annual_period(): void
    {
        $this->withSession($this->workerSession())
            ->post(route('reports.download'), [
                'prepared_by' => 'Juan Dela Cruz',
                'period_type' => 'annual',
            ])
            ->assertOk()
            ->assertSee('ANNUAL', false);
    }

    public function test_generate_report_requires_health_worker_session(): void
    {
        $this->post(route('reports.generate'), [
            'prepared_by' => 'Someone',
            'period_type' => 'monthly',
            'month' => now()->month,
        ])->assertForbidden();
    }
}
