@extends('layout')

@section('content')
<div class="row justify-content-center">
    <div class="col-12">
        <div class="p-2 p-md-3">
            <h3 class="mb-3" style="font-weight:800; letter-spacing:-.01em;">下記の項目を入力してください。</h3>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label" for="name">ユーザー名</label>
                    <input id="name" type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="email">メールアドレス</label>
                    <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="avatar">ユーザーアイコン（任意）</label>
                    <input id="avatar" type="file" name="avatar" class="form-control" accept="image/*">
                    <div class="form-text" style="color: rgba(255,255,255,0.7);">1MB以内の画像</div>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="password">パスワード</label>
                    <input id="password" type="password" name="password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="password_confirmation">パスワード（確認）</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" required>
                </div>

                <div class="d-flex gap-2 justify-content-between">
                    <button type="submit" class="btn btn-primary">アカウントを登録する</button>
                    <a href="{{ route('posts.index') }}" class="btn btn-back">戻る</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
