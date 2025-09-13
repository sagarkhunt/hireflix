@extends('layouts.app')

@section('title', $interview->title)

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">{{ $interview->title }}</h4>
                <div>
                    <a href="{{ route('interviews.edit', $interview) }}" class="btn btn-outline-secondary btn-sm">Edit</a>
                    <a href="{{ route('interviews.submissions', $interview) }}" class="btn btn-primary btn-sm">View Submissions</a>
                </div>
            </div>
            <div class="card-body">
                <p class="card-text">{{ $interview->description }}</p>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Created by:</strong> {{ $interview->creator->name }}
                    </div>
                    <div class="col-md-6">
                        <strong>Status:</strong>
                        <span class="badge {{ $interview->is_active ? 'bg-success' : 'bg-secondary' }}">
                            {{ $interview->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>

                <h5>Questions ({{ $interview->questions->count() }})</h5>
                @foreach($interview->questions as $index => $question)
                <div class="card mb-2">
                    <div class="card-body">
                        <h6 class="card-title">Question {{ $index + 1 }}</h6>
                        <p class="card-text">{{ $question->question_text }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Interview Statistics</h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6">
                        <h4 class="text-primary">{{ $interview->questions->count() }}</h4>
                        <small class="text-muted">Questions</small>
                    </div>
                    <div class="col-6">
                        <h4 class="text-success">{{ $interview->submissions->count() }}</h4>
                        <small class="text-muted">Submissions</small>
                    </div>
                </div>

                <hr>

                <h6>Recent Submissions</h6>
                @forelse($interview->submissions->take(5) as $submission)
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                        <small class="text-muted">{{ $submission->candidate->name }}</small><br>
                        <small>{{ $submission->created_at->diffForHumans() }}</small>
                    </div>
                    <div>
                        @if($submission->score !== null)
                        <span class="badge bg-success">{{ $submission->score }}/100</span>
                        @else
                        <span class="badge bg-warning">Pending</span>
                        @endif
                    </div>
                </div>
                @empty
                <p class="text-muted">No submissions yet</p>
                @endforelse

                @if($interview->submissions->count() > 5)
                <a href="{{ route('interviews.submissions', $interview) }}" class="btn btn-outline-primary btn-sm w-100 mt-2">
                    View All Submissions
                </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection