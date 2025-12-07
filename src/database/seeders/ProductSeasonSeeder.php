<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Season;

class ProductSeasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 商品と季節の紐付け設定
        $map = [
            'キウイ' => ['秋', '冬'],
            'ストロベリー' => ['春'],
            'オレンジ' => ['冬'],
            'スイカ' => ['夏'],
            'ピーチ' => ['夏'],
            'シャインマスカット' => ['夏', '秋'],
            'パイナップル' => ['春', '夏'],
            'ブドウ' => ['夏', '秋'],
            'バナナ' => ['夏'],
            'メロン' => ['春', '夏'],
        ];

        $seasonIds = Season::pluck('id', 'name');

        foreach ($map as $productName => $seasonNames) {

            $product = Product::where('name', $productName)->first();

            if (!$product) continue;

            $attachIds = [];

            foreach ($seasonNames as $sName) {
                if (isset($seasonIds[$sName])) {
                    $attachIds[] = $seasonIds[$sName];
                }
            }

            $product->seasons()->attach($attachIds);
        }
    }
}
