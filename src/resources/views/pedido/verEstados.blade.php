@extends('adminlte::page')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3>Estados del Pedido</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Estado</th>
                            <th>Desde</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($estados as $estado)
                            @php
                                $estadoActual = App\Models\Estado::find($estado->estado_id);
                            @endphp
                            <tr>
                                <td>{{ $estadoActual->nombre }}</td>
                                <td>{{ $estado->created_at->format('d/m/Y H:i:s') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <a href="{{ route('pedido.index') }}" class="btn btn-primary">Volver</a>
                @if ($siguienteEstado)
                    <a href="{{ route('pedido.actualizarestado', ['pedido_id' => $pedido->id, 'estado_id' => $siguienteEstado->id]) }}" class="btn btn-success">Cambiar a {{ $siguienteEstado->nombre }}</a>
                @endif
            </div>
        </div>
    </div>
@endsection
