@extends('layouts.app')

@section('title', 'Главная - Недвижимость')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <h1 class="mb-5">Одобренные заявки</h1>

                @if($applications->count() > 0)
                    <div class="row justify-content-center">
                        @foreach($applications as $application)
                            <div class="col-lg-4 col-md-6 mb-4 d-flex justify-content-center">
                                <a href="{{ route('applications.show', $application->id) }}" style="text-decoration: none; color: inherit; width: 100%; max-width: 420px;">
                                    <div class="card h-100 shadow-sm" style="cursor: pointer; transition: transform 0.2s, box-shadow 0.2s;">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $application->address }}</h5>

                                            <div class="mb-2">
                                                <small class="text-muted">
                                                    <i class="bi bi-geo-alt"></i>
                                                    {{ $application->address ?? 'Нет адреса' }}
                                                </small>
                                            </div>

                                            <div class="row mb-2">
                                                <div class="col-6">
                                                    <small><strong>Цена:</strong> {{ $application->price ? number_format($application->price, 0, ',', ' ') . ' ₽' : 'Не указана' }}</small>
                                                </div>
                                                <div class="col-6 text-end">
                                                    <span class="badge bg-success">{{ $application->status?->name ?? 'Нет статуса' }}</span>
                                                </div>
                                            </div>

                                            <div class="row mb-2">
                                                <div class="col-12">
                                                    <small><strong>Тип:</strong> {{ $application->type_buy?->name ?? 'Не указан' }}</small>
                                                </div>
                                            </div>

                                            <small class="text-muted d-block">
                                                <i class="bi bi-calendar"></i>
                                                {{ $application->created_at->format('d.m.Y') }}
                                            </small>
                                        </div>
                                        <div class="card-footer bg-transparent border-top">
                                            <div class="text-center">
                                                <small class="text-primary">Нажмите для просмотра →</small>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-info text-center">
                        <p>Одобренных заявок нет</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        .card {
            border: none;
            overflow: hidden;
        }

        a .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15) !important;
        }

        a .card {
            transition: all 0.3s ease;
        }
    </style>
@endsection
