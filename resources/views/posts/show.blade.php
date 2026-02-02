@extends('layout')

@section('content')
<div class="row justify-content-center">
    <div class="col-12">
        <div class="glass p-4">
            <div class="d-flex align-items-center gap-2 mb-3">
                @if ($post->user && $post->user->avatarUrl())
                    <img class="avatar" src="{{ $post->user->avatarUrl() }}" alt="avatar">
                @elseif ($post->user)
                    <span class="avatar-fallback">{{ mb_substr($post->user->name, 0, 1) }}</span>
                @else
                    <span class="avatar-fallback">?</span>
                @endif
                <div class="d-flex flex-column">
                    <div class="post-author" style="font-weight:800;">{{ $post->user?->name ?? 'ゲスト' }}</div>
                </div>
            </div>

            <div class="post-title">{{ $post->title }}</div>
            <p class="post-body" style="white-space: pre-wrap;">{{ $post->content }}</p>

            @if ($post->imageUrl())
                <div class="mt-2">
                    <div class="post-image-wrap">
                        <img class="post-image post-image--detail" src="{{ $post->imageUrl() }}" alt="post image">
                    </div>
                </div>
            @endif

            <div class="mt-3 d-flex justify-content-end">
                <div class="post-time">{{ $post->created_at?->format('Y/m/d H:i') }}</div>
            </div>
        </div>

        <div class="mt-3 d-flex flex-wrap gap-2">
            <a href="{{ route('posts.index') }}" class="btn btn-back">戻る</a>
            @auth
                @if ($post->user_id && (int) $post->user_id === (int) auth()->id())
                    <a href="{{ route('posts.edit', $post->id ) }}" class="btn btn-primary">編集</a>
                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="d-inline confirm-delete">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger-soft">削除</button>
                    </form>
                @endif
            @endauth
        </div>
    </div>
</div>
@endsection