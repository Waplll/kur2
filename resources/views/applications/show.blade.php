@extends('layouts.app')

@section('title', 'Просмотр заявки')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2>Информация о заявке</h2>
                <dl class="row mb-4">
                    <dt class="col-sm-4">Адрес</dt>
                    <dd class="col-sm-8">{{ $application->address }}</dd>

                    <dt class="col-sm-4">Количество комнат</dt>
                    <dd class="col-sm-8">{{ $application->count_rooms }}</dd>

                    <dt class="col-sm-4">Цена (руб.)</dt>
                    <dd class="col-sm-8">{{ number_format($application->price, 0, ',', ' ') }}</dd>

                    <dt class="col-sm-4">Тип сделки</dt>
                    <dd class="col-sm-8">{{ $application->typeBuy->type_buy ?? 'N/A' }}</dd>

                    <dt class="col-sm-4">Статус</dt>
                    <dd class="col-sm-8"><span class="badge bg-info">{{ $application->status->status ?? 'Неизвестно' }}</span></dd>

                    <dt class="col-sm-4">Дата создания</dt>
                    <dd class="col-sm-8">{{ $application->created_at->format('d.m.Y H:i') }}</dd>

                    <div class="mb-3">
                        <label class="form-label"><strong>Телефон:</strong></label>
                        <p>{{ $application->phone ?? 'Не указан' }}</p>
                    </div>


                @if ($application->path_image)
                        <dt class="col-sm-4">Фотография</dt>
                        <dd class="col-sm-8">
                            <img src="{{ asset('storage/' . $application->path_image) }}"
                                 alt="Фото объекта" class="img-fluid rounded shadow" style="max-width: 320px;">
                        </dd>
                    @endif
                </dl>

                <a href="{{ route('applications.index') }}" class="btn btn-secondary">Вернуться к списку</a>
            </div>
        </div>
    </div>
@endsection
