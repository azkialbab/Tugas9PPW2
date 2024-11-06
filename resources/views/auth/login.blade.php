@extends('auth.layouts')

<!-- Link ke Bootstrap 5 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">

@section('content')

<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Login</div>
            <div class="card-body">
                <form action="{{ route('authenticate') }}" method="post">
                    @csrf
                    <!-- Kolom Email -->
                    <div class="mb-3 row">
                        <label for="email" class="col-md-4 col-form-label text-md-end">Email Address</label>
                        <div class="col-md-6">
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}">
                            @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- Kolom Password -->
                    <div class="mb-3 row">
                        <label for="password" class="col-md-4 col-form-label text-md-end">Password</label>
                        <div class="col-md-6">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                            @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- Tombol Login -->
                    <div class="mb-3 row">
                        <div class="col-md-12 d-flex justify-content-center">
                            <input type="submit" class="btn btn-primary" value="Login">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
