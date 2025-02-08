@extends('Layouts.pantilla')
@section('title', 'Cliente | Inevt')
@section('css')
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/v/dt/dt-2.1.3/datatables.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet" />
@endsection
@section('contenido')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4> <i class="fas fa-user-shield"> Clientes</i>
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalcreacli">
                            Nuevo cliente
                        </button>
                    </h4>
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
                    <table id="cliesTable" class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th style="text-align: center">Teléfono</th>
                                <th>DNI</th>
                                <th  style="text-align: center">Fecha Nacimiento</th>
                                <th>Foto</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $contador = 1;
                            @endphp

                            @foreach ($cliente as $cli)
                            <tr>
                                <td>{{ $contador++ }}</td>
                                <td>{{ $cli->nombre }} {{ $cli->apellidos }}</td>
                                <td style="text-align: center">{{ $cli->telefono }}</td>
                                <td  style="text-align: center">{{ $cli->dni }}</td>
                                <td  style="text-align: center">{{ $cli->edad }}</td>
                                <td>
                                    @php
                                        $rutaImagen = public_path($cli->avatar);
                                    @endphp

                                    @if (file_exists($rutaImagen) && !is_dir($rutaImagen))
                                        <img src="{{ asset($cli->avatar) }}" class="img-fluid img-circle"
                                            style="width: 40px; cursor: none;">
                                    @else
                                        <img src="{{ asset('img/proveedor.png') }}" class="img-fluid img-circle"
                                            style="width: 40px; cursor: none;">
                                    @endif
                                </td>

                                <td>
                                    @if ($cli->estado == 'Activo')
                                        <span class="badge bg-success">Activo</span>
                                    @else
                                        <span class="badge bg-danger">Inactivo</span>
                                    @endif
                                </td>

                                <td>
                                    <button type="button" class="avatar btn btn-sm btn-info"
                                        data-id="{{ $cli->id }}" data-nombre="{{ $cli->nombre }}"
                                        data-avatar="{{ asset($cli->avatar ?? 'img/cli.png') }}">
                                        <i class="fas fa-image"></i>
                                    </button>

                                    <button class="editar-prov btn btn-sm btn-success" type="button"
                                        data-id="{{ $cli->id }}" data-toggle="modal"
                                        data-target="#modalEditarcli">
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>

                                    <button class="borrar btn btn-sm btn-danger"  data-id="{{ $cli->id }}" data-nombre="{{ $cli->nombre }}">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal crear cli -->
    <div class="modal fade" id="modalcreacli">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Crear Clientes</h3>
                        <button data-bs-dismiss="modal" aria-label="close" class="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('crear_cliente') }}" method="POST">
                            @csrf
                            <div class="row">
                                <!-- Columna 1 -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nombre">Nombres:</label>
                                        <input id="nombre" name="nombre" type="text" class="form-control"
                                            placeholder="Ingrese Nombre" required>
                                    </div>
                                </div>
                                <!-- Columna 2 -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="apellidos">Apellidos:</label>
                                        <input id="apellidos" name="apellidos" type="text" class="form-control"
                                            placeholder="Ingrese Apellidos" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Columna 1 -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="dni">DNI:</label>
                                        <input id="dni" name="dni" type="number" class="form-control"
                                            placeholder="Ingrese DNI">
                                    </div>
                                </div>
                                <!-- Columna 2 -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="f_nac">Nacimiento:</label>
                                        <input id="f_nac" name="f_nac" type="date" class="form-control"
                                            placeholder="Ingrese Fecha De Nacimiento" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Columna 1 -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="telefono">Telefono:</label>
                                        <input id="telefono" name="telefono" type="number" class="form-control"
                                            placeholder="Ingrese Telefono">
                                    </div>
                                </div>
                                <!-- Columna 2 -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="correo">Correo</label>
                                        <input id="correo" name="correo" type="email" class="form-control"
                                            placeholder="Ingrese Correo">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Columna 1 -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sexo">Sexo:</label>
                                        <select name="id_sexo" id="id_sexo" class="form-control select2"
                                            style="width: 100%">
                                            <option value="">Seleccionar</option>
                                            @foreach ($sexo as $item)
                                                <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!-- Columna 2 -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="adicional">Direccion:</label>
                                        <textarea name="direccion" id="direccion" class="form-control" placeholder="Ingrese su direccion">

                                        </textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit"
                                    class="btn bg-gradient-primary float-right m-1 w-100">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de cambiar logo -->
    <div class="animate__animated animate__bounceInDown modal fade" id="cambiologo">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h5 class="modal-title">Cambiar Foto De cli</h5>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <img id='logoactual' src="{{ asset('img/cli.png') }}"
                            class="profile-user-img img-fluid img-circle">
                    </div>
                    <div class="text-center">
                        <b id="nombre_logo"></b>
                    </div>

                    <form action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="input-group mb-3 ml-5 mt-2">
                            <!-- SE AGREGA ID AL INPUT -->
                            <input type="file" id="photo" name="photo" class="input-group">
                            <input type="hidden" name="funcion" id="funcion">
                            <input type="hidden" name="id-logo-prov" id="id-logo-prov">
                        </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn bg-gradient-primary w-100">Guardar</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal editar cli -->
    <div class="modal fade" id="modalEditarcli">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Editar cli</h3>
                        <button data-dismiss="modal" aria-label="close" class="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="nombre">Nombres:</label>
                                <input id="nombre_edit" name="nombre_edit" type="text" class="form-control"
                                    placeholder="Ingrese Nombre" required>
                            </div>

                            <div class="form-group">
                                <label for="telefono">Telefono:</label>
                                <input id="telefono_edit" name="telefono_edit" type="number" class="form-control"
                                    placeholder="Ingrese Telefono" required>
                            </div>

                            <div class="form-group">
                                <label for="correo">Correo</label>
                                <input id="correo_edit" name="correo_edit" type="email" class="form-control"
                                    placeholder="Ingrese Correo">
                            </div>

                            <div class="form-group">
                                <label for="direccion">Direccion:</label>
                                <input id="direccion_edit" name="direccion_edit" type="text" class="form-control"
                                    placeholder="Ingrese Direccion" required>
                            </div>

                            <input type="hidden" name="id_edit_prov" id="id_edit_prov">

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn bg-gradient-primary float-right m-1 w-100">Guardar</button>
                    </div>
                    </form>
                </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    @if ($errors->any())
    <script>
      Swal.fire({
          icon: 'error',
          title: 'Error',
          text: '{{ $errors->first() }}',
      });
    </script>
    @endif



@endsection
