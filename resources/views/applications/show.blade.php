@extends('layouts.app')

@section('title', 'Просмотр заявки')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0 text-center">Детали заявки</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted">Адрес:</h6>
                            <p class="h5">{{ $application->address }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Статус:</h6>
                            <p class="h5">
                                <span class="badge bg-info text-dark">{{ $application->status->status ?? 'Неизвестно' }}</span>
                            </p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted">Комнаты:</h6>
                            <p class="h5">{{ $application->count_rooms }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Цена:</h6>
                            <p class="h5">{{ number_format($application->price, 0, ',', ' ') }} руб.</p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted">Тип покупки:</h6>
                            <p class="h5">{{ $application->typeBuy->type_buy ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Дата создания:</h6>
                            <p class="h5">{{ $application->created_at->format('d.m.Y H:i') }}</p>
                        </div>
                    </div>

                    @if($application->path_image)
                        <div class="mb-4">
                            <h6 class="text-muted">Фото:</h6>
                            <img src="{{ asset('storage/' . $application->path_image) }}" alt="Фото объекта" class="img-fluid img-thumbnail" style="max-width: 100%;">
                        </div>
                    @endif

                    <div class="mb-4">
                        <h6 class="text-muted">Владелец заявки:</h6>
                        <p class="h5">{{ $application->user->name }}</p>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('applications.index') }}" class="btn btn-secondary">Вернуться к списку</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
