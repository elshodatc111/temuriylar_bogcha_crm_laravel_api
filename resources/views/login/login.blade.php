@extends('layouts.login')
@section('title','Kirish')
@section('content')
    <div class="container">
        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="pt-4 pb-2">
                                    <h5 class="card-title text-center pb-0 fs-4">Kirish</h5>
                                </div>
                                <form method="POST" action="{{ route('login') }}" class="row g-3 needs-validation" novalidate>
                                    @csrf
                                    @if(session('message'))
                                        <div class="alert alert-warning mt-3 w-100 text-center">
                                            {{ session('message') }}
                                        </div>
                                    @endif
                                    @if (session('error'))
                                        <div class="alert alert-danger mt-3 w-100 text-center">
                                            {{ session('error') }}
                                        </div>
                                    @endif
                                    <div class="col-12">
                                        <label for="yourUsername" class="form-label">Telefon raqam</label>
                                        <div class="input-group has-validation">
                                             <input type="text" name="phone" class="form-control phone @error('phone') is-invalid @enderror" value="+998" placeholder="+998 90 123 4567" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label for="yourPassword" class="form-label">Parol</label>
                                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"  required>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="rememberMe">Eslab qolish</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn-primary w-100" type="submit">Kirish</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
