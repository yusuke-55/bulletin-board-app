# Bulletin Board App（掲示板アプリ）

[![CI](https://github.com/yusuke-55/bulletin-board-app/actions/workflows/ci.yml/badge.svg)](https://github.com/yusuke-55/bulletin-board-app/actions/workflows/ci.yml)

Laravelで作成したシンプルな掲示板アプリです。認証付きの投稿CRUDに加えて、投稿画像・アバター画像のアップロードに対応しています。

## 主な機能

- ユーザー登録 / ログイン / ログアウト
- プロフィール編集（表示名・アバター画像のアップロード/削除）
- 投稿の一覧 / 詳細 / 作成 / 編集 / 削除（作成者のみ編集・削除）
- 投稿画像のアップロード/差し替え/削除
- ページネーション（最新順）

## 技術スタック

- Backend: Laravel 12 / PHP 8.2
- Frontend: Vite
- DB: SQLite（ローカル開発向け）
- Storage: `public` disk（`storage:link`）

## セットアップ（ローカル起動）

前提: PHP 8.2+, Composer, Node.js

```bash
composer install
copy .env.example .env
php artisan key:generate
php artisan migrate
npm install
npm run dev
```

別案（用意しているスクリプト）

```bash
composer run setup
composer run dev
```

## テスト

```bash
php artisan test
```

## 公開にあたっての注意

- `.env` やDBバックアップ（`*.sqlite*`, `*.bak*`）はリポジトリに含めません（`.gitignore`で除外）。
- 画像アップロード先（`storage/app/public`）はローカル環境の状態に依存するため、必要に応じてダミーデータ生成で再現します。

## メモ

- CIはGitHub Actionsで `php artisan test` と `npm run build` を実行します。
- リポジトリ名やユーザー名を変える場合は、CIバッジURLも合わせて更新してください。
