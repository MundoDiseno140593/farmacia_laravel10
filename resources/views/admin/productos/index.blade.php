@extends('Layouts.pantilla')
@section('title', 'Productos')

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
                <div class="col-sm-10">
                    <h4>
                        <i class="fas fa-box-open"> Gestion de Productos</i>
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalCrearProducto">
                            Nuevo Producto
                        </button>
                    </h4>
                </div>
                <div class="col-sm-2">
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
                    <h3 class="card-title">Buscar producto</h3>
                    <div class="input-group">
                        <input type="text" class="form-control" id="busquedaProductos" placeholder="Buscar productos...">
                        <div class="input-group-append">
                            <button class="btn btn-secondary" type="button">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>

                    </div>
                </div>

                <div class="card-body">
                    <div id="productos" class="row d-flex align-items-stretch">

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal crear producto-->
    <div class="modal fade" id="modalCrearProducto">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Crear Producto</h3>
                        <button class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="card-body">
                        <form id="formCrearProducto" method="POST" en>
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="nombre_producto">Nombre:</label>
                                        <input type="text" class="form-control" name="nombre_producto"
                                            id="nombre_producto" placeholder="Ingrese nombre del producto">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="concentracion">Concentracion:</label>
                                        <input type="text" class="form-control" name="concentracion" id="concentracion"
                                            placeholder="Ingrese Concentracion del producto">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="adicional">Adicional:</label>
                                        <input type="text" class="form-control" name="adicional" id="adicional"
                                            placeholder="Ingrese adicional del producto">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="precio">Precio:</label>
                                        <input type="number" class="form-control" value="1" name="precio"
                                            id="precio" placeholder="Ingrese precio del producto">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="laboratorio">Laboratorio:</label>
                                        <select class="form-control select2" name="laboratorio" id="laboratorio"
                                            style="width: 100%;">
                                            <option value="">Seleccione un laboratorio</option>
                                            @foreach ($laboratorios as $laboratorio)
                                                <option value="{{ $laboratorio->id }}">{{ $laboratorio->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="tipo">Tipo:</label>
                                        <select class="form-control select2" name="tipo" id="tipo"
                                            style="width: 100%;">
                                            <option value="">Seleccione un presentacion</option>
                                            @foreach ($tipospr as $tipo)
                                                <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="presentacion">Presentacion:</label>
                                        <select class="form-control select2" name="presentacion" id="presentacion"
                                            style="width: 100%;">
                                            <option value="">Seleccione un presentacion</option>
                                            @foreach ($presentaciones as $presentacion)
                                                <option value="{{ $presentacion->id }}">{{ $presentacion->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info w-100">Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="animate__animated animate__bounceInDown modal fade" id="cambiologo">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header  text-center badge badge-success">
                    <h5 class="modal-title" id="cambiocontra">Cambiar Foto De Producto</h5>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <img id='logoactual' src="../img/producto/" class="profile-user-img img-fluid img-circle">
                    </div>
                    <div class="text-center">
                        <b id="nombre_logo">
                        </b>
                    </div>
                    <form id="form-logo" name="form-logo" enctype="multipart/form-data">
                        @csrf
                        <div class="input-group mb-3 ml-5 mt-2">
                            <input type="file" name="photo" class="input-group">
                            <input type="hidden" name="funcion" id="funcion">
                            <input type="hidden" name="id-logo-prod" id="id-logo-prod">
                        </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn bg-gradient-primary">Guardar</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal editar producto-->
    <div class="modal fade" id="modalEditarProducto">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Editar Producto</h3>
                        <button class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="card-body">
                        <form id="formEditarProducto" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="nombre_producto">Nombre:</label>
                                        <input type="text" class="form-control" name="edit_nombre" id="edit_nombre"
                                            placeholder="Ingrese nombre del producto">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="concentracion">Concentracion:</label>
                                        <input type="text" class="form-control" name="edit_concentracion"
                                            id="edit_concentracion" placeholder="Ingrese Concentracion del producto">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="adicional">Adicional:</label>
                                        <input type="text" class="form-control" name="edit_adicional"
                                            id="edit_adicional" placeholder="Ingrese adicional del producto">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="precio">Precio:</label>
                                        <input type="number" class="form-control" value="1" name="edit_precio"
                                            id="edit_precio" placeholder="Ingrese precio del producto">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="laboratorio">Laboratorio:</label>
                                        <select class="form-control select2" name="edit_laboratorio"
                                            id="edit_laboratorio" style="width: 100%;">
                                            <option value="">Seleccione un laboratorio</option>
                                            @foreach ($laboratorios as $laboratorio)
                                                <option value="{{ $laboratorio->id }}">{{ $laboratorio->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="tipo">Tipo:</label>
                                        <select class="form-control select2" name="edit_tipo" id="edit_tipo"
                                            style="width: 100%;">
                                            <option value="">Seleccione un presentacion</option>
                                            @foreach ($tipospr as $tipo)
                                                <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="presentacion">Presentacion:</label>
                                        <select class="form-control select2" name="edit_presentacion"
                                            id="edit_presentacion" style="width: 100%;">
                                            <option value="">Seleccione un presentacion</option>
                                            @foreach ($presentaciones as $presentacion)
                                                <option value="{{ $presentacion->id }}">{{ $presentacion->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="id_edit_prod" name="id_edit_prod">
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info w-100">Actualizar</button>
                        </form>
                    </div>
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
            var funcion;


            $('#formCrearProducto').on('submit', function(e) {
                // Prevenimos el comportamiento por defecto del formulario (recargar la página)
                e.preventDefault();

                // Creamos un objeto FormData para manejar los datos del formulario, incluidos los archivos.
                const formData = new FormData(this);

                // Asignamos la URL para la creación de productos usando la ruta definida en Laravel.
                var url = "{{ route('crear_productos') }}";

                // Realizamos una solicitud AJAX para enviar los datos al servidor.
                $.ajax({
                    type: "POST", // Método HTTP: POST
                    url: url, // URL del endpoint para crear el producto
                    data: formData, // Los datos del formulario
                    processData: false, // No procesamos los datos (es necesario cuando usamos FormData)
                    contentType: false, // No definimos el tipo de contenido (también por el uso de FormData)
                    success: function(data) {
                        // Si la respuesta es exitosa, mostramos un mensaje usando Toastr
                        if (data.status === 'success') {
                            $('#formCrearProducto').trigger('reset');
                            toastr.success(data.message, 'Producto Creado', {
                                closeButton: true, // Botón para cerrar el mensaje
                                progressBar: true // Barra de progreso
                            });
                            // Llamamos a la función 'buscar_producto' para actualizar la lista de productos
                            buscar_producto();
                            $('#modalCrearProducto').modal('hide');
                        } else {
                            // Si ocurre un error en el servidor, mostramos un mensaje de error
                            toastr.error(data.message, 'Error', {
                                closeButton: true,
                                progressBar: true
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        // Si ocurre un error en la solicitud, mostramos los detalles en consola
                        console.error("Error details:");
                        console.error("Status: " + status);
                        console.error("Error: " + error);
                        console.error("Response Text: " + xhr.responseText);

                        // Si el error es un 400 (Bad Request), mostramos el mensaje específico
                        if (xhr.status === 400) {
                            var response = JSON.parse(xhr.responseText);
                            toastr.error(response.message, 'Error', {
                                closeButton: true,
                                progressBar: true
                            });
                        } else {
                            // Para cualquier otro error, mostramos un mensaje genérico
                            toastr.error('Ocurrió un error al procesar la solicitud', 'Error', {
                                closeButton: true,
                                progressBar: true
                            });
                        }
                    }
                });
            });

            // Llamamos a la función 'buscar_producto' al cargar la página para mostrar todos los productos inicialmente.
            buscar_producto();

            // Función para buscar productos usando la consulta proporcionada
            function buscar_producto(consulta = '') {
                var url = "{{ route('buscar_productos') }}";
                $.ajax({
                    type: "GET", // Método HTTP: GET
                    url: url, // URL del endpoint para buscar productos
                    data: {
                        consulta: consulta
                    }, // Pasamos la consulta de búsqueda al servidor
                    success: function(data) {
                        let template =
                            ''; // Inicializamos una variable para almacenar el HTML de los productos

                        // Iteramos sobre cada producto recibido
                        data.forEach(prod => {
                            // Construimos una tarjeta (card) para cada producto con sus detalles
                            template += `
                                <div prodId="${prod.id}" prodNomb="${prod.nombre}" prodPrecio="${prod.precio}" prodConcent="${prod.concentracion}" prodAdicional="${prod.adicional}" prodLab="${prod.laboratorio_id}" prodTip="${prod.tipo_id}" prodPrese="${prod.presentacion_id}" prodAvatar="${prod.avatar}" class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
                                    <div class="card bg-light d-flex flex-fill">
                                        <div class="card-header text-muted border-bottom-0">
                                            <i class="fas fa-lg fa-cubes mr-1"></i> ${prod.stock}
                                        </div>
                                        <div class="card-body pt-0">
                                            <div class="row">
                                                <div class="col-7">
                                                    <h2 class="lead"><b>${prod.nombre}</b></h2>
                                                    <h4 class="lead"><b><i class="fas fa-lg fa-dollar-sign mr-1"></i>${prod.precio}</b></h4>
                                                    <ul class="ml-4 mb-0 fa-ul text-muted">
                                                        <li class="small"><span class="fa-li  mr-1"><i class="fas fa-lg fa-mortar-pestle"></i></span><b>Concentración:</b> ${prod.concentracion}</li>
                                                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-prescription-bottle-alt"></i></span><b> Adicional:</b>${prod.adicional}</li>
                                                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-flask"></i></span><b>Laboratorio:</b>${prod.laboratorio}</li>
                                                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-copyright"></i></span><b>Tipo:</b>${prod.tipo}</li>
                                                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-pills"></i></span><b>Presentación:</b>${prod.presentacion}</li>
                                                    </ul>
                                                </div>
                                                <div class="col-5 text-center">
                                                    <img src="${prod.avatar}" alt="user-avatar" class="img-circle img-fluid">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <div class="text-right">
                                                <button class="avatar btn btn-sm bg-teal" type="button" data-toggle="modal" data-target="#cambiologo">
                                                    <i class="fas fa-image"></i>
                                                </button>
                                                <button class="editar-prod btn btn-sm btn-success" type="button" data-bs-toggle="modal" data-bs-target="#modalEditarProducto">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </button>
                                                <button class="borrar btn btn-sm btn-danger">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                        });

                        // Insertamos el HTML generado en el contenedor con id 'productos'
                        $('#productos').html(template);
                    },
                    error: function(xhr, status, error) {
                        // Si ocurre un error, mostramos los detalles en consola
                        console.error("Error details:");
                        console.error("Status: " + status);
                        console.error("Error: " + error);
                        console.error("Response Text: " + xhr.responseText);
                    }
                });
            }

            // Al escribir en el campo de búsqueda, llamamos a la función 'buscar_producto' para filtrar los productos
            $(document).on('keyup', '#busquedaProductos', function() {
                let valor = $(this).val(); // Obtenemos el valor del campo de búsqueda
                if (valor != '') {
                    buscar_producto(valor); // Si hay un valor, buscamos productos que coincidan
                } else {
                    buscar_producto(); // Si no hay valor, mostramos todos los productos
                }
            });


            $(document).on('click', '.avatar', (e) => {
                funcion = "cambiar_avatar";
                const elemento = $(this)[0].activeElement.parentElement.parentElement.parentElement
                    .parentElement;

                const id = $(elemento).attr('prodId');
                const nombre = $(elemento).attr('prodNomb');
                const avatar = $(elemento).attr('prodAvatar');
                $('#logoactual').attr('src', avatar);
                $('#nombre_logo').html(nombre);
                $('#funcion').val(funcion);
                $('#id-logo-prod').val(id);

            });


            $('#form-logo').submit(e => {
                e.preventDefault(); // Evitar que el formulario se envíe normalmente
                let formData = new FormData($('#form-logo')[0]);
                var url = "{{ route('cambiar_avatar') }}";

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    dataType: 'json', // Asegúrate de que la respuesta se interprete como JSON
                    success: function(response) {
                        if (response.alert == 'edit') {
                            $('#logoactual').attr('src', response.ruta);
                            $('#form-logo').trigger('reset');
                            toastr.success('¡Avatar actualizado correctamente!');
                            buscar_producto();

                            // Retraso antes de cerrar el modal
                            setTimeout(function() {
                                $('#cambiologo').modal('hide');
                            }, 500); // 500 ms de retraso
                        } else if (response.alert == 'error') {
                            toastr.error('Ocurrió un error al actualizar el avatar.');
                            $('#form-logo').trigger('reset');
                        }
                    },
                    error: function(xhr, status, error) {
                        // Si ocurre un error, mostramos los detalles en consola
                        console.error("Error details:");
                        console.error("Status: " + status);
                        console.error("Error: " + error);
                        console.error("Response Text: " + xhr.responseText);

                        // Si el error es de validación (Laravel devuelve un JSON)
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            // Recorremos los errores y los mostramos con Toastr
                            $.each(xhr.responseJSON.errors, function(field, messages) {
                                // Mostramos el primer error de cada campo en un toastr
                                toastr.error(messages[0]);
                            });
                        } else {
                            // Si no es un error de validación, mostramos un mensaje genérico
                            toastr.error(
                                'Error en la solicitud. Por favor, inténtelo nuevamente.');
                        }
                    }
                });
            });

            $(document).on('click', '.editar-prod', (e) => {
                const elemento = $(this)[0].activeElement.parentElement.parentElement.parentElement
                    .parentElement;
                const id = $(elemento).attr('prodId');
                const nombre = $(elemento).attr('prodNomb');
                const concentracion = $(elemento).attr('prodConcent');
                const adicional = $(elemento).attr('prodAdicional');
                const precio = $(elemento).attr('prodPrecio');
                const laboratorio = $(elemento).attr('prodLab');
                const tipo = $(elemento).attr('prodTip');
                const presentacion = $(elemento).attr('prodPrese');

                $('#id_edit_prod').val(id);
                $('#edit_nombre').val(nombre);
                $('#edit_concentracion').val(concentracion);
                $('#edit_adicional').val(adicional);
                $('#edit_precio').val(precio);
                $('#edit_laboratorio').val(laboratorio).trigger('change');
                $('#edit_tipo').val(tipo).trigger('change');
                $('#edit_presentacion').val(presentacion).trigger('change');
            });

            $('#formEditarProducto').on('submit', function(e) {
                // Prevenimos el comportamiento por defecto del formulario (recargar la página)
                e.preventDefault();

                // Creamos un objeto FormData para manejar los datos del formulario, incluidos los archivos.
                const formData = new FormData(this);

                // Asignamos la URL para la creación de productos usando la ruta definida en Laravel.
                var url = "{{ route('editar_productos') }}";

                // Realizamos una solicitud AJAX para enviar los datos al servidor.
                $.ajax({
                    type: "POST", // Método HTTP: POST
                    url: url, // URL del endpoint para crear el producto
                    data: formData, // Los datos del formulario
                    processData: false, // No procesamos los datos (es necesario cuando usamos FormData)
                    contentType: false, // No definimos el tipo de contenido (también por el uso de FormData)
                    success: function(data) {
                        // Si la respuesta es exitosa, mostramos un mensaje usando Toastr
                        if (data.status === 'success') {
                            toastr.success(data.message, 'Producto Actualizado', {
                                closeButton: true, // Botón para cerrar el mensaje
                                progressBar: true // Barra de progreso
                            });
                            // Llamamos a la función 'buscar_producto' para actualizar la lista de productos
                            buscar_producto();
                            $('#modalEditarProducto').modal('hide');
                        } else {
                            // Si ocurre un error en el servidor, mostramos un mensaje de error
                            toastr.error(data.message, 'Error', {
                                closeButton: true,
                                progressBar: true
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        // Si ocurre un error en la solicitud, mostramos los detalles en consola
                        console.error("Error details:");
                        console.error("Status: " + status);
                        console.error("Error: " + error);
                        console.error("Response Text: " + xhr.responseText);

                        // Si el error es un 400 (Bad Request), mostramos el mensaje específico
                        if (xhr.status === 400) {
                            var response = JSON.parse(xhr.responseText);
                            toastr.error(response.message, 'Error', {
                                closeButton: true,
                                progressBar: true
                            });
                        } else {
                            // Para cualquier otro error, mostramos un mensaje genérico
                            toastr.error('Ocurrió un error al procesar la solicitud', 'Error', {
                                closeButton: true,
                                progressBar: true
                            });
                        }
                    }
                });
            });

            $(document).on('click', '.borrar', function(e) {
                // Función para borrar
                const elemento = $(this).closest('[prodId]'); // Selecciona el elemento con atributos personalizados
                const id = elemento.attr('prodId');
                const nombre = elemento.attr('prodNomb');
                const avatar = elemento.attr('ProdAvatar');

                var URL = "{{ route('eliminar_producto', ['id' => ':id']) }}";
                URL = URL.replace(':id', id);

                // Configuración de SweetAlert
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger mr-1'
                    },
                    buttonsStyling: false
                });

                // Confirmación de eliminación
                swalWithBootstrapButtons.fire({
                    title: 'Desea Eliminar ' + nombre + '?',
                    text: "No Podrás Revertir Esto!",
                    imageUrl: avatar,
                    imageWidth: 100,
                    imageHeight: 100,
                    showCancelButton: true,
                    confirmButtonText: 'Sí, borrar esto!',
                    cancelButtonText: 'No, cancelar!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Enviar solicitud AJAX para eliminar
                        $.ajax({
                            url: URL,
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}" // Token CSRF para Laravel
                            },
                            success: function(response) {
                                console.log(response);
                                if (response === 'borrado') {
                                    swalWithBootstrapButtons.fire(
                                        '¡Borrado!',
                                        `El producto ${nombre} fue marcado como inactivo.`,
                                        'success'
                                    );
                                    buscar_producto(); // Actualizar la lista
                                } else {
                                    swalWithBootstrapButtons.fire(
                                        '¡No se pudo borrar!',
                                        `El producto ${nombre} tiene lotes activos.`,
                                        'error'
                                    );
                                }
                            },
                            error: function() {
                                swalWithBootstrapButtons.fire(
                                    '¡Error!',
                                    'Ocurrió un problema al intentar borrar el producto.',
                                    'error'
                                );
                            }
                        });
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        swalWithBootstrapButtons.fire(
                            'Cancelado',
                            'El Producto ' + nombre + ' no fue borrado.',
                            'error'
                        );
                    }
                });
            });




        });
    </script>



@endsection
