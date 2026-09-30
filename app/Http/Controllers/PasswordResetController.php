<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PasswordResetController extends Controller
{
    /**
     * Session key holding the id of the admin account that is
     * currently going through the forgot-password flow.
     */
    private const SESSION_KEY = 'password_reset_user_id';

    /**
     * Step 1: ask for the admin username.
     * Step 2 (once a pending account exists in the session): show the
     * configured security question and the new-password form.
     */
    public function create(Request $request): View
    {
        return view('auth.forgot-password', [
            'admin' => $this->pendingAdmin($request),
        ]);
    }

    /**
     * Step 1 submit: locate the admin account and open a pending reset
     * session so the security question can be asked on the next screen.
     */
    public function identify(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'username' => ['required', 'string', 'max:255'],
        ]);

        $admin = User::query()
            ->where('role', 'admin')
            ->where(function ($query) use ($data): void {
                $query->where('username', $data['username'])
                    ->orWhere('email', $data['username']);
            })
            ->first();

        if (! $admin) {
            throw ValidationException::withMessages([
                'username' => 'No administrator account matches that username.',
            ]);
        }

        if (! $admin->hasSecurityQuestion()) {
            throw ValidationException::withMessages([
                'username' => 'No security question is configured for this account yet. Ask an administrator to set one up under Admin Accounts.',
            ]);
        }

        $request->session()->put(self::SESSION_KEY, $admin->id);

        return redirect()->route('password.request');
    }

    /**
     * Step 2 submit: verify the security answer, then store the new password.
     */
    public function reset(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'security_answer' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $admin = $this->pendingAdmin($request);

        if (! $admin) {
            throw ValidationException::withMessages([
                'security_answer' => 'Your reset session has expired. Please start again from the beginning.',
            ]);
        }

        if (! $admin->verifySecurityAnswer($data['security_answer'])) {
            throw ValidationException::withMessages([
                'security_answer' => 'That answer does not match the one on file for this account.',
            ]);
        }

        $admin->password = Hash::make($data['password']);
        $admin->save();

        $request->session()->forget(self::SESSION_KEY);

        return redirect()->route('home')->with('status', 'Your password has been updated. You can now sign in with your new password.');
    }

    /**
     * Abandon the pending reset and return to the login page.
     */
    public function cancel(Request $request): RedirectResponse
    {
        $request->session()->forget(self::SESSION_KEY);

        return redirect()->route('home');
    }

    /**
     * Resolve the admin account tied to the pending reset session,
     * clearing the session when the account is no longer usable
     * (deleted, no longer an admin, or question removed).
     */
    private function pendingAdmin(Request $request): ?User
    {
        $id = $request->session()->get(self::SESSION_KEY);

        $admin = filled($id) ? User::find($id) : null;

        if (! $admin || $admin->role !== 'admin' || ! $admin->hasSecurityQuestion()) {
            $request->session()->forget(self::SESSION_KEY);

            return null;
        }

        return $admin;
    }
}