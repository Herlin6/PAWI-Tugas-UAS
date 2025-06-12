<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Welcome to GDeBook</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            overflow: hidden;
        }

        body {
            background: url('{{ asset('assets/img/welcome-background.png') }}') no-repeat center center fixed;
            background-size: cover;
            font-family: sans-serif;
            position: relative;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background-color: rgba(0, 0, 0, 0.65);
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 1rem;
            color: white;
            text-align: center;
        }

        h1 {
            font-size: 2.5rem;
        }

        p {
            font-size: 1rem;
        }

        @media (min-width: 768px) {
            h1 {
                font-size: 3rem;
            }

            p {
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body>
    <div class="overlay">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-6 p-lg-3">
                    <img
                        src="{{ asset('assets/img/GDeBookLogo2.png') }}"
                        alt="GDeBook Logo"
                        class="img-fluid mb-4 w-50 mx-auto d-block"
                        data-aos="zoom-in" data-aos-duration="500"
                    />
                    <h1 class="title-color font-playfair mb-3" data-aos="fade-up" data-aos-duration="650">Welcome</h1>
                    <p class="main-color font-playfair fs-5" data-aos="fade-up" data-aos-duration="800">
                        Literacy is the gateway to knowledge, the foundation of freedom, and the spark for lifelong learning.
                    </p>
                    <div class="d-grid gap-3 mt-4 w-75 mx-auto">
                        <x-button type="submit" class="btn btn-theme p-2" href="{{ route('login') }}" data-aos="fade-up" data-aos-duration="950">
                            <div class="font-playfair fs-5"><b>Login</b></div>
                        </x-button>
                        <x-dark-button type="submit" class="btn btn-theme p-2" href="{{ route('register') }}" data-aos="fade-up" data-aos-duration="1100">
                            <div class="font-playfair fs-5"><b>Register</b></div>
                        </x-dark-button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
window.addEventListener('load', function () {
    AOS.init({
        once: false,
        mirror: true,
        offset: 0,
    });

    setTimeout(() => AOS.refresh(), 100);
});
</script>
</html>
