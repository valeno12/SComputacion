@extends('adminlte::page')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Editar Pedido</div>

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

                        <form method="POST" action="{{ route('pedido.updateI', $pedido->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row mb-3">
                                <div class="col-md-6">
                                <label for="cliente">Cliente</label>
                                <select class="form-control" id="search" name="cliente_id" required>
                                    <option value="{{ $pedido->cliente_id }}" selected>{{ $pedido->cliente->nombre }} {{ $pedido->cliente->apellido }} - {{ $pedido->cliente->dni }}</option>
                                </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="equipo">Equipo</label>
                                <input type="text" class="form-control" id="equipo" name="equipo" value="{{ $pedido->equipo }}" required>
                            </div>
                            <div class="form-group">
                                <label for="estado_ingreso">Descripción del problema:</label>
                                <textarea class="form-control" id="estado_ingreso" name="estado_ingreso" rows="3" required>{{ $pedido->estado_ingreso }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <!-- Cargador -->
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="cargador" name="cargador" @if($pedido->cargador) checked @endif>
                                    <label class="form-check-label" for="cargador">
                                        ¿Incluye cargador?
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-primary mt-3">Actualizar Pedido</button>
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
