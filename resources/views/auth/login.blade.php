<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - SIPEKA</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
  <style>
    :root {
      --peka-primary: #1A6B6B;
      --peka-primary-light: #2A8F8F;
      --peka-primary-pale: #E8F5F5;
      --peka-secondary: #E84393;
      --peka-secondary-light: #FDEEF6;
      --gray-100: #F1F5F9;
      --gray-200: #E2E8F0;
      --gray-500: #64748B;
      --gray-700: #334155;
      --gray-900: #0F172A;
    }

    body {
      font-family: 'DM Sans', sans-serif;
      color: var(--gray-900);
      background: linear-gradient(135deg, var(--peka-primary-pale) 0%, var(--peka-secondary-light) 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 16px;
    }

    .login-shell {
      width: 100%;
      max-width: 480px;
      display: flex;
      flex-direction: column;
      background: #fff;
      border: 1px solid rgba(255,255,255,.7);
      border-radius: 24px;
      overflow: hidden;
      box-shadow: 0 25px 60px rgba(15,23,42,.1);
      animation: fadeInUp .6s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @media (min-width: 992px) {
      .login-shell {
        max-width: 1000px;
        display: grid;
        grid-template-columns: 1.1fr 1fr;
      }
    }

    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .login-hero {
      display: none;
      background: linear-gradient(135deg, var(--peka-primary) 0%, #114b4b 100%);
      padding: 60px;
      flex-direction: column;
      justify-content: center;
      color: white;
      position: relative;
      overflow: hidden;
    }

    @media (min-width: 992px) {
      .login-hero {
        display: flex;
      }
    }

    .login-hero::before {
      content: '';
      position: absolute;
      top: -100px;
      right: -100px;
      width: 300px;
      height: 300px;
      background: rgba(255,255,255,0.05);
      border-radius: 50%;
    }

    .hero-icon {
      font-size: 3rem;
      margin-bottom: 20px;
      color: rgba(255,255,255,0.9);
      filter: drop-shadow(0 10px 15px rgba(0,0,0,0.1));
    }

    @media (min-width: 1200px) {
      .hero-icon { font-size: 4rem; margin-bottom: 30px; }
    }

    .hero-title {
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 2.5rem;
      font-weight: 800;
      line-height: 1.1;
      margin-bottom: 12px;
    }

    @media (min-width: 1200px) {
      .hero-title { font-size: 3.5rem; margin-bottom: 20px; }
    }

    .hero-tagline {
      font-size: 1.1rem;
      font-weight: 500;
      color: rgba(255,255,255,0.8);
      margin-bottom: 20px;
    }

    @media (min-width: 1200px) {
      .hero-tagline { font-size: 1.4rem; margin-bottom: 30px; }
    }

    .hero-desc {
      font-size: 0.95rem;
      line-height: 1.6;
      color: rgba(255,255,255,0.7);
      max-width: 400px;
    }

    .login-panel {
      padding: 32px 24px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    @media (min-width: 576px) {
      .login-panel { padding: 40px; }
    }

    @media (min-width: 992px) {
      .login-panel { padding: 60px; }
    }

    .brand-logo {
      display: flex;
      width: 54px;
      height: 54px;
      background: var(--peka-primary);
      border-radius: 16px;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 1.6rem;
      margin-bottom: 24px;
      box-shadow: 0 8px 20px rgba(26,107,107,0.2);
    }

    @media (min-width: 992px) {
      .brand-logo {
        display: none;
      }
    }

    .brand-title {
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 1.75rem;
      font-weight: 800;
      color: var(--peka-primary);
      margin-bottom: 8px;
    }

    @media (min-width: 576px) {
      .brand-title { font-size: 2rem; }
    }

    .brand-subtitle {
      color: var(--gray-500);
      font-size: 0.95rem;
      margin-bottom: 32px;
    }

    .form-label {
      font-size: .875rem;
      font-weight: 600;
      color: var(--gray-700);
      margin-bottom: 8px;
    }

    .form-control-peka {
      border: 2px solid #E2E8F0;
      border-radius: 14px;
      padding: 12px 16px;
      width: 100%;
      font-size: 1rem;
      transition: all .2s;
    }

    @media (min-width: 576px) {
      .form-control-peka { padding: 14px 16px; }
    }

    .form-control-peka:focus {
      border-color: var(--peka-primary);
      box-shadow: 0 0 0 4px rgba(26,107,107,0.1);
      outline: none;
    }

    .input-group-wrapper {
      position: relative;
    }

    .input-icon {
      position: absolute;
      left: 18px;
      top: 50%;
      transform: translateY(-50%);
      color: #94A3B8;
      pointer-events: none;
      font-size: 1rem;
    }

    @media (min-width: 576px) {
      .input-icon { font-size: 1.1rem; }
    }

    .has-icon .form-control-peka {
      padding-left: 48px;
    }

    @media (min-width: 576px) {
      .has-icon .form-control-peka { padding-left: 50px; }
    }

    .btn-peka {
      background: var(--peka-primary);
      color: white;
      border: none;
      border-radius: 14px;
      padding: 14px 24px;
      width: 100%;
      font-weight: 700;
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 1rem;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      margin-top: 10px;
      transition: all .3s;
      cursor: pointer;
    }

    @media (min-width: 576px) {
      .btn-peka { font-size: 1.05rem; }
    }

    .btn-peka:hover {
      background: #114b4b;
      transform: translateY(-2px);
      box-shadow: 0 10px 25px rgba(26,107,107,0.25);
    }

    .btn-peka:active {
      transform: translateY(0);
    }

    .helper-text {
      color: var(--gray-500);
      font-size: .875rem;
      margin-top: 30px;
      text-align: center;
      line-height: 1.5;
    }
  </style>
</head>
<body>
  <div class="login-shell">
    <section class="login-hero">
      <div class="hero-icon">
        <i class="fas fa-heart-circle-plus"></i>
      </div>
      <h1 class="hero-title">SIPEKA</h1>
      <p class="hero-tagline">Menjaga Ibu, Melindungi Generasi</p>
      <p class="hero-desc">Platform digital terintegrasi untuk skrining preeklampsia dan pemantauan kehamilan demi kesehatan ibu dan anak yang lebih baik.</p>
    </section>

    <section class="login-panel">
      <div class="brand-logo">
        <i class="fas fa-heart-circle-plus"></i>
      </div>
      <h2 class="brand-title">Selamat Datang</h2>
      <p class="brand-subtitle">Silakan masuk untuk mengakses sistem</p>

      @if($errors->any())
        <div class="alert alert-danger" style="font-size: .875rem; border-radius: 12px; margin-bottom: 24px;">
          <i class="fas fa-exclamation-circle me-2"></i> {{ $errors->first() }}
        </div>
      @endif

      <form method="POST" action="{{ route('login.post') }}">
        @csrf
        <div class="mb-3">
          <label class="form-label">Email Akun</label>
          <div class="input-group-wrapper has-icon">
            <i class="fas fa-envelope input-icon"></i>
            <input type="email" id="email" name="email" class="form-control-peka" placeholder="Masukkan email anda" value="{{ old('email') }}" required autofocus>
          </div>
        </div>

        <div class="mb-4">
          <label class="form-label">Password</label>
          <div class="input-group-wrapper has-icon">
            <i class="fas fa-lock input-icon"></i>
            <input type="password" id="password" name="password" class="form-control-peka" placeholder="Masukkan password anda" required>
          </div>
        </div>

        <button type="submit" class="btn-peka">
          <span>Masuk Sistem</span>
          <i class="fas fa-arrow-right"></i>
        </button>
      </form>

      <div class="helper-text">
        Lupa password atau kendala akses? <br>
        Silakan hubungi Admin Fasilitas Kesehatan anda.
      </div>
    </section>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
