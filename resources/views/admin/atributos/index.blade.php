@extends('Layouts.pantilla')
@section('title', 'Atributos | Inevt')
@section('css')
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/v/dt/dt-2.1.3/datatables.min.css" rel="stylesheet">
@endsection

@section('contenido')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-sitemap"></i> Gestion Atributos</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card ">
                        <div class="card-header">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a href="#laboratorio" class="nav-link active"
                                        data-toggle="tab">Laboratorio</a></li>
                                <li class="nav-item"><a href="#tipo" class="nav-link" data-toggle="tab">Tipo Producto</a>
                                </li>
                                <li class="nav-item"><a href="#presentacion" class="nav-link"
                                        data-toggle="tab">Presentacion</a></li>
                            </ul>
                        </div>

                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="laboratorio">
                                    <div class="card card-secondary">
                                        <div class="card-header">
                                            <div class="card-title" style="margin-bottom: 0px;">Lista Laboratorio
                                                <button class="btn btn-info float-right" style="margin-left: 10px;"
                                                    data-bs-toggle="modal" data-bs-target="#crearLaboratorio">
                                                    <i class="fas fa-plus"></i> Nuevo Laboratorio
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <table id="laboratorioTable" class="table  table-hover">
                                                <thead>
                                                    <tr>
                                                        <th style="text-align: center">#</th>
                                                        <th>Nombre</th>
                                                        <th style="text-align: center">Foto</th>
                                                        <th style="text-align: center">Actiones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane" id="tipo">
                                    <div class="card card-secondary">
                                        <div class="card-header">
                                            <div class="card-title" style="margin-bottom: 0px;">
                                                Lista Tipo Producto
                                                <button class="btn btn-success float-right" style="margin-left: 10px;"
                                                    data-bs-toggle="modal" data-bs-target="#crearTipo">
                                                    <i class="fas fa-plus"></i> Nuevo Tipo
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <table id="tipoTable" class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th style="text-align: center">#</th>
                                                        <th>Nombre</th>
                                                        <th style="text-align: center">Actiones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="presentacion">
                                    <div class="card card-secondary">
                                        <div class="card-header">
                                            <div class="card-title" style="margin-bottom: 0px;">
                                                Lista Presentacion
                                                <button class="btn btn-success float-right" style="margin-left: 10px;"
                                                data-bs-toggle="modal" data-bs-target="#crearPresentacion">
                                                <i class="fas fa-plus"></i> Nueva Presentacion
                                            </button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <table id="presentacionTable" class="table  table-hover">
                                                <thead>
                                                    <tr>
                                                        <th style="text-align: center">#</th>
                                                        <th>Nombre</th>
                                                        <th style="text-align: center">Actiones</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{--  modales de laboratorios  --}}

    <!-- Modal crear laboratorio -->
    <div class="modal fade" id="crearLaboratorio">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="crearLaboratorioLabel">Agregar Laboratorio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('crearLaboratorio') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre del Laboratorio</label>
                            <input type="text" class="form-control" id="nombre" name="nombre"
                                placeholder="Crear Laboratorio" required>
                        </div>

                        <div class="mb-3 text-center">
                            <!-- Añadir una clase para centrar la imagen -->
                            <div style="display: flex; justify-content: center;">
                                <img id="preview" src="{{ asset('img/default.jpg') }}" alt="Vista previa"
                                    style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%; display: none;">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto del Laboratorio</label>
                            <input type="file" class="form-control" id="foto" name="foto" accept="image/*"
                                onchange="previewImage(event)">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100">Crear Laboratorio</button>
                </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Modal para editar laboratorio -->
    <div class="modal fade" id="editarLaboratorio">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarLaboratorioLabel">Editar Laboratorio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditarLaboratorio">
                        @csrf
                        <input type="hidden" id="laboratorioId" name="id">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre del Laboratorio</label>
                            <input type="text" class="form-control" id="edit_nombre" name="edit_nombre" required>
                        </div>

                        <div class="mb-3 text-center">
                            <img id="fotoPreview" src="{{ asset('img/default.jpg') }}" alt="Vista previa"
                                style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%;">
                        </div>

                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto del Laboratorio</label>
                            <input type="file" class="form-control" id="edit_foto" name="edit_foto"
                                accept="image/*">
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{--  modales de tipo  --}}
    <!-- Modal crear tipo -->
    <div class="modal fade" id="crearTipo">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="crearLaboratorioLabel">Agregar Tipo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formCrearTipo" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre_tipo" name="nombre_tipo"
                                placeholder="Tipo Producto" required>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100">Crear Laboratorio</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal para editar tipo -->
    <div class="modal fade" id="editarTipo">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarTipoLabel">Editar Tipo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditarTipo">
                        @csrf
                        <input type="hidden" id="tipoId" name="id">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre del Laboratorio</label>
                            <input type="text" class="form-control" id="edit_nombre_tip" name="edit_nombre_tip" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{--  modales de presentacion   --}}
    <!-- Modal crear presentacion -->
    <div class="modal fade" id="crearPresentacion">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="crearPresentacionLabel">Agregar Presentacion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formcrearPresentacion" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre_pre" name="nombre_pre"
                                placeholder="Presentacion" required>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100">Crear Presentacion</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal para editar tipo -->
    <div class="modal fade" id="editarpresent">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarPreLabel">Editar Presentacion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditarPresent">
                        @csrf
                        <input type="hidden" id="preId" name="id">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre del Laboratorio</label>
                            <input type="text" class="form-control" id="edit_nombre_pre" name="edit_nombre_pre" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Guardar Cambios</button>
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
    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('preview');
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result; // Asigna la imagen cargada a la fuente de la vista previa
                    preview.style.display = 'block'; // Muestra la vista previa
                }
                reader.readAsDataURL(file); // Lee la imagen como una URL de datos
            } else {
                preview.src = '{{ asset('default.png') }}'; // Restablece a la imagen por defecto
                preview.style.display = 'none'; // Oculta la vista previa si no hay archivo
            }
        }

        $(document).ready(function() {
            // Inicializa DataTable para laboratorio
            var laboratorioTable = $('#laboratorioTable').DataTable({
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.11.4/i18n/es_es.json"
                }
            });

            recargarTabla();

            // Función para recargar la tabla de laboratorios
            function recargarTabla() {
                var URL = "{{ route('listarLaboratorios') }}";
                $.ajax({
                    url: URL,
                    type: 'GET',
                    success: function(data) {
                        // Destruir el DataTable antes de recargar los datos
                        laboratorioTable.destroy();

                        // Limpia la tabla actual
                        $('#laboratorioTable tbody').empty();

                        // Itera sobre los datos y vuelve a llenar la tabla
                        let contador = 1;
                        data.lab.forEach(function(item) {
                            const fotoUrl = item.foto_url ? item.foto_url :
                                '{{ asset('img/default.jpg') }}';
                            $('#laboratorioTable tbody').append(`
                                <tr id="lab-row-${item.id}">
                                    <td style="text-align: center">${contador++}</td>
                                    <td>${item.nombre}</td>
                                    <td style="text-align: center">
                                        <img src="${fotoUrl}" style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%;">
                                    </td>
                                    <td style="text-align: center">
                                        <button class="editar btn btn-warning" data-id="${item.id}">
                                            <i class="far fa-edit"></i>
                                        </button>
                                        <button class="eliminar btn btn-danger" data-id="${item.id}">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            `);
                        });

                        // Re-inicializa el DataTable después de recargar los datos
                        laboratorioTable = $('#laboratorioTable').DataTable({
                            "language": {
                                "url": "https://cdn.datatables.net/plug-ins/1.11.4/i18n/es_es.json"
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr);
                        console.log(status);
                        console.log(error);
                    }
                });
            }

            $('#laboratorioTable').on('click', '.eliminar', function() {
                var labId = $(this).data('id');

                var URL = "{{ route('eliminarLaboratorio', ['id' => ':id']) }}";
                URL = URL.replace(':id', labId);

                Swal.fire({
                    title: '¿Estás seguro de eliminar este Laboratorio?',
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
                                if (data.success) {
                                    Swal.fire('Eliminado!', data.message, 'success');
                                    recargarTabla();
                                } else {
                                    Swal.fire('Error!', data.message, 'error');
                                }
                            },
                            error: function(xhr, status, error) {
                                console.log(xhr);
                                console.log(status);
                                console.log(error);
                            }
                        });
                    }
                });
            });

            $('#laboratorioTable').on('click', '.editar', function() {
                var labId = $(this).data('id');

                var URL = "{{ route('datoslaboratorio', ['id' => ':id']) }}";
                URL = URL.replace(':id', labId);

                $.ajax({
                    url: URL,
                    type: 'GET',
                    success: function(data) {
                        if (data.success) {
                            $('#laboratorioId').val(data.laboratorio.id);
                            $('#edit_nombre').val(data.laboratorio.nombre);
                            $('#fotoPreview').attr('src', data.laboratorio.foto_url ? data
                                .laboratorio.foto_url : '{{ asset('img/default.jpg') }}');
                            $('#editarLaboratorio').modal('show'); // Muestra el modal
                        } else {
                            Swal.fire('Error!', data.message, 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr);
                        console.log(status);
                        console.log(error);
                    }
                });
            });

            $('#formEditarLaboratorio').on('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                const laboratorioId = $('#laboratorioId').val();

                var URL = "{{ route('editarLabo', ['id' => ':id']) }}";
                URL = URL.replace(':id', laboratorioId);

                $.ajax({
                    url: URL,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        if (data.success) {
                            Swal.fire('Actualizado!', data.message, 'success');
                            $('#editarLaboratorio').modal('hide');
                            recargarTabla();
                            $('#formEditarLaboratorio')[0].reset();
                        } else {
                            Swal.fire('Error!', data.message, 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        // Mostrar detalles del error
                        console.error("Error details:");
                        console.error("Status: " + status);
                        console.error("Error: " + error);
                        console.error("Response Text: " + xhr.responseText);
                    }
                });
            });

            //procesos  Tipo Producto
            var tipoTable = $('#tipoTable').DataTable({
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.11.4/i18n/es_es.json"
                }
            });

            recargarTablaTipo();

            $('#formCrearTipo').on('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                var URL = "{{ route('crearTipoProd') }}";

                $.ajax({
                    url: URL,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        if (data.success) {
                            Swal.fire('Creado!', data.message, 'success');
                            $('#crearTipo').modal('hide');
                            recargarTablaTipo();
                            // Limpiar el formulario
                            $('#formCrearTipo')[0].reset();
                        } else {
                            Swal.fire('Error!', data.message, 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log("Error details:");
                        console.log("Status: " + status);
                        console.log("Error: " + error);
                        console.log("Response Text: " + xhr.responseText);
                        Swal.fire('Error!',
                            'Ocurrió un error al intentar crear el laboratorio.', 'error');
                    }
                });
            });

            function recargarTablaTipo() {
                var URL = "{{ route('listartipo') }}";
                $.ajax({
                    url: URL,
                    type: 'GET',
                    success: function(data) {
                        // Destruir el DataTable antes de recargar los datos
                        tipoTable.destroy();

                        // Limpia la tabla actual
                        $('#tipoTable tbody').empty();

                        // Itera sobre los datos y vuelve a llenar la tabla
                        let contador = 1;
                        data.tip.forEach(function(item) {
                            $('#tipoTable tbody').append(`
                                <tr id="tip-row-${item.id}">
                                    <td style="text-align: center">${contador++}</td>
                                    <td>${item.nombre}</td>
                                    <td style="text-align: center">
                                        <button class="editarTip btn btn-warning" data-id="${item.id}">
                                            <i class="far fa-edit"></i>
                                        </button>
                                        <button class="eliminarTip btn btn-danger" data-id="${item.id}" data-nombre="${item.nombre}">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            `);
                        });

                        // Re-inicializa el DataTable después de recargar los datos
                        tipoTable = $('#tipoTable').DataTable({
                            "language": {
                                "url": "https://cdn.datatables.net/plug-ins/1.11.4/i18n/es_es.json"
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr);
                        console.log(status);
                        console.log(error);
                    }
                });
            }

            $('#tipoTable').on('click', '.editarTip', function() {
                var tipId = $(this).data('id');

                var URL = "{{ route('datosTip', ['id' => ':id']) }}";
                URL = URL.replace(':id', tipId);

                $.ajax({
                    url: URL,
                    type: 'GET',
                    success: function(data) {
                        if (data.success) {
                            $('#tipoId').val(data.tipo.id);
                            $('#edit_nombre_tip').val(data.tipo.nombre);
                            $('#editarTipo').modal('show'); // Muestra el modal
                        } else {
                            Swal.fire('Error!', data.message, 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr);
                        console.log(status);
                        console.log(error);
                    }
                });
            });

            $('#formEditarTipo').on('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                const tipoId = $('#tipoId').val();

                var URL = "{{ route('editarTipo', ['id' => ':id']) }}";
                URL = URL.replace(':id', tipoId);

                $.ajax({
                    url: URL,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        if (data.success) {
                            Swal.fire('Actualizado!', data.message, 'success');
                            $('#editarTipo').modal('hide');
                            recargarTablaTipo();
                            $('#formEditarTipo')[0].reset();
                        } else {
                            Swal.fire('Error!', data.message, 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        // Mostrar detalles del error
                        console.error("Error details:");
                        console.error("Status: " + status);
                        console.error("Error: " + error);
                        console.error("Response Text: " + xhr.responseText);
                    }
                });
            });

            $('#tipoTable').on('click', '.eliminarTip', function() {
                var tipoId = $(this).data('id');
                var tipoNombre = $(this).data('nombre');

                var URL = "{{ route('eliminarTipo', ['id' => ':id']) }}";
                URL = URL.replace(':id', tipoId);

                Swal.fire({
                    title: '¿Estás seguro de eliminar este Tipo Producto?',
                    text: `Una vez eliminado, no podrá recuperarlo! Tipo: ${tipoNombre}`,
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
                                if (data.success) {
                                    Swal.fire('Eliminado!', data.message, 'success');
                                    recargarTablaTipo();
                                } else {
                                    Swal.fire('Error!', data.message, 'error');
                                }
                            },
                            error: function(xhr, status, error) {
                                console.log(xhr);
                                console.log(status);
                                console.log(error);
                            }
                        });
                    }
                });
            });

            {{--  procesos de presentacion  --}}
            var presentacionTable = $('#presentacionTable').DataTable({
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.11.4/i18n/es_es.json"
                }
            });
            recargarTablapresentacion();

            $('#formcrearPresentacion').on('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                var URL = "{{ route('crearPresentacion') }}";

                $.ajax({
                    url: URL,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        if (data.success) {
                            Swal.fire('Creado!', data.message, 'success');
                            $('#crearPresentacion').modal('hide');
                            recargarTablapresentacion();
                            // Limpiar el formulario
                            $('#formcrearPresentacion')[0].reset();
                        } else {
                            Swal.fire('Error!', data.message, 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log("Error details:");
                        console.log("Status: " + status);
                        console.log("Error: " + error);
                        console.log("Response Text: " + xhr.responseText);
                        Swal.fire('Error!',
                            'Ocurrió un error al intentar crear el laboratorio.', 'error');
                    }
                });
            });

            function recargarTablapresentacion() {
                var URL = "{{ route('listarPresentacion') }}";
                $.ajax({
                    url: URL,
                    type: 'GET',
                    success: function(data) {
                        // Destruir el DataTable antes de recargar los datos
                        presentacionTable.destroy();

                        // Limpia la tabla actual
                        $('#presentacionTable tbody').empty();

                        // Itera sobre los datos y vuelve a llenar la tabla
                        let contador = 1;
                        data.pre.forEach(function(item) {
                            $('#presentacionTable tbody').append(`
                                <tr id="pre-row-${item.id}">
                                    <td style="text-align: center">${contador++}</td>
                                    <td>${item.nombre}</td>
                                    <td style="text-align: center">
                                        <button class="editarPre btn btn-warning" data-id="${item.id}">
                                            <i class="far fa-edit"></i>
                                        </button>
                                        <button class="eliminarPre btn btn-danger" data-id="${item.id}" data-nombre="${item.nombre}">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            `);
                        });

                        // Re-inicializa el DataTable después de recargar los datos
                        presentacionTable = $('#presentacionTable').DataTable({
                            "language": {
                                "url": "https://cdn.datatables.net/plug-ins/1.11.4/i18n/es_es.json"
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr);
                        console.log(status);
                        console.log(error);
                    }
                });
            }

            $('#presentacionTable').on('click', '.editarPre', function() {
                var preId = $(this).data('id');

                var URL = "{{ route('datosPre', ['id' => ':id']) }}";
                URL = URL.replace(':id', preId);

                $.ajax({
                    url: URL,
                    type: 'GET',
                    success: function(data) {
                        if (data.success) {
                            $('#preId').val(data.pre.id);
                            $('#edit_nombre_pre').val(data.pre.nombre);
                            $('#editarpresent').modal('show'); // Muestra el modal
                        } else {
                            Swal.fire('Error!', data.message, 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr);
                        console.log(status);
                        console.log(error);
                    }
                });
            });

            $('#formEditarPresent').on('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                const preId = $('#preId').val();

                var URL = "{{ route('editarPre', ['id' => ':id']) }}";
                URL = URL.replace(':id', preId);

                $.ajax({
                    url: URL,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        if (data.success) {
                            Swal.fire('Actualizado!', data.message, 'success');
                            $('#editarpresent').modal('hide');
                            recargarTablapresentacion();
                            $('#formEditarPresent')[0].reset();
                        } else {
                            Swal.fire('Error!', data.message, 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        // Mostrar detalles del error
                        console.error("Error details:");
                        console.error("Status: " + status);
                        console.error("Error: " + error);
                        console.error("Response Text: " + xhr.responseText);
                    }
                });
            });

            $('#presentacionTable').on('click', '.eliminarPre', function() {
                var preId = $(this).data('id');
                var preNombre = $(this).data('nombre');

                var URL = "{{ route('eliminarPre', ['id' => ':id']) }}";
                URL = URL.replace(':id', preId);

                Swal.fire({
                    title: '¿Estás seguro de eliminar esta Presentacion?',
                    text: `Una vez eliminado, no podrá recuperarlo! Tipo: ${preNombre}`,
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
                                if (data.success) {
                                    Swal.fire('Eliminado!', data.message, 'success');
                                    recargarTablapresentacion();
                                } else {
                                    Swal.fire('Error!', data.message, 'error');
                                }
                            },
                            error: function(xhr, status, error) {
                                console.log(xhr);
                                console.log(status);
                                console.log(error);
                            }
                        });
                    }
                });
            });

        });
    </script>

@endsection
