<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title> Admin Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--   Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;

            background: url('{{ asset('assets/images/bg/abstract-bg-3.webp') }}') no-repeat center center/cover;
            position: relative;
        }

        /* 🔥 Overlay */
        body::before {
            content: "";
            position: absolute;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.55);
            top: 0;
            left: 0;
            z-index: 0;
        }

        .login-container {
            position: relative;
            z-index: 1;
            width: 380px;
            padding: 30px;
            border-radius: 15px;

            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(12px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);

            text-align: center;
            color: #fff;
        }

        .brand {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .brand span {
            color: #00d4ff;
        }

        h2 {
            margin-bottom: 10px;
        }

        p {
            font-size: 14px;
            margin-bottom: 20px;
            opacity: 0.8;
        }

        .input-group {
            margin-bottom: 15px;
            text-align: left;
        }

        .input-group label {
            font-size: 13px;
            margin-bottom: 5px;
            display: block;
        }

        .input-group input {
            width: 100%;
            padding: 10px;
            padding-right: 40px;
            border-radius: 8px;
            border: none;
            outline: none;
            font-size: 14px;
        }

        .input-group input:focus {
            box-shadow: 0 0 8px rgba(0, 212, 255, 0.8);
        }

        /* 👁️ Password Eye */
        .password-wrapper {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 18px;
            color: #333;
        }

        .toggle-password:hover {
            color: #00d4ff;
        }

        .login-btn {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: none;
            margin-top: 10px;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;

            background: #00d4ff;
            color: #000;
            transition: 0.3s;
        }

        .login-btn:hover {
            background: #00b8e6;
            transform: scale(1.03);
        }

        .error {
            background: rgba(255, 0, 0, 0.3);
            padding: 8px;
            border-radius: 5px;
            margin-bottom: 10px;
            font-size: 13px;
        }

    </style>
</head>
<body>

<div class="login-container">

    <div class="brand">E<span>com</span></div>
    <h2>Admin Login</h2>
    <p>Secure access to Rovista dashboard</p>

    @if(session('error'))
        <div class="error">{{ session('error') }}</div>
    @endif

    <form method="POST" action="/admin/login">
        @csrf

        <div class="input-group">
            <label>username</label>
         <input type="text" name="username" placeholder="Enter username" required>
        </div>

        <div class="input-group">
            <label>Password</label>

            <div class="password-wrapper">
                <input type="password" id="password" name="password" placeholder="Enter password" required>
                <i class="bi bi-eye toggle-password" id="toggleIcon" onclick="togglePassword()"></i>
            </div>
        </div>

        <button class="login-btn">Login</button>

    </form>

</div>

<!--   JS -->
<script>
function togglePassword() {
    const password = document.getElementById("password");
    const icon = document.getElementById("toggleIcon");

    if (password.type === "password") {
        password.type = "text";
        icon.classList.remove("bi-eye");
        icon.classList.add("bi-eye-slash");
    } else {
        password.type = "password";
        icon.classList.remove("bi-eye-slash");
        icon.classList.add("bi-eye");
    }
}
</script>

</body>
</html>