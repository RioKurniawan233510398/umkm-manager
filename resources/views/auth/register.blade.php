<!DOCTYPE html>
<html>
<head>
    <title>Register - UMKM Manager</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body{
            background: linear-gradient(135deg,#0d6efd,#198754);
            min-height:100vh;
            display:flex;
            align-items:center;
            justify-content:center;
        }

        .register-card{
            width:450px;
            border:none;
            border-radius:20px;
            padding:20px;
            box-shadow:0 10px 30px rgba(0,0,0,.2);
        }
    </style>
</head>
<body>

<div class="card register-card">

    <div class="card-body">

        <h2 class="text-center mb-4">
            Register UMKM Manager
        </h2>

        <form action="/register" method="POST">

            @csrf

            <div class="mb-3">
                <label>Nama Lengkap</label>
                <input type="text"
                       name="name"
                       class="form-control"
                       required>
            </div>

            <div class="mb-3">
                <label>Username</label>
                <input type="text"
                       name="username"
                       class="form-control"
                       required>
            </div>

            <div class="mb-3">
                <label>Password</label>
                <input type="password"
                       name="password"
                       class="form-control"
                       required>
            </div>

            <button class="btn btn-success w-100">
                Register
            </button>

        </form>

        <div class="text-center mt-3">

            Sudah punya akun?

            <a href="/login">
                Login
            </a>

        </div>

    </div>

</div>

</body>
</html>
