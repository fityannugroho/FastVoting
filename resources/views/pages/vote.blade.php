@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1>{{ $voter->event->title }}</h1>
    <div class="d-flex flex-wrap mb-3">
        <div class="d-flex gap-2 align-items-center me-3" title="Started at" style="width: 200px;">
            <i class="fa-solid fa-calendar-day"></i>
            <span>{{ $voter->event->started_at->format('D, d M Y, H.i e') }}</span>
        </div>
        <div class="d-flex gap-2 align-items-center" title="Finished at">
            <i class="fa-solid fa-calendar-week"></i>
            <span>{{ $voter->event->finished_at->format('D, d M Y, H.i e') }}</span>
        </div>
    </div>
    @isset($voter->event->description)
        <p class="fs-6">{{ $voter->event->description }}</p>
    @endisset
    <hr class="mb-4">
    <h2>Your Identity</h2>
    <table class="table table-borderless mb-4">
        <tbody>
            <tr>
                <th>Name</th>
                <td>{{ $voter->name }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $voter->email }}</td>
            </tr>
        </tbody>
    </table>
    <div class="option-list">
        @foreach ($voter->event->options as $option)
            <div class="card option-item">
                @if (isset($option->image_location))
                    <div class="row g-0">
                        <div class="col-8">
                            <div class="card-body">
                                <h5 class="card-title">{{ $option->name }}</h5>
                                @isset($option->description)
                                    <p class="card-text">{{ $option->description }}</p>
                                @endisset
                                <a class="btn btn-success" href="{{'/events/eventId/result'}}">Vote</a>
                            </div>
                        </div>
                        <div class="col-4 option-item__image-frame">
                            <img class="option-item__image" src="{{ route('option.image', ['name' => $option->image_location]) }}" alt="{{ $option->name }}">
                        </div>
                    </div>
                @else
                    <div class="card-body">
                        <h5 class="card-title">{{ $option->name }}</h5>
                        @isset($option->description)
                            <p class="card-text">{{ $option->description }}</p>
                        @endisset
                        <a class="btn btn-success" href="{{'/events/eventId/result'}}">Vote</a>
                    </div>
                @endif
            </div>
            {{-- <div class="card option-item">
                @isset($option->image_location)
                    <img class="option-item__image" src="{{ route('option.image', ['name' => $option->image_location]) }}" alt="{{ $option->name }}">
                @endisset
                <div class="card-body">
                    <p class="h5 card-title text-center fw-bold">{{ $option->name }}</p>
                    @isset($option->description)
                        <p class="card-text">{{ $option->description }}</p>
                    @endisset
                    <a class="btn btn-success" href="{{'/events/eventId/result'}}">Vote</a>
                </div>
            </div> --}}
        @endforeach
    </div>
</div>
@endsection
