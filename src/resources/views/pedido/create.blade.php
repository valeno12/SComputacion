@extends('adminlte::page')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Crear Nuevo Pedido</div>

                    <div class="card-body">
                        <!-- Mostrar errores de validación -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('pedido.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <!-- Cliente  -->
                                    <label for="cliente">Cliente</label>
                                    <select class="form-control" id="search" name="cliente_id" required></select>
                                    <!-- Botón para agregar nuevo cliente -->
                                    <button type="button" class="btn btn-primary mt-2" data-toggle="modal" data-target="#modalAgregarCliente">
                                        Agregar Cliente
                                    </button>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="equipo">Equipo</label>
                                <input type="text" class="form-control" id="equipo" name="equipo" required>
                            </div>
                            <div class="form-group">
                                <label for="estado_ingreso">Descripción del problema:</label>
                                <textarea class="form-control" id="estado_ingreso" name="estado_ingreso" rows="3" required></textarea>
                            </div>
                            <div class="col-md-6">
                                <!-- Cargador -->
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="cargador" name="cargador">
                                    <label class="form-check-label" for="cargador">
                                        ¿Incluye cargador?
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-primary mt-3">Crear Pedido</button>
                                        <a href="{{ route('pedido.index') }}" class="btn btn-secondary mt-3">Cancelar</a>
                                    </div>
                                    <div class="col-md-6">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para agregar nuevo cliente -->
    <div class="modal fade" id="modalAgregarCliente" tabindex="-1" role="dialog" aria-labelledby="modalAgregarClienteLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAgregarClienteLabel">Agregar Nuevo Cliente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Formulario para agregar un nuevo cliente -->
                    <form action="{{ route('cliente.store') }}" method="POST" id="formNuevoCliente">
                        @csrf
                        <div class="form-group">
                            <label for="dni">DNI:</label>
                            <input type="text" class="form-control" id="dni" name="dni" required>
                        </div>
                        <div class="form-group">
                            <label for="nombre">Nombre:</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="apellido">Apellido:</label>
                            <input type="text" class="form-control" id="apellido" name="apellido" required>
                        </div>
                        <div class="form-group">
                            <label for="direccion">Domicilio:</label>
                            <input type="text" class="form-control" id="direccion" name="direccion" required>
                        </div>
                        <div class="form-group">
                            <label for="telefono">Teléfono:</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" required>
                        </div>
                        <div class="form-group">
                            <label for="mail">Correo Electrónico:</label>
                            <input type="email" class="form-control" id="mail" name="mail" >
                        </div>
                        <!-- Otros campos del formulario -->
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="guardarCliente">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Script para enviar los datos del nuevo cliente al servidor -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Manejo del evento click en el botón "Guardar"
            document.getElementById('guardarCliente').addEventListener('click', function() {
                // Envía los datos del formulario al servidor usando AJAX
                $.ajax({
                    url: '{{ route("cliente.store") }}', // URL del endpoint para guardar un nuevo cliente
                    method: 'POST',
                    data: $('#formNuevoCliente').serialize(), // Datos del formulario serializados
                    success: function(response) {
                        // Maneja la respuesta del servidor (puedes actualizar la lista de clientes, etc.)
                        console.log(response);
                        // Cierra el modal después de guardar el cliente
                        $('#modalAgregarCliente').modal('hide');
                    },
                    error: function(error) {
                        console.error('Error al guardar el cliente:', error);
                    }
                });
            });
        });
    </script>

@endsection

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"/>
    <style>
        /* Estilos para el campo de selección de clientes */
        #search {
            width: 100%; /* Ocupa todo el ancho del contenedor */
            height: 38px; /* Altura deseada */
            font-size: 14px; /* Tamaño de fuente deseado */
            color: #495057; /* Color de texto deseado */
            border: 1px solid #ced4da; /* Borde del campo */
            border-radius: .25rem; /* Borde redondeado */
            background-color: #fff; /* Color de fondo deseado */
            padding: .375rem .75rem; /* Espaciado interno */
        }

        /* Estilos para el campo de selección cuando está enfocado */
        #search:focus {
            border-color: #80bdff; /* Color de borde deseado cuando está enfocado */
        }

        /* Estilos adicionales para otros elementos */
        .select2-container--default .select2-selection--single {
            height: 38px; /* Altura deseada */
            font-size: 14px; /* Tamaño de fuente deseado */
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #495057; /* Color de texto deseado */
            border-color: #ced4da; /* Color de borde deseado */
            background-color: #fff; /* Color de fondo deseado */
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            background-color: #fff; /* Color de fondo deseado */
        }

        .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: #80bdff; /* Color de borde deseado cuando está enfocado */
        }

        .select2-container--default .select2-results__option--highlighted {
            background-color: #cce5ff; /* Color de fondo del elemento seleccionado en el menú desplegable */
        }
    </style>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        var path = "{{ route('pedido.clientesobtener') }}";

        $('#search').select2({
            placeholder: 'Seleccionar usuario',
            ajax: {
                url: path,
                dataType: 'json',
                delay: 250,
                processResults: function (clientes) {
                    return {
                        results:  $.map(clientes, function (item) {
                            return {
                                text: item.nombre + ' ' + item.apellido + ' - ' + item.dni,
                                id: item.id
                            }
                        })
                    };
                },
                cache: true
            }
        });
    </script>
@endsection
