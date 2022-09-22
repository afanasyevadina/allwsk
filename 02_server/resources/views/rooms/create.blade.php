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
                        <h2 class="h4">Create new room</h2>
                    </div>
                </div>

                <form class="needs-validation" novalidate action="{{ route('rooms.create', $event->id) }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-12 col-lg-4 mb-3">
                            <label for="inputName">Name</label>
                            <!-- adding the class is-invalid to the input, shows the invalid feedback below -->
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="inputName" name="name" placeholder="" value="{{ old('name') }}">
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-lg-4 mb-3">
                            <label for="selectChannel">Channel</label>
                            <select class="form-control @error('channel_id') is-invalid @enderror" id="selectChannel" name="channel_id">
                                @foreach($event->channels as $channel)
                                    <option value="{{ $channel->id }}" {{ $channel->id == old('channel_id') ? 'selected' : '' }}>{{ $channel->name }}</option>
                                @endforeach
                            </select>
                            @error('channel_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-lg-4 mb-3">
                            <label for="inputCapacity">Capacity</label>
                            <input type="number" class="form-control @error('capacity') is-invalid @enderror" id="inputCapacity" name="capacity" placeholder="" value="{{ old('capacity') }}">
                            @error('capacity')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <hr class="mb-4">
                    <button class="btn btn-primary" type="submit">Save room</button>
                    <a href="{{ route('events.detail', $event->id) }}" class="btn btn-link">Cancel</a>
                </form>

            </main>
        </div>
    </div>

@endsection
