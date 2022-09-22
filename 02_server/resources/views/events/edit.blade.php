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
                </div>

                <form class="needs-validation" novalidate action="{{ route('events.edit', $event->id) }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-12 col-lg-4 mb-3">
                            <label for="inputName">Name</label>
                            <!-- adding the class is-invalid to the input, shows the invalid feedback below -->
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="inputName" name="name" placeholder="" value="{{ old('name') ?? $event->name }}">
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-lg-4 mb-3">
                            <label for="inputSlug">Slug</label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="inputSlug" name="slug" placeholder="" value="{{ old('slug') ?? $event->slug }}">
                            @error('slug')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-lg-4 mb-3">
                            <label for="inputDate">Date</label>
                            <input type="text"
                                   class="form-control @error('date') is-invalid @enderror"
                                   id="inputDate"
                                   name="date"
                                   placeholder="yyyy-mm-dd"
                                   value="{{ old('date') ?? $event->date }}">
                            @error('date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <hr class="mb-4">
                    <button class="btn btn-primary" type="submit">Save</button>
                    <a href="{{ route('events.detail', $event->id) }}" class="btn btn-link">Cancel</a>
                </form>

            </main>
        </div>
    </div>
@endsection
