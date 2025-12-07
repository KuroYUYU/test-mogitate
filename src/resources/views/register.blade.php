@extends('layouts.app')

@section('css')
	<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<div class="product-register">
    <div class="product-register__card">
        <h2 class="product-register__title">商品登録</h2>
        <form class="product-register__form" method="post" enctype="multipart/form-data">
            @csrf
            {{-- 商品名 --}}
            <div class="product-register__group">
                <label class="product-register__label" for="name">
                    商品名
                    <span class="product-register__badge product-register__badge--required">必須</span>
                </label>
                <input class="product-register__input" id="name" type="text" name="name" placeholder="商品名を入力" value="{{ old('name') }}">
                @error('name')
                    <p class="product-register__error">{{ $message }}</p>
                @enderror
            </div>

            {{-- 値段 --}}
            <div class="product-register__group">
                <label class="product-register__label" for="price">
                    値段
                    <span class="product-register__badge product-register__badge--required">必須</span>
                </label>
                <input class="product-register__input" id="price" type="text" name="price" placeholder="価格を入力" value="{{ old('price') }}">
                @error('price')
                    <p class="product-register__error">{{ $message }}</p>
                @enderror
            </div>

            {{-- 商品画像 --}}
            <div class="product-register__group">
                <label class="product-register__label" for="image">
                    商品画像
                    <span class="product-register__badge product-register__badge--required">必須</span>
                </label>
                {{-- 画像プレビュー表示用 --}}
                <div class="product-register__preview">
                    <img id="preview-image" src="" alt="" style="display:none;">
                </div>

                <input id="image" type="file" name="image" class="product-register__file">
                @error('image')
                    <p class="product-register__error">{{ $message }}</p>
                @enderror
            </div>

            {{-- 季節 --}}
            <div class="product-register__group">

                <div class="product-register__label-row">
                    <span class="product-register__label">季節</span>
                    <span class="product-register__badge product-register__badge--required">必須</span>
                </div>

                @php
                    $seasonMaster = [
                        'spring' => '春',
                        'summer' => '夏',
                        'autumn' => '秋',
                        'winter' => '冬',
                    ];

                    $selectedSeasons = isset($product)
                        ? explode(',', $product->season)
                        : [];
                @endphp

                <div class="product-register__season-group">
                    {{-- seasonモデルより季節を読み取る --}}
                    @foreach($seasons as $season)
                        <label class="product-register__season-item">
                            <input class="product-register__season-input" type="checkbox" name="season[]" value="{{ $season->id }}" {{ in_array($season->id, old('season', [])) ? 'checked' : '' }}>
                            <span class="product-register__season-label">
                                {{ $season->name }}
                            </span>
                        </label>
                    @endforeach
                </div>

                @error('season')
                    <p class="product-register__error">{{ $message }}</p>
                @enderror
            </div>

            {{-- 商品説明 --}}
            <div class="product-register__group">
                <label class="product-register__label" for="description">
                    商品説明
                    <span class="product-register__badge product-register__badge--required">必須</span>
                </label>
                <textarea class="product-register__textarea" id="description" name="description" rows="5" placeholder="商品の説明を入力">{{ old('description') }}</textarea>
                @error('description')
                    <p class="product-register__error">{{ $message }}</p>
                @enderror
            </div>

            {{-- 下部ボタン --}}
            <div class="product-register__actions">
                <a href="/products" class="product-register__button product-register__button--secondary">戻る</a>
                <button type="submit" class="product-register__button product-register__button--primary">登録</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('js/image-preview.js') }}"></script>
@endsection
