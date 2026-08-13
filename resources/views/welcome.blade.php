<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BIOS FILKOM UB - Halaman Utama</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #1d6ce0;
            --primary-hover: #0d45b5;
            --dark: #0f172a;
            --gray: #64748b;
            --light: #f8fafc;
            --accent: #f59e0b;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background-color: var(--light);
            color: var(--dark);
            scroll-behavior: smooth;
        }

        /* Navbar */
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 8%;
            background: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .logo-container {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .logo-img {
            height: 42px;
            width: auto;
            mix-blend-mode: multiply;
            filter: contrast(1.1);
        }
        .logo-text {
            font-size: 21px;
            font-weight: 800;
            color: var(--dark);
            letter-spacing: -0.5px;
        }
        .logo-text span { color: var(--primary); }
        .btn-login {
            background: linear-gradient(135deg, #1d6ce0 0%, #0d45b5 100%);
            color: white;
            text-decoration: none;
            padding: 10px 22px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            transition: opacity 0.2s;
        }
        .btn-login:hover { opacity: 0.88; }

        /* Hero */
        .hero {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 60px 8%;
            gap: 50px;
            background: linear-gradient(160deg, #f0f6ff 0%, #e8f0ff 40%, #f8fafc 100%);
        }
        .hero-text { flex: 1.2; }
        .hero-text .badge {
            background: linear-gradient(90deg, #dbeafe, #c7d7fd);
            color: #1d4ed8;
            padding: 5px 13px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            display: inline-block;
            margin-bottom: 16px;
            letter-spacing: 0.3px;
        }
        .hero-text h1 {
            font-size: 42px;
            font-weight: 800;
            line-height: 1.15;
            margin: 0 0 20px;
            color: var(--dark);
        }
        .hero-text h1 span {
            background: linear-gradient(90deg, #1d6ce0, #6366f1);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .hero-text p {
            font-size: 16px;
            color: var(--gray);
            line-height: 1.65;
            margin-bottom: 28px;
        }
        .hero-text a {
            color: var(--primary);
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .hero-image {
            flex: 0.8;
            display: flex;
            justify-content: center;
        }
        .hero-image img {
            max-width: 100%;
            height: auto;
            border-radius: 16px;
            box-shadow: 0 16px 48px rgba(29, 108, 224, 0.18);
        }

        /* Struktur Section */
        .structure-section {
            padding: 80px 8%;
            background: white;
        }
        .section-title {
            text-align: center;
            margin-bottom: 50px;
        }
        .section-title h2 {
            font-size: 32px;
            font-weight: 800;
            margin: 0 0 8px;
        }
        .section-title p {
            color: var(--gray);
            margin: 0;
            font-size: 15px;
        }
        .sub-section-title {
            font-size: 20px;
            font-weight: 700;
            color: var(--dark);
            margin: 40px 0 20px;
            padding-left: 14px;
            border-left: 4px solid;
            border-radius: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .sub-section-title.divisi { border-color: var(--accent); color: #92400e; }
        .sub-section-title.dept   { border-color: var(--primary); color: #1e3a8a; }

        /* Grid & Cards */
        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 20px;
        }
        .card {
            background: var(--light);
            border-radius: 14px;
            border: 0.5px solid #e2e8f0;
            overflow: hidden;
            transition: transform 0.25s, box-shadow 0.25s, border-color 0.25s;
        }
        .card:hover { transform: translateY(-4px); box-shadow: 0 12px 32px rgba(0,0,0,0.08); }
        .card.divisi:hover { border-color: #fbbf24; }
        .card.departemen:hover { border-color: #60a5fa; }
        .card-img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            display: block;
        }
        .card-body { padding: 18px 20px 20px; }
        .card-tag {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            padding: 3px 9px;
            border-radius: 5px;
            display: inline-block;
            margin-bottom: 9px;
        }
        .divisi .card-tag  { background: #fef3c7; color: #92400e; }
        .departemen .card-tag { background: #dbeafe; color: #1e3a8a; }
        .card-body h3 {
            font-size: 16px;
            font-weight: 700;
            margin: 0 0 8px;
        }
        .divisi .card-body h3    { color: #b45309; }
        .departemen .card-body h3 { color: var(--primary); }
        .card-body p {
            font-size: 13.5px;
            color: var(--gray);
            line-height: 1.55;
            margin: 0;
        }

        footer {
            text-align: center;
            padding: 28px;
            background: var(--dark);
            color: #94a3b8;
            font-size: 14px;
        }
    </style>
</head>
<body>

    <nav>
        <div class="logo-container">
            <img src="https://media.licdn.com/dms/image/v2/C4D0BAQHyFvXEddKarw/company-logo_200_200/company-logo_200_200/0/1630576083886?e=1782950400&v=beta&t=x46Cw9Uw4eAQLpvC4zzQirmeZHk0ijATUI3ChqltlC4" alt="Logo BIOS" class="logo-img">
            <div class="logo-text">BIOS<span>FILKOM</span></div>
        </div>
        <a href="{{ route('login') }}" class="btn-login">Masuk ke Sistem</a>
    </nav>

    <section class="hero">
        <div class="hero-text">
            <span class="badge">Lembaga Semi Otonom (LSO) FILKOM UB</span>
            <h1>Badan Internal <span>Olahraga dan Seni</span> (BIOS)</h1>
            <p>BIOS merupakan wadah utama bagi mahasiswa Fakultas Ilmu Komputer, Universitas Brawijaya untuk menyalurkan, mengasah, dan mengembangkan minat serta bakat di bidang olahraga dan kesenian. Bersama menciptakan iklim organisasi yang sehat, prestatif, dan suportif di FILKOM UB Jawa Timur, Indonesia.</p>
            <a href="#struktur-organisasi">Eksplorasi 6 Divisi &amp; 4 Departemen Kami ↓</a>
        </div>
        <div class="hero-image">
            <img src="https://filkom.ub.ac.id/wp-content/uploads/2025/03/Head-BIOS-2.png" alt="Pimpinan BIOS FILKOM UB">
        </div>
    </section>

    <section class="structure-section" id="struktur-organisasi">
        <div class="section-title">
            <h2>Struktur Kepengurusan BIOS</h2>
            <p>Roda penggerak BIOS yang terbagi ke dalam fokus minat bakat (Divisi) dan manajerial internal (Departemen).</p>
        </div>

        <div class="sub-section-title divisi">6 Divisi Minat Bakat</div>
        <div class="grid-container" style="margin-bottom: 40px;">

            <div class="card divisi">
                <img class="card-img" src="https://images.unsplash.com/photo-1508700115892-45ecd05ae2ad?w=400&q=80" alt="Foto Divisi Tari">
                <div class="card-body">
                    <span class="card-tag">Divisi</span>
                    <h3>Tari</h3>
                    <p>Wadah kreativitas seni tari, baik tari tradisional nusantara maupun modern dance mahasiswa FILKOM.</p>
                </div>
            </div>

            <div class="card divisi">
                <img class="card-img" src="https://images.unsplash.com/photo-1511379938547-c1f69419868d?w=400&q=80" alt="Foto Divisi Homeband">
                <div class="card-body">
                    <span class="card-tag">Divisi</span>
                    <h3>Homeband</h3>
                    <p>Mengembangkan bakat bermusik, vokal, instrumentalis, hingga manajemen performa panggung kampus.</p>
                </div>
            </div>

            <div class="card divisi">
                <img class="card-img" src="https://images.unsplash.com/photo-1529900748604-07564a03e7a6?w=400&q=80" alt="Foto Divisi Futsal">
                <div class="card-body">
                    <span class="card-tag">Divisi</span>
                    <h3>Futsal</h3>
                    <p>Menghimpun dan melatih atlet futsal FILKOM untuk bersaing di turnamen universitas maupun regional.</p>
                </div>
            </div>

            <div class="card divisi">
                <img class="card-img" src="https://images.unsplash.com/photo-1613918431703-aa50889e3be8?w=400&q=80" alt="Foto Divisi Badminton">
                <div class="card-body">
                    <span class="card-tag">Divisi</span>
                    <h3>Badminton</h3>
                    <p>Pusat pelatihan bulutangkis internal guna menjaga kebugaran dan mencetak delegasi prestasi lomba.</p>
                </div>
            </div>

            <div class="card divisi">
                <img class="card-img" src="https://images.unsplash.com/photo-1546519638-68e109498ffc?w=400&q=80" alt="Foto Divisi Basket">
                <div class="card-body">
                    <span class="card-tag">Divisi</span>
                    <h3>Basket</h3>
                    <p>Mengasah teknik basket, strategi tim, rutin sparing, dan persiapan turnamen bergengsi antar-fakultas.</p>
                </div>
            </div>

            <div class="card divisi">
                <img class="card-img" src="https://images.unsplash.com/photo-1542751371-adc38448a05e?w=400&q=80" alt="Foto Divisi Esport">
                <div class="card-body">
                    <span class="card-tag">Divisi</span>
                    <h3>Esport</h3>
                    <p>Wadah kompetitif e-sports: Mobile Legends, PUBG Mobile, Valorant, dan game taktis lainnya.</p>
                </div>
            </div>

        </div>

        <div class="sub-section-title dept">4 Departemen Struktural</div>
        <div class="grid-container">

            <div class="card departemen">
                <img class="card-img" src="https://images.unsplash.com/photo-1561070791-2526d30994b5?w=400&q=80" alt="Foto Dept Artistik">
                <div class="card-body">
                    <span class="card-tag">Departemen</span>
                    <h3>Artistik dan Media</h3>
                    <p>Bertanggung jawab atas visual branding, dokumentasi kegiatan, desain publikasi, dan estetika konten pameran BIOS.</p>
                </div>
            </div>

            <div class="card departemen">
                <img class="card-img" src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?w=400&q=80" alt="Foto Dept Humas">
                <div class="card-body">
                    <span class="card-tag">Departemen</span>
                    <h3>Hubungan Masyarakat</h3>
                    <p>Menjadi jembatan komunikasi BIOS dengan pihak eksternal, birokrasi kampus FILKOM, dan kerja sama strategis.</p>
                </div>
            </div>

            <div class="card departemen">
                <img class="card-img" src="https://images.unsplash.com/photo-1552664730-d307ca884978?w=400&q=80" alt="Foto Dept PSDO">
                <div class="card-body">
                    <span class="card-tag">Departemen</span>
                    <h3>PSDO</h3>
                    <p>Pengembangan Sumber Daya Organisasi — kaderisasi, keakraban, soft skill, dan stabilitas internal kepengurusan.</p>
                </div>
            </div>

            <div class="card departemen">
                <img class="card-img" src="https://images.unsplash.com/photo-1579621970588-a35d0e7ab9b6?w=400&q=80" alt="Foto Dept Kewirausahaan">
                <div class="card-body">
                    <span class="card-tag">Departemen</span>
                    <h3>Kewirausahaan</h3>
                    <p>Mengembangkan kemandirian finansial LSO melalui unit bisnis kreatif, merchandise BIOS, dan pencarian dana mandiri.</p>
                </div>
            </div>

        </div>
    </section>

    <footer>
        &copy; 2026 BIOS FILKOM UB. All Rights Reserved. Powered by Laravel.
    </footer>

</body>
</html>