@extends('layouts.app')

@section('title', 'Interviews')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Interviews</h2>
    <a href="{{ route('interviews.create') }}" class="btn btn-primary">Create New Interview</a>
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
                        Status:
                        <span class="badge {{ $interview->is_active ? 'bg-success' : 'bg-secondary' }}">
                            {{ $interview->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </small>
                </p>
            </div>
            <div class="card-footer">
                <div class="btn-group w-100" role="group">
                    <a href="{{ route('interviews.show', $interview) }}" class="btn btn-outline-primary btn-sm">View</a>
                    @if($interview->created_by === auth()->id() || auth()->user()->isAdmin())
                    <a href="{{ route('interviews.edit', $interview) }}" class="btn btn-outline-secondary btn-sm">Edit</a>
                    @endif
                    <a href="{{ route('interviews.submissions', $interview) }}" class="btn btn-outline-info btn-sm">Submissions</a>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="text-center py-5">
            <h4>No interviews found</h4>
            <p class="text-muted">Create your first interview to get started.</p>
            <a href="{{ route('interviews.create') }}" class="btn btn-primary">Create Interview</a>
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