@extends('layouts.app')

@section('title', 'Создать заявку')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h2 class="mb-4">Создать заявку на продажу</h2>
                <form method="POST" action="{{ route('applications.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="address" class="form-label">Адрес</label>
                        <input type="text" id="address" name="address"
                               class="form-control @error('address') is-invalid @enderror"
                               value="{{ old('address') }}" required>
                        @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="count_rooms" class="form-label">Количество комнат</label>
                        <input type="number" id="count_rooms" name="count_rooms" min="1"
                               class="form-control @error('count_rooms') is-invalid @enderror"
                               value="{{ old('count_rooms') }}" required>
                        @error('count_rooms')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Цена (руб.)</label>
                        <input type="number" id="price" name="price" min="0"
                               class="form-control @error('price') is-invalid @enderror"
                               value="{{ old('price') }}" required>
                        @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="type_buy_id" class="form-label">Тип сделки</label>
                        <select id="type_buy_id" name="type_buy_id"
                                class="form-select @error('type_buy_id') is-invalid @enderror"
                                required>
                            <option value="">Выберите тип</option>
                            @foreach($typeBuys as $type)
                                <option value="{{ $type->id }}"
                                        @if(old('type_buy_id') == $type->id) selected @endif>
                                    {{ $type->type_buy }}
                                </option>
                            @endforeach
                        </select>
                        @error('type_buy_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="path_image" class="form-label">Фотография (опционально, jpg/png/gif, до 2МБ)</label>
                        <input type="file" class="form-control @error('path_image') is-invalid @enderror" name="path_image" id="path_image" accept="image/*">
                        @error('path_image')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Сохранить заявку</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
