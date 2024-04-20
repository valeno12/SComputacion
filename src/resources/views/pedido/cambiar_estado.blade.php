@extends('adminlte::page')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Cambiar Estado del Pedido</div>

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

                        <form id="pedidoForm" method="POST" action="{{ route('pedido.storeAprobacion', $pedido->id) }}">
                            @csrf
                            @method('PUT')
                            
                            <div class="form-group">
                                <label for="componente_problematico">Componente Problemático:</label>
                                <input type="text" class="form-control" id="componente_problematico" name="componente_problematico" >
                            </div>
                            <div class="form-group">
                                <label for="trabajo_realizar">Trabajo a Realizar:</label>
                                <textarea class="form-control" id="trabajo_realizar" name="trabajo_realizar" rows="3" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="costo_mano_obra">Costo de Mano de Obra:</label>
                                <input type="number" class="form-control" id="costo_mano_obra" name="costo_mano_obra" required>
                            </div>

                            <!-- Lista de Productos Seleccionados -->
                            <div id="productos_seleccionados" class="mt-3">
                                <h5>Productos Seleccionados:</h5>
                                <ul class="list-group" id="lista_productos">
                                    <!-- Aquí se añadirán dinámicamente los productos seleccionados -->
                                </ul>
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

@section('js')
<script>
    $(document).ready(function() {
        // Manejar clic en botón "Agregar Producto"
        $('.agregar_producto').click(function() {
            var nuevoProducto = $('#producto_oculto').clone();
            nuevoProducto.removeAttr('id').addClass('producto-container').appendTo('#productos_seleccionados').show(); // Clonar y mostrar el campo de selección de productos
            nuevoProducto.find('.productos').trigger('change'); // Disparar el evento de cambio para actualizar las cantidades disponibles
        });

        // Manejar clic en botón "Eliminar Producto"
        $('#productos_seleccionados').on('click', '.eliminar_producto', function() {
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
            $('.productos').each(function(index) {
                var valorSeleccionado = $(this).val();
                var cantidad = $(this).closest('.producto-container').find('.cantidad').val();
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