<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\Season;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // 検索機能はindexにて行うよう実施、ルートは仕様通り
        $keyword = $request->input('keyword');  // 商品名検索用
        $sort    = $request->input('sort');     // 並び替え条件

        $products = Product::query()
            ->latest()  // 新着順（created_at DESC）
            ->nameLike($keyword)
            ->sortByCondition($sort)
            ->paginate(6)
            ->withQueryString(); // ページングしても検索条件維持させる

        return view('products', compact('products', 'keyword', 'sort'));
    }

    public function create()
    {
        $seasons = Season::all();
        return view('register', [
            'seasons' => $seasons
        ]);
    }

    public function store(ProductRequest $request)
    {
        $validated = $request->validated();

        // チェックされた季節ID
        $seasonIds = $validated['season'];
        unset($validated['season']);

        $imagePath = $request->file('image')->store('products', 'public');

        // 作成したProductを$productに代入
        $product = Product::create([
            'name'        => $validated['name'],
            'price'       => $validated['price'],
            'image'       => $imagePath,
            'description' => $validated['description'],
        ]);

        // 中間テーブルに紐付る
        $product->seasons()->attach($seasonIds);

        return redirect('products');
    }

    public function show($productId)
    {
        $product = Product::with('seasons')->findOrFail($productId);
        $seasons = Season::all();
        // 季節DBのID配列で取得
        $productSeasonIds = $product->seasons->pluck('id')->toArray();

        if (session()->hasOldInput()) {
            // バリデーションエラー（未選択状態）にした際は未選択状態で残る
            $selectedSeasonIds = (array) old('season', []);
        } else {
            // 初回表示はDBに保存されている季節をチェック状態にする
            $selectedSeasonIds = $productSeasonIds;
        }

        return view('detail', [
            'product' => $product,
            'seasons' => $seasons,
            'selectedSeasonIds' => $selectedSeasonIds,
        ]);
    }

    public function update(ProductRequest $request, Product $product)
    {
        // バリデーション済みデータを取得
        $validated = $request->validated();

        $seasonIds = $validated['season'];
        unset($validated['season']);

        // 古い画像を削除
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        // 新しい画像を保存（バリデーション文言を表示させる関係で毎回必ず画像を選択させるしかできませんでした)
        $imagePath = $request->file('image')->store('products', 'public');

        $product->update([
            'name'        => $validated['name'],
            'price'       => $validated['price'],
            'description' => $validated['description'],
            'image'       => $imagePath,
        ]);

        // 季節の紐付けを更新
        $product->seasons()->sync($seasonIds);

        return redirect('products');
    }

    public function destroy(Product $product)
    {
        // 本番運用時は画像ファイルも削除する想定
        // Storage::disk('public')->delete($product->image);
        // 今回の課題では、シーダーで投入したダミー画像を保持したいので
        // 画像削除は行わず、レコードのみ削除する

        $product->delete();

        return redirect('products');
    }
}
