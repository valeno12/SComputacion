@extends('adminlte::page')

@section('title', 'Historial de Salidas de Stock')

@section('content_header')
    <h1>Historial de Salidas de Stock</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Registros de Salida</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Pedido</th>
                            <th>Cantidad</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($movimientos as $movimiento)
                            @if($movimiento->tipo_movimiento === 'salida')
                                <tr>
                                    <td>{{ $movimiento->producto->nombre }} {{ $movimiento->producto->marca }}</td>
                                    <td>{{ $movimiento->pedido->codigo ?? 'N/A' }}</td>
                                    <td>{{ $movimiento->cantidad }}</td>
                                    <td>{{ $movimiento->fecha }}</td>
                                    <td>
                                    <a href="{{ $movimiento->pedido ? route('pedido.showF', $movimiento->pedido->id) : '#' }}" class="btn btn-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
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
    <style>
        .table-responsive {
            overflow-x: auto;
        }
    </style>
@stop
