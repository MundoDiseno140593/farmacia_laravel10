@extends('Layouts.pantilla')

@section('title', 'Farmacia|Usuario')

@section('css')
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/v/dt/dt-2.1.3/datatables.min.css" rel="stylesheet">
    <style>
        .profile-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #ddd;
            margin-bottom: 15px;
        }
    </style>
@endsection

@section('contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Dashboard
                        <button type="button" class="btn btn-info" data-bs-toggle="modal"
                            data-bs-target="#agregarusuariomodal">
                            Agregar Nuevo Usuario
                        </button>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="home.php">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Consultas</h3>
                </div>

                <div class="card-body">
                    <table class="table table-hover" id="usuarios">
                        <thead style="text-align: center">
                            <tr style="text-align: center">
                                <th style="text-align: center">N°</th>
                                <th style="text-align: center">Nombre</th>
                                <th style="text-align: center">Avatar</th>
                                <th style="text-align: center">Email</th>
                                <th style="text-align: center">Rol</th>
                                <th style="text-align: center">F.Registro</th>
                                <th style="text-align: center">Acciones</th>
                            </tr>
                        </thead>

                        <tbody style="text-align: center">
                            @php
                                $contador = 1;
                            @endphp
                            @foreach ($user as $us)
                                <tr id="user-row-{{ $us->id }}" style="text-align: center">
                                    <td style="text-align: center">{{ $contador++ }}</td>
                                    <td style="text-align: left">{{ $us->name }}</td>
                                    <td style="text-align: center">
                                        <img src="{{ $us->avatar ? asset('storage/profile_images/' . $us->avatar) : asset('img/default.jpg') }}"
                                            alt="Avatar"
                                            style="width: 50px; height: 50px; border-radius: 50%; margin-left: 5px;">
                                    </td>
                                    <td style="text-align: center">{{ $us->email }}</td>
                                    <td style="text-align: center">
                                        <span class="badge bg-primary"> {{ $us->tipo->nombre }}</span>
                                    </td>
                                    <td style="text-align: center">

                                        {{ $us->created_at->format('Y-m-d') }}

                                    </td>
                                    <td style="text-align: center">

                                        <button type="button" class="ver btn btn-sm btn-info"
                                            data-id="{{ $us->id }}"><i class="fas fa-eye"></i></button>

                                        <button type="button" class="editar btn btn-sm btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal" data-id="{{ $us->id }}">
                                            <i class="fas fa-user-edit"></i>
                                        </button>
                                        {{-- Mostrar el botón de eliminación solo si el usuario es root (id_tipo 1) --}}
                                        @if ((auth()->user()->id_tipo === 1 || auth()->user()->id_tipo === 2) && $us->id_tipo !== 1)
                                            <button type="button" data-id="{{ $us->id }}"
                                                class="eliminar btn btn-sm btn-danger">
                                                <i class="fas fa-user-minus"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="agregarusuariomodal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Crear Nuevo Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('saveuser') }}" method="POST">
                        @csrf
                        <div class="form-group m-2">
                            <label for="nombre">Nombre Completo</label>
                            <input type="text" name="nombre" class="form-control"
                                placeholder="Ingrese el nombre del usuario" required>
                        </div>

                        <div class="form-group m-2">
                            <label for="email">Correo Electronico</label>
                            <input type="email" name="email" class="form-control"
                                placeholder="Ingrese el correo electronico" required>
                        </div>

                        <div class="form-group m-2">
                            <label for="password">Contraseña</label>
                            <input type="password" name="password" class="form-control" placeholder="Ingrese la contraseña"
                                required>
                        </div>

                        <div class="form-group m-2">
                            <label for="rol">Tipo de usuario</label>
                            <select name="id_tipo" id="id_tipo" class="form-control select2" style="width: 100%">
                                <option value="">Selecionar</option>
                                @foreach ($tipousuario as $tip)
                                    <option value="{{ $tip->id }}">{{ $tip->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="verusuariomodal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-info">
                    <h5 class="modal-title" id="exampleModalLabel">Ver Datos del Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="card bg-light d-flex flex-fill">
                        <div class="card-header text-muted border-bottom-0">
                            <span id="verRol" class="badge bg-danger"></span>
                        </div>
                        <div class="card-body pt-0">
                            <div class="row">
                                <div class="col-7">
                                    <h2 class="lead"><b id="verNombre">Nicole Pearson</b></h2>

                                    <ul class="ml-4 mb-0 fa-ul text-muted">
                                        <li class="small">
                                            <span class="fa-li">
                                                <i<i class="fas fa-at"></i>
                                            </span><span id="verEmail"></span>
                                        </li>
                                        {{--  <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span>
                                            Phone #: + 800 - 12 12 23 52
                                        </li>  --}}
                                    </ul>
                                </div>
                                <div class="col-5 text-center">
                                    <img id="verAvatar" alt="user-avatar" class="img-circle img-fluid" style="height: 110px; width:110px">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <p><strong>Fecha de Registro: </strong><span id="verFechaRegistro"></span></p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal editar usuario -->
    <div class="modal fade" id="exampleModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form action="{{ route('editar_usuario') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="iduser" id="iduser">

                        <div class="text-center">
                            <img id="profileImage" alt="Foto de perfil" class="profile-image">
                        </div>


                        <div class="form-group">
                            <label for="profile_image">Subir nueva foto de perfil</label>
                            <input type="file" name="profile_image" class="form-control" id="profile_image" required>
                        </div>

                        <div class="form-group">
                            <label for="nombre">Nombre Completo</label>
                            <input type="text" name="username" id="username" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="eamil">Correo Electronico</label>
                            <input type="email" name="useremail" id="useremail" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="rol">Tipo de usuario</label>
                            <select name="id_tipo_edit" id="id_tipo_edit" class="form-control select2"
                                style="width: 100%">
                                <option value="">Selecionar</option>
                                @foreach ($tipousuario as $tip)
                                    <option value="{{ $tip->id }}">{{ $tip->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100">Actualizar Datos</button>
                </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('js')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/v/dt/dt-2.1.3/datatables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#id_tipo').select2()
            $('#id_tipo_edit').select2()

            $('#usuarios').DataTable({
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.11.4/i18n/es_es.json"
                }
            });

            $(document).on('click', '.ver', function() {
                var userId = $(this).data('id');

                var URL = "{{ route('verusuario', ['id' => ':id']) }}";
                URL = URL.replace(':id', userId);

                $.ajax({
                    url: URL,
                    type: 'GET',
                    success: function(data) {
                        console.log(data);
                        $('#verNombre').text(data.name)
                        $('#verEmail').text(data.email)
                        $('#verRol').text(data.tipo.nombre)

                        var fecharegistro = new Date(data.created_at)


                        var options = {
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric',
                            hour: 'numeric',
                            minute: 'numeric',
                            second: 'numeric'
                        };

                        var fechaformateada = fecharegistro.toLocaleDateString('es-ES',
                            options);

                        $('#verFechaRegistro').text(fechaformateada);
                        $('#verAvatar').attr('src', data.avatar);


                        $('#verusuariomodal').modal('show');
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr);
                        console.log(status);
                        console.log(error);
                    }
                });
            })


            $(document).on('click', '.editar', function() {
                var userId = $(this).data('id');


                var URL = "{{ route('editarus', ['id' => ':id']) }}";
                URL = URL.replace(':id', userId);

                $.ajax({
                    url: URL,
                    type: 'GET',
                    success: function(data) {
                        console.log(data);
                        $('#iduser').val(data.id);
                        $('#username').val(data.name);
                        $('#useremail').val(data.email);
                        $('#id_tipo_edit').val(data.id_tipo).trigger('change');

                        // Mostrar la imagen de perfil o una imagen por defecto si el avatar es null
                        $('#profileImage').attr('src', data.avatar);
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr);
                        console.log(status);
                        console.log(error);
                    }
                });
            })


            $(document).on('click', '.eliminar', function() {
                var userId = $(this).data('id');

                var URL = "{{ route('eliminar', ['id' => ':id']) }}";
                URL = URL.replace(':id', userId);

                Swal.fire({
                    title: '¿Estás seguro de eliminar este usuario?',
                    text: "Una vez eliminado, no podrá recuperarlo!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, eliminar!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: URL,
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(data) {
                                console.log(data);
                                if (data.success) {
                                    Swal.fire(
                                        'Eliminado!',
                                        data.message,
                                        'success'
                                    );

                                    $('#user-row-' + userId).remove();
                                } else {
                                    Swal.fire(
                                        'Error!',
                                        data.message,
                                        'error'
                                    );
                                }
                            },
                            error: function(xhr, status, error) {
                                console.log(xhr);
                                console.log(status);
                                console.log(error);
                            }
                        });
                    }
                })
            })




        });
    </script>

@endsection
