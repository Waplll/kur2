@extends('layouts.app')

@section('title', 'Админка: все заявки')

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">Административная панель заявок</h2>
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                <tr>
                    <th>Пользователь</th>
                    <th>Адрес</th>
                    <th>Комнаты</th>
                    <th>Цена</th>
                    <th>Тип</th>
                    <th>Статус</th>
                    <th>Дата</th>
                    <th>Фото</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach($applications as $app)
                    <tr>
                        <td>{{ $app->user->name ?? '-' }}</td>
                        <td>{{ $app->address }}</td>
                        <td>{{ $app->count_rooms }}</td>
                        <td>{{ number_format($app->price, 0, ',', ' ') }}</td>
                        <td>{{ $app->typeBuy->type_buy ?? 'N/A' }}</td>
                        <td>
                            <span class="badge bg-info">{{ $app->status->status ?? 'Неизвестно' }}</span>
                        </td>
                        <td>{{ $app->created_at->format('d.m.Y H:i') }}</td>
                        <td>
                            @if ($app->path_image)
                                <img src="{{ asset('storage/' . $app->path_image) }}" alt="Фото" style="max-width: 80px;">
                            @else
                                —
                            @endif
                        </td>
                        <td>
                            @if ($app->status_id == 1)
                                <form action="{{ route('admin.applications.approve', $app->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm mb-1">Одобрить</button>
                                </form>
                                <br>
                                <form action="{{ route('admin.applications.decline', $app->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm mb-1">Отклонить</button>
                                </form>
                                <br>
                            @endif

                            <form action="{{ route('admin.applications.destroy', $app->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Удалить эту заявку?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash"></i> Удалить
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{-- Для пагинации, если используется ->paginate --}}
            @if(method_exists($applications, 'links'))
                {{ $applications->links() }}
            @endif
        </div>
    </div>
@endsection
