<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <title>Login — Sistem Inventaris</title>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --navy:  #0d1b2a;
            --navy2: #1b2d42;
            --teal:  #1a8c7a;
            --teal2: #22b5a0;
            --light: #f5f7fa;
            --muted: #8a9ab0;
            --white: #ffffff;
        }

        html, body {
            height: 100%;
            overflow: hidden;
            font-family: 'DM Sans', sans-serif;
            background: var(--white);
        }

        /* ── WRAPPER ── */
        .login-wrapper {
            display: flex;
            height: 100vh;
            width: 100vw;
            overflow: hidden;
        }

        /* ══════════════════
           LEFT — Form Panel
        ══════════════════ */
        .form-panel {
            width: 38%;
            min-width: 360px;
            max-width: 500px;
            height: 100%;
            background: var(--white);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 40px 52px;
            position: relative;
            z-index: 2;
            box-shadow: 4px 0 32px rgba(13,27,42,.07);
        }

        /* decorative blobs */
        .form-panel::before {
            content: '';
            position: absolute;
            bottom: -80px; right: -80px;
            width: 260px; height: 260px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(26,140,122,.07) 0%, transparent 70%);
            pointer-events: none;
        }
        .form-panel::after {
            content: '';
            position: absolute;
            top: -60px; left: -60px;
            width: 220px; height: 220px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(200,168,75,.06) 0%, transparent 70%);
            pointer-events: none;
        }

        /* ── BRAND ── */
        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            opacity: 0;
            animation: fadeUp .6s .05s ease forwards;
        }
        .brand-icon {
            width: 38px; height: 38px;
            background: linear-gradient(135deg, var(--teal) 0%, var(--navy2) 100%);
            border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 14px rgba(26,140,122,.35);
            flex-shrink: 0;
        }
        .brand-icon i { color: var(--white); font-size: .88rem; }
        .brand-name {
            font-family: 'Playfair Display', serif;
            font-size: 1.05rem;
            color: var(--navy);
        }

        /* ── FORM BODY ── */
        .form-body {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-tag {
            font-size: .68rem;
            font-weight: 600;
            letter-spacing: .2em;
            text-transform: uppercase;
            color: var(--teal);
            margin-bottom: 8px;
            display: flex; align-items: center; gap: 8px;
            opacity: 0;
            animation: fadeUp .6s .15s ease forwards;
        }
        .form-tag::before {
            content: '';
            display: inline-block;
            width: 16px; height: 2px;
            background: var(--teal);
            border-radius: 1px;
        }

        .form-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.85rem;
            color: var(--navy);
            line-height: 1.22;
            margin-bottom: 5px;
            opacity: 0;
            animation: fadeUp .6s .2s ease forwards;
        }

        .form-subtitle {
            font-size: .84rem;
            color: var(--muted);
            margin-bottom: 32px;
            opacity: 0;
            animation: fadeUp .6s .25s ease forwards;
        }

        /* ── FIELD ── */
        .field-group {
            margin-bottom: 18px;
            opacity: 0;
            animation: fadeUp .6s ease forwards;
        }
        .field-group:nth-of-type(1) { animation-delay: .32s; }
        .field-group:nth-of-type(2) { animation-delay: .40s; }

        .field-label {
            display: block;
            font-size: .72rem;
            font-weight: 600;
            letter-spacing: .07em;
            text-transform: uppercase;
            color: var(--navy2);
            margin-bottom: 7px;
        }

        .field-wrap { position: relative; }

        .field-icon {
            position: absolute;
            left: 14px; top: 50%;
            transform: translateY(-50%);
            color: #c0cad8;
            font-size: .85rem;
            pointer-events: none;
            transition: color .2s;
        }

        .form-input {
            width: 100%;
            height: 46px;
            padding: 0 44px 0 40px;
            border: 1.5px solid #e2e8f2;
            border-radius: 9px;
            background: var(--light);
            font-family: 'DM Sans', sans-serif;
            font-size: .9rem;
            color: var(--navy);
            outline: none;
            transition: border-color .22s, box-shadow .22s, background .22s;
            -webkit-appearance: none;
        }
        .form-input::placeholder { color: #b8c4d4; font-size: .86rem; }
        .form-input:focus {
            border-color: var(--teal);
            background: var(--white);
            box-shadow: 0 0 0 3.5px rgba(26,140,122,.11);
        }
        .field-wrap:focus-within .field-icon { color: var(--teal); }

        .toggle-btn {
            position: absolute;
            right: 12px; top: 50%;
            transform: translateY(-50%);
            background: none; border: none;
            color: #c0cad8;
            cursor: pointer;
            padding: 4px 5px;
            transition: color .2s;
            font-size: .85rem;
            line-height: 1;
        }
        .toggle-btn:hover { color: var(--teal); }

        /* ── FORGOT ── */
        .forgot-row {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 24px;
            opacity: 0;
            animation: fadeUp .6s .48s ease forwards;
        }
        .forgot-link {
            font-size: .8rem;
            color: var(--muted);
            text-decoration: none;
            transition: color .2s;
        }
        .forgot-link:hover { color: var(--teal); }

        /* ── SUBMIT ── */
        .btn-submit {
            width: 100%;
            height: 46px;
            background: linear-gradient(135deg, var(--teal) 0%, var(--navy2) 100%);
            color: var(--white);
            font-family: 'DM Sans', sans-serif;
            font-size: .9rem;
            font-weight: 600;
            letter-spacing: .04em;
            border: none;
            border-radius: 9px;
            cursor: pointer;
            display: flex; align-items: center; justify-content: center; gap: 9px;
            box-shadow: 0 5px 18px rgba(26,140,122,.36);
            transition: transform .22s, box-shadow .22s;
            opacity: 0;
            animation: fadeUp .6s .55s ease forwards;
        }
        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 28px rgba(26,140,122,.46);
        }
        .btn-submit:active { transform: translateY(-1px); }

        /* ── REGISTER ── */
        .register-hint {
            text-align: center;
            font-size: .82rem;
            color: var(--muted);
            margin-top: 20px;
            opacity: 0;
            animation: fadeUp .6s .62s ease forwards;
        }
        .register-hint a { color: var(--teal); font-weight: 600; text-decoration: none; }
        .register-hint a:hover { text-decoration: underline; }

        /* ── FOOTER ── */
        .form-footer {
            font-size: .7rem;
            color: #c4cdd8;
            opacity: 0;
            animation: fadeUp .6s .7s ease forwards;
        }

        /* ══════════════════
           RIGHT — Image Panel
        ══════════════════ */
        .image-panel {
            flex: 1;
            height: 100%;
            overflow: hidden;
        }
        .image-panel img {
            width: 100%; height: 100%;
            object-fit: cover;
            object-position: center;
            display: block;
        }

        /* ── ANIMATION ── */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 767px) {
            .image-panel { display: none; }
            .form-panel  { width: 100%; max-width: 100%; min-width: unset; padding: 36px 28px; }
        }
    </style>
</head>
<body>

<div class="login-wrapper">

    <!-- ══ LEFT: FORM ══ -->
    <div class="form-panel">

        <!-- Brand -->
        <div class="brand">
            <div class="brand-icon"><i class="fas fa-box-archive"></i></div>
            <span class="brand-name">RS Darmayu</span>
        </div>

        <!-- Form -->
        <div class="form-body">
            <p class="form-tag">Selamat datang kembali</p>
            <h1 class="form-title">Masuk ke Sistem<br>Inventaris</h1>
            <p class="form-subtitle">Masukkan kredensial Anda untuk melanjutkan</p>

            <form method="post" action="{{ url('login/check') }}">
                @csrf

                <!-- Username -->
                <div class="field-group">
                    <label class="field-label" for="form2Example18">Username</label>
                    <div class="field-wrap">
                        <i class="fas fa-user field-icon"></i>
                        <input
                            type="text"
                            name="name"
                            id="form2Example18"
                            class="form-input"
                            placeholder="Masukkan username Anda"
                            autocomplete="username"
                        />
                    </div>
                </div>

                <!-- Password -->
                <div class="field-group">
                    <label class="field-label" for="form2Example28">Password</label>
                    <div class="field-wrap">
                        <i class="fas fa-lock field-icon"></i>
                        <input
                            type="password"
                            name="password"
                            id="form2Example28"
                            class="form-input"
                            placeholder="Masukkan password Anda"
                            autocomplete="current-password"
                        />
                        <button type="button" class="toggle-btn" id="togglePassword" aria-label="Tampilkan password">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- Forgot -->
                <div class="forgot-row">
                    <a href="#!" class="forgot-link">Lupa password?</a>
                </div>

                <!-- Submit -->
                <button type="submit" class="btn-submit">
                    Login &nbsp;<i class="fas fa-arrow-right"></i>
                </button>

                <!-- Register -->
                <p class="register-hint">
                    Belum punya akun? <a href="#!">Daftar di sini</a>
                </p>
            </form>
        </div>

        <!-- Footer -->
        <p class="form-footer">&copy; 2025 RS Darmayu &middot; Sistem Management Inventaris</p>
    </div>

    <!-- ══ RIGHT: IMAGE ══ -->
    <div class="image-panel d-none d-md-block">
        <img
            src="https://madiun.rsdarmayu.com/wp-content/uploads/2023/11/rs-darmayu-kota-madiun-scaled.jpg"
            alt="RS Darmayu Madiun"
        />
    </div>
</div>

<script>
    document.getElementById("togglePassword").addEventListener("click", function () {
        var passwordField = document.getElementById("form2Example28");
        var icon = this.querySelector("i");

        if (passwordField.type === "password") {
            passwordField.type = "text";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        } else {
            passwordField.type = "password";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        }
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>

{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Login</title>
</head>
<body>
    <section class="min-vh-100">
        <div class="container-fluid">
            <div class="row h-100 align-items-center">
            <div class="col-lg-4 col-md-4 text-black bg-white h-100">

                <div class="px-5 ms-xl-4">
                <i class="fas fa-crow fa-2x me-3 pt-5 mt-xl-4" style="color: #709085;"></i>
                <span class="h1 fw-bold mb-0">Logo</span>
                </div>

                <div class="d-flex align-items-center justify-content-center h-100 px-5">

                <form method="post" action="{{ url('login/check') }}" style="w-100" style="max-width: 360px;">
                    @csrf
                    <h3 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">SISTEM MANAGEMENT INVENTARIS </h3>

                    <div data-mdb-input-init class="form-outline mb-4">
                        <label class="form-label" for="form2Example18">Username</label>
                        <input type="name" name="name" id="form2Example18" class="form-control form-control-md" />
                    </div>

                    <div class="form-outline mb-4">
                        <label class="form-label" for="form2Example28">Password</label>

                        <div class="input-group">
                            <input type="password" name="password" id="form2Example28"class="form-control form-control-md">
                            <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="pt-1 mb-4">
                    <button data-mdb-button-init data-mdb-ripple-init  class="btn-login" type="submit">Login</button>
                    </div>

                    <p class="small mb-2 pb-sm-2"><a class="text-muted" href="#!">Forgot password?</a></p>
                    <p>Don't have an account? <a href="#!" class="link-info">Register here</a></p>

                </form>
                </div>

            </div>
            <div class="col-lg-8 col-md-6 px-0 d-none d-md-block h-100">
                <img src="https://madiun.rsdarmayu.com/wp-content/uploads/2023/11/rs-darmayu-kota-madiun-scaled.jpg"
                alt="Login image" class="w-100 vh-100" style="object-fit: cover; object-position: center;">
            </div>
            </div>
        </div>
    </section>
   <script>
        document.getElementById("togglePassword").addEventListener("click", function () {
            var passwordField = document.getElementById("form2Example28");
            var icon = this.querySelector("i");

            if (passwordField.type === "password") {
                passwordField.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                passwordField.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js" integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBqfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y" crossorigin="anonymous"></script>
</body>
</html> --}}
