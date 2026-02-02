# 掲示板アプリ
Demo:https://bulletin-board-app-wlhj.onrender.com/posts

Laravelで作成した、認証機能付きのシンプルな掲示板アプリです。
ユーザーはログイン後、投稿の作成・編集・削除（CRUD）を行えます。

基本的な設計思想（MVC、認証、CRUD）を理解し、
実務でよく使われる機能構成を意識して作成したポートフォリオです。

---

## 機能

* ユーザー登録 / ログイン / ログアウト
* プロフィール編集（表示名・アバター画像）
* 投稿の一覧 / 作成 / 編集 / 削除

  * 投稿者本人のみ編集・削除可能
* 投稿画像のアップロード
* ページネーション（最新順）

---

## 使用技術

* Laravel 12
* PHP 8.4+
* Vite
* SQLite（ローカル開発）
* GitHub Actions（CI）

---

## セットアップ

```bash
composer install
copy .env.example .env
php artisan key:generate
php artisan migrate
npm install
npm run dev
```

---

## テスト

```bash
php artisan test
```

---

## 補足

* `.env` やDBファイルはリポジトリに含めていません
* デプロイ手順は [DEPLOY.md](DEPLOY.md) に記載しています
