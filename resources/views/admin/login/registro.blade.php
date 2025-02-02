<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
    data-sidebar-image="none">

<head>

    <meta charset="utf-8" />
    <title>Registro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- Layout config Js -->
    <script src="{{ asset('js/layout.js') }}"></script>
    <!-- Bootstrap Css -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{ asset('css/custom.min.css') }}" rel="stylesheet" type="text/css" />

</head>

<body>
    <div class="auth-page-wrapper auth-bg-cover py-5 d-flex justify-content-center align-items-center min-vh-100">
        <div class="bg-overlay"></div>
        <!-- auth-page content -->
        <div class="auth-page-content overflow-hidden pt-lg-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card overflow-hidden">
                            <div class="row g-0">
                                <div class="col-lg-6">
                                    <div class="p-lg-5 p-4 auth-one-bg h-100">
                                        <div class="bg-overlay"></div>
                                        <div class="position-relative h-100 d-flex flex-column">
                                            <div class="mb-4">
                                                <a href="index.html" class="d-block">
                                                    <img src="assets/images/logo-light.png" alt=""
                                                        height="18">
                                                </a>
                                            </div>

                                        </div>
                                    </div>
                                </div>


                                <div class="col-lg-6">
                                    <div class="p-lg-5 p-4">
                                        <div class="text-center">
                                            <h5 class="text-primary">Solo Se va A Registrar !</h5>
                                            <p class="text-muted">El usuario de Tipo Root.</p>
                                        </div>

                                        <div class="mt-4">
                                            <form action="{{ route('crearusuario') }}" method="POST">
                                                @csrf

                                                @if ($errors->any())
                                                    <div class="alert alert-danger">
                                                        <ul>
                                                            @foreach ($errors->all() as $error)
                                                                <li>{{ $error }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif
                                                <div class="mb-3">
                                                    <label for="username" class="form-label">Nombre Completo</label>
                                                    <input type="text" class="form-control" id="name"
                                                        name="name" placeholder="Nombre Completo">
                                                </div>

                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Correo Electronico</label>
                                                    <input type="email" class="form-control" id="email"
                                                        name="email" placeholder="Ingresar Correo Electronico"
                                                        pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$">
                                                    <div class="invalid-feedback" id="email-feedback">
                                                        Por favor, ingresa un correo electrónico válido.
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label" for="password-input">Contraseña</label>
                                                    <div class="position-relative auth-pass-inputgroup mb-3">
                                                        <input type="password" class="form-control pe-5" name="password"
                                                            placeholder="Ingrese su Contraseña" id="password-input"
                                                            required>
                                                        <button
                                                            class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted"
                                                            type="button" id="password-addon">
                                                            <i class="ri-eye-fill align-middle" id="toggle-icon"></i>
                                                        </button>
                                                    </div>
                                                </div>

                                                <div class="mt-4">
                                                    <button class="btn btn-info  w-100" type="submit">
                                                        Crear Usuario Root
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('libs/feather-icons/feather.min.js') }}"></script>
    <script src="j{{ asset('libs/feather-icons/feather.min.js') }}"></script>

    <script>
        // Mostrar/Ocultar contraseña
        document.getElementById('password-addon').addEventListener('click', function() {
            var passwordInput = document.getElementById('password-input');
            var toggleIcon = document.getElementById('toggle-icon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('ri-eye-fill');
                toggleIcon.classList.add('ri-eye-off-fill');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('ri-eye-off-fill');
                toggleIcon.classList.add('ri-eye-fill');
            }
        });

        // Validar correo electrónico
        document.getElementById('login-form').addEventListener('submit', function(event) {
            var emailInput = document.getElementById('email');
            var emailFeedback = document.getElementById('email-feedback');
            var emailPattern = /^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/;

            if (!emailPattern.test(emailInput.value)) {
                emailInput.classList.add('is-invalid');
                emailFeedback.style.display = 'block';
                event.preventDefault(); // Evita el envío del formulario si el correo no es válido
            } else {
                emailInput.classList.remove('is-invalid');
                emailFeedback.style.display = 'none';
            }
        });
    </script>
</body>

</html>
