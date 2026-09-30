<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminForgotPasswordTest extends TestCase
{
    use RefreshDatabase;

    private const QUESTION = 'What city were you born in?';

    private function makeAdmin(array $attributes = [], bool $withSecurityQuestion = true): User
    {
        $admin = User::create(array_merge([
            'name' => 'Admin One',
            'username' => 'adminone',
            'email' => 'adminone@tabacare.local',
            'password' => 'old-secret-123',
            'role' => 'admin',
        ], $attributes));

        if ($withSecurityQuestion) {
            $admin->setSecurityQuestion(self::QUESTION, 'Tabaco');
            $admin->save();
        }

        return $admin;
    }

    public function test_forgot_password_page_loads(): void
    {
        $this->get(route('password.request'))
            ->assertOk()
            ->assertSee('Forgot Password')
            ->assertSee('Admin Username');
    }

    public function test_identify_rejects_unknown_username(): void
    {
        $this->from(route('password.request'))
            ->post(route('password.identify'), ['username' => 'ghost-admin'])
            ->assertRedirect(route('password.request'))
            ->assertSessionHasErrors('username');
    }

    public function test_identify_rejects_health_worker_accounts(): void
    {
        User::create([
            'name' => 'Juan Dela Cruz',
            'username' => 'juan',
            'email' => 'juan@tabacare.local',
            'password' => 'secret-password',
            'role' => 'health_worker',
            'barangay' => 'Agnas',
        ]);

        $this->from(route('password.request'))
            ->post(route('password.identify'), ['username' => 'juan'])
            ->assertRedirect(route('password.request'))
            ->assertSessionHasErrors('username')
            ->assertSessionMissing('password_reset_user_id');
    }

    public function test_identify_requires_a_configured_security_question(): void
    {
        $this->makeAdmin(['username' => 'adminone'], false);

        $this->from(route('password.request'))
            ->post(route('password.identify'), ['username' => 'adminone'])
            ->assertRedirect(route('password.request'))
            ->assertSessionHasErrors('username')
            ->assertSessionMissing('password_reset_user_id');
    }

    public function test_identify_opens_pending_reset_and_shows_question(): void
    {
        $admin = $this->makeAdmin();

        $this->from(route('password.request'))
            ->post(route('password.identify'), ['username' => 'adminone'])
            ->assertRedirect(route('password.request'))
            ->assertSessionHas('password_reset_user_id', $admin->id);

        $this->get(route('password.request'))
            ->assertOk()
            ->assertSee(self::QUESTION, false)
            ->assertSee('Your Answer');
    }

    public function test_reset_rejects_wrong_security_answer(): void
    {
        $admin = $this->makeAdmin();

        $this->withSession(['password_reset_user_id' => $admin->id])
            ->post(route('password.update'), [
                'security_answer' => 'Manila',
                'password' => 'brand-new-pass',
                'password_confirmation' => 'brand-new-pass',
            ])
            ->assertSessionHasErrors('security_answer');

        $this->assertTrue(Hash::check('old-secret-123', $admin->fresh()->password));
    }

    public function test_reset_requires_a_pending_session(): void
    {
        $this->post(route('password.update'), [
                'security_answer' => 'Tabaco',
                'password' => 'brand-new-pass',
                'password_confirmation' => 'brand-new-pass',
            ])
            ->assertSessionHasErrors('security_answer');
    }

    public function test_full_reset_flow_updates_password_and_allows_login(): void
    {
        $admin = $this->makeAdmin();

        $this->post(route('password.identify'), ['username' => 'adminone'])
            ->assertSessionHas('password_reset_user_id', $admin->id);

        // Case and whitespace around the answer are ignored.
        $this->withSession(['password_reset_user_id' => $admin->id])
            ->post(route('password.update'), [
                'security_answer' => '  TABACO ',
                'password' => 'brand-new-pass',
                'password_confirmation' => 'brand-new-pass',
            ])
            ->assertRedirect(route('home'))
            ->assertSessionMissing('password_reset_user_id');

        $this->assertTrue(Hash::check('brand-new-pass', $admin->fresh()->password));

        $this->post(route('login'), [
                'username' => 'adminone',
                'password' => 'brand-new-pass',
                'role' => 'admin',
            ])
            ->assertRedirect(route('admin.dashboard'));
    }

    public function test_cancel_clears_the_pending_reset(): void
    {
        $admin = $this->makeAdmin();

        $this->withSession(['password_reset_user_id' => $admin->id])
            ->post(route('password.cancel'))
            ->assertRedirect(route('home'))
            ->assertSessionMissing('password_reset_user_id');
    }

    public function test_admin_account_requires_security_question_on_create(): void
    {
        $this->withSession(['id' => 1, 'role' => 'admin'])
            ->from(route('admin.admin-accounts.index'))
            ->post(route('admin.admin-accounts.store'), [
                'username' => 'newadmin',
                'password' => 'secret-1234',
            ])
            ->assertSessionHasErrors(['security_question', 'security_answer']);
    }

    public function test_admin_account_is_created_with_security_question(): void
    {
        $this->withSession(['id' => 1, 'role' => 'admin'])
            ->post(route('admin.admin-accounts.store'), [
                'username' => 'newadmin',
                'password' => 'secret-1234',
                'security_question' => self::QUESTION,
                'security_answer' => 'Tabaco',
            ])
            ->assertRedirect(route('admin.admin-accounts.index'));

        $created = User::where('username', 'newadmin')->firstOrFail();

        $this->assertTrue($created->hasSecurityQuestion());
        $this->assertTrue($created->verifySecurityAnswer('tabaco'));
        $this->assertFalse($created->verifySecurityAnswer('wrong'));
    }
}
