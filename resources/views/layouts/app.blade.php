<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UMKM Manager</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:'Segoe UI',sans-serif;
        }

        body{
            background:#F4F7FE;
        }

        .sidebar{

            width:280px;
            height:100vh;

            position:fixed;
            left:0;
            top:0;

            background:linear-gradient(180deg,#0F2D7A,#16A34A);

            padding:30px 20px;

            overflow-y:auto;
        }

        .logo-box{
            text-align:center;
            margin-bottom:50px;
        }

        .logo-box img{
            width:100px;
            background:white;
            border-radius:20px;
            padding:10px;
        }

        .logo-box h2{
            color:white;
            margin-top:20px;
            font-weight:700;
        }

        .menu a{

            display:flex;
            align-items:center;
            gap:15px;

            color:white;
            text-decoration:none;

            padding:15px 20px;

            border-radius:15px;

            margin-bottom:10px;

            transition:.3s;
        }

        .menu a:hover{

            background:rgba(255,255,255,.15);
        }

        .main-content{

            margin-left:280px;
            padding:30px;
        }

        .topbar{

            background:white;

            border-radius:25px;

            padding:20px 30px;

            box-shadow:0 5px 15px rgba(0,0,0,.08);

            display:flex;

            justify-content:space-between;

            align-items:center;

            margin-bottom:30px;
        }

        .admin-box{

            display:flex;

            align-items:center;

            gap:15px;
        }

        .admin-box i{

            font-size:45px;

            color:#16A34A;
        }

        footer{

            text-align:center;

            margin-top:40px;

            color:#666;
        }

    </style>

</head>
<body>

<div class="sidebar">

    <div class="logo-box">

        <img src="{{ asset('images/logo.png') }}">

        <h2>UMKM Manager</h2>

    </div>

    <div class="menu">

        <a href="/dashboard">
            <i class="fas fa-home"></i>
            Dashboard
        </a>

        <a href="{{ url('/products') }}">
            <i class="fas fa-box"></i>
            Products
        </a>

        <a href="/sales">
            <i class="fas fa-shopping-cart"></i>
            Sales
        </a>

        <a href="/finance">
            <i class="fas fa-wallet"></i>
            Finance
        </a>

        <a href="/reports">
            <i class="fas fa-chart-line"></i>
            Reports
        </a>

        <a href="/business-profile">
            <i class="fas fa-building"></i>
            Business Profile
        </a>

        <a href="/activities">
            <i class="fas fa-calendar-alt"></i>
            Activities
        </a>

        <form action="/logout" method="POST" class="mt-5">

            @csrf

            <button class="btn btn-danger w-100 rounded-4">

                <i class="fas fa-sign-out-alt"></i>

                Logout

            </button>

        </form>

    </div>

</div>

<div class="main-content">

    <div class="topbar">

        <div>

            <h2>@yield('title')</h2>

        </div>

        <div class="admin-box">

            <i class="fas fa-user-circle"></i>

            <div>

                <strong>{{ session('user_name') }}</strong>

                <br>

                <small>Administrator</small>

            </div>

        </div>

    </div>

    @yield('content')

    <footer>

        © {{ date('Y') }} UMKM Manager |
        Kelola Usaha Lebih Mudah

    </footer>

</div>

</body>
</html>
