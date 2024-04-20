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

                        <form id="pedidoForm" method="POST" action="{{ route('pedido.updateF', $pedido->id) }}">
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
                                <label for="componente_problematico">Componente Problemático:</label>
                                <input type="text" class="form-control" id="componente_problematico" name="componente_problematico" value="{{ $pedido->componente_problematico }}" >
                            </div>

                            <div class="form-group">
                                <label for="trabajo_realizar">Trabajo a Realizar:</label>
                                <textarea class="form-control" id="trabajo_realizar" name="trabajo_realizar" rows="3" required>{{ $pedido->trabajo_realizar }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="costo_mano_obra">Costo de Mano de Obra:</label>
                                <input type="number" class="form-control" id="costo_mano_obra" name="costo_mano_obra" value="{{ $pedido->costo_mano_obra }}"required>
                            </div>

                            <!-- Lista de Productos Seleccionados -->
                            <div id="productos_seleccionados" class="mt-3">
                                <h5>Productos Seleccionados:</h5>
                                <ul class="list-group" id="lista_productos">
                                    <!-- Aquí se añadirán dinámicamente los productos seleccionados -->
                                </ul>
                            </div>

                            <div>
                                @foreach($productosPedido as $productoPedido)
                                    <div class="producto-container">
                                        <div class="form-group d-flex align-items-center">
                                            <label for="productos" class="mr-3">Producto:</label>
                                            <select class="form-control productos" name="productos[]">
                                                @foreach($productos as $producto)
                                                    <option value="{{ $producto->id }}" {{ $productoPedido->producto_id == $producto->id ? 'selected' : '' }}>{{ $producto->nombre }} - {{ $producto->marca }} - ${{ $producto->precio }}</option>
                                                @endforeach
                                            </select>
                                            <label for="cantidad" class="ml-3">Cantidad:</label>
                                            <select class="form-control cantidad" name="cantidad[]">
                                                @for($i = 1; $i <= $productoPedido->producto->cantidad_disponible + $productoPedido->cantidad; $i++)
                                                    <option value="{{ $i }}" {{ $productoPedido->cantidad == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                @endfor
                                            </select>
                                            <a href="#" class="eliminar_producto ml-3"><i class="fas fa-times text-danger"></i></a> <!-- Ícono de eliminar -->
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Contenedor oculto para clonar -->
                            <div id="producto_oculto" class="producto-container" style="display: none;">
                                <div class="form-group d-flex align-items-center">
                                    <label for="productos" class="mr-3">Producto:</label>
                                    <select class="form-control productos" name="productos[]">
                                        @foreach($productos as $producto)
                                            @if($producto->cantidad_disponible > 0)
                                                <option value="{{ $producto->id }}" data-cantidad-disponible="{{ $producto->cantidad_disponible }}">{{ $producto->nombre }} - {{ $producto->marca }} - ${{ $producto->precio }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <label for="cantidad" class="ml-3">Cantidad:</label>
                                    <select class="form-control cantidad" name="cantidad[]">
                                    </select>
                                    <a href="#" class="eliminar_producto ml-3"><i class="fas fa-times text-danger"></i></a> <!-- Ícono de eliminar -->
                                </div>
                            </div>

                            <div>
                                <button type="button" class="btn btn-success mt-3 agregar_producto">Agregar Producto</button>
                            </div>

                            <button type="submit" class="btn btn-primary mt-3">Guardar Cambios</button>
                            <a href="{{ route('pedido.index') }}" class="btn btn-secondary mt-3">Cancelar</a>
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
    <script>
        $(document).ready(function() {
            // Manejar clic en botón "Agregar Producto"
            $('.agregar_producto').click(function() {
                var nuevoProducto = $('#producto_oculto').clone();
                nuevoProducto.removeAttr('id').addClass('producto-container').appendTo('#productos_seleccionados').show(); // Clonar y mostrar el campo de selección de productos
                nuevoProducto.find('.productos').trigger('change'); // Disparar el evento de cambio para actualizar las cantidades disponibles
            });

            // Manejar clic en botón "Eliminar Producto"
            $(document).on('click', '.eliminar_producto', function() {
                $(this).closest('.producto-container').remove(); // Eliminar el contenedor del producto actual
            });


            // Manejar cambio en select de productos
            $(document).on('change', '.productos', function() {
                var cantidadDisponible = $(this).find(':selected').data('cantidad-disponible');
                var selectCantidad = $(this).closest('.producto-container').find('.cantidad');
                selectCantidad.empty();
                for (var i = 1; i <= cantidadDisponible; i++) {
                    selectCantidad.append('<option value="' + i + '">' + i + '</option>');
                }
            });

            // Manejar envío del formulario
            $('#pedidoForm').submit(function() {
                // Eliminar campos de productos no seleccionados
                $('#producto_oculto').remove();
                $('.producto-container').each(function() {
                    if ($(this).find('.productos').val() === '') {
                        $(this).remove();
                    }
                });

                // Recopilar valores seleccionados de todos los select de productos y sus cantidades
                var productosSeleccionados = [];
                $('.producto-container').each(function(index) {
                    var valorSeleccionado = $(this).find('.productos').val();
                    var cantidad = $(this).find('.cantidad').val();
                    if (valorSeleccionado !== '') {
                        productosSeleccionados.push({id: valorSeleccionado, cantidad: cantidad});
                    }
                });

                // Limpiar campos de productos antes de agregar nuevos
                $('#pedidoForm').find('input[name^="productos"]').remove();

                // Agregar los valores directamente al formulario para enviarlos
                $.each(productosSeleccionados, function(index, producto) {
                    $('#pedidoForm').append('<input type="hidden" name="productos[' + index + '][id]" value="' + producto.id + '">');
                    $('#pedidoForm').append('<input type="hidden" name="productos[' + index + '][cantidad]" value="' + producto.cantidad + '">');
                });
            });


        });
    </script>
@endsection
