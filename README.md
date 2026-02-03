# 掲示板アプリ
Demo:https://bulletin-board-app-wlhj.onrender.com/posts

Laravelで作成した、認証機能付きのシンプルな掲示板アプリです。
ユーザーはログイン後、投稿の作成・編集・削除（CRUD）を行えます。

基本的な設計思想（MVC、認証、CRUD）を理解し、
実務でよく使われる機能構成を意識して作成しました。

---

## 機能

* ユーザー登録 / ログイン / ログアウト
* プロフィール編集（表示名・アバター画像）
* 投稿の一覧 / 作成 / 編集 / 削除

  * 投稿者本人のみ編集・削除可能
* 投稿画像のアップロード
* ページネーション（最新順）

---

## アプリ画面イメージ

### 投稿一覧
<img width="1536" height="1024" alt="投稿一覧" src="https://github.com/user-attachments/assets/5685fd94-cf8a-4bdc-ac59-e84562903af6" />

### アカウント登録画面
![アカウント登録画面](https://github.com/user-attachments/assets/9cbcee76-b867-4071-9dc0-a238d7baa964)

### 投稿作成画面
![投稿作成画面](https://github.com/user-attachments/assets/d068fa23-78ff-4559-bf4d-088b63cae84d)

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
