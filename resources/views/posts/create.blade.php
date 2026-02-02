@extends('layout')

@section('content')
<div class="row justify-content-center">
    <div class="col-12">
        <div class="p-2 p-md-3">
            <h3 class="mb-3" style="font-weight:800; letter-spacing:-.01em;">投稿内容を入力してください。</h3>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">タイトル</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">内容</label>
                        <textarea name="content" class="form-control" rows="6" required>{{ old('content') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">画像（任意）</label>
                        <input id="image" type="file" name="image" class="form-control" accept="image/*">
                        <div class="form-text" style="color: rgba(255,255,255,0.7);">2MB以内の画像</div>
                    </div>
                    <div class="d-flex gap-2 justify-content-between">
                        <button type="submit" class="btn btn-primary">投稿する</button>
                        <a href="{{ route('posts.index') }}" class="btn btn-back">戻る</a>
                    </div>
                </form>
        </div>
    </div>
</div>
@endsection