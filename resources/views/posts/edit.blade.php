@extends('layout')

@section('content')
<div class="row justify-content-center">
    <div class="col-12">
        <div class="p-2 p-md-3">
            <h3 class="mb-3" style="font-weight:800; letter-spacing:-.01em;">投稿編集</h3>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="title" class="form-label">タイトル</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $post->title) }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">内容</label>
                        <textarea name="content" class="form-control" rows="6" required>{{ old('content', $post->content) }}</textarea>
                    </div>

                    @if ($post->imageUrl())
                        <div class="mb-3">
                            <div class="mb-2" style="color: rgba(255,255,255,0.85); font-weight:600;">現在の画像</div>
                            <img src="{{ $post->imageUrl() }}" alt="current image" style="width:100%; max-height:360px; object-fit:contain; border-radius:16px; border:1px solid rgba(255,255,255,0.18); background: rgba(255,255,255,0.08);">

                            <div class="form-check mt-2">
                                <input id="remove_image" type="checkbox" name="remove_image" value="1" class="form-check-input">
                                <label for="remove_image" class="form-check-label" style="color: rgba(255,255,255,0.85);">画像を削除（添付解除）</label>
                            </div>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label for="image" class="form-label">画像（任意）</label>
                        <input id="image" type="file" name="image" class="form-control" accept="image/*">
                        <div class="form-text" style="color: rgba(255,255,255,0.7);">差し替える場合のみ選択（2MB以内）</div>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">更新</button>
                        <a href="{{ route('posts.show', $post->id) }}" class="btn btn-back">戻る</a>
                    </div>
                </form>
        </div>
    </div>
</div>
@endsection