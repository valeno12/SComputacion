@extends('adminlte::page')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">Agregar Nuevo Producto</div>
                    <div class="card-body">
                        <form action="{{ route('producto.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="nombre">Nombre:</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" >
                            </div>
                            <div class="form-group">
                                <label for="marca">Marca:</label>
                                <input type="text" class="form-control" id="marca" name="marca">
                            </div>
                            <div class="form-group">
                                <label for="proveedor">proveedor:</label>
                                <input type="text" class="form-control" id="proveedor" name="proveedor">
                            </div>
                            <div class="form-group">
                                <label for="precio">Precio:</label>
                                <input type="text" class="form-control" id="precio" name="precio" required>
                            </div>
                            <div class="form-group">
                                <label for="cantidad_disponible">Cantidad Disponible:</label>
                                <input type="number" class="form-control" id="cantidad_disponible" name="cantidad_disponible" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <a href="{{ route('producto.index') }}" class="btn btn-secondary">Cancelar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- jQuery UI Autocomplete -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>

        $(document).ready(function() {
            $("#nombre").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('producto.buscarNombre') }}",
                        dataType: "json",
                        data: {
                            q: request.term
                        },
                        success: function(data) {
                            response(data);
                        }
                    });
                },
                minLength: 1
            });
        });

        $(document).ready(function() {
            $("#marca").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('producto.buscarMarca') }}",
                        dataType: "json",
                        data: {
                            q: request.term
                        },
                        success: function(data) {
                            response(data);
                        }
                    });
                },
                minLength: 1
            });
        });

        $(document).ready(function() {
            $("#proveedor").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('proveedor.buscarNombre') }}",
                        dataType: "json",
                        data: {
                            q: request.term
                        },
                        success: function(data) {
                            response(data);
                        }
                    });
                },
                minLength: 1
            });
        });
    </script>
@endsection
