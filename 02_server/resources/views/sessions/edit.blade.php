@extends('layouts.app')

@section('content')

    @include('layouts.nav')

    <div class="container-fluid">
        <div class="row">
            @include('layouts.sidebar')

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <div class="border-bottom mb-3 pt-3 pb-2">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                        <h1 class="h2">{{ $event->name }}</h1>
                    </div>
                    <span class="h6">{{ \Carbon\Carbon::create($event->date)->format('F, d Y') }}</span>
                </div>

                <div class="mb-3 pt-3 pb-2">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                        <h2 class="h4">Edit session</h2>
                    </div>
                </div>

                <form class="needs-validation" novalidate action="{{ route('sessions.edit', [$event->id, $session->id]) }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-12 col-lg-4 mb-3">
                            <label for="selectType">Type</label>
                            <select class="form-control @error('type') is-invalid @enderror" id="selectType" name="type">
                                <option {{ old('type') == 'talk' ? 'selected' : '' }} value="talk" selected>Talk</option>
                                <option {{ old('type') == 'workshop' ? 'selected' : '' }} value="workshop">Workshop</option>
                            </select>
                            @error('type')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-lg-4 mb-3">
                            <label for="inputTitle">Title</label>
                            <!-- adding the class is-invalid to the input, shows the invalid feedback below -->
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="inputTitle" name="title" placeholder="" value="{{ old('title') ?? $session->title }}">
                            @error('title')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-lg-4 mb-3">
                            <label for="inputSpeaker">Speaker</label>
                            <input type="text" class="form-control @error('speaker') is-invalid @enderror" id="inputSpeaker" name="speaker" placeholder="" value="{{ old('speaker') ?? $session->speaker }}">
                            @error('speaker')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-lg-4 mb-3">
                            <label for="selectRoom">Room</label>
                            <select class="form-control @error('room_id') is-invalid @enderror" id="selectRoom" name="room_id">
                                @foreach($event->rooms as $room)
                                    <option value="{{ $room->id }}" {{ old('room_id') && $room->id == old('room_id') || $room->id == $session->room_id ? 'selected' : '' }}>{{ $room->name }}</option>
                                @endforeach
                            </select>
                            @error('room_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-lg-4 mb-3">
                            <label for="inputCost">Cost</label>
                            <input type="number" class="form-control @error('cost') is-invalid @enderror" id="inputCost" name="cost" placeholder="" value="{{ old('cost', $session->cost) }}">
                            @error('cost')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-lg-6 mb-3">
                            <label for="inputStart">Start</label>
                            <input type="text"
                                   class="form-control @error('start') is-invalid @enderror"
                                   id="inputStart"
                                   name="start"
                                   placeholder="yyyy-mm-dd HH:MM"
                                   value="{{ old('start') ?? $session->start }}">
                            @error('start')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col-12 col-lg-6 mb-3">
                            <label for="inputEnd">End</label>
                            <input type="text"
                                   class="form-control @error('end') is-invalid @enderror"
                                   id="inputEnd"
                                   name="end"
                                   placeholder="yyyy-mm-dd HH:MM"
                                   value="{{ old('end') ?? $session->end }}">
                            @error('end')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="textareaDescription">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="textareaDescription" name="description" placeholder="" rows="5">{{ old('description') ?? $session->description }}</textarea>
                            @error('description')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <hr class="mb-4">
                    <button class="btn btn-primary" type="submit">Save session</button>
                    <a href="{{ route('events.detail', $event->id) }}" class="btn btn-link">Cancel</a>
                </form>

            </main>
        </div>
    </div>

@endsection
