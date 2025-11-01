@extends('layouts.app')

@section('title', 'Создание заявки на продажу')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0 text-center">Создание заявки на продажу недвижимости</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('applications.store') }}" enctype="multipart/form-data">
                            @csrf

                            <!-- Адрес -->
                            <div class="mb-3">
                                <label for="address" class="form-label">Адрес объекта *</label>
                                <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address') }}" placeholder="Улица, дом, квартира" required>
                                @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Количество комнат -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="count_rooms" class="form-label">Количество комнат *</label>
                                    <input type="number" class="form-control @error('count_rooms') is-invalid @enderror" id="count_rooms" name="count_rooms" value="{{ old('count_rooms') }}" min="1" placeholder="1" required>
                                    @error('count_rooms')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Цена -->
                                <div class="col-md-6 mb-3">
                                    <label for="price" class="form-label">Цена (руб.) *</label>
                                    <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}" min="0" placeholder="0" required>
                                    @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Тип покупки -->
                            <div class="mb-3">
                                <label for="type_buy_id" class="form-label">Тип покупки *</label>
                                <select class="form-select @error('type_buy_id') is-invalid @enderror" id="type_buy_id" name="type_buy_id" required>
                                    <option value="">-- Выберите тип --</option>
                                    @foreach($typeBuys as $type)
                                        <option value="{{ $type->id }}" @if(old('type_buy_id') == $type->id) selected @endif>
                                            {{ $type->type_buy }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('type_buy_id')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Изображение -->
                            <div class="mb-3">
                                <label for="path_image" class="form-label">Фото объекта (опционально)</label>
                                <input type="file" class="form-control @error('path_image') is-invalid @enderror" id="path_image" name="path_image" accept="image/*">
                                <small class="text-muted">Разрешённые форматы: JPEG, PNG, JPG, GIF. Максимальный размер: 2MB</small>
                                @error('path_image')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Preview изображения -->
                            <div class="mb-3" id="imagePreview" style="display: none;">
                                <img id="previewImg" src="" alt="Preview" class="img-thumbnail" style="max-width: 200px;">
                            </div>

                            <!-- Кнопки -->
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-success flex-grow-1">Создать заявку</button>
                                <a href="{{ route('applications.index') }}" class="btn btn-secondary">Отмена</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script для preview изображения -->
    <script>
        document.getElementById('path_image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('imagePreview');
            const previewImg = document.getElementById('previewImg');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    previewImg.src = event.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
            }
        });
    </script>
@endsection
