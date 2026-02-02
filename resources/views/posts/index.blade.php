@extends('layout')

@section('content')
<div class="text-center hero">
    <h2 class="mb-2" style="font-size:3rem; font-weight:800; letter-spacing:-.02em;">Post it cool</h2>
    <div class="muted">あなたの“いま”を共有しよう</div>

    <div class="hero-cta">
        @auth
            <a href="{{ route('posts.create') }}" class="btn btn-primary btn-cta">投稿画面へ</a>
        @else
            <button type="button" class="btn btn-primary btn-cta" data-bs-toggle="modal" data-bs-target="#loginPromptModal">投稿する</button>
        @endauth
    </div>
</div>

<div class="post-list">
    @forelse ($posts as $post)
        <a href="{{ route('posts.show', $post->id) }}" class="post-card-link">
            <div class="glass p-4 post-card">
                <div class="d-flex flex-column">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        @if ($post->user && $post->user->avatarUrl())
                            <img class="avatar" src="{{ $post->user->avatarUrl() }}" alt="avatar">
                        @elseif ($post->user)
                            <span class="avatar-fallback">{{ mb_substr($post->user->name, 0, 1) }}</span>
                        @else
                            <span class="avatar-fallback">?</span>
                        @endif
                        <div class="d-flex flex-column">
                            <div class="post-author">{{ $post->user?->name ?? 'ゲスト' }}</div>
                        </div>
                    </div>

                    <div class="post-title">{{ $post->title }}</div>
                    <p class="post-body">{{ Str::limit($post->content, 200) }}</p>

                    @if ($post->imageUrl())
                        <div class="post-image-wrap post-image-wrap--thumb mb-2">
                            <img class="post-image post-image--thumb" src="{{ $post->imageUrl() }}" alt="post image">
                        </div>
                    @endif

                    <div class="mt-auto d-flex justify-content-end">
                        <div class="post-time">{{ $post->created_at?->format('Y/m/d H:i') }}</div>
                    </div>
                </div>
            </div>
        </a>
    @empty
        <div class="glass p-4 post-card text-center">
            <div style="font-weight:800; letter-spacing:-.01em;">まだ投稿がありません</div>
            @guest
                <div class="mt-2" style="color: rgba(255,255,255,0.72);">初めての方は、まずは右上の「アカウント登録画面へ」をクリック！</div>
            @endguest
            <div class="mt-3 d-flex justify-content-center gap-2"></div>
        </div>
    @endforelse
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $posts->links() }}
</div>

@endsection