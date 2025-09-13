@extends('layouts.app')

@section('title', 'Submissions')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>All Submissions</h2>
</div>

<div class="card">
    <div class="card-body">
        @forelse($submissions as $submission)
        <div class="row border-bottom py-3">
            <div class="col-md-3">
                <strong>{{ $submission->candidate->name }}</strong><br>
                <small class="text-muted">{{ $submission->candidate->email }}</small>
            </div>
            <div class="col-md-4">
                <strong>{{ $submission->interview->title }}</strong><br>
                <small class="text-muted">Question: {{ $submission->question->question_text }}</small>
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
                <small class="text-muted">{{ $submission->created_at->format('M d, Y') }}</small><br>
                <small class="text-muted">{{ $submission->created_at->diffForHumans() }}</small>
            </div>
            <div class="col-md-1">
                <a href="{{ route('submissions.show', $submission) }}" class="btn btn-outline-primary btn-sm">
                    Review
                </a>
            </div>
        </div>
        @empty
        <div class="text-center py-5">
            <h4>No submissions found</h4>
            <p class="text-muted">There are no submissions to review yet.</p>
        </div>
        @endforelse
    </div>
</div>

@if($submissions->hasPages())
<div class="d-flex justify-content-center mt-4">
    {{ $submissions->links() }}
</div>
@endif
@endsection