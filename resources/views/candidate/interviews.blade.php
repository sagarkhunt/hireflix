@extends('layouts.app')

@section('title', 'Available Interviews')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Available Interviews</h2>
</div>

<div class="row">
    @forelse($interviews as $interview)
    <div class="col-md-6 col-lg-4 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title">{{ $interview->title }}</h5>
                <p class="card-text">{{ Str::limit($interview->description, 100) }}</p>
                <p class="card-text">
                    <small class="text-muted">
                        Created by: {{ $interview->creator->name }}<br>
                        Questions: {{ $interview->questions->count() }}<br>
                        <span class="badge bg-success">Active</span>
                    </small>
                </p>
            </div>
            <div class="card-footer">
                <a href="{{ route('candidate.interview', $interview) }}" class="btn btn-primary w-100">
                    Start Interview
                </a>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="text-center py-5">
            <h4>No interviews available</h4>
            <p class="text-muted">There are currently no active interviews for you to participate in.</p>
        </div>
    </div>
    @endforelse
</div>

@if($interviews->hasPages())
<div class="d-flex justify-content-center">
    {{ $interviews->links() }}
</div>
@endif
@endsection