<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use App\Models\Post;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('posts:purge-guest {--force : Confirm deletion without prompting}', function () {
    $query = Post::query()->whereNull('user_id')->orWhere('user_id', 0);
    $count = (clone $query)->count();

    if ($count === 0) {
        $this->info('ゲスト投稿はありません。');
        return 0;
    }

    if (!$this->option('force')) {
        if (!$this->confirm("ゲスト投稿 {$count} 件を削除します（添付画像ファイルも削除）。よろしいですか？")) {
            $this->warn('キャンセルしました。');
            return 1;
        }
    }

    $deleted = 0;
    $query->orderBy('id')->chunkById(200, function ($posts) use (&$deleted) {
        foreach ($posts as $post) {
            if ($post->image_path) {
                Storage::disk('public')->delete($post->image_path);
            }
            $post->delete();
            $deleted++;
        }
    });

    $this->info("削除完了: {$deleted} 件");

    return 0;
})->purpose('Delete all guest posts (user_id NULL/0) including attached images');
