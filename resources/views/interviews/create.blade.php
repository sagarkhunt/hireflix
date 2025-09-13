@extends('layouts.app')

@section('title', 'Create Interview')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Create New Interview</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('interviews.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="title" class="form-label">Interview Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                            id="title" name="title" value="{{ old('title') }}" required>
                        @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                            id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                        @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Questions</label>
                        <div id="questions-container">
                            <div class="question-item mb-2">
                                <div class="input-group">
                                    <span class="input-group-text">1</span>
                                    <input type="text" class="form-control" name="questions[]"
                                        placeholder="Enter question text" required>
                                    <button type="button" class="btn btn-outline-danger remove-question"
                                        style="display: none;">Remove</button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-outline-primary btn-sm" id="add-question">
                            Add Question
                        </button>
                        @error('questions')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('interviews.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Create Interview</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('questions-container');
        const addBtn = document.getElementById('add-question');
        let questionCount = 1;

        addBtn.addEventListener('click', function() {
            questionCount++;
            const questionDiv = document.createElement('div');
            questionDiv.className = 'question-item mb-2';
            questionDiv.innerHTML = `
            <div class="input-group">
                <span class="input-group-text">${questionCount}</span>
                <input type="text" class="form-control" name="questions[]" 
                       placeholder="Enter question text" required>
                <button type="button" class="btn btn-outline-danger remove-question">Remove</button>
            </div>
        `;
            container.appendChild(questionDiv);

            // Show remove buttons for all questions
            document.querySelectorAll('.remove-question').forEach(btn => {
                btn.style.display = 'block';
            });
        });

        container.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-question')) {
                e.target.closest('.question-item').remove();
                questionCount--;

                // Update question numbers
                document.querySelectorAll('.question-item').forEach((item, index) => {
                    item.querySelector('.input-group-text').textContent = index + 1;
                });

                // Hide remove buttons if only one question left
                if (questionCount === 1) {
                    document.querySelectorAll('.remove-question').forEach(btn => {
                        btn.style.display = 'none';
                    });
                }
            }
        });
    });
</script>
@endsection