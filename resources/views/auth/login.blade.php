<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>App Monitoring</title>
    
    <!-- Fonts and Icons -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Noto+Sans:300,400,500,600,700,800|PT+Mono:300,400,500,600,700" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/349ee9c857.js" crossorigin="anonymous"></script>
    
    <!-- CSS Files -->
    <link rel="stylesheet" href="../assets/css/corporate-ui-dashboard.css?v=1.0.0">
</head>

<body class="bg-light-blue">
    <main class="d-flex align-items-center min-vh-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6">
                    <div class="text-center mb-4">
                        <img src="http://absensi.connectis.my.id/logo.png" style="height: 8rem; filter: drop-shadow(0px 4px 8px rgba(0, 0, 0, 0.5));" alt="Logo">
                    </div>
                    <div class="card shadow-lg border-0">
                        <div class="card-body p-4">
                            <h3 class="text-center text-dark mb-3">Monitoring App</h3>
                            <p class="text-center text-muted">Silahkan Masukkan Data Login</p>
                            
                            @if (session('status'))
                                <div class="alert alert-success text-center" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            @error('message')
                                <div class="alert alert-danger text-center" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                            
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" value="{{ old('email') }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group">
                                        <input type="password" id="password" name="password" class="form-control" placeholder="Enter password" required>
                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword"><i class="fa fa-eye"></i></button>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary w-100 mt-3">Sign in</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Core JS Files -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordField = document.getElementById('password');
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
    </script>

    <style>
        /* Background color */
        .bg-light-blue {
            background-color: #2e29b0;
        }

        .card {
            border-radius: 15px;
            background-color: #f8f9fa;
        }

        .btn-primary {
            background: linear-gradient(135deg, #4b79a1, #283e51);
            border: none;
            font-weight: bold;
            transition: all 0.2s ease-in-out;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #3b5998, #192f4d);
            transform: scale(1.05);
        }

        .form-control, .input-group .btn {
            border-radius: 0.5rem;
        }
    </style>
</body>
</html>
