<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'interview_id',
        'question_text',
        'order',
    ];

    /**
     * Get the interview that owns the question
     */
    public function interview()
    {
        return $this->belongsTo(Interview::class);
    }

    /**
     * Get the submissions for the question
     */
    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
}
