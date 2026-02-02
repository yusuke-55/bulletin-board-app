@extends('layout')

@section('content')
<div class="row justify-content-center">
    <div class="col-12">
        <div class="p-2 p-md-3">
            <h3 class="mb-3" style="font-weight:800; letter-spacing:-.01em;">アカウント設定画面</h3>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label" for="name">ユーザー名</label>
                    <input id="name" type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                </div>

                <div class="mb-3">
                    <div class="mb-2" style="color: rgba(255,255,255,0.85); font-weight:600;">現在のアイコン</div>
                    @if ($user->avatarUrl())
                        <img class="avatar" src="{{ $user->avatarUrl() }}" alt="avatar" style="width:64px; height:64px;">
                        <div class="form-check mt-2">
                            <input id="remove_avatar" type="checkbox" name="remove_avatar" value="1" class="form-check-input">
                            <label for="remove_avatar" class="form-check-label" style="color: rgba(255,255,255,0.85);">アイコンを削除</label>
                        </div>
                    @else
                        <span class="avatar-fallback" style="width:64px; height:64px; font-size:1.2rem;">{{ mb_substr($user->name, 0, 1) }}</span>
                    @endif
                </div>

                <div class="mb-3">
                    <label class="form-label" for="avatar">アイコン画像（任意）</label>
                    <input id="avatar" type="file" name="avatar" class="form-control" accept="image/*">
                    <div class="form-text" style="color: rgba(255,255,255,0.7);">1MB以内の画像</div>
                </div>

                <div class="d-flex gap-2 justify-content-between">
                    <button type="submit" class="btn btn-primary">保存</button>
                    <a href="{{ route('posts.index') }}" class="btn btn-back">戻る</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
