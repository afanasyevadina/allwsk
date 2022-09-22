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
                        <h2 class="h4">Create new ticket</h2>
                    </div>
                </div>

                <form class="needs-validation" novalidate action="{{ route('tickets.create', $event->id) }}" method="POST">
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
                            <label for="inputCost">Cost</label>
                            <input type="number" class="form-control @error('cost') is-invalid @enderror" id="inputCost" name="cost" placeholder="" value="{{ old('cost', 0) }}">
                            @error('cost')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-lg-4 mb-3">
                            <label for="selectSpecialValidity">Special Validity</label>
                            <select class="form-control @error('special_validity') is-invalid @enderror" id="selectSpecialValidity" name="special_validity">
                                <option value="" selected>None</option>
                                <option {{ old('special_validity') == 'amount' ? 'selected' : '' }} value="amount">Limited amount</option>
                                <option {{ old('special_validity') == 'date' ? 'selected' : '' }} value="date">Purchaseable till date</option>
                            </select>
                            @error('special_validity')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-lg-4 mb-3">
                            <label for="inputAmount">Maximum amount of tickets to be sold</label>
                            <input type="number" class="form-control @error('amount') is-invalid @enderror" id="inputAmount" name="amount" placeholder="" value="{{ old('amount', 0) }}">
                            @error('amount')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-lg-4 mb-3">
                            <label for="inputValidTill">Tickets can be sold until</label>
                            <input type="text"
                                   class="form-control @error('date') is-invalid @enderror"
                                   id="inputValidTill"
                                   name="date"
                                   placeholder="yyyy-mm-dd HH:MM"
                                   value="">
                            @error('date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <hr class="mb-4">
                    <button class="btn btn-primary" type="submit">Save ticket</button>
                    <a href="{{ route('events.detail', $event->id) }}" class="btn btn-link">Cancel</a>
                </form>

            </main>
        </div>
    </div>
@endsection
