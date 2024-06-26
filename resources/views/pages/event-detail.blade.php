@extends('layouts.app')

@section('content')
<div class="container py-4">
    <section style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            @if (auth()->user()->is_admin)
                <li class="breadcrumb-item"><a href="{{ route('users.show', ['user' => $event->creator]) }}">User</a></li>
            @endif
            <li class="breadcrumb-item active" aria-current="page">Event</li>
        </ol>
    </section>

    <section class="mb-4">
        <div class="d-flex align-items-center justify-content-between gap-3 mb-3">
            <div class="d-flex flex-wrap align-items-center gap-1">
                {{-- Event Title --}}
                <h1 class="fw-bold me-3">{{ $event->title }}</h1>
                {{-- Event status badge --}}
                @if ($event->is_committed)
                    @if ($event->finished_at->isPast())
                        <span class="badge fs-6 rounded-pill bg-danger" title="This event is closed">{{ __('Closed') }}</span>
                    @elseif ($event->started_at->isPast())
                        <span class="badge fs-6 rounded-pill bg-success" title="This event is opened">{{ __('Opened') }}</span>
                    @else
                        <span class="badge fs-6 rounded-pill bg-primary" title="This event will start at the appointed time">{{ __('Waiting') }}</span>
                    @endif
                @else
                    <span class="badge fs-6 rounded-pill bg-secondary" title="This event is uncommitted">{{ __('Uncommitted') }}</span>
                @endif
            </div>

            @if ($event->isEditable())
                <a type="button" class="btn btn-outline-secondary" href="{{ route('events.edit', ['event' => $event]) }}" title="Edit this event">
                    <i class="fa-solid fa-pen">Edit</i>
                </a>
            @endif
        </div>

        <div class="d-flex flex-wrap mb-3 gap-2">
            <div class="d-flex gap-2 align-items-center me-3" title="Started at">
                <i class="fa-solid fa-calendar-day fa-lg"></i>
                @if ($event->started_at)
                    <span>{{ $event->started_at->format('D, j M Y H:i:s e') }}</span>
                @else
                    <span class="text-muted">{{ __('Not set') }}</span>
                @endif
            </div>
            <div class="d-flex gap-2 align-items-center" title="Finished at">
                <i class="fa-solid fa-calendar-week fa-lg"></i>
                @if ($event->finished_at)
                    <span>{{ $event->finished_at->format('D, j M Y H:i:s e') }}</span>
                @else
                    <span class="text-muted">{{ __('Not set') }}</span>
                @endif
            </div>
        </div>

        @isset($event->description)
            {!! $event->description !!}
        @endisset
    </section>

    <hr>

    {{-- Vote Result --}}
    @if ($event->is_committed)
        <section class="mb-4">
            <h2>Vote Result</h2>

            @if ($event->started_at->isPast())
                <table class="table">
                    <tbody>
                    <tr>
                        <th>Total Registered Voters</th>
                        <td>{{ $event->voters->count() }}</td>
                    </tr>
                    <tr>
                        <th>Total Incoming Votes</th>
                        <td>{{ $event->ballots->count() }}</td>
                    </tr>
                    <tr>
                        <th>Incoming Votes Percentage</th>
                        <td>{{ $event->ballots->count() / $event->voters->count() * 100 }}%</td>
                    </tr>
                    </tbody>
                </table>
                <div class="option-list">
                    @foreach ($event->options as $option)
                        <div class="card option-item">
                            <div class="card-body">
                                <p class="card-title fs-5">{{ $option->name }}</p>
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span>Total Votes</span>
                                    <span>{{ $option->ballots->count() }}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span>Votes Percentage</span>
                                    <span>{{ $option->ballots->count() / $event->voters->count() * 100 }}%</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            @else
                <div class="card p-3 text-center mt-3">
                    <span class="text-muted">{{ __('The vote result will be available after the event has started') }}</span>
                </div>
            @endif
        </section>
    @endif

    {{-- Options --}}
    <section class="mb-4">
        <h2>{{ __('Options') }}</h2>
        <div class="d-flex justify-content-between align-items-center gap-2 flex-wrap mb-3">
            <span>{{ $event->options->count() }} {{ $event->options->count() > 1 ? __('options available') : __('option available') }}</span>
            @if ($event->isEditable())
                <a class="btn btn-primary" href="{{ route('events.options.create', ['event' => $event]) }}">{{ __('Add Option') }}</a>
            @endif
        </div>

        @if ($event->options->count() > 0)
            <div class="option-list">
                @foreach ($event->options as $option)
                    <div class="option-item card">
                            {{-- Option Image --}}
                            <div class="option-item__image-frame">
                                @if ($option->image_location)
                                    <img src="{{ route('options.image', ['option' => $option]) }}" class="option-item__image" alt="{{ $option->name }}">
                                @else
                                    {{-- Default image --}}
                                    <img src="{{ Vite::image('image-option.jpg') }}" class="option-item__image" alt="No image">
                                @endif
                            </div>
                            {{-- Option Name --}}
                            <div class="@isset($option->image_location) @endisset">
                                <div class="card-body">
                                    <p class="card-title fs-5 fw-bold">{{ $option->name }}</p>
                                    @isset($option->description)
                                        <p class="card-text">{!! $option->description !!}</p>
                                    @endisset
                                    <div class="d-flex justify-content-start gap-2 mt-3">
                                        @if ($event->isEditable())
                                            {{-- Edit Option Button --}}
                                            <a class="btn btn-outline-secondary" href="{{ route('options.edit', ['option' => $option]) }}" title="Edit this option">
                                                <i class="fa-pen fa-solid">Edit</i>
                                            </a>
                                            {{-- Delete Option Button --}}
                                            <form action="{{ route('options.destroy', ['option' => $option]) }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button class="btn btn-outline-danger" type="submit" onclick="return confirm('Are you sure to delete this \'{{ $option->name }}\' option?')" title="Delete this option">
                                                    <i class="fa-trash fa-solid">Delete</i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="card p-3 text-center">
                <span class="text-muted">{{ __('There are no options') }}</span>
            </div>
        @endif
    </section>

    {{-- Voters --}}
    <section class="mb-4">
        <h2>{{ __('Voters') }}</h2>
        <div class="d-flex justify-content-between align-items-center gap-2 flex-wrap mb-3">
            <span>{{ $event->voters->count() }} {{ $event->voters->count() > 1 ? __('registered voters') : __('registered voter')  }}</span>
            <a class="btn btn-primary" href="{{ route('events.voters.index', ['event' => $event]) }}">{{ __('Show All') }}</a>
        </div>

        @if ($event->voters->count() > 0)
            {{-- Showing max. 5 voters --}}
            <div class="d-flex flex-wrap">
                @foreach ($event->voters->sortBy('email', SORT_NATURAL)->take(5) as $voter)
                    <article class="card mb-2" style="width: 100%">
                        <div class="card-body">
                            <p class="card-title mb-0 fs-5">{{ $voter->name }}</p>
                            <p class="mb-0">{{ $voter->email }}</p>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="card p-3 text-center">
                <span class="text-muted">{{ __('There are no voters') }}</span>
            </div>
        @endif
    </section>

    {{-- Commit --}}
    @if ($event->isEditable())
        <section class="mb-4">
            <h2>{{ __('Commit Event') }}</h2>
            <div class="p-3 bg-white border mt-3">
                <p>Commit this event to start the voting at the time you specify. We will send a voting link to each voter's email.</p>
                <p>Before commit, make sure you fulfill this requirement:</p>
                <ul>
                    @foreach ($event->getCommitChecklist() as $checkItem)
                        <li>
                            <span class="me-1">{{ $checkItem['name'] }}</span>
                            @if ($checkItem['is_fulfilled'])
                                <i class="fa-solid fa-check" title="Fulfilled"></i>
                            @else
                                <i class="fa-solid fa-xmark" title="Not fulfilled"></i>
                            @endif
                        </li>
                    @endforeach
                </ul>

                <p><strong class="text-danger">Warning!</strong> You <strong>can't change</strong> the event's detail, the options, and the voters after you commit this event.</p>
                @if ($event->isAllCommitChecklistFulfilled())
                    <form action="{{ route('events.commit', ['event' => $event]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-outline-danger">{{ __('Commit Event') }}</button>
                    </form>
                @else
                    <button type="button" class="btn btn-outline-danger" disabled>{{ __('Commit Event') }}</button>
                @endif
            </div>
        </section>
    @endif

    {{-- Delete Event --}}
    @if ($event->isAuthorized())
        <section class="mb-4">
            <h2>{{ __('Delete Event') }}</h2>
            <div class="p-3 bg-white border border-danger mt-3">
                <p><span class="text-danger fw-bold">Warning!</span> You <strong>can't undo</strong> this action.<br>All event data, options, voters and ballots <strong>will be lost</strong>.</p>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal">Delete Event</button>
            </div>
        </section>
    @endif
</div>

<!-- Modal -->
@if ($event->isAuthorized())
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmationModalLabel">{{ __('Delete This Event?') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{ __('You are going to delete this event. Are you sure with this?') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <form action="{{ route('events.destroy', ['event' => $event]) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger">{{ __('Yes, Delete Now') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif

@endsection
