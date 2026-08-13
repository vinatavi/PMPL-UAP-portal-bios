<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Portal BIOS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #0f4fcf 0%, #3b82f6 100%);
            --bg-main: #f4f6fa;
            --text-dark: #1f2937;
            --text-gray: #6b7280;
            --border-color: #e5e7eb;
            --sidebar-width: 260px;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', Arial, sans-serif; }
        body { background: var(--bg-main); color: var(--text-dark); min-height: 100vh; display: flex; }

        .sidebar { width: var(--sidebar-width); background: #ffffff; position: fixed; left: 0; top: 0; bottom: 0; border-right: 1px solid var(--border-color); display: flex; flex-direction: column; justify-content: space-between; z-index: 100; }
        .sidebar-top { padding: 30px 24px; }
        .logo { font-size: 24px; font-weight: 800; background: var(--primary-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent; letter-spacing: -0.5px; }
        .subtitle { color: var(--text-gray); font-size: 11px; margin-top: 4px; margin-bottom: 35px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
        .menu { display: flex; flex-direction: column; gap: 6px; }
        .menu-group-title { font-size: 11px; font-weight: 700; color: #9ca3af; text-transform: uppercase; margin: 12px 0 6px 12px; letter-spacing: 0.5px; }
        .menu a { text-decoration: none; color: #4b5563; padding: 12px 14px; border-radius: 10px; font-size: 14px; font-weight: 500; display: flex; align-items: center; gap: 12px; transition: all 0.2s; }
        .menu a svg { width: 18px; height: 18px; stroke: #6b7280; fill: none; stroke-width: 2; }
        .menu a:hover { background: #f3f4f6; color: var(--text-dark); }
        
        .menu a.active { background: var(--primary-gradient) !important; color: white !important; }
        .menu a.active svg { stroke: white !important; }
        
        .sidebar-user { border-top: 1px solid var(--border-color); padding: 20px 24px; display: flex; align-items: center; gap: 12px; background: #fafafa; }
        .avatar { width: 40px; height: 40px; border-radius: 50%; background: var(--primary-gradient); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 14px; }
        .user-details h5 { font-size: 13px; font-weight: 600; }
        .user-details p { font-size: 11px; color: var(--text-gray); }

        .main { margin-left: var(--sidebar-width); flex: 1; padding: 30px 40px; min-width: 0; display: flex; flex-direction: column; min-height: 100vh; }
        .topbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 35px; gap: 20px; }
        .search-wrapper { position: relative; width: 100%; max-width: 400px; }
        .search { width: 100%; background: #fff; border: 1px solid var(--border-color); border-radius: 12px; padding: 12px 16px 12px 40px; font-size: 14px; }
        .search-icon { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; stroke: var(--text-gray); fill: none; stroke-width: 2; }
        .top-right { display: flex; align-items: center; gap: 24px; }
        .icon-btn { background: none; border: none; cursor: pointer; display: flex; align-items: center; }
        .icon-btn svg { width: 22px; height: 22px; stroke: #4b5563; fill: none; stroke-width: 2; }
        .user-info { display: flex; align-items: center; gap: 12px; padding-left: 20px; border-left: 1px solid var(--border-color); }
        .user-info img { width: 36px; height: 36px; border-radius: 50%; object-fit: cover; }

        .card { background: #fff; border-radius: 16px; border: 1px solid var(--border-color); padding: 28px; margin-bottom: 25px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); }
        .section-title { color: #0f4fcf; font-size: 12px; font-weight: 700; margin-bottom: 22px; text-transform: uppercase; letter-spacing: 1px; display: flex; align-items: center; gap: 8px; }
        .section-title svg { width: 16px; height: 16px; stroke: currentColor; fill: none; stroke-width: 2.5; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th { text-align: left; padding: 14px; font-size: 13px; font-weight: 600; color: var(--text-gray); border-bottom: 2px solid var(--border-color); }
        td { padding: 14px; font-size: 14px; color: var(--text-dark); border-bottom: 1px solid var(--border-color); }
        tr:hover td { background: #f9fafb; }
        
        .badge { display: inline-block; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; }
        .badge-pending { background: #fef3c7; color: #d97706; }
        .badge-wait-bpi { background: #e0e7ff; color: #4338ca; }
        .badge-revisi { background: #fee2e2; color: #dc2626; }
        .badge-active { background: #d1fae5; color: #059669; }

        .btn { background: var(--primary-gradient); color: white; border: none; padding: 10px 18px; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 8px rgba(15, 79, 207, 0.1); }
        .btn-secondary { background: white; color: #4b5563; border: 1px solid #d1d5db; box-shadow: none; }
        .btn-danger { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white; }

        footer { text-align: center; margin-top: auto; padding-top: 40px; color: var(--text-gray); font-size: 13px; border-top: 1px solid var(--border-color); }

        @media (max-width: 768px) {
            .sidebar { display: none; }
            .main { margin-left: 0; padding: 20px; }
        }

        /* Animasi Notifikasi */
        @keyframes alertSlideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
    @yield('styles')
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-top">
            <div class="logo">Portal BIOS</div>
            <div class="subtitle">Manajemen Internal</div>

            <div class="menu">
                <div class="menu-group-title">Dashboards</div>
                
                @if(Auth::user() && in_array(strtolower(Auth::user()->role), ['bpi', 'presdir']))
                    <a href="{{ route('dashboard.bpi') }}" class="{{ request()->routeIs('dashboard.bpi*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="9"></rect><rect x="14" y="3" width="7" height="5"></rect><rect x="14" y="12" width="7" height="9"></rect><rect x="3" y="16" width="7" height="5"></rect></svg>
                        Dashboard BPI
                    </a>
                @endif

                @if(Auth::user() && strtolower(Auth::user()->role) === 'bph')
                    <a href="{{ route('dashboard.bph') }}" class="{{ request()->routeIs('dashboard.bph*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path></svg>
                        Dashboard BPH
                    </a>
                @endif

                @if(Auth::user() && strtolower(Auth::user()->role) === 'staff')
                    <a href="{{ route('dashboard.staff') }}" class="{{ request()->routeIs('dashboard.staff*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle></svg>
                        Dashboard Staff
                    </a>
                @endif

                <div class="menu-group-title">Modul Kerja</div>
                
                <a href="{{ route('proposal.list') }}" class="{{ request()->routeIs('proposal.list') || request()->routeIs('proposal.show') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                    Proposals
                </a>

                @if(Auth::user() && in_array(strtolower(Auth::user()->role), ['bpi', 'presdir']))
                    <a href="{{ route('dashboard.finance') }}" class="{{ request()->routeIs('*finance*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                        Finance
                    </a>
                @endif

                <a href="{{ route('dashboard.calendar') }}" class="{{ request()->routeIs('*calendar*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                    Calendar
                </a>

                @if(Auth::user() && in_array(strtolower(Auth::user()->role), ['bpi', 'presdir']))
                    <div class="menu-group-title">Persetujuan</div>
                    <a href="{{ route('proposal.review') }}" class="{{ request()->routeIs('*review*') || Request::is('proposal/review*') || Request::is('proposals/review*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                        BPI Approval
                    </a>
                @endif
            </div>
        </div>

        <div class="sidebar-user">
            <div class="avatar">{{ strtoupper(substr(Auth::user()->role ?? 'USR', 0, 3)) }}</div>
            <div class="user-details">
                <h5>{{ Auth::user()->name ?? 'User BIOS' }}</h5>
                <p style="text-transform: uppercase; font-size: 10px; font-weight: 700; color: #3b82f6;">{{ Auth::user()->role }}</p>
            </div>
        </div>
    </div>

    <div class="main">
        <div class="topbar">
            <div class="search-wrapper">
                <svg class="search-icon" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                <input type="text" class="search" placeholder="Cari data internal organisasi...">
            </div>

            <div class="top-right">
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="icon-btn" title="Keluar Sistem">
                        <svg viewBox="0 0 24 24" style="stroke: #ef4444;"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                    </button>
                </form>
                <div class="user-info">
                    <img src="https://api.dicebear.com/7.x/initials/svg?seed={{ Auth::user()->name }}" alt="Avatar" style="width:36px; height:36px; border-radius:50%;">
                </div>
            </div>
        </div>

        {{-- ─── SISTEM FLASH NOTIFIKASI GLOBAL (AUTO-CLEANUP) ─── --}}
        @if(session('success'))
        <div style="display: flex; gap: 14px; background: #f0fdf4; border-left: 4px solid #16a34a; border-radius: 12px; padding: 14px 18px; margin-bottom: 25px; animation: alertSlideDown 0.3s ease-out;">
            <svg style="width:20px; height:20px; stroke:#16a34a; fill:none; stroke-width:2.5; flex-shrink:0; margin-top:2px;" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
            <div>
                <h4 style="font-size: 14px; font-weight: 600; margin: 0 0 2px 0; color: #14532d;">Berhasil!</h4>
                <p style="font-size: 13px; margin: 0; color: #166534; line-height: 1.4;">{{ session('success') }}</p>
            </div>
        </div>
        @php session()->forget('success'); @endphp
        @endif

        @if(session('warning'))
        <div style="display: flex; gap: 14px; background: #fff7ed; border-left: 4px solid #ea580c; border-radius: 12px; padding: 14px 18px; margin-bottom: 25px; animation: alertSlideDown 0.3s ease-out;">
            <svg style="width:20px; height:20px; stroke:#ea580c; fill:none; stroke-width:2.5; flex-shrink:0; margin-top:2px;" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
            <div>
                <h4 style="font-size: 14px; font-weight: 600; margin: 0 0 2px 0; color: #7c2d12;">Perhatian Revisi!</h4>
                <p style="font-size: 13px; margin: 0; color: #9a3412; line-height: 1.4;">{{ session('warning') }}</p>
            </div>
        </div>
        @php session()->forget('warning'); @endphp
        @endif

        @if(session('error'))
        <div style="display: flex; gap: 14px; background: #fef2f2; border-left: 4px solid #dc2626; border-radius: 12px; padding: 14px 18px; margin-bottom: 25px; animation: alertSlideDown 0.3s ease-out;">
            <svg style="width:20px; height:20px; stroke:#dc2626; fill:none; stroke-width:2.5; flex-shrink:0; margin-top:2px;" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
            <div>
                <h4 style="font-size: 14px; font-weight: 600; margin: 0 0 2px 0; color: #7f1d1d;">Gagal Proses!</h4>
                <p style="font-size: 13px; margin: 0; color: #991b1b; line-height: 1.4;">{{ session('error') }}</p>
            </div>
        </div>
        @php session()->forget('error'); @endphp
        @endif

        @yield('content')

        <footer>
            &copy; 2026 Portal BIOS. Seluruh Hak Cipta Dilindungi.
        </footer>
    </div>

    @yield('scripts')
</body>
</html>