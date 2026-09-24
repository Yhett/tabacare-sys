<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function logout(Request $request): RedirectResponse
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string'],
            'role' => ['required', 'in:admin,health_worker'],
            'barangay' => ['nullable', 'string', 'max:100'],
        ]);

        if ($credentials['role'] === 'health_worker' && blank($credentials['barangay'] ?? null)) {
            throw ValidationException::withMessages([
                'barangay' => 'Please select your barangay before signing in.',
            ]);
        }

        $user = User::query()
            ->where('username', $credentials['username'])
            ->where('role', $credentials['role'])
            ->when(
                $credentials['role'] === 'health_worker',
                fn ($query) => $query->where('barangay', $credentials['barangay'])
            )
            ->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'username' => $credentials['role'] === 'health_worker'
                    ? 'Health worker account not found for that barangay.'
                    : 'Invalid admin username or password.',
            ]);
        }

        $request->session()->regenerate();
        $request->session()->put([
            'user' => $user->username,
            'id' => $user->id,
            'role' => $user->role,
            'barangay' => $user->barangay,
        ]);

        $user->forceFill(['last_active' => now()])->save();

        return redirect()->intended(
            $user->role === 'health_worker' ? route('dashboard') : route('admin.dashboard')
        );
    }
}
