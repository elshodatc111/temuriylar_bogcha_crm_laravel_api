@extends('layouts.app')
@section('title','Xonalar')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1 page-header-title">Xonalar</h2>
            <p class="mb-0 page-header-sub">Bog‘chadagi mavjud xonalar</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card role-card bg-gradient">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="card-title role-title mb-0">Management (Boshqaruv)</h2>
                <span class="role-badge">
                    <button class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#verticalycentered"><i class="bi bi-plus"></i> Yangi xona</button>
                </span>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-bordered text-center">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Xona nomi</th>
                            <th scope="col">Xona haqida</th>
                            <th scope="col">Xona sig'imi</th>
                            <th scope="col">Xona yaratdi</th>
                            <th scope="col">Xona yaratildi</th>
                            <th scope="col">Xonani o'chirdi</th>
                            <th scope="col">Xonani o'chirish</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rooms as $item)
                            <tr>
                                <th scope="row">{{ $loop->index+1 }}</th>
                                <td>{{ $item['name'] }}</td>
                                <td>{{ $item['about'] }}</td>
                                <td>{{ $item['size'] }}</td>
                                <td>{{ $item['user'] }}</td>
                                <td>{{ $item['created_at'] }}</td>
                                <td>
                                    {{ !$item['status']?$item['delete_user']:" " }}
                                </td>
                                <td>
                                    @if(!$item['status'])
                                        {{ $item['delete_data'] }}
                                    @else
                                        <form action="{{ route('rooms_delete') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $item['id'] }}">
                                            <button class="btn btn-danger px-1 py-0" type="submit"><i class="bi bi-trash"></i></button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center" colspan=8>Xonalar mavjud emas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="verticalycentered" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Yangi xona</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('rooms_create') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="name">Xona nomi</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="about">Xona haqida</label>
                            <textarea name="about" id="about" rows="3" class="form-control @error('about') is-invalid @enderror" required>{{ old('about') }}</textarea>
                            @error('about')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="size">Xona sig'imi</label>
                            <input type="number" name="size" id="size" value="{{ old('size') }}" class="form-control @error('size') is-invalid @enderror" required>
                            @error('size')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary w-100"><i class="bi bi-save"></i> Saqlash</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
