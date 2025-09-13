<?php

namespace App\Http\Controllers;

use App\Models\Interview;
use App\Models\Question;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SubmissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of submissions for reviewers.
     */
    public function index()
    {
        $this->middleware('role:admin,reviewer');

        $submissions = Submission::with(['interview', 'question', 'candidate', 'reviewer'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('submissions.index', compact('submissions'));
    }

    /**
     * Store a newly created submission.
     */
    public function store(Request $request)
    {
        $this->middleware('role:candidate');

        $request->validate([
            'interview_id' => 'required|exists:interviews,id',
            'question_id' => 'required|exists:questions,id',
            'video' => 'required|file|mimes:mp4,avi,mov,wmv|max:102400', // 100MB max
            'answer_text' => 'nullable|string',
        ]);

        // Check if interview is active
        $interview = Interview::findOrFail($request->interview_id);
        if (!$interview->is_active) {
            return back()->withErrors(['interview' => 'This interview is not active.']);
        }

        // Check if submission already exists
        $existingSubmission = Submission::where('interview_id', $request->interview_id)
            ->where('question_id', $request->question_id)
            ->where('candidate_id', Auth::id())
            ->first();

        if ($existingSubmission) {
            return back()->withErrors(['submission' => 'You have already submitted an answer for this question.']);
        }

        // Store video file
        $videoPath = $request->file('video')->store('submissions', 'public');

        Submission::create([
            'interview_id' => $request->interview_id,
            'question_id' => $request->question_id,
            'candidate_id' => Auth::id(),
            'video_path' => $videoPath,
            'answer_text' => $request->answer_text,
        ]);

        return back()->with('success', 'Your answer has been submitted successfully.');
    }

    /**
     * Display the specified submission.
     */
    public function show(Submission $submission)
    {
        $this->middleware('role:admin,reviewer');

        $submission->load(['interview', 'question', 'candidate', 'reviewer']);
        return view('submissions.show', compact('submission'));
    }

    /**
     * Update the specified submission (scoring and comments).
     */
    public function update(Request $request, Submission $submission)
    {
        $this->middleware('role:admin,reviewer');

        $request->validate([
            'score' => 'required|integer|min:0|max:100',
            'comments' => 'nullable|string|max:1000',
        ]);

        $submission->update([
            'score' => $request->score,
            'comments' => $request->comments,
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ]);

        return back()->with('success', 'Submission reviewed successfully.');
    }

    /**
     * Get submissions for a specific interview.
     */
    public function interviewSubmissions(Interview $interview)
    {
        $this->middleware('role:admin,reviewer');

        $submissions = $interview->submissions()
            ->with(['question', 'candidate', 'reviewer'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('submissions.interview', compact('interview', 'submissions'));
    }
}
