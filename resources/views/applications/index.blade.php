@extends('layouts.app')

@section('title', 'Мои заявки')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>Мои заявки на продажу</h2>
                    <a href="{{ route('applications.create') }}" class="btn btn-success">+ Создать заявку</a>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($applications->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                            <tr>
                                <th>Адрес</th>
                                <th>Комнаты</th>
                                <th>Цена (руб.)</th>
                                <th>Тип</th>
                                <th>Статус</th>
                                <th>Дата создания</th>
                                <th>Действия</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($applications as $app)
                                <tr>
                                    <td>{{ $app->address }}</td>
                                    <td>{{ $app->count_rooms }}</td>
                                    <td>{{ number_format($app->price, 0, ',', ' ') }}</td>
                                    <td>{{ $app->typeBuy->type_buy ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge bg-info">{{ $app->status->status ?? 'Неизвестно' }}</span>
                                    </td>
                                    <td>{{ $app->created_at->format('d.m.Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route('applications.show', $app->id) }}" class="btn btn-sm btn-primary">Просмотр</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info text-center">
                        <p>У вас ещё нет заявок.</p>
                        <a href="{{ route('applications.create') }}" class="btn btn-success">Создать первую заявку</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
