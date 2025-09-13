@extends('layouts.app')

@section('title', $interview->title)

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">{{ $interview->title }}</h4>
            </div>
            <div class="card-body">
                <p class="card-text">{{ $interview->description }}</p>

                <h5 class="mt-4">Questions</h5>
                @foreach($interview->questions as $index => $question)
                <div class="card mb-3">
                    <div class="card-body">
                        <h6 class="card-title">Question {{ $index + 1 }}</h6>
                        <p class="card-text">{{ $question->question_text }}</p>

                        @if(isset($submissions[$question->id]))
                        <div class="alert alert-success">
                            <strong>Submitted!</strong>
                            @if($submissions[$question->id]->score !== null)
                            Score: {{ $submissions[$question->id]->score }}/100
                            @endif
                        </div>
                        @else
                        <form method="POST" action="{{ route('submissions.store') }}"
                            enctype="multipart/form-data" class="mt-3">
                            @csrf
                            <input type="hidden" name="interview_id" value="{{ $interview->id }}">
                            <input type="hidden" name="question_id" value="{{ $question->id }}">

                            <div class="mb-3">
                                <label for="video_{{ $question->id }}" class="form-label">Record/Upload Video Answer</label>
                                <input type="file" class="form-control @error('video') is-invalid @enderror"
                                    id="video_{{ $question->id }}" name="video"
                                    accept="video/*" required>
                                <div class="form-text">Supported formats: MP4, AVI, MOV, WMV (Max 100MB)</div>
                                @error('video')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="answer_text_{{ $question->id }}" class="form-label">Additional Notes (Optional)</label>
                                <textarea class="form-control" id="answer_text_{{ $question->id }}"
                                    name="answer_text" rows="3"
                                    placeholder="Add any additional notes or context to your video answer..."></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Submit Answer</button>
                        </form>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Interview Progress</h5>
            </div>
            <div class="card-body">
                <div class="progress mb-3">
                    <div class="progress-bar" role="progressbar"
                        style="width: {{ ($submissions->count() / $interview->questions->count()) * 100 }}%">
                        {{ $submissions->count() }}/{{ $interview->questions->count() }}
                    </div>
                </div>
                <p class="text-muted">
                    {{ $submissions->count() }} of {{ $interview->questions->count() }} questions answered
                </p>

                @if($submissions->count() === $interview->questions->count())
                <div class="alert alert-success">
                    <strong>Congratulations!</strong> You have completed all questions for this interview.
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection