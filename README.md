# 掲示板アプリ

[![CI](https://github.com/yusuke-55/bulletin-board-app/actions/workflows/ci.yml/badge.svg)](https://github.com/yusuke-55/bulletin-board-app/actions/workflows/ci.yml)

Laravelで作成した、認証機能付きのシンプルな掲示板アプリです。  
ユーザーはログイン後、投稿の作成・編集・削除（CRUD）を行うことができ、
投稿画像やプロフィール用アバター画像のアップロードにも対応しています。

## Demo

- URL: （デプロイ後にここへ貼る）

---

## 主な機能
- ユーザー登録 / ログイン / ログアウト（Laravel認証）
- プロフィール編集
  - 表示名の変更
  - アバター画像のアップロード / 削除
- 投稿の一覧 / 詳細 / 作成 / 編集 / 削除
  - 投稿者本人のみ編集・削除可能
- 投稿画像のアップロード / 差し替え / 削除
- ページネーション（最新順）

---

## 使用技術
- Backend: Laravel 12 / PHP 8.2
- Frontend: Vite
- DB: SQLite（ローカル開発用）
- Storage: public disk（storage:link）
- CI: GitHub Actions（テスト・ビルド）

---

## 工夫した点
- 認証済みユーザーのみ投稿操作ができるように、ミドルウェアで制御
- 投稿・プロフィール画像の管理を統一し、差し替え・削除時の処理を整理
- 不正な操作（他人の投稿編集など）を防ぐため、権限チェックを実装

---

## セットアップ（ローカル起動）

### 前提
- PHP 8.2+
- Composer
- Node.js

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
- デプロイ手順は [DEPLOY.md](DEPLOY.md) にまとめています。
