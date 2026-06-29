<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - UMKM Manager</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:'Segoe UI',sans-serif;
        }

        body{
            min-height:100vh;

            background:
            linear-gradient(rgba(15,45,122,.75),rgba(22,163,74,.65)),
            url('/images/umkm-bg.jpg');

            background-size:cover;
            background-position:center;
            background-repeat:no-repeat;

            display:flex;
            justify-content:center;
            align-items:center;
        }

        .login-container{
            width:90%;
            max-width:1200px;
            display:flex;
            align-items:center;
            gap:60px;
        }

        .left-content{
            flex:1;
            color:white;
        }

        .left-content h1{
            font-size:4rem;
            font-weight:700;
            line-height:1.2;
            margin-bottom:20px;
        }

        .left-content p{
            font-size:1.2rem;
            opacity:.9;
        }

        .feature-box{
            display:flex;
            gap:20px;
            margin-top:50px;
        }

        .feature{
            background:rgba(255,255,255,.1);
            backdrop-filter:blur(10px);
            padding:20px;
            border-radius:15px;
            width:180px;
        }

        .login-card{
            width:450px;
            background:white;
            border-radius:30px;
            padding:50px;
            box-shadow:0 20px 50px rgba(0,0,0,.2);
        }

        .logo{
            text-align:center;
            margin-bottom:25px;
        }

        .logo img{
            width:130px;
        }

        .welcome{
            text-align:center;
            margin-bottom:30px;
        }

        .welcome h4{
            font-weight:700;
        }

        .form-control{
            height:55px;
            border-radius:15px;
        }

        .btn-login{
            width:100%;
            height:55px;
            border:none;
            border-radius:15px;

            background:linear-gradient(135deg,#0F2D7A,#16A34A);

            color:white;
            font-size:18px;
            font-weight:600;

            transition:.3s;
        }

        .btn-login:hover{
            transform:translateY(-3px);
            box-shadow:0 10px 25px rgba(0,0,0,.2);
        }

        @media(max-width:992px){

            .left-content{
                display:none;
            }

            .login-card{
                width:100%;
            }
        }

    </style>

</head>
<body>

<div class="login-container">

    <div class="left-content">

        <h1>UMKM <br> Manager</h1>

        <p>
            Manage your business more easily, efficiently,
            and professionally.
        </p>

        <div class="feature-box">

            <div class="feature">
                📦<br><br>
                Product Management
            </div>

            <div class="feature">
                💰<br><br>
                Sales Monitoring
            </div>

            <div class="feature">
                📊<br><br>
                Financial Reports
            </div>

        </div>

    </div>


    <div class="login-card">

        <div class="logo">

            <img src="{{ asset('images/logo.png') }}">

        </div>

        <div class="welcome">

            <h4>Welcome Back 👋</h4>

            <p class="text-muted">
                Please login to continue
            </p>

        </div>

        @if(session('error'))

            <div class="alert alert-danger">
                {{ session('error') }}
            </div>

        @endif

        <form action="/login" method="POST">

            @csrf

            <div class="mb-3">

                <label class="mb-2">Username</label>

                <input
                    type="text"
                    name="username"
                    class="form-control"
                    placeholder="Enter username">

            </div>

            <div class="mb-4">

                <label class="mb-2">Password</label>

                <input
                    type="password"
                    name="password"
                    class="form-control"
                    placeholder="Enter password">

            </div>

            <button class="btn-login">

                Login

            </button>

        </form>

        <div class="text-center mt-3">

    Belum punya akun?

    <a href="/register">
        Daftar disini
    </a>

</div>

    </div>

</div>

</body>
</html>
