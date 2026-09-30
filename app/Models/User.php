<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Security questions an administrator can choose from when
     * configuring the "Forgot Password" recovery flow on the login page.
     *
     * @var list<string>
     */
    public const SECURITY_QUESTIONS = [
        'What city were you born in?',
        'What was the name of your first pet?',
        'What is your favorite food?',
        'What is your favorite color?',
        'What is your favorite movie?',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
        'barangay',
        'created_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'security_answer',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'email_verified_at' => 'datetime',
            'last_active' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Configure (or replace) this account's forgot-password security
     * question. The answer is normalized and hashed, so it can only be
     * verified afterwards — never read back.
     */
    public function setSecurityQuestion(string $question, string $answer): void
    {
        $this->security_question = $question;
        $this->security_answer = Hash::make($this->normalizeSecurityAnswer($answer));
    }

    /**
     * Whether this account can use the forgot-password flow.
     */
    public function hasSecurityQuestion(): bool
    {
        return filled($this->security_question) && filled($this->security_answer);
    }

    /**
     * Check a submitted answer against the stored hash.
     */
    public function verifySecurityAnswer(string $answer): bool
    {
        if (! $this->hasSecurityQuestion()) {
            return false;
        }

        return Hash::check($this->normalizeSecurityAnswer($answer), $this->security_answer);
    }

    /**
     * Answers are matched loosely: case and surrounding whitespace
     * are ignored so a remembered answer still works.
     */
    private function normalizeSecurityAnswer(string $answer): string
    {
        return mb_strtolower(trim($answer));
    }
}
