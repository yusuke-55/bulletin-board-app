# Deploy

このリポジトリは **Docker** でデプロイできるようにしてあります。

## Render（おすすめ / 手順が簡単）

1. Renderで **New +** → **Web Service**
2. **Build and deploy from a Git repository** を選び、このGitHubリポジトリを接続
3. Environment: **Docker**（Dockerfileを自動検出）
4. Env Vars（最低限）
   - `APP_ENV=production`
   - `APP_DEBUG=false`
   - `APP_KEY=...`（ローカルで `php artisan key:generate --show` して貼る）
   - `APP_URL=https://<renderのURL>`

### DBについて

- まずは動作優先なら `DB_CONNECTION=sqlite` のままでも起動できますが、
  無償プラン等ではファイルが永続化されない場合があります。
- ポートフォリオ用途で安定させるなら、RenderのPostgresを作って
  `DB_CONNECTION=pgsql` と各種 `DB_*`（host/db/user/pass）を設定するのがおすすめです。

### 画像アップロードについて

- `storage/app/public` はコンテナのファイルシステムに保存されます。
  永続化したい場合は、S3等のオブジェクトストレージを使うか、永続ディスクを利用してください。

## GitHubにアプリURLを貼る

- リポジトリページ右側の **About** → 歯車 → **Website** にURLを貼る
- あわせてREADMEにも `Demo` セクションとしてURLを載せると親切です
