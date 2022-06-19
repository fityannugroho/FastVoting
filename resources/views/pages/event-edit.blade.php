@extends('layouts.app')

@section('content')
<div class="container py-4">
    <section style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('events.show', ['event' => $event]) }}">Event</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
        </ol>
    </section>
    <h1>{{ __('Edit Event') }}</h1>
    <form action="{{ route('events.update', ['event' => $event]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group mb-2">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" placeholder="Title" value="{{ old('title') ?? $event->title }}">
            @error('title')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group mb-2">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" placeholder="Description">{{ old('description') ?? $event->description }}</textarea>
            @error('description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group mb-2">
            <label for="startedAt" class="form-label">Started At</label>
            <input type="datetime-local" class="form-control @error('started_at') is-invalid @enderror" id="startedAt" name="started_at" placeholder="Started At" min="{{ Date::now()->format('Y-m-d H:i') }}" value="{{ old('started_at') ?? $event->started_at }}">
            <p class="form-text">This date using UTC timezone.</p>
            @error('started_at')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group mb-3">
            <label for="finishedAt" class="form-label">Finished At</label>
            <input type="datetime-local" class="form-control @error('finished_at') is-invalid @enderror" id="finishedAt" name="finished_at" placeholder="Finished At" value="{{ old('finished_at') ?? $event->finished_at }}">
            <p class="form-text">This date using UTC timezone.</p>
            @error('finished_at')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">{{ __('Edit Event') }}</button>
    </form>
</div>
@endsection
