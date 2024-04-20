@extends('adminlte::page')

@section('title', 'Detalle del Pedido')

@section('content_header')
    <h1 class="m-0 text-dark">Detalle del Pedido</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Información del Pedido</h5>
        </div>
        <div class="card-body">
            <dl class="row">
                <div class="col-sm-6">
                    <dt>Código:</dt>
                    <dd>{{ $pedido->codigo }}</dd>

                    <dt>Nombre y Apellido:</dt>
                    <dd>{{ $pedido->cliente->nombre }} {{ $pedido->cliente->apellido }}</dd>

                    <dt>DNI del Cliente:</dt>
                    <dd>{{ $pedido->cliente->dni }}</dd>

                    <dt>Equipo:</dt>
                    <dd>{{ $pedido->equipo }}</dd>

                    <dt>Estado de Ingreso:</dt>
                    <dd>{{ $pedido->estado_ingreso }}</dd>

                    <dt>Fecha de Ingreso:</dt>
                    <dd>{{ \Carbon\Carbon::parse($pedido->fecha_ingreso)->format('d/m/Y') }}</dd>
                </div>

                <div class="col-sm-6">
                    <dt>Trabajo a Realizar:</dt>
                    <dd>{{ $pedido->trabajo_realizar ?? 'N/A' }}</dd>

                    <dt>Componente Problemático:</dt>
                    <dd>{{ $pedido->componente_problematico ?? 'N/A' }}</dd>

                    <dt>Presupuesto:</dt>
                    <dd>${{ number_format($pedido->presupuesto, 2, ',', '.') }}</dd>

                    <dt>Ganancia:</dt>
                    <dd>${{ number_format($pedido->ganancia, 2, ',', '.') }}</dd>

                    <dt>Mano de Obra:</dt>
                    <dd>${{ number_format($pedido->costo_mano_obra, 2, ',', '.') }}</dd>

                    <dt>Costo:</dt>
                    <dd>${{ number_format($pedido->costo, 2, ',', '.') }}</dd>

                    <dt>Fecha de Pago:</dt>
                    <dd>{{ \Carbon\Carbon::parse($pedido->fecha_pago)->format('d/m/Y') ?? 'N/A' }}</dd>
                </div>
            </dl>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Productos Seleccionados</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio Unitario</th>
                            <th>Precio de Unitario de Venta</th>
                            <th>Costo total</th>
                            <th>Total </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pedido->productosSeleccionados as $productoSeleccionado)
                            <tr>
                                <td>{{ $productoSeleccionado->producto->nombre }} {{ $productoSeleccionado->producto->marca }}</td>
                                <td>{{ $productoSeleccionado->cantidad }}</td>
                                <td>${{ number_format($productoSeleccionado->precio, 2, ',', '.') }}</td>
                                <td>${{ number_format($productoSeleccionado->precio * 1.3, 2, ',', '.') }}</td>
                                <td>${{ number_format($productoSeleccionado->precio * $productoSeleccionado->cantidad, 2, ',', '.') }}</td>
                                <td>${{ number_format(($productoSeleccionado->precio * 1.3 ) * $productoSeleccionado->cantidad, 2, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="card-footer">
        @if ($pedido->estadoActual_id == 4)
            <a href="{{ route('pedido.finalizados') }}" class="btn btn-primary">Volver</a>
        @elseif ($pedido->estadoActual_id == 5)
            <a href="{{ route('pedido.entregados') }}" class="btn btn-primary">Volver</a>
        @else
            <a href="{{ route('pedido.index') }}" class="btn btn-primary">Volver</a>
        @endif
    </div>

@endsection
