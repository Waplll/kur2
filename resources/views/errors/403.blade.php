@extends('layouts.app')
@section('title', 'Доступ запрещён')

@section('content')
    <div class="container mt-5 text-center">
        <h1 class="display-1 text-danger">403</h1>
        <h2>Доступ запрещён</h2>
        <p class="lead">У вас нет прав для доступа к этой странице.</p>
        <p>Только администраторы могут просматривать админ-панель.</p>
        <a href="{{ route('home') }}" class="btn btn-primary mt-3">Вернуться на главную</a>
    </div>
@endsection
