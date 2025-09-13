<?php

namespace App\Http\Controllers;

use App\Models\Interview;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InterviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin,reviewer')->except(['candidateIndex', 'candidateShow']);
    }

    /**
     * Display a listing of the resource for admins/reviewers.
     */
    public function index()
    {
        $interviews = Interview::with(['creator', 'questions'])
            ->where('created_by', Auth::id())
            ->orWhere('is_active', true)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('interviews.index', compact('interviews'));
    }

    /**
     * Display a listing of active interviews for candidates.
     */
    public function candidateIndex()
    {
        $interviews = Interview::with(['creator', 'questions'])
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('candidate.interviews', compact('interviews'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('interviews.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'questions' => 'required|array|min:1',
            'questions.*' => 'required|string',
        ]);

        $interview = Interview::create([
            'title' => $request->title,
            'description' => $request->description,
            'created_by' => Auth::id(),
        ]);

        foreach ($request->questions as $index => $questionText) {
            Question::create([
                'interview_id' => $interview->id,
                'question_text' => $questionText,
                'order' => $index + 1,
            ]);
        }

        return redirect()->route('interviews.index')
            ->with('success', 'Interview created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Interview $interview)
    {
        $interview->load(['questions', 'creator', 'submissions.candidate']);
        return view('interviews.show', compact('interview'));
    }

    /**
     * Display the specified resource for candidates.
     */
    public function candidateShow(Interview $interview)
    {
        if (!$interview->is_active) {
            abort(404);
        }

        $interview->load(['questions']);
        $submissions = $interview->submissions()
            ->where('candidate_id', Auth::id())
            ->get()
            ->keyBy('question_id');

        return view('candidate.interview', compact('interview', 'submissions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Interview $interview)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Allow if user created the interview, is admin, or is reviewer
        if ($interview->created_by !== $user->id && !$user->isAdmin() && !$user->isReviewer()) {
            abort(403);
        }

        $interview->load('questions');
        return view('interviews.edit', compact('interview'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Interview $interview)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Allow if user created the interview, is admin, or is reviewer
        if ($interview->created_by !== $user->id && !$user->isAdmin() && !$user->isReviewer()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'is_active' => 'boolean',
        ]);

        $interview->update($request->only(['title', 'description', 'is_active']));

        return redirect()->route('interviews.index')
            ->with('success', 'Interview updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Interview $interview)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Only allow creator or admin to delete (reviewers can't delete)
        if ($interview->created_by !== $user->id && !$user->isAdmin()) {
            abort(403);
        }

        $interview->delete();

        return redirect()->route('interviews.index')
            ->with('success', 'Interview deleted successfully.');
    }
}
