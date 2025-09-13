@extends('layouts.app')

@section('title', 'Interview Submissions - ' . $interview->title)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Submissions for "{{ $interview->title }}"</h2>
    <a href="{{ route('interviews.show', $interview) }}" class="btn btn-outline-secondary">Back to Interview</a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                @forelse($submissions as $submission)
                <div class="row border-bottom py-3">
                    <div class="col-md-4">
                        <strong>{{ $submission->candidate->name }}</strong><br>
                        <small class="text-muted">{{ $submission->candidate->email }}</small>
                    </div>
                    <div class="col-md-4">
                        <strong>Question {{ $submission->question->order }}</strong><br>
                        <small class="text-muted">{{ Str::limit($submission->question->question_text, 50) }}</small>
                    </div>
                    <div class="col-md-2">
                        @if($submission->score !== null)
                        <span class="badge bg-success">{{ $submission->score }}/100</span><br>
                        <small class="text-muted">Reviewed</small>
                        @else
                        <span class="badge bg-warning">Pending</span><br>
                        <small class="text-muted">Not reviewed</small>
                        @endif
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('submissions.show', $submission) }}" class="btn btn-outline-primary btn-sm">
                            Review
                        </a>
                    </div>
                </div>
                @empty
                <div class="text-center py-5">
                    <h4>No submissions found</h4>
                    <p class="text-muted">There are no submissions for this interview yet.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Interview Overview</h5>
            </div>
            <div class="card-body">
                <p><strong>Title:</strong> {{ $interview->title }}</p>
                <p><strong>Questions:</strong> {{ $interview->questions->count() }}</p>
                <p><strong>Total Submissions:</strong> {{ $submissions->total() }}</p>
                <p><strong>Status:</strong>
                    <span class="badge {{ $interview->is_active ? 'bg-success' : 'bg-secondary' }}">
                        {{ $interview->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </p>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0">Quick Stats</h6>
            </div>
            <div class="card-body">
                @php
                $reviewedCount = $submissions->where('score', '!=', null)->count();
                $pendingCount = $submissions->where('score', null)->count();
                @endphp
                <div class="row text-center">
                    <div class="col-6">
                        <h4 class="text-success">{{ $reviewedCount }}</h4>
                        <small class="text-muted">Reviewed</small>
                    </div>
                    <div class="col-6">
                        <h4 class="text-warning">{{ $pendingCount }}</h4>
                        <small class="text-muted">Pending</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($submissions->hasPages())
<div class="d-flex justify-content-center mt-4">
    {{ $submissions->links() }}
</div>
@endif
@endsection