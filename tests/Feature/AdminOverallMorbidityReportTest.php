<?php

namespace Tests\Feature;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminOverallMorbidityReportTest extends TestCase
{
    use RefreshDatabase;

    private function makeAdmin(): User
    {
        return User::create([
            'name' => 'Administrator',
            'username' => 'administrator',
            'email' => 'administrator@tabacare.local',
            'password' => 'secret-password',
            'role' => 'admin',
        ]);
    }

    private function makePatient(User $admin, string $code, string $disease, string $barangay, string $onset): void
    {
        Patient::create([
            'patient_code' => $code,
            'disease' => $disease,
            'date_onset' => $onset,
            'address' => $barangay,
            'age' => 25,
            'age_unit' => 'years',
            'gender' => 'Male',
            'added_by' => $admin->id,
        ]);
    }

    public function test_admin_can_export_citywide_monthly_morbidity_in_barangay_workbook_format(): void
    {
        $admin = $this->makeAdmin();
        $this->makePatient($admin, 'P-001', 'Influenza', 'Agnas', now()->startOfMonth()->addDays(2)->toDateString());
        $this->makePatient($admin, 'P-002', 'Influenza', 'Fatima', now()->startOfMonth()->addDays(4)->toDateString());
        $this->makePatient($admin, 'P-003', 'Influenza', 'Basud', now()->subMonth()->startOfMonth()->addDays(2)->toDateString());

        $this->withSession(['user' => 'Administrator', 'id' => $admin->id, 'role' => 'admin'])
            ->get(route('admin.reports.overall-export', [
                'period_type' => 'monthly',
                'month' => now()->month,
            ]))
            ->assertOk()
            ->assertHeader('Content-Type', 'application/vnd.ms-excel; charset=UTF-8')
            ->assertHeader('Content-Disposition')
            ->assertSee('FHSIS REPORT for the', false)
            ->assertSee('All Barangays')
            ->assertSee('Male', false)
            ->assertSee('Female', false)
            ->assertSee('<td class="grand-total">2</td>', false)
            ->assertDontSee('<td class="grand-total">3</td>', false);
    }

    public function test_admin_reports_page_offers_overall_export_and_annual_format(): void
    {
        $admin = $this->makeAdmin();
        $session = ['user' => 'Administrator', 'id' => $admin->id, 'role' => 'admin'];

        $this->withSession($session)
            ->get(route('admin.reports'))
            ->assertOk()
            ->assertSee('Export overall morbidity report')
            ->assertSee(route('admin.reports.overall-export'), false)
            ->assertSee('target="exportFrame"', false)
            ->assertSee('id="exportFrame"', false);

        $this->withSession($session)
            ->get(route('admin.reports.overall-export', ['period_type' => 'annual']))
            ->assertOk()
            ->assertSee('ANNUAL', false)
            ->assertSee('All Barangays');
    }

    public function test_overall_morbidity_export_requires_admin_session(): void
    {
        $this->get(route('admin.reports.overall-export', [
            'period_type' => 'monthly',
            'month' => now()->month,
        ]))->assertForbidden();
    }
}
