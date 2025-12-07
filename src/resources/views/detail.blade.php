@extends('layouts.app')

@section('css')
	<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
<div class="product-detail">
    {{-- パンくずリスト部 --}}
    <div class="product-detail__breadcrumb">
        <a href="/products" class="product-detail__breadcrumb-link">商品一覧</a>
        <span class="product-detail__breadcrumb-separator">＞</span>
        <span class="product-detail__breadcrumb-current">{{ $product->name }}</span>
    </div>

    {{-- カード内容 --}}
    <form action="/products/{{ $product->id }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="product-detail__card">
            <div class="product-detail__top">
                {{-- jsを使用し変更した画像を表示 --}}
                <div class="product-detail__image-area">
                    <img id="preview-image" class="product-detail__image" src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}">
                    <div class="product-detail__file">
                        <input id="image" type="file" name="image">
                    </div>
                    @error('image')
                        <p class="product-detail__error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="product-detail__info">
                    {{-- 商品名 --}}
                    <div class="product-detail__field">
                        <label class="product-detail__label">商品名</label>
                        <input class="product-detail__input" type="text" name="name" value="{{ old('name', $product->name) }}" placeholder="商品名を入力">
                    </div>
                    @error('name')
                        <p class="product-detail__error">{{ $message }}</p>
                    @enderror

                    {{-- 値段 --}}
                    <div class="product-detail__field">
                        <label class="product-detail__label">値段</label>
                        <input class="product-detail__input" type="text" name="price" value="{{ old('price', $product->price) }}" placeholder="値段を入力">
                    </div>
                    @error('price')
                        <p class="product-detail__error">{{ $message }}</p>
                    @enderror

                    {{-- 季節 --}}
                    <div class="product-detail__field">
                        <label class="product-detail__label">季節</label>
                        <div class="product-detail__season">
                            @foreach($seasons as $season)
                                <label class="product-detail__season-item">
                                    <input class="product-detail__season-input" type="checkbox" name="season[]" value="{{ $season->id }}" {{ in_array($season->id, $selectedSeasonIds, true) ? 'checked' : '' }}>
                                    <span class="product-detail__season-label">
                                        {{ $season->name }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                        @error('season')
                            <p class="product-detail__error">{{ $message }}</p>
                        @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- 商品説明 --}}
            <div class="product-detail__bottom">
                <label class="product-detail__label">商品説明</label>
                <textarea class="product-detail__textarea" name="description" placeholder="商品の説明を入力">{{ old('description', $product->description) }}</textarea>
            </div>
            @error('description')
                <p class="product-detail__error">{{ $message }}</p>
            @enderror

            {{-- 保存と戻るボタン --}}
            <div class="product-detail__actions">
                <a href="/products" class="product-detail__button product-detail__button--secondary">戻る</a>
                <button class="product-detail__button product-detail__button--primary" type="submit">変更を保存</button>
            </div>
        </div>
    </form>

    {{-- 削除ボタン --}}
    <form action="/products/{{ $product->id }}" method="POST" class="product-detail__delete-form">
        @csrf
        @method('DELETE')
        {{-- &#x1F5D1;ゴミ箱マーク --}}
        <button class="product-detail__delete" type="submit">&#x1F5D1;</button>
    </form>
</div>
@endsection

@section('js')
<script src="{{ asset('js/image-preview.js') }}"></script>
@endsection
