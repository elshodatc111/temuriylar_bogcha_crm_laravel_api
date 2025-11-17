@extends('layouts.app')
@section('title','Dashboard')
@section('content')

<div class="card">
    <div class="card-body">
        <h2 class="card-title">Dashboard</h2>
        <h2>Assalomu alaykum, {{ auth()->user()->name }}!</h2>
        <p>Lavozim: {{ auth()->user()->position->name ?? '-' }}</p>
        <p>Telefon: {{ auth()->user()->phone }}</p>
    </div>
</div>


@endsection
