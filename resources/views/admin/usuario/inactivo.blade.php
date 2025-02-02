@extends('Layouts.pantilla')

@section('title', 'usuario')

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
                    <h1><i class="fas fa-question-circle"></i> Lista de usuarios Inactivos
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
                </div>

                <div class="card-body">
                    <table class="table table-hover" id="usuarios">
                        <thead style="text-align: center">
                            <tr style="text-align: center">
                                <th style="text-align: center">N°</th>
                                <th style="text-align: center">Nombre</th>
                                <th style="text-align: center">Email</th>
                                <th style="text-align: center">Rol</th>
                                <th style="text-align: center">F.Registro</th>
                                <th style="text-align: center">Estado</th>
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
                                    <td style="text-align: center">{{ $us->email }}</td>
                                    <td style="text-align: center">
                                        <span class="badge bg-primary"> {{ $us->tipo->nombre }}</span>
                                    </td>
                                    <td style="text-align: center">

                                        {{ $us->created_at->format('Y-m-d') }}

                                    </td>
                                    <td style="text-align: center"><span class="badge badge-danger">{{ $us->estado }}</span></td>
                                    <td style="text-align: center">
                                        <button type="button" data-id="{{ $us->id }}" class="activar btn btn-sm btn-warning">
                                            <i class="fas fa-user-shield"></i>
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


            $(document).on('click', '.activar', function() {
                var userId = $(this).data('id');

                var URL = "{{ route('activarusaurios', ['id' => ':id']) }}";
                URL = URL.replace(':id', userId);

                Swal.fire({
                    title: '¿Estás seguro de Reactivar este usuario?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, Activar!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: URL,
                            type: 'POST',
                            data:{
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(data) {
                                console.log(data);
                                if (data.success){
                                    Swal.fire(
                                        'Activado!',
                                        data.message,
                                       'success'
                                    );

                                    $('#user-row-'+ userId).remove();
                                }else{
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
