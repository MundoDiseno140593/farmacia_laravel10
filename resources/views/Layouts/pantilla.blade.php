<!DOCTYPE html>
<html lang="en">
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="0">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title') | Farmacia</title>

@yield('css')
<link rel="shortcut icon" href="{{ asset('img/HECRH.png') }}" type="image/x-icon" />
<!-- Font Awesome -->
<link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
<!-- Ionicons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<!-- Tempusdominus Bootstrap 4 -->
<link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
<!-- iCheck -->
<link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
<!-- Theme style -->
<link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs5.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/font-awesome.css') }}">

<!-- overlayScrollbars -->
<link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">

<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

<link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">
<link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
<style>
    .resaltado {
        color: #007bff99;
        padding: 5px;
        border-radius: 5px;
    }

    .nav-link.active {
        background-color: #007bff !important;
        /* Cambia esto al color que prefieras */
        color: white !important;
    }
</style>
<script>
    function obtenerNombreMes(numeroMes) {
        var meses = [
            "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
            "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
        ];
        return meses[numeroMes - 1];
    }

    function actualizarFechaYHora() {
        var fecha = new Date();
        var dia = fecha.getDate();
        var mes = obtenerNombreMes(fecha.getMonth() + 1); // Se suma 1 porque los meses en JavaScript van de 0 a 11
        var año = fecha.getFullYear();
        var hora = fecha.getHours();
        var minutos = fecha.getMinutes();
        var segundos = fecha.getSeconds();

        // Formatear la fecha como "dd de mes de yyyy"
        var fechaFormateada = dia + '  ' + mes + ' del ' + año;

        // Formatear la hora como "HH:mm:ss"
        var horaFormateada = (hora < 10 ? '0' : '') + hora + ':' + (minutos < 10 ? '0' : '') + minutos + ':' + (
            segundos < 10 ? '0' : '') + segundos;

        // Actualizar el contenido del elemento con id "horaActual"
        document.getElementById('horaActual').innerText = 'Nicaragua, ' + fechaFormateada + ', ' + horaFormateada;
    }

    // Actualizar la fecha y hora cada segundo
    setInterval(actualizarFechaYHora, 1000);

    // Llamar a la función para mostrar la fecha y hora inicial
    actualizarFechaYHora();
</script>
</head>

<body class="layout-fixed layout-navbar-fixed layout-footer-fixed sidebar-mini">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                        <i class="fas fa-bars"></i>
                    </a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-clock nav-item m-1"></i>
                        <b id="horaActual" class="resaltado"></b>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                        <img id="avatar4" src="{{ asset('img/logo.jpg') }}" class="user-image img-circle"
                            alt="User Image" style="width: 40px; height:35px">
                        <span class="d-none d-md-inline">{{ $nombre }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <!-- User image -->
                        <div class="dropdown-header text-center bg-primary">
                            <img id="avatar4" src="{{ asset('img/logo.jpg') }}" class="img-circle" alt="User Image"
                                style="width: 100px; height:150px;">
                            <p>
                                {{ $nombre }} <br>
                                <small>Miembro desde Nov. 2021</small>
                            </p>
                        </div>
                        <!-- Menu Footer-->
                        <div class="dropdown-footer d-flex justify-content-between">
                            <a href="" class="btn btn-default btn-flat">Perfil</a>
                            <a href="{{ route('logout') }}"
                                class="btn btn-default btn-flat">Cerrar sesión</a>
                        </div>

                    </div>
                </li>
            </ul>
        </nav>



        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="" class="brand-link">
                <img src="{{ asset('img/logo.png') }}"  class="brand-image img-circle elevation-3"
                    style="opacity: .8">
                <span class="brand-text font-weight-light">Elvis Code</span>
            </a>


            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item menu-open">
                            <a href="" class="nav-link active">
                                <p>

                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                            </ul>
                        </li>

                        <li class="nav-item ">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Gestion Usuarios
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>

                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('listausuario') }}" class="nav-link">
                                        <i class="fas fa-solid fa-user-plus nav-icon"></i>
                                        <p>usuarios Activos</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('usuariosinactivos') }}" class="nav-link">

                                        <i class="fas fa-user-minus nav-icon"></i>
                                        <p>usuarios Inactivos</p>
                                    </a>
                                </li>
                            </ul>

                        </li>

                        <li class="nav-item ">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-user-tie"></i>
                                <p>
                                    Clientes
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>

                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('listaCliente') }}" class="nav-link">
                                        <i class="fas fa-address-card nav-icon"></i>
                                        <p>Gestion clientes</p>
                                    </a>
                                </li>

                            </ul>

                        </li>

                        <li class="animate__animated animate__jackInTheBox nav-header">Almacen</li>
                        <li class="nav-item ">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-tablets"></i>
                                <p>
                                    Productos
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>

                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('vistaproducto') }}" class="nav-link">
                                        <i class="fas fa-box-open  nav-icon"></i>
                                        <p>Gestion Productos</p>
                                    </a>
                                </li>
                            </ul>

                        </li>

                        <li class="nav-item ">
                            <a href="{{ route('vistaAtributos') }}" class="nav-link" >
                                <i class="nav-icon fas fa-vials"></i>
                                <p>
                                    Atributos
                                </p>
                            </a>
                        </li>


                        <li class="nav-header">Compra</li>
                        <li class="nav-item ">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-truck-loading"></i>
                                <p>
                                    Proveedores
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>

                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('vistaproveedor') }}" class="nav-link">
                                        <i class="fas fa-truck-moving  nav-icon"></i>
                                        <p>Gestion Proveedor</p>
                                    </a>
                                </li>
                            </ul>

                        </li>

                        <li class="nav-item ">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-store-alt"></i>
                                <p>
                                    Compra producto
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>

                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('vista_compra') }}" class="nav-link">
                                        <i class="fas fa-truck-moving  nav-icon"></i>
                                        <p>Gestion Compra</p>
                                    </a>
                                </li>
                            </ul>

                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <div class="content-wrapper">
            <section class="content">

                <div class="container-fluid">
                    @yield('contenido')
                </div>

            </section>
        </div>

        <footer class="main-footer">
            <strong>Copyright &copy; 2014-2021</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 3.1.0
            </div>
        </footer>
        <aside class="control-sidebar control-sidebar-dark">
        </aside>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js"></script>
    <script src="{{ asset('plugins/summernote/summernote-bs5.min.js') }}"></script>
    <script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <script src="{{ asset('dist/js/adminlte.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js">
        < script src = "https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" >
    </script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    @yield('js')
</body>

</html>
