@extends('layouts.app')

@section('css')
	<link rel="stylesheet" href="{{ asset('css/products.css') }}">
@endsection

@section('content')
<div class="product-page">

    <!-- 左サイドバー（検索・ソート） -->
    <aside class="product-sidebar">
        <!-- 検索した際は””の商品一覧を表示 -->
        <h2 class="product-sidebar__title">
            @if (!empty($keyword))
                “{{ $keyword }}”の商品一覧
            @else
                商品一覧
            @endif
        </h2>

        <form id="product-filter-form" class="product-search" action="/products/search" method="GET">
            <input class="product-search__input" id="keyword" type="text" name="keyword" placeholder="商品名で検索" value="{{ old('keyword', $keyword) }}">
            <button class="product-search__button" type="submit">検索</button>

            <div class="product-sort">
                <p class="product-sort__label">価格順で表示</p>
                <select class="product-sort__select" name="sort">
                    {{-- 空のoptionを無効化＋選択不可にする --}}
                    <option value="" disabled selected hidden>価格で並べ替え</option>
                    <option value="price_desc" {{ $sort === 'price_desc' ? 'selected' : '' }}>高い順に表示</option>
                    <option value="price_asc"  {{ $sort === 'price_asc'  ? 'selected' : '' }}>低い順に表示</option>
                </select>
            </div>
            {{-- 並べ替えリセットボタンは並べ替え中だけ表示 --}}
            @if (!empty($sort))
                {{-- 並べ替えた時のリセットボタンの文言を変える --}}
                @php
                $sortLabel = $sort === 'price_desc' ? '価格が高い順' : ($sort === 'price_asc' ? '価格が低い順' : '');
                @endphp
                <a href="/products" class="sort-reset-button">
                    {{ $sortLabel }} ×
                </a>
            @endif
        </form>
    </aside>

    <!-- 右側ブロック -->
    <section class="product-content">
        <!-- タイトル + 追加ボタン -->
        <div class="product-content__header">
            <!-- 検索した時はボタンを非表示にする -->
            <a class="product-content__add-button {{ !empty($keyword) ? 'product-content__add-button--hidden' : '' }}" href="/products/register">
                ＋ 商品を追加
            </a>
        </div>

        <!-- 商品カード一覧表示 -->
        <ul class="product-grid">
            @foreach ($products as $product)
                <li class="product-card">
                    <a href="/products/detail/{{ $product->id }}" class="product-card__link">
                        <img class="product-card__image" src="{{ asset('storage/'.$product->image) }}">

                        <div class="product-card__body">
                            <p class="product-card__name">{{ $product->name }}</p>
                            <p class="product-card__price">¥{{ number_format($product->price) }}</p>
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>

        <!-- ページネーション -->
        <div class="product-pagination">
            {{ $products->links() }}
        </div>
    </section>
</div>
@endsection

@section('js')
<script src="{{ asset('js/card-sort.js') }}"></script>
@endsection