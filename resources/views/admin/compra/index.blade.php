@extends('Layouts.pantilla')
@section('title', 'Compra')
@section('css')
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/v/dt/dt-2.1.3/datatables.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet" />

    <style>
        .modal-fullscreen {
            width: 100vw !important;
            height: 100vh !important;
            margin: 0 !important;
            padding: 0 !important;
            max-width: 100% !important;
        }
    </style>
@endsection

@section('contenido')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3>
                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#crearCompra">
                            <i class="fas fa-shopping-cart"> Gestion Compras</i>
                        </button>
                    </h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="">Home</a></li>
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
                    <h3 class="card-title">Lista Lotes</h3>
                </div>

                <div class="card-body table-responsive">
                    <table id="listarcompras" class="table table-dark table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th style="text-align:center">ID | Codigo</th>
                                <th style="text-align:center">Fecha De Compra</th>
                                <th style="text-align:center">Fecha De Entrega</th>
                                <th style="text-align:center">Total</th>
                                <th style="text-align:center">Estado</th>
                                <th style="text-align:center">Proveedor</th>
                                <th style="text-align:center">Operaciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $contador = 1;
                            @endphp
                            @foreach ($compras as $compra)
                                <tr>
                                    <td>{{ $contador++ }}</td>
                                    <td style="text-align:center">{{ $compra->codigo }}</td>
                                    <td style="text-align:center">{{ $compra->fecha_compra }}</td>
                                    <td style="text-align:center">{{ $compra->fecha_entrega }}</td>
                                    <td style="text-align:center">{{ $compra->total }}</td>
                                    <td style="text-align:center">
                                        @if ($compra->estado == 'Cancelado')
                                            <span class="badge bg-warning">{{ $compra->estado }}</span>
                                        @else
                                            <span class="badge bg-danger">{{ $compra->estado }}</span>
                                        @endif
                                    </td>

                                    <td style="text-align:center">{{ $compra->proveedor }}</td>
                                    <td style="text-align:center">
                                        <button class="imprimir btn btn-secondary" data-id="{{ $compra->id }}"><i
                                                class="fas fa-print"></i>
                                        </button>

                                        <button class="ver  btn btn-primary" data-id="{{ $compra->id }}" type="button"
                                            data-toggle="modal" data-bs-target="#vistacompra"><i class="fas fa-eye"></i>
                                        </button>

                                        <button class="editar btn btn-info" type="button" data-id="{{ $compra->id }}"
                                            data-bs-toggle="modal" data-bs-target="#cambiarestado"><i
                                                class="fas fa-pencil-alt"></i>
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

    <!-- Modal crear compra -->
    <div class="modal fade" id="crearCompra">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header badge badge-success">
                    <h5 class="modal-title" id="exampleModalLabel">Crear Compra</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body row">
                    <div class="card col-sm-3 p-3">
                        <div class="alert alert-danger text-center" id="noadd-compra" style='display:none;'>
                            <span id='error-compra'><i class="fas fa-times m-1"></i>no se agrego</span>
                        </div>
                        <form id="form-crear-compra" method="POST">
                            @csrf
                            <div class="form-group ">
                                <label for="codigo">Codigo: </label>
                                <input id="codigo" name="codigo" type="text" class="form-control"
                                    placeholder="Ingrese codigo" required>
                            </div>
                            <div class="form-group">
                                <label for="fecha_compra">Fecha de compra: </label>
                                <input id="fecha_compra" name="fecha_compra " type="date" class="form-control"
                                    placeholder="Ingrese fecha de compra" required>
                            </div>
                            <div class="form-group">
                                <label for="fecha_entrega">Fecha de entrega: </label>
                                <input id="fecha_entrega" name="fecha_entrega" type="date" class="form-control"
                                    placeholder="Ingrese fecha de entrega" required>
                            </div>
                            <div class="form-group">
                                <label for="total">Total</label>
                                <input id="total" name="total" type="number" step="any" class="form-control"
                                    value='1' placeholder="Ingrese total" required>
                            </div>
                            <div class="form-group">
                                <label for="estado">Estado de pago</label>
                                <select id="estado" class="form-control select2" style="width:100%"></select>
                            </div>
                            <div class="form-group">
                                <label for="proveedor">Proveedor</label>
                                <select id="proveedor" name="proveedor" class="form-control select2"
                                    style="width:100%"></select>
                            </div>
                        </form>
                    </div>

                    <div class="card col-sm-9 p-3">
                        <div class="card p-3">
                            <div class="alert alert-success text-center" id="add-prod" style='display:none;'>
                                <span><i class="fas fa-check m-1"></i>Se agrego correctamente</span>
                            </div>
                            <div class="alert alert-danger text-center" id="noadd-prod" style='display:none;'>
                                <span id='error'><i class="fas fa-times m-1"></i>no se agrego</span>
                            </div>
                            <div class="form-group">
                                <label for="producto">Producto</label>
                                <select id="producto" class="form-control  select2" style="width:100%"></select>
                            </div>
                            <div class="form-group">
                                <label for="codigo_lote">Codigo</label>
                                <input id="codigo_lote" type="text" class="form-control"
                                    placeholder="Ingrese codigo de lote" required>
                            </div>
                            <div class="form-group">
                                <label for="cantidad">Cantidad</label>
                                <input id="cantidad" type="number" class="form-control" value='1'
                                    placeholder="Ingrese cantidad" required>
                            </div>
                            <div class="form-group ">
                                <label for="vencimiento">Vencimiento: </label>
                                <input id="vencimiento" type="date" class="form-control"
                                    placeholder="Ingrese vencimiento" required>
                            </div>
                            <div class="form-group">
                                <label for="precio_compra">Precio de compra</label>
                                <input id="precio_compra" type="number" step="any" class="form-control"
                                    value='1' placeholder="Ingrese precio de compra" required>
                            </div>
                            <div class="form-group text-right">
                                <button class="agregar-producto btn bg-gradient-info ml-2 w-100">Agregar</button>
                            </div>
                        </div>
                    </div>

                    <div class="card p-3 table-responsive">
                        <table class="table table-hover text-nowrap">
                            <thead class='table-success'>
                                <tr>
                                    <th>Producto</th>
                                    <th>Codigo</th>
                                    <th>Cantidad</th>
                                    <th>Vencimiento</th>
                                    <th>Precio de compra</th>
                                    <th>Operacion</th>
                                </tr>
                            </thead>
                            <tbody id="registros_compra" class='table-active'>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="crear-compra btn bg-gradient-success text-center w-100">Crear compra</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal ver datos  -->
    <div class="modal fade" id="vistacompra">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header badge badge-warning">
                    <h5 class="modal-title" id="exampleModalLabel">Detalle Compra</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <div class="row">
                            <!-- Card para los detalles de la compra (4 columnas) -->
                            <div class="col-md-3">
                                <div class="card">
                                    <div class="card-header bg-success text-white">
                                        <h6 class="mb-0">Detalles de la Compra</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="codigo_compra">Cod Compra:</label>
                                            <span id="codigo_compra"></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="fecha_compra">Fecha Compra:</label>
                                            <span id="fecha_compra1"></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="fecha_entrega">Fecha Entrega:</label>
                                            <span id="fecha_entrega1"></span>
                                        </div>
                                        <div class="form-group">
                                            <label class="badge badge-success" for="estado">Estado:</label>
                                            <span id="estado1"></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="proveedor">Proveedor:</label>
                                            <span id="proveedor1"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card para la tabla de detalles (8 columnas) -->
                            <div class="col-md-9">
                                <div class="card">
                                    <div class="card-header bg-success text-white">
                                        <h6 class="mb-0">Detalles de Productos</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover text-nowrap">
                                                <thead class="table-success">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Código</th>
                                                        <th>Cantidad</th>
                                                        <th>Vencimiento</th>
                                                        <th>Precio Compra</th>
                                                        <th>Producto</th>
                                                        <th>Laboratorio</th>
                                                        <th>Presentación</th>
                                                        <th>Tipo</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="table-warning" id="detalles">
                                                    <!-- Los datos se llenarán aquí dinámicamente -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Total (colocado correctamente debajo de la tabla) -->
                        <div class="row mt-3">
                            <div class="col-md-12 text-end">
                                <h3 class="d-inline">Total: </h3>
                                <h3 class="d-inline" id="total1"></h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal cambiar  estado -->
    <div class="modal fade" id="cambiarestado">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header badge badge-success">
                    <h5 class="modal-title" id="exampleModalLabel">Cambiar Estado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="estado">Seleccionar Estado:</label>
                            <select class="form-control" id="estado_edit" name="estado_edit" style="width: 100%">
                                <option value="0">Seleccionar</option>
                                @foreach ($estado as $item)
                                    <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary w-100">Actualizar estado</button>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#estado').select2();
            $('#estado_edit').select2();
            $('#producto').select2()
            $('#proveedor').select2()
            $('#listarcompras').DataTable();
            // Definir la variable 'prods' en el ámbito global
            let prods = [];

            rellenar_productos();
            rellenar_estado_pago();
            rellenar_proveedores();

            // Función que se encarga de rellenar el select con los productos
            function rellenar_productos() {
                // Se obtiene la URL de la ruta 'llenar_producto' definida en Laravel.
                var url = "{{ route('llenar_producto') }}";

                // Realizamos una solicitud AJAX al servidor
                $.ajax({
                    // El tipo de solicitud es 'GET'
                    type: 'GET',

                    // La URL donde se realizará la solicitud (ruta 'llenar_producto')
                    url: url,

                    // Si la solicitud es exitosa, se ejecuta esta función
                    success: function(data) {
                        // Los datos recibidos son almacenados en la variable 'productos'
                        let productos = data;

                        // Se muestra la lista de productos en la consola del navegador
                        {{--  console.log(productos);  --}}

                        // Se inicializa una variable para almacenar el contenido HTML del select
                        let template = '';

                        // Se recorre la lista de productos y se agrega una opción en el select por cada producto
                        productos.forEach(producto => {
                            // Aquí se crea una opción para el select con el nombre del producto
                            template += `
                                <option value="${producto.nombre}">${producto.nombre}</option>
                                `;
                        });

                        // Se establece el contenido del select con el id 'producto' al HTML generado
                        $('#producto').html(template);
                    },

                    // Si ocurre un error durante la solicitud, se ejecuta esta función
                    error: function(xhr, status, error) {
                        // Se muestra el mensaje de error en la consola
                        console.log(xhr.responseText);
                    }
                });
            }


            // Función que se encarga de rellenar el select con los estados de pago usando AJAX con GET
            function rellenar_estado_pago() {
                // Definimos la ruta que vamos a llamar en el controlador de Laravel
                var url = "{{ route('rellenar_estados') }}"; // Utilizando la ruta definida en Laravel

                // Usamos $.ajax() para hacer la petición con método GET
                $.ajax({
                    type: 'GET', // Método GET para obtener los datos
                    url: url, // URL del controlador
                    success: function(response) {
                        // Se recibe la respuesta en formato JSON
                        let estados =
                            response; // Ya no es necesario hacer JSON.parse, Laravel automáticamente convierte a JSON

                        // Se inicializa una variable para almacenar el contenido HTML del select
                        let template = '';

                        // Recorremos los estados recibidos y generamos una opción para cada uno
                        estados.forEach(estado => {
                            template += `
                                <option value="${estado.id}">${estado.nombre}</option>
                                `;
                        });

                        // Se actualiza el select con el id 'estado' con las opciones generadas
                        $('#estado').html(template);
                    },
                    error: function(xhr, status, error) {
                        // Si ocurre un error, se muestra en la consola
                        console.log(xhr.responseText);
                    }
                });
            }


            // Función que se encarga de rellenar el select con los proveedores usando AJAX con GET
            function rellenar_proveedores() {
                // Definimos la ruta que vamos a llamar en el controlador de Laravel
                var url = "{{ route('rellenar_proveedores') }}"; // Utilizando la ruta definida en Laravel

                // Usamos $.ajax() para hacer la petición con método GET
                $.ajax({
                    type: 'GET', // Método GET para obtener los datos
                    url: url, // URL del controlador
                    success: function(response) {
                        console.log(response);
                        // Se recibe la respuesta en formato JSON
                        let proveedores =
                            response; // No es necesario hacer JSON.parse, Laravel convierte automáticamente a JSON

                        // Se inicializa una variable para almacenar el contenido HTML del select
                        let template = '';

                        // Recorremos los proveedores recibidos y generamos una opción para cada uno
                        proveedores.forEach(proveedor => {
                            template += `
                        <option value="${proveedor.id}">${proveedor.nombre}</option>
                        `;
                        });

                        // Se actualiza el select con el id 'proveedor' con las opciones generadas
                        $('#proveedor').html(template);
                    },
                    error: function(xhr, status, error) {
                        // Si ocurre un error, se muestra en la consola
                        console.log(xhr.responseText);
                    }
                });
            }




            $(document).on('click', '.agregar-producto', (e) => {
                // Asignar las variables de los campos del formulario
                let productoSeleccionado = $('#producto').val();
                let loteCodigo = $('#codigo_lote').val();
                let cantidadProducto = $('#cantidad').val();
                let fechaVencimiento = $('#vencimiento').val();
                let precioUnitario = $('#precio_compra').val();

                // Validación de campos
                if (!productoSeleccionado) {
                    mostrarError('¡Elija un Producto!');
                } else if (!loteCodigo) {
                    mostrarError('¡Ingrese un Código de Lote!');
                } else if (!cantidadProducto) {
                    mostrarError('¡Ingrese una Cantidad!');
                } else if (!fechaVencimiento) {
                    mostrarError('¡Ingrese una Fecha de Vencimiento!');
                } else if (!precioUnitario) {
                    mostrarError('¡Ingrese un Precio de Compra!');
                } else {
                    // Procesar los datos
                    let productoArray = productoSeleccionado.split(' | ');
                    let nuevoProducto = {
                        id: productoArray[0],
                        nombre: productoSeleccionado,
                        codigo: loteCodigo,
                        cantidad: cantidadProducto,
                        vencimiento: fechaVencimiento,
                        precioCompra: precioUnitario
                    };

                    // Agregar producto al array de productos
                    prods.push(nuevoProducto);

                    // Crear la fila para agregar al listado de productos
                    let filaProducto = `
                        <tr prodId="${nuevoProducto.id}">
                            <td>${nuevoProducto.nombre}</td>
                            <td>${nuevoProducto.codigo}</td>
                            <td>${nuevoProducto.cantidad}</td>
                            <td>${nuevoProducto.vencimiento}</td>
                            <td>${nuevoProducto.precioCompra}</td>
                            <td><button class="borrar-producto btn btn-danger"><i class="fas fa-times-circle"></i></button></td>
                        </tr>
                    `;

                    // Agregar la fila a la tabla de registros de compra
                    $('#registros_compra').append(filaProducto);

                    // Mostrar mensaje de éxito y ocultar el formulario
                    $('#add-prod').hide('slow').show(1000).hide(2000);

                    // Limpiar los campos del formulario
                    $('#producto').val('').trigger('change');
                    $('#codigo_lote').val('');
                    $('#cantidad').val('');
                    $('#vencimiento').val('');
                    $('#precio_compra').val('');
                }
            });

            // Función para mostrar mensajes de error
            function mostrarError(mensaje) {
                $('#error').text(mensaje);
                $('#noadd-prod').hide('slow').show(1000).hide(2000);
            }


            $(document).on('click', '.borrar-producto', function(e) {
                // Obtener el elemento del producto que se va a eliminar
                let elemento = $(this).closest(
                    'tr'); // Usamos closest para obtener el 'tr' que contiene el botón
                let id = elemento.attr('prodId'); // Obtener el 'prodId' del 'tr' del producto

                // Buscar el producto en el array 'prods' y eliminarlo
                prods.forEach(function(prod, index) {
                    if (prod.id == id) {
                        prods.splice(index, 1); // Eliminar el producto del array
                    }
                });

                // Eliminar el producto de la tabla
                elemento.remove();
            });


            $(document).on('click', '.crear-compra', (e) => {
                let codigo = $('#codigo').val();
                let fecha_compra = $('#fecha_compra').val();
                let fecha_entrega = $('#fecha_entrega').val();
                let total = $('#total').val();
                let estado = $('#estado').val();
                let proveedor = $('#proveedor').val();

                // Validaciones
                let validaciones = [{
                        field: codigo,
                        message: 'Ingrese Un Codigo!'
                    },
                    {
                        field: fecha_compra,
                        message: 'Ingrese Una Fecha De Compra!'
                    },
                    {
                        field: fecha_entrega,
                        message: 'Ingrese Una Fecha De Entrega!'
                    },
                    {
                        field: total,
                        message: 'Ingrese Un Total!'
                    },
                    {
                        field: estado,
                        message: 'Seleccione Un Estado!',
                        isNull: true
                    },
                    {
                        field: proveedor,
                        message: 'Seleccione Un Proveedor!',
                        isNull: true
                    },
                    {
                        field: prods.length === 0,
                        message: 'No Hay Productos Agregados!',
                        isLength: true
                    }
                ];

                // Validación de los campos
                for (let i = 0; i < validaciones.length; i++) {
                    let condition = validaciones[i];

                    // Validar si el campo está vacío o es nulo
                    if ((condition.isNull && condition.field == null) ||
                        (condition.isLength && condition.field) ||
                        (!condition.isNull && !condition.isLength && condition.field == '')) {

                        $('#error-compra').text(condition.message);
                        $('#noadd-compra').hide('slow').show(1000).hide(2000);
                        return; // Si hay error, detener el proceso
                    }
                }

                // Preparar los datos para enviar al servidor
                let descripcion = {
                    codigo: codigo,
                    fecha_compra: fecha_compra,
                    fecha_entrega: fecha_entrega,
                    total: total,
                    estado: estado,
                    proveedor: proveedor
                };

                let productosString = JSON.stringify(prods);
                let descripcionString = JSON.stringify(descripcion);

                var url = "{{ route('crear_compra') }}";

                // Realizamos la petición AJAX
                $.ajax({
                    url: url, // La URL de tu controlador
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                            'content') // Incluir el token CSRF
                    },
                    data: {
                        productosString: productosString,
                        descripcionString: descripcionString
                    },
                    success: (response) => {
                        if (response == 'add') {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Se Realizo La Compra',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function() {
                                // Recargar la página actual para reflejar los cambios
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Error En El Sistema!',
                            });
                        }
                    },
                    error: (xhr, status, error) => {
                        console.error('Error en la solicitud AJAX:');
                        console.error('XHR:', xhr); // Objeto XHR completo
                        console.error('Estado:',
                            status); // Estado de la solicitud (ej. "timeout", "error", etc.)
                        console.error('Error:',
                            error); // Error de la solicitud (mensaje de error)
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Error al realizar la solicitud: ' + error,
                        });
                    }
                });
            });

            // Ver una compra con detalles
            $('#listarcompras').on('click', '.ver', function() {
                var id = $(this).data('id'); // Obtener el id de la compra

                // Definir la URL para la solicitud AJAX
                var url = "{{ route('extraer_lote_compra', ['id' => ':id']) }}";
                url = url.replace(':id', id); // Reemplazar el marcador con el id

                $.ajax({
                    url: url, // Cambia esto con la ruta de tu controlador en Laravel
                    type: 'GET',
                    success: function(response) {
                        console.log(response)
                        if (response.success) {
                            // Mostrar los detalles de la compra en los elementos correspondientes
                            $('#codigo_compra').text(response.compra.codigo);
                            $('#fecha_compra1').text(response.compra.fecha_compra);
                            $('#fecha_entrega1').text(response.compra.fecha_entrega);
                            $('#estado1').text(response.compra.estado);
                            $('#proveedor1').text(response.compra.proveedor);
                            $('#total1').text(response.compra.total);

                            // Limpiar los detalles de los lotes antes de agregar nuevos
                            $('#detalles').empty();

                            // Recorrer los lotes y agregar la información al modal
                            $.each(response.lotes, function(index, lote) {
                                var tr = $('<tr></tr>');

                                tr.append('<td>' + (index + 1) + '</td>');
                                tr.append('<td>' + lote.codigo + '</td>');
                                tr.append('<td>' + lote.cantidad + '</td>');
                                tr.append('<td>' + lote.vencimiento + '</td>');
                                tr.append('<td>' + lote.precio_compra + '</td>');
                                tr.append('<td>' + lote.producto + '</td>');
                                tr.append('<td>' + lote.laboratorio.nombre +
                                    '</td>'); // Nombre del laboratorio
                                tr.append('<td>' + lote.presentacion.nombre +
                                    '</td>'); // Nombre de la presentación
                                tr.append('<td>' + lote.tipo.nombre +
                                    '</td>'); // Nombre del tipo

                                // Agregar la fila al cuerpo de la tabla
                                $('#detalles').append(tr);
                            });

                            // Mostrar el modal
                            $('#vistacompra').modal('show');
                        } else {
                            Swal.fire('Error', 'No se encontraron los detalles de la compra',
                                'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Error al realizar la solicitud: ' + error,
                        });
                    }
                });
            });


            $('#listarcompras').on('click', '.editar', function() {
                var id = $(this).data('id');

                var url = "{{ route('extraer_estados', ['id' => ':id']) }}";
                url = url.replace(':id', id);

                // Petición AJAX a Laravel para obtener los datos de la compra
                $.ajax({
                    url: url, // Ruta para obtener los datos
                    type: 'GET',
                    success: function(response) {
                        console.log(response)
                        if (response.success) {
                            $('#estado_edit').val(response.estado)
                        .change(); // Mostrar estado en el modal
                        } else {
                            alert('Error al obtener la información');
                        }
                    },
                    error: function() {
                        alert('Error en la conexión con el servidor');
                    }
                });

            });

        });
    </script>


@endsection
