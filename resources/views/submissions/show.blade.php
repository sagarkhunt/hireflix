@extends('layouts.app')

@section('title', 'Review Submission')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Review Submission</h4>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Candidate:</strong> {{ $submission->candidate->name }}<br>
                        <strong>Email:</strong> {{ $submission->candidate->email }}
                    </div>
                    <div class="col-md-6">
                        <strong>Interview:</strong> {{ $submission->interview->title }}<br>
                        <strong>Submitted:</strong> {{ $submission->created_at->format('M d, Y H:i') }}
                    </div>
                </div>

                <hr>

                <h5>Question</h5>
                <div class="card mb-3">
                    <div class="card-body">
                        <p class="mb-0">{{ $submission->question->question_text }}</p>
                    </div>
                </div>

                <h5>Video Answer</h5>
                @if($submission->video_path)
                <div class="mb-3">
                    <video controls width="100%" style="max-width: 600px;">
                        <source src="{{ asset('storage/' . $submission->video_path) }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
                @else
                <p class="text-muted">No video uploaded</p>
                @endif

                @if($submission->answer_text)
                <h5>Additional Notes</h5>
                <div class="card mb-3">
                    <div class="card-body">
                        <p class="mb-0">{{ $submission->answer_text }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Review & Score</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('submissions.update', $submission) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="score" class="form-label">Score (0-100)</label>
                        <input type="number" class="form-control @error('score') is-invalid @enderror"
                            id="score" name="score" value="{{ old('score', $submission->score) }}"
                            min="0" max="100" required>
                        @error('score')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="comments" class="form-label">Comments</label>
                        <textarea class="form-control @error('comments') is-invalid @enderror"
                            id="comments" name="comments" rows="4"
                            placeholder="Provide feedback and comments...">{{ old('comments', $submission->comments) }}</textarea>
                        @error('comments')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            {{ $submission->isReviewed() ? 'Update Review' : 'Submit Review' }}
                        </button>
                    </div>
                </form>

                @if($submission->isReviewed())
                <hr>
                <div class="mt-3">
                    <small class="text-muted">
                        <strong>Reviewed by:</strong> {{ $submission->reviewer->name }}<br>
                        <strong>Reviewed on:</strong> {{ $submission->reviewed_at->format('M d, Y H:i') }}
                    </small>
                </div>
                @endif
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0">Quick Actions</h6>
            </div>
            <div class="card-body">
                <a href="{{ route('submissions.index') }}" class="btn btn-outline-secondary btn-sm w-100 mb-2">
                    Back to All Submissions
                </a>
                <a href="{{ route('interviews.submissions', $submission->interview) }}" class="btn btn-outline-info btn-sm w-100">
                    View All Submissions for This Interview
                </a>
            </div>
        </div>
    </div>
</div>
@endsection