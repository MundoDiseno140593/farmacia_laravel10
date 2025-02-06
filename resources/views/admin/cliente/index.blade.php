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
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalcreaproveedor">
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

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal crear proveedor -->
    <div class="modal fade" id="modalcreaproveedor">
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
                        <form action="{{ route('crear_proveedor') }}" method="POST">
                            @csrf
                            <div class="row">
                                <!-- Columna 1 -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nombre">Nombres:</label>
                                        <input id="nombre" type="text" class="form-control" placeholder="Ingrese Nombre" required>
                                    </div>
                                </div>
                                <!-- Columna 2 -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="apellidos">Apellidos:</label>
                                        <input id="apellidos" type="text" class="form-control" placeholder="Ingrese Apellidos" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Columna 1 -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="dni">DNI:</label>
                                        <input id="dni" type="text" class="form-control" placeholder="Ingrese DNI">
                                    </div>
                                </div>
                                <!-- Columna 2 -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="edad">Nacimiento:</label>
                                        <input id="edad" type="date" class="form-control" placeholder="Ingrese Fecha De Nacimiento" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Columna 1 -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="telefono">Telefono:</label>
                                        <input id="telefono" type="number" class="form-control" placeholder="Ingrese Telefono">
                                    </div>
                                </div>
                                <!-- Columna 2 -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="correo">Correo</label>
                                        <input id="correo" type="email" class="form-control" placeholder="Ingrese Correo">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Columna 1 -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sexo">Sexo:</label>
                                        <select name="id_sexo" id="id_sexo" class="form-control select2" style="width: 100%">
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
                                <button type="submit" class="btn bg-gradient-primary float-right m-1 w-100">Guardar</button>
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
                        <form action="{{ route('actualizar_proveedor') }}" method="POST">
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
                    type: "GET",
                    url: url,
                    dataType: "json", // Aseguramos que la respuesta sea JSON
                    success: function(response) {
                        console.log(response)
                        if (response.success) {
                            var proveedor = response.data;
                            // Llenar los campos del modal con los datos obtenidos
                            $('#nombre_edit').val(proveedor.nombre);
                            $('#correo_edit').val(proveedor.correo);
                            $('#telefono_edit').val(proveedor.telefono);
                            $('#direccion_edit').val(proveedor.direccion);
                            // Mostrar el modal
                            $('#modalEditarproveedor').modal('hide');
                        } else {
                            alert("No se encontraron datos del proveedor.");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error en la petición AJAX:", error);
                    }
                });
            });


            $('#proveedoresTable').on('click','.borrar', function(){
                var id = $(this).data('id');
                var nombre = $(this).data('nombre');

                var url = "{{ route('eliminar_proveedor',['id'=>':id']) }}";
                url = url.replace(':id', id);

                Swal.fire({
                    title: "¿Estás seguro?",
                    text: "Se eliminará el proveedor: " + nombre,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Sí, eliminar",
                    cancelButtonText: "Cancelar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: url,
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire("¡Inactivado!", response.message, "success")
                                        .then(() => {
                                            location.reload(); // Recargar la página o actualizar la tabla
                                        });
                                } else {
                                    Swal.fire("Error", response.message, "error");
                                }
                            },
                            error: function(xhr, status, error) {
                                Swal.fire("Error", "No se pudo inactivar el proveedor.", "error");
                            }
                        });
                    }
                });

            })

        });
    </script>



@endsection
