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
                        <h2 class="h4">Room Capacity</h2>
                    </div>
                </div>

                <canvas id="myChart"></canvas>

            </main>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{ asset('public/assets/Chart.min.js') }}"></script>
    <script>
        const ctx = document.getElementById('myChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($rooms->pluck('name')),
                datasets: [{
                    label: 'Attendees',
                    data: @json($rooms->pluck('session_registrations_count')),
                    backgroundColor: JSON.parse('<?= json_encode($rooms->map(fn($room) => $room->capacity > $room->session_registrations_count ? 'rgba(75, 192, 192, .3)' : 'rgba(255, 99, 132, .3)')->toArray()) ?>'),
                    borderColor: JSON.parse('<?= json_encode($rooms->map(fn($room) => $room->capacity > $room->session_registrations_count ? 'rgba(75, 192, 192, .3)' : 'rgba(255, 99, 132, .3)')->toArray()) ?>'),
                    borderWidth: 1
                },
                    {
                        label: 'Capacity',
                        data: @json($rooms->pluck('capacity')),
                        backgroundColor: JSON.parse('<?= json_encode($rooms->map(fn($room) => 'rgba(54, 162, 235, .3)')->toArray()) ?>'),
                        borderColor: JSON.parse('<?= json_encode($rooms->map(fn($room) => 'rgba(54, 162, 235, .3)')->toArray()) ?>'),
                        borderWidth: 1
                    }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
@endsection
