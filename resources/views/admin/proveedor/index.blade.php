@extends('Layouts.pantilla')
@section('title', 'Porveedor | Inevt')
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
                    <h4> <i class="fas fa-truck-moving"> Proveedores</i>
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalcreaproveedor">
                            Nuevo Proveedor
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
                    <table id="proveedoresTable" class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th style="text-align: center">Teléfono</th>
                                <th>Correo</th>
                                <th>Direccion</th>
                                <th>Foto</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $contador = 1;
                            @endphp
                            @foreach ($proveedores as $proveedor)
                                <tr>
                                    <td>{{ $contador++ }}</td>
                                    <td>{{ $proveedor->nombre }}</td>
                                    <td style="text-align: center">{{ $proveedor->telefono }}</td>
                                    <td>{{ $proveedor->correo }}</td>
                                    <td>{{ $proveedor->direccion }}</td>
                                    <td>
                                        @php
                                            $rutaImagen = public_path($proveedor->avatar);
                                        @endphp

                                        @if (file_exists($rutaImagen) && !is_dir($rutaImagen))
                                            <img src="{{ asset($proveedor->avatar) }}" class="img-fluid img-circle"
                                                style="width: 40px; cursor: none;">
                                        @else
                                            <img src="{{ asset('img/proveedor.png') }}" class="img-fluid img-circle"
                                                style="width: 40px; cursor: none;">
                                        @endif
                                    </td>

                                    <td>
                                        @if ($proveedor->estado == 'Activo')
                                            <span class="badge bg-success">Activo</span>
                                        @else
                                            <span class="badge bg-danger">Inactivo</span>
                                        @endif
                                    </td>

                                    <td>
                                        <button type="button" class="avatar btn btn-sm btn-info"
                                            data-id="{{ $proveedor->id }}" data-nombre="{{ $proveedor->nombre }}"
                                            data-avatar="{{ asset($proveedor->avatar ?? 'img/proveedor.png') }}">
                                            <i class="fas fa-image"></i>
                                        </button>

                                        <button class="editar-prov btn btn-sm btn-success" type="button"
                                            data-id="{{ $proveedor->id }}" data-toggle="modal"
                                            data-target="#modalEditarproveedor">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>

                                        <button class="borrar btn btn-sm btn-danger">
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

    <!-- Modal crear proveedor -->
    <div class="modal fade" id="modalcreaproveedor">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Craer Proveedor</h3>
                        <button data-bs-dismiss="modal" aria-label="close" class="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('crear_proveedor') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="nombre">Nombres:</label>
                                <input id="nombre" name="nombre" type="text" class="form-control"
                                    placeholder="Ingrese Nombre" required>
                            </div>

                            <div class="form-group">
                                <label for="telefono">Telefono:</label>
                                <input id="telefono" name="telefono" type="number" class="form-control"
                                    placeholder="Ingrese Telefono" required>
                            </div>

                            <div class="form-group">
                                <label for="correo">Correo</label>
                                <input id="correo" name="correo" type="email" class="form-control"
                                    placeholder="Ingrese Correo">
                            </div>

                            <div class="form-group">
                                <label for="direccion">Direccion:</label>
                                <input id="direccion" name="direccion" type="text" class="form-control"
                                    placeholder="Ingrese Direccion" required>
                            </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn bg-gradient-primary float-right m-1 w-100">Guardar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de cambiar logo -->
    <div class="animate__animated animate__bounceInDown modal fade" id="cambiologo">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h5 class="modal-title">Cambiar Foto De Proveedor</h5>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <img id='logoactual' src="{{ asset('img/proveedor.png') }}"
                            class="profile-user-img img-fluid img-circle">
                    </div>
                    <div class="text-center">
                        <b id="nombre_logo"></b>
                    </div>

                    <form action="{{ route('cambiar_foto_proveedor') }}" method="POST" enctype="multipart/form-data">
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

    <!-- Modal editar proveedor -->
    <div class="modal fade" id="modalEditarproveedor">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Editar Proveedor</h3>
                        <button data-dismiss="modal" aria-label="close" class="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('crear_proveedor') }}" method="POST">
                            @csrf

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
    <script>
        // Esperamos a que el documento esté listo antes de ejecutar el código.
        $(document).ready(function() {
            $('.select2').select2();
            $('#proveedoresTable').DataTable();

            // Detectar cambio en input file y mostrar la imagen seleccionada
            $('#photo').change(function(event) {
                var file = event.target.files[0]; // Obtener archivo
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#logoactual').attr('src', e.target.result); // Mostrar en modal
                    };
                    reader.readAsDataURL(file);
                } else {
                    console.warn("No se seleccionó ningún archivo.");
                }
            });

            $('#proveedoresTable').on('click', '.avatar', function(e) {
                var id = $(this).data('id');
                var nombre = $(this).data('nombre');
                var avatar = $(this).data('avatar');

                // Si el proveedor ya tiene foto, mostrarla; si no, usar la default
                $('#logoactual').attr('src', avatar || "{{ asset('img/proveedor.png') }}");
                $('#nombre_logo').html(nombre);
                $('#id-logo-prov').val(id);

                $('#cambiologo').modal('show');
            });

            $('#proveedoresTable').on('click', '.editar-prov', function() {
                var id = $(this).data('id');
                $('#id_edit_prov').val(id);
                var url = "{{ route('extraer_datos', ['id' => ':id']) }}";
                url = url.replace(':id', id);

                $.ajax({
                    type: "GET", // Método HTTP: POST
                    url: url, // URL del endpoint para crear el producto
                    processData: false, // No procesamos los datos (es necesario cuando usamos FormData)
                    contentType: false, // No definimos el tipo de contenido (también por el uso de FormData)
                })
            })

        });
    </script>



@endsection
