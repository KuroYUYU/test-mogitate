# アプリケーション名
Mogitate（商品登録管理アプリ）

# 環境構築
## Dockerビルド
・git clone git@github.com:KuroYUYU/test-mogitate.git

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

## ダミーデータの商品画像について

本アプリは、商品画像を `storage/app/public` に保存して表示します。  
GitHub 上には画像ファイルは含めていません。  
動作確認の際は、配布された「商品画像素材」を `storage/app/public` に配置してください。

# 開発環境
・商品一覧画面：http://localhost/products

・phpMyAdmin：http://localhost:8080/

# 使用技術(実行環境)
・PHP:8.1.33

・Laravel:8.83.29

・MySQL:Ver 8.0.26

・nginx:1.21.1

# ER図
<img width="861" height="473" alt="スクリーンショット 2025-12-08 6 21 07" src="https://github.com/user-attachments/assets/5426912b-6acb-4c92-9ad5-f82fde4d2df4" />

