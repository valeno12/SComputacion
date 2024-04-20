@extends('adminlte::page')

@section('content_header')
    <h1>Listado de Pedidos Entregados</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Pedidos Entregados</h3>
        </div>
        <div class="card-body">
            <table class="table" id="pedidos-table">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Cliente</th>
                        <th>DNI</th>
                        <th>Equipo</th>
                        <th>Fecha de Entrega</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pedidos as $pedido)
                        <tr>
                            <td>{{ $pedido->codigo }}</td>
                            <td>{{ $pedido->cliente->nombre }} {{ $pedido->cliente->apellido }}</td>
                            <td>{{ $pedido->cliente->dni }}</td>
                            <td>{{ $pedido->equipo }}</td>
                            <td>{{ $pedido->estadoEntregado->created_at->format('d/m/Y H:i:s') }}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('pedido.showF', $pedido->id) }}" class="btn btn-primary">
                                        <i class="fas fa-eye"></i> <!-- Icono de ojo -->
                                    </a>
                                    <a href="{{ route('pedido.verestados', $pedido->id) }}" class="btn btn-secondary">
                                        Ver Estados
                                        <i class="fas fa-check ml-1" style="color: green;"></i> <!-- Icono de cheque -->
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
@endsection

@section('js')
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
    <script>
       $(document).ready(function() {
            $('#pedidos-table').DataTable({
                "order": [[0, "desc"]] // Ordenar por la primera columna (Código) en orden descendente
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('success') == 'ok')
        <script>
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Pedido Entregado!",
                showConfirmButton: false,
                timer: 1500
            });
        </script>
    @endif
@endsection
