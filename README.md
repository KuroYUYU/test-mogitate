# アプリケーション名
Mogitate（商品登録管理アプリ）

# 環境構築
## Dockerビルド
・git clone git@github.com:KuroYUYU/変える.git

・docker-compose up -d --build

## Larabel環境構築
・docker-compose exec php bash

・composer install

・cp .env.example .env , 環境変数を適宣変更

・php artisan key:generate

・php artisan migrate

・php artisan db:seed

・php artisan storage:link  
ブラウザから画像を表示するために、public/storage へのシンボリックリンク作成が必要です。  
そのため上記コマンドを実行してください。

## 商品画像について

本アプリでは、商品画像を `storage/app/public` に保存して表示する仕様です。  
GitHub 上には画像ファイルは含めていません。  
動作確認の際は、商品登録画面から画像をアップロードしてご利用ください。

# 開発環境
・商品一覧画面：http://localhost/products

・phpMyAdmin：http://localhost:8080/

# 使用技術(実行環境)
・PHP:8.1.33


・Laravel:8.83.29

・MySQL:Ver 8.0.26

・nginx:1.21.1

# ER図
