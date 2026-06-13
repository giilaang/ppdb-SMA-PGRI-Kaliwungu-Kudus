<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin | CMS PPDB SMA PGRI Kaliwungu</title>

    <link rel="icon" type="image/png" href="{{ asset('images/ppdb/favicon.png') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
          rel="stylesheet">

    <style>
        :root{
            --primary:#2563eb;
            --primary-dark:#1d4ed8;
            --dark:#0f172a;
            --text:#f8fafc;
            --muted:#94a3b8;
        }

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            font-family:'Inter',sans-serif;
            min-height:100vh;
            display:flex;
            align-items:center;
            justify-content:center;
            overflow:hidden;
            position:relative;

            background:
                radial-gradient(circle at top left,
                rgba(37,99,235,.18) 0%,
                transparent 35%),

                radial-gradient(circle at bottom right,
                rgba(99,102,241,.15) 0%,
                transparent 35%),

                linear-gradient(
                    135deg,
                    #020617 0%,
                    #0f172a 45%,
                    #111827 100%
                );
        }

        /* ambient glow */
        body::before,
        body::after{
            content:'';
            position:absolute;
            border-radius:50%;
            filter:blur(90px);
            z-index:0;
        }

        body::before{
            width:280px;
            height:280px;
            background:rgba(37,99,235,.15);
            top:-100px;
            left:-80px;
        }

        body::after{
            width:320px;
            height:320px;
            background:rgba(99,102,241,.12);
            bottom:-120px;
            right:-100px;
        }

        .login-wrapper{
            width:100%;
            max-width:420px;
            padding:16px;
            position:relative;
            z-index:2;
        }

        .login-card{
            position:relative;
            overflow:hidden;

            border-radius:28px;

            background:rgba(255,255,255,.08);

            backdrop-filter:blur(25px);
            -webkit-backdrop-filter:blur(25px);

            border:1px solid rgba(255,255,255,.10);

            box-shadow:
                0 20px 60px rgba(0,0,0,.40),
                inset 0 1px 0 rgba(255,255,255,.06);
        }

        .login-card::before{
            content:'';
            position:absolute;
            inset:0;
            background:
                linear-gradient(
                    135deg,
                    rgba(255,255,255,.06),
                    transparent 40%
                );
            pointer-events:none;
        }

        /* HEADER */
        .login-header{
            text-align:center;
            padding:34px 30px 18px;
        }

        .login-logo{
            width:80px;
            height:80px;
            object-fit:contain;

            background:rgba(255,255,255,.12);

            border-radius:22px;

            border:1px solid rgba(255,255,255,.15);

            padding:8px;

            margin-bottom:16px;

            box-shadow:
                0 8px 25px rgba(0,0,0,.25);
        }

        .login-header h1{
            color:#fff;
            font-size:15px;
            font-weight:800;
            letter-spacing:.3px;
            margin-bottom:6px;
        }

        .login-header p{
            color:#cbd5e1;
            font-size:12px;
            margin:0;
        }

        /* BODY */
        .login-body{
            padding:18px 30px 26px;
        }

        .login-title{
            color:#fff;
            font-size:22px;
            font-weight:800;
            margin-bottom:4px;
        }

        .login-sub{
            color:#94a3b8;
            font-size:13px;
            margin-bottom:26px;
        }

        .form-label{
            color:#e2e8f0;
            font-size:13px;
            font-weight:600;
            margin-bottom:8px;
        }

        /* INPUT */
        .input-icon-wrap{
            position:relative;
        }

        .input-icon-wrap i{
            position:absolute;
            left:16px;
            top:50%;
            transform:translateY(-50%);
            color:#94a3b8;
            font-size:15px;
        }

        .input-icon-wrap input{
            width:100%;
            height:50px;

            border-radius:14px;
            border:1px solid rgba(255,255,255,.10);

            background:rgba(255,255,255,.06);

            padding:0 16px 0 48px;

            color:#fff;
            font-size:13px;

            transition:.25s ease;
        }

        .input-icon-wrap input::placeholder{
            color:#64748b;
        }

        .input-icon-wrap input:focus{
            outline:none;

            border-color:rgba(96,165,250,.45);

            background:rgba(255,255,255,.08);

            box-shadow:
                0 0 0 4px rgba(37,99,235,.10),
                0 8px 24px rgba(37,99,235,.12);
        }

        .form-check-label{
            color:#cbd5e1;
            font-size:13px;
        }

        .form-check-input{
            background-color:rgba(255,255,255,.1);
            border:1px solid rgba(255,255,255,.2);
        }

        /* BUTTON */
        .btn-login{
            width:100%;
            height:50px;
            border:none;
            border-radius:14px;

            background:
                linear-gradient(
                    135deg,
                    #2563eb,
                    #1d4ed8
                );

            color:#fff;
            font-size:14px;
            font-weight:700;

            transition:.3s ease;

            box-shadow:
                0 10px 28px rgba(37,99,235,.30);
        }

        .btn-login:hover{
            transform:translateY(-2px);

            box-shadow:
                0 14px 34px rgba(37,99,235,.38);
        }

        /* ALERT */
        .alert{
            border:none;
            border-radius:14px;
            font-size:13px;
        }

        /* INFO */
        .credentials-info{
            margin-top:20px;
            padding:14px;

            border-radius:16px;

            background:rgba(255,255,255,.05);

            border:1px solid rgba(255,255,255,.08);

            color:#cbd5e1;
            font-size:12px;
        }

        .credentials-info strong{
            display:block;
            color:#fff;
            margin-bottom:8px;
        }

        .credentials-info code{
            background:rgba(255,255,255,.08);
            color:#93c5fd;
            border-radius:6px;
            padding:2px 6px;
        }

        /* FOOTER */
        .login-footer{
            text-align:center;
            padding:0 0 24px;
        }

        .login-footer a{
            color:#94a3b8;
            text-decoration:none;
            font-size:13px;
            transition:.25s;
        }

        .login-footer a:hover{
            color:#fff;
        }

        /* MOBILE */
        @media (max-width:576px){

            .login-wrapper{
                padding:14px;
            }

            .login-card{
                border-radius:24px;
            }

            .login-header{
                padding:28px 22px 16px;
            }

            .login-body{
                padding:18px 22px 24px;
            }

            .login-title{
                font-size:20px;
            }

            .login-logo{
                width:72px;
                height:72px;
            }
        }
    </style>
</head>
<body>

<div class="login-wrapper">
    <div class="login-card">

        <!-- Header -->
        <div class="login-header">

            <img src="/images/ppdb/favicon.png"
                 alt="Logo"
                 class="login-logo">

            <h1>SMA PGRI KALIWUNGU KUDUS</h1>
            <p>Sistem Manajemen PPDB — Panel Administrator</p>
        </div>

        <!-- Login Body -->
     <div class="login-body">

           

            @if($errors->any())
                <div class="alert alert-danger d-flex align-items-center gap-2 mb-3">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.submit') }}">
                @csrf

                <!-- Email -->
                <div class="mb-3">
                    <label class="form-label">
                        Email
                    </label>

                    <div class="input-icon-wrap">
                        <i class="bi bi-envelope"></i>

                        <input
                            type="email"
                            name="email"
                            placeholder="admin@smapgrikaliwungu.sch.id"
                            value="{{ old('email') }}"
                            required
                            autofocus>
                    </div>
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label class="form-label">
                        Password
                    </label>

                    <div class="input-icon-wrap">
                        <i class="bi bi-lock"></i>

                        <input
                            type="password"
                            name="password"
                            placeholder="••••••••"
                            required>
                    </div>
                </div>

                <!-- Remember -->
                <div class="form-check mb-4">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        name="remember"
                        id="remember">

                    <label class="form-check-label" for="remember">
                        Ingat saya
                    </label>
                </div>

                <!-- Button -->
                <button type="submit" class="btn-login">
                    Masuk ke Dashboard
                </button>
            </form>

          

        </div>

      
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>