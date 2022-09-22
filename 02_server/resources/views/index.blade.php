@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <main class="col-md-6 mx-sm-auto px-4">
                <div class="pt-3 pb-2 mb-3 border-bottom text-center">
                    <h1 class="h2">WorldSkills Event Platform</h1>
                </div>

                <form class="form-signin" method="POST" action="{{ route('login') }}">
                    @csrf
                    <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>

                    <label for="inputEmail" class="sr-only">Email</label>
                    <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email" autofocus>

                    <label for="inputPassword" class="sr-only">Password</label>
                    <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password">
                    @error('email')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <button class="btn btn-lg btn-primary btn-block" id="login" type="submit">Sign in</button>
                </form>

            </main>
        </div>
    </div>
@endsection
