<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>掲示板アプリ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-1: #3b82f6;
            --bg-2: #06b6d4;
            --bg-3: #1e40af;
            --glass: rgba(255,255,255,0.16);
            --glass-border: rgba(255,255,255,0.22);
            --text: rgba(255,255,255,0.92);
            --muted: rgba(255,255,255,0.70);
        }
        body {
            font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial;
            min-height: 100vh;
            color: var(--text);
            background:
                radial-gradient(1200px 900px at 15% 20%, rgba(255,255,255,0.25), transparent 55%),
                radial-gradient(900px 700px at 85% 30%, rgba(255,255,255,0.18), transparent 60%),
                linear-gradient(135deg, var(--bg-2) 0%, var(--bg-1) 35%, var(--bg-3) 100%);
        }
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            pointer-events: none;
            background:
                radial-gradient(circle at 30% 10%, rgba(255,255,255,0.06) 0, transparent 60%),
                radial-gradient(circle at 70% 90%, rgba(255,255,255,0.05) 0, transparent 55%);
            mix-blend-mode: overlay;
        }
        .container-main { max-width: 860px; margin:0 auto; padding: 2.25rem 1rem; }
        .site-header { padding: 1.25rem 0 0.5rem; }

        .navbar-brand {
            font-weight: 700;
            letter-spacing: .02em;
            font-size: 1.1rem;
            color: var(--text);
        }

        .glass {
            background: var(--glass);
            border: 1px solid var(--glass-border);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            box-shadow: 0 20px 60px rgba(0,0,0,0.18);
            border-radius: 26px;
        }

        .header-bar {
            background: transparent;
            border: none;
            box-shadow: none;
            backdrop-filter: none;
            -webkit-backdrop-filter: none;
            border-radius: 0;
        }

        .avatar {
            width: 32px;
            height: 32px;
            border-radius: 999px;
            object-fit: cover;
            border: 1px solid rgba(255,255,255,0.25);
            box-shadow: 0 8px 18px rgba(0,0,0,0.18);
        }

        .avatar-fallback {
            width: 32px;
            height: 32px;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            color: rgba(255,255,255,0.95);
            background: linear-gradient(135deg, rgba(34,211,238,0.95), rgba(59,130,246,0.95));
            border: 1px solid rgba(255,255,255,0.18);
            box-shadow: 0 8px 18px rgba(0,0,0,0.18);
        }

        .post-image-wrap {
            border-radius: 14px;
            border: 1px solid rgba(255,255,255,0.18);
            background: rgba(255,255,255,0.08);
            overflow: hidden;
        }

        .post-image-wrap--thumb {
            height: clamp(120px, 18vw, 160px);
        }

        .post-image {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: cover;
        }

        .post-image--thumb {
            object-fit: contain;
        }

        .post-image--detail {
            height: auto;
            max-height: 420px;
            object-fit: contain;
            background: rgba(255,255,255,0.06);
        }

        .muted { color: var(--muted); }

        .header-auth .btn {
            padding: .28rem .62rem;
            font-size: .82rem;
            border-radius: 999px;
        }
        .header-auth .btn-outline-primary,
        .header-auth .btn-outline-secondary {
            background: rgba(255,255,255,0.58);
            border-color: rgba(255,255,255,0.0);
            color: #0b1b2a;
        }
        .header-auth .btn-outline-primary:hover,
        .header-auth .btn-outline-secondary:hover {
            background: rgba(255,255,255,0.72);
        }
        .header-auth .btn-primary {
            box-shadow: 0 10px 22px rgba(0,0,0,0.14);
        }

        .hero {
            margin-bottom: 2.25rem;
            position: relative;
        }

        .hero-cta {
            position: absolute;
            top: .25rem;
            left: 0;
            display: flex;
            justify-content: flex-start;
        }

        .btn.btn-cta {
            padding: 1.35rem 1.725rem;
            font-size: 1.53rem;
            font-weight: 800;
            letter-spacing: .01em;
            background: linear-gradient(135deg, rgba(34,211,238,0.95), rgba(59,130,246,0.95));
            border: 1px solid rgba(255,255,255,0.18);
            color: rgba(255,255,255,0.96);
            box-shadow: 0 12px 28px rgba(0,0,0,0.18);
        }

        .btn.btn-cta:hover {
            filter: brightness(1.03);
        }

        @media (max-width: 768px) {
            .hero-cta {
                position: static;
                margin-top: 1.25rem;
                justify-content: center;
            }
        }

        .auth-float {
            position: fixed;
            top: 22px;
            right: 22px;
            z-index: 1060;
            display: flex;
            gap: .75rem;
            align-items: center;
            padding: 0;
            border-radius: 0;
            background: transparent;
            border: none;
            backdrop-filter: none;
            -webkit-backdrop-filter: none;
            box-shadow: none;
        }

        .profile-float {
            position: fixed;
            top: 22px;
            left: 22px;
            z-index: 1060;
            max-width: calc(100vw - 44px);
            display: flex;
            gap: .5rem;
            align-items: center;
        }

        .btn-profile-cta {
            padding: 1.05rem 1.55rem;
            font-size: 1.12rem;
            font-weight: 800;
            border-radius: 999px;
            letter-spacing: .01em;
            white-space: nowrap;
            background: rgba(255,255,255,0.95);
            border: 1px solid rgba(255,255,255,0.95);
            color: #0b1b2a;
            box-shadow: 0 16px 44px rgba(0,0,0,0.18);
        }
        .btn-profile-cta:hover {
            background: rgba(255,255,255,0.90);
            border-color: rgba(255,255,255,0.90);
            color: #0b1b2a;
        }
        .btn-profile-cta .avatar,
        .btn-profile-cta .avatar-fallback {
            width: 34px;
            height: 34px;
        }

        .btn-auth-cta {
            padding: 1.05rem 2.025rem;
            font-size: 1.12rem;
            font-weight: 800;
            border-radius: 999px;
            letter-spacing: .01em;
            white-space: nowrap;
        }

        @media (max-width: 576px) {
            .auth-float {
                left: 12px;
                right: 12px;
                top: 12px;
                justify-content: center;
                flex-wrap: wrap;
            }
            .btn-auth-cta {
                flex: 1 1 auto;
                width: 100%;
            }

            .profile-float {
                top: 12px;
                left: 12px;
                max-width: calc(100vw - 24px);
            }
            .btn-profile-cta {
                padding: .95rem 1.25rem;
                font-size: 1.05rem;
            }
        }

        .post-list {
            display: flex;
            flex-direction: column;
        }
        .post-card-link {
            display: block;
            color: inherit;
            text-decoration: none;
        }
        .post-list > .post-card-link:not(:first-child) { margin-top: 1.25rem; }
        .post-list > .post-card-link:not(:first-child):nth-child(3n) { margin-top: 2rem; }
        .post-card {
            transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease;
        }
        @media (hover: hover) and (pointer: fine) {
            .post-card-link:hover .post-card {
                transform: translateY(-2px);
                box-shadow: 0 26px 80px rgba(0,0,0,0.24);
                border-color: rgba(255,255,255,0.26);
            }
        }

        .post-card-link:focus-visible {
            outline: none;
        }
        .post-card-link:focus-visible .post-card {
            box-shadow: 0 0 0 .25rem rgba(255,255,255,0.22), 0 26px 80px rgba(0,0,0,0.24);
            border-color: rgba(255,255,255,0.30);
        }

        .post-author {
            font-weight: 700;
            font-size: .95rem;
        }
        .post-title {
            font-weight: 800;
            font-size: 1.22rem;
            letter-spacing: -.01em;
            margin-bottom: .35rem;
        }
        .post-body {
            color: rgba(255,255,255,0.74);
            font-weight: 400;
            line-height: 1.65;
            margin-bottom: .75rem;
        }
        .post-time {
            font-size: .78rem;
            color: rgba(255,255,255,0.55);
            letter-spacing: .01em;
        }

        @media (max-width: 576px) {
            .post-time { text-align: right; }
        }

        h1, h2, h3 { color: var(--text); }

        .btn {
            border-radius: 999px;
            font-weight: 600;
            letter-spacing: .01em;
        }

        .btn:focus-visible {
            outline: none;
            box-shadow: 0 0 0 .25rem rgba(255,255,255,0.22) !important;
        }

        .btn-primary {
            background: linear-gradient(135deg, rgba(34,211,238,0.95), rgba(59,130,246,0.95));
            border: 1px solid rgba(255,255,255,0.18);
            color: rgba(255,255,255,0.96);
            box-shadow: 0 12px 28px rgba(0,0,0,0.18);
        }
        .btn-primary:hover { filter: brightness(1.03); }

        .btn-outline-primary {
            background: rgba(255,255,255,0.95);
            border-color: rgba(255,255,255,0.95);
            color: #0b1b2a;
        }
        .btn-outline-primary:hover {
            background: rgba(255,255,255,0.90);
            border-color: rgba(255,255,255,0.90);
            color: #0b1b2a;
        }

        .btn-outline-secondary {
            background: #0b1b2a;
            border-color: rgba(255,255,255,0.22);
            color: rgba(255,255,255,0.92);
        }
        .btn-outline-secondary:hover {
            background: #0f2a44;
            border-color: rgba(255,255,255,0.28);
            color: rgba(255,255,255,0.96);
        }

        .btn-back {
            background: rgba(255,255,255,0.95);
            border: 1px solid rgba(255,255,255,0.95);
            color: #0b1b2a;
            box-shadow: 0 12px 28px rgba(0,0,0,0.14);
        }
        .btn-back:hover {
            background: rgba(255,255,255,0.90);
            border-color: rgba(255,255,255,0.90);
            color: #0b1b2a;
        }

        .btn-danger-soft {
            background: #ef4444;
            border: 1px solid #ef4444;
            color: rgba(255,255,255,0.96);
        }
        .btn-danger-soft:hover {
            background: #dc2626;
            border-color: #dc2626;
            color: rgba(255,255,255,0.98);
        }

        .card { border: 0; border-radius: 22px; }

        .form-label { color: rgba(255,255,255,0.88); }
        .form-control {
            background: rgba(255,255,255,0.88);
            border: 1px solid rgba(255,255,255,0.35);
            color: #0b1b2a;
            border-radius: 14px;
        }
        .form-control:focus {
            border-color: rgba(255,255,255,0.65);
            box-shadow: 0 0 0 .25rem rgba(255,255,255,0.18);
        }

        .alert { border-radius: 16px; }
        .pagination .page-link { color: rgba(255,255,255,0.92); background: rgba(255,255,255,0.12); border-color: rgba(255,255,255,0.18); }
        .pagination .page-item.active .page-link { background: rgba(255,255,255,0.82); border-color: rgba(255,255,255,0.82); color:#0b1b2a; }
        footer { color: rgba(255,255,255,0.6); }

        .modal-content {
            background: rgba(11, 27, 42, 0.78);
            border: 1px solid rgba(255,255,255,0.18);
            color: var(--text);
            border-radius: 22px;
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
            box-shadow: 0 22px 80px rgba(0,0,0,0.35);
        }
        .modal-header { border-bottom-color: rgba(255,255,255,0.14); }
        .modal-footer { border-top-color: rgba(255,255,255,0.14); }
        .modal .btn-close { filter: invert(1); opacity: 0.85; }
    </style>
</head>
<body>
    @guest
        <header class="container-main site-header">
            <div class="header-bar p-3 d-flex flex-wrap align-items-center justify-content-center gap-2">
                {{-- 一時的に非表示: タイムライン / 新規投稿 --}}
            </div>
        </header>
    @endguest

    <main class="container-main">
        <div class="mb-3">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <i class="bi bi-exclamation-octagon-fill me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>

        <div class="glass p-4 p-md-5">
            @yield('content')
        </div>
    </main>

    <div class="auth-float" aria-label="auth actions">
        @guest
            <a class="btn btn-primary btn-auth-cta" href="{{ route('login') }}">ログイン画面へ</a>
            <a class="btn btn-primary btn-auth-cta" href="{{ route('register') }}">アカウント登録画面へ</a>
        @else
            <form action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="btn btn-primary btn-auth-cta">ログアウト</button>
            </form>
            <a class="btn btn-primary btn-auth-cta" href="{{ route('profile.edit') }}">アカウント設定</a>
        @endguest
    </div>

    @guest
        <div class="modal fade" id="loginPromptModal" tabindex="-1" aria-labelledby="loginPromptModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="loginPromptModalLabel" style="font-weight:800; letter-spacing:-.01em;">ゲストの方は投稿できません。</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="color: rgba(255,255,255,0.78);">
                        投稿するにはログイン、またはアカウント登録をしてください。
                    </div>
                </div>
            </div>
        </div>
    @endguest

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('form.confirm-delete').forEach(function(form) {
                form.addEventListener('submit', function(e) {
                    if (!confirm('本当に削除しますか？')) {
                        e.preventDefault();
                    }
                });
            });

            // 自動でフラッシュを消す（4秒後）
            setTimeout(function() {
                document.querySelectorAll('.alert').forEach(function(alert) {
                    alert.style.transition = 'opacity 0.4s ease, max-height 0.4s ease, margin 0.4s ease';
                    alert.style.opacity = '0';
                    alert.style.maxHeight = '0';
                    alert.style.margin = '0';
                    setTimeout(function() { alert.remove(); }, 400);
                });
            }, 4000);
        });
    </script>
</body>
</html>