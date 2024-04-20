@extends('adminlte::page')

@section('title', 'Historial de Entradas de Stock')

@section('content_header')
    <h1>Historial de Entradas de Stock</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Registros de Entrada</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Costo Unitario</th>
                            <th>Costo Total</th>
                            <th>Proveedor</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($movimientos as $movimiento)
                            @if($movimiento->tipo_movimiento === 'entrada')
                                <tr>
                                    <td>{{ $movimiento->producto->nombre }} {{ $movimiento->producto->marca }}</td>
                                    <td>{{ $movimiento->cantidad }}</td>
                                    <td>${{ number_format($movimiento->precio, 2, ',', '.') }} </td>
                                    <td>${{ number_format($movimiento->cantidad * $movimiento->precio, 2, ',', '.') }}</td>
                                    <td>{{ $movimiento->proveedor->nombre }}</td>
                                    <td>{{ $movimiento->fecha->format('d/m/Y H:i:s') }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer clearfix">
            {{ $movimientos->links() }}
        </div>
    </div>
@stop

@section('adminlte_css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css">
    <style>
        .table-responsive {
            overflow-x: auto;
        }
    </style>
@stop

@section('adminlte_js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
@stop
