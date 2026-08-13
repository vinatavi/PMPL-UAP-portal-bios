<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PORTAL BIOS</title>
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #0f4fcf 0%, #3b82f6 100%);
            --bg-main: #f4f6fa;
            --text-dark: #1f2937;
            --text-gray: #6b7280;
            --border-color: #e5e7eb;
        }
        * { 
            margin: 0; 
            padding: 0; 
            box-sizing: border-box; 
            font-family: 'Inter', Arial, sans-serif; 
        }
        body { 
            background: var(--bg-main); 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            min-height: 100vh; 
            padding: 20px; 
        }
        .login-card { 
            background: white; 
            width: 100%; 
            max-width: 400px; 
            padding: 40px 35px; 
            border-radius: 16px; 
            border: 1px solid var(--border-color); 
            box-shadow: 0 4px 20px rgba(0,0,0,0.03); 
        }
        .logo-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 30px;
        }
        .logo { 
            font-size: 28px; 
            font-weight: 800; 
            background: var(--primary-gradient); 
            -webkit-background-clip: text; 
            -webkit-text-fill-color: transparent; 
            letter-spacing: -0.5px; 
        }
        .subtitle { 
            color: var(--text-gray); 
            font-size: 13px; 
            margin-top: 6px;
            font-weight: 500;
            text-align: center;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }
        .input-icon {
            position: absolute;
            left: 14px;
            width: 18px;
            height: 18px;
            stroke: var(--text-gray);
            fill: none;
            stroke-width: 2;
        }
        label { 
            display: block; 
            font-size: 13px; 
            font-weight: 600; 
            color: #374151; 
            margin-bottom: 8px; 
        }
        input { 
            width: 100%; 
            border: 1px solid #d1d5db; 
            border-radius: 10px; 
            padding: 12px 14px 12px 42px; 
            outline: none; 
            font-size: 14px; 
            transition: all 0.2s;
        }
        input:focus { 
            border-color: #0f4fcf; 
            box-shadow: 0 0 0 3px rgba(15, 79, 207, 0.08); 
        }
        .btn-submit { 
            width: 100%; 
            background: var(--primary-gradient); 
            color: white; 
            border: none; 
            padding: 14px; 
            border-radius: 10px; 
            font-size: 14px; 
            font-weight: 600; 
            cursor: pointer; 
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 12px rgba(15, 79, 207, 0.15);
            transition: opacity 0.2s; 
        }
        .btn-submit:hover { 
            opacity: 0.95; 
        }
        .btn-submit svg {
            width: 16px;
            height: 16px;
            stroke: white;
            fill: none;
            stroke-width: 2.5;
        }
        .errors { 
            background: #fee2e2; 
            border: 1px solid #fca5a5; 
            padding: 12px 15px; 
            border-radius: 10px; 
            margin-bottom: 20px; 
            font-size: 13px; 
            color: #b91c1c; 
        }
        .error-item {
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .error-item svg {
            width: 14px;
            height: 14px;
            stroke: currentColor;
            fill: none;
            stroke-width: 2.5;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="logo-wrapper">
            <div class="logo">PORTAL BIOS</div>
            <div class="subtitle">Sistem Autentikasi Kredensial Pengurus</div>
        </div>

        <!-- NOTIFIKASI ERROR JIKA LOGIN GAGAL -->
        @if ($errors->any())
            <div class="errors">
                @foreach ($errors->all() as $error)
                    <div class="error-item">
                        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                        <span>{{ $error }}</span>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- FORM LOGIN RESMI AUTH LARAVEL -->
        <form action="{{ route('login') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label>Alamat Email Resmi</label>
                <div class="input-wrapper">
                    <svg class="input-icon" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                    <input type="email" name="email" placeholder="nama@portalbios.com" value="{{ old('email') }}" required autofocus>
                </div>
            </div>

            <div class="form-group">
                <label>Kata Sandi (Password)</label>
                <div class="input-wrapper">
                    <svg class="input-icon" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                    <input type="password" name="password" placeholder="••••••••" required>
                </div>
            </div>

            <button type="submit" class="btn-submit">
                <span>Masuk</span>
            </button>
        </form>
    </div>

</body>
</html>