<?php

namespace Tests\Feature;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminStatisticsPercentageTest extends TestCase
{
    use RefreshDatabase;

    private function adminSession(): array
    {
        return [
            'user' => 'Administrator',
            'id' => 1,
            'role' => 'admin',
        ];
    }

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

    private function makePatient(User $admin, string $code, string $barangay, string $onset): Patient
    {
        return Patient::create([
            'patient_code' => $code,
            'disease' => 'Influenza',
            'date_onset' => $onset,
            'address' => $barangay,
            'age' => 25,
            'age_unit' => 'years',
            'gender' => 'Male',
            'added_by' => $admin->id,
        ]);
    }

    /**
     * The reported bug: with 3 cases last month and the top-ranked barangay
     * also on 3 cases, the card rendered -100% because it compared the
     * city-wide current month (0 cases) against last month instead of the two
     * numbers it actually displays.
     */
    public function test_highest_case_barangay_percentage_matches_displayed_figures(): void
    {
        $admin = $this->makeAdmin();

        // Three cases last month => the "3 cases last month" subtext.
        $this->makePatient($admin, 'P-001', 'Bombon', now()->subMonth()->startOfMonth()->addDays(2)->toDateString());
        $this->makePatient($admin, 'P-002', 'Basud', now()->subMonth()->startOfMonth()->addDays(5)->toDateString());
        $this->makePatient($admin, 'P-003', 'Bognabong', now()->subMonth()->startOfMonth()->addDays(9)->toDateString());

        // Fatima leads the ranking on 3 cases (all-time), matching the subtext.
        $this->makePatient($admin, 'P-004', 'Fatima', now()->subMonths(6)->toDateString());
        $this->makePatient($admin, 'P-005', 'Fatima', now()->subMonths(5)->toDateString());
        $this->makePatient($admin, 'P-006', 'Fatima', now()->subMonths(4)->toDateString());

        $response = $this->withSession($this->adminSession())
            ->get(route('admin.statistics'));

        $response->assertOk();
        $response->assertSee('Highest-case barangays');
        $response->assertSee('3 cases last month');
        // (3 - 3) / 3 * 100 = 0% — must not render -100%.
        $response->assertSee('<strong>0%</strong>', false);
        $response->assertDontSee('<strong>-100%</strong>', false);
    }

    public function test_percentage_is_positive_when_top_barangay_exceeds_last_month(): void
    {
        $admin = $this->makeAdmin();

        // Exactly one case last month.
        $this->makePatient($admin, 'P-101', 'Bombon', now()->subMonth()->startOfMonth()->addDays(2)->toDateString());

        // Fatima on 4 cases, all older than last month.
        $this->makePatient($admin, 'P-102', 'Fatima', now()->subMonths(6)->toDateString());
        $this->makePatient($admin, 'P-103', 'Fatima', now()->subMonths(5)->toDateString());
        $this->makePatient($admin, 'P-104', 'Fatima', now()->subMonths(4)->toDateString());
        $this->makePatient($admin, 'P-105', 'Fatima', now()->subMonths(3)->toDateString());

        // (4 - 1) / 1 * 100 = +300%.
        $this->withSession($this->adminSession())
            ->get(route('admin.statistics'))
            ->assertOk()
            ->assertSee('<strong>+300%</strong>', false);
    }

    public function test_percentage_never_divides_by_zero_when_last_month_is_empty(): void
    {
        $admin = $this->makeAdmin();

        $this->makePatient($admin, 'P-201', 'Fatima', now()->subMonths(2)->toDateString());

        $this->withSession($this->adminSession())
            ->get(route('admin.statistics'))
            ->assertOk()
            ->assertSee('<strong>+100%</strong>', false);
    }

    public function test_percentage_is_zero_when_there_are_no_cases_at_all(): void
    {
        $this->makeAdmin();

        $this->withSession($this->adminSession())
            ->get(route('admin.statistics'))
            ->assertOk()
            ->assertSee('<strong>0%</strong>', false);
    }
}
