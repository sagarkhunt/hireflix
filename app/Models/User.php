<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is reviewer
     */
    public function isReviewer(): bool
    {
        return $this->role === 'reviewer';
    }

    /**
     * Check if user is candidate
     */
    public function isCandidate(): bool
    {
        return $this->role === 'candidate';
    }

    /**
     * Check if user can manage interviews (admin or reviewer)
     */
    public function canManageInterviews(): bool
    {
        return $this->isAdmin() || $this->isReviewer();
    }

    /**
     * Get interviews created by this user
     */
    public function createdInterviews()
    {
        return $this->hasMany(Interview::class, 'created_by');
    }

    /**
     * Get submissions made by this user (as candidate)
     */
    public function submissions()
    {
        return $this->hasMany(Submission::class, 'candidate_id');
    }

    /**
     * Get submissions reviewed by this user (as reviewer)
     */
    public function reviewedSubmissions()
    {
        return $this->hasMany(Submission::class, 'reviewed_by');
    }
}
