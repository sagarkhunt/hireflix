<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = [
        'interview_id',
        'question_id',
        'candidate_id',
        'video_path',
        'answer_text',
        'score',
        'comments',
        'reviewed_by',
        'reviewed_at',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    /**
     * Get the interview that owns the submission
     */
    public function interview()
    {
        return $this->belongsTo(Interview::class);
    }

    /**
     * Get the question that owns the submission
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Get the candidate who made the submission
     */
    public function candidate()
    {
        return $this->belongsTo(User::class, 'candidate_id');
    }

    /**
     * Get the reviewer who reviewed the submission
     */
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    /**
     * Check if submission is reviewed
     */
    public function isReviewed(): bool
    {
        return !is_null($this->reviewed_at);
    }
}
