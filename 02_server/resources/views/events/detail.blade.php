@extends('layouts.app')
@section('content')
    @include('layouts.nav')
    <div class="container-fluid">
        <div class="row">
            @include('layouts.sidebar')

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">@if(session()->get('success'))
                    <div class="alert alert-success mt-3">{{ session()->get('success') }}</div>
                @endif
                <div class="border-bottom mb-3 pt-3 pb-2 event-title">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                        <h1 class="h2">{{ $event->name }}</h1>
                        <div class="btn-toolbar mb-2 mb-md-0">
                            <div class="btn-group mr-2">
                                <a href="{{ route('events.edit', $event->id) }}" class="btn btn-sm btn-outline-secondary">Edit event</a>
                            </div>
                        </div>
                    </div>
                    <span class="h6">{{ \Carbon\Carbon::create($event->date)->format('F, d Y') }}</span>
                </div>

                <!-- Tickets -->
                <div id="tickets" class="mb-3 pt-3 pb-2">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                        <h2 class="h4">Tickets</h2>
                        <div class="btn-toolbar mb-2 mb-md-0">
                            <div class="btn-group mr-2">
                                <a href="{{ route('tickets.create', $event->id) }}" class="btn btn-sm btn-outline-secondary">
                                    Create new ticket
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row tickets">
                    @foreach($event->tickets as $ticket)
                        <div class="col-md-4">
                            <div class="card mb-4 shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $ticket->name }}</h5>
                                    <p class="card-text">{{ $ticket->cost }}</p>
                                    <p class="card-text">&nbsp;</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Sessions -->
                <div id="sessions" class="mb-3 pt-3 pb-2">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                        <h2 class="h4">Sessions</h2>
                        <div class="btn-toolbar mb-2 mb-md-0">
                            <div class="btn-group mr-2">
                                <a href="{{ route('sessions.create', $event->id) }}" class="btn btn-sm btn-outline-secondary">
                                    Create new session
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive sessions">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Time</th>
                            <th>Type</th>
                            <th class="w-100">Title</th>
                            <th>Speaker</th>
                            <th>Channel</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($event->rooms as $room)
                            @foreach($room->sessions as $session)
                                <tr>
                                    <td class="text-nowrap">{{ \Carbon\Carbon::create($session->start)->format('H:i') }} - {{ \Carbon\Carbon::create($session->end)->format('H:i') }}</td>
                                    <td>{{ ucfirst($session->type) }}</td>
                                    <td><a href="{{ route('sessions.edit', [$event->id, $session->id]) }}">{{ $session->title }}</a></td>
                                    <td class="text-nowrap">{{ $session->speaker }}</td>
                                    <td class="text-nowrap">{{ $session->room->name }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Channels -->
                <div id="channels" class="mb-3 pt-3 pb-2">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                        <h2 class="h4">Channels</h2>
                        <div class="btn-toolbar mb-2 mb-md-0">
                            <div class="btn-group mr-2">
                                <a href="{{ route('channels.create', $event->id) }}" class="btn btn-sm btn-outline-secondary">
                                    Create new channel
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row channels">
                    @foreach($event->channels as $channel)
                        <div class="col-md-4">
                            <div class="card mb-4 shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $channel->name }}</h5>
                                    <p class="card-text">{{ $channel->sessions()->count() }} sessions, {{ $channel->rooms()->count() }} room</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Rooms -->
                <div id="rooms" class="mb-3 pt-3 pb-2">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                        <h2 class="h4">Rooms</h2>
                        <div class="btn-toolbar mb-2 mb-md-0">
                            <div class="btn-group mr-2">
                                <a href="{{ route('rooms.create', $event->id) }}" class="btn btn-sm btn-outline-secondary">
                                    Create new room
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive rooms">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Capacity</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($event->rooms as $room)
                            <tr>
                                <td>{{ $room->name }}</td>
                                <td>{{ $room->capacity }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </main>
        </div>
    </div>
@endsection
