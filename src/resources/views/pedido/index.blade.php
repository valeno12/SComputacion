@extends('adminlte::page')

@section('content_header')
    <h1>Listado de Pedidos</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Pedidos</h3>
            <div class="card-tools">
                <a href="{{ route('pedido.create') }}" class="btn btn-success">Nuevo Pedido</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table" id="pedidos-table">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Cliente</th>
                        <th>DNI</th>
                        <th>Equipo</th>
                        <th>Estado</th>
                        <th class="text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pedidos as $pedido)
                        <tr>
                            <td>{{ $pedido->codigo }}</td>
                            <td>{{ $pedido->cliente->nombre }} {{ $pedido->cliente->apellido }}</td>
                            <td>{{ $pedido->cliente->dni }}</td>
                            <td>{{ $pedido->equipo }}</td>
                            <td>{{ $pedido->estadoActual->nombre }}</td>
                            <td class = "text-right">
                                @if ($pedido->estadoActual->nombre == 'En revision')
                                    <a href="{{ route('pedido.showI', $pedido->id) }}" class="btn btn-info">Ver</a>
                                    <a href="{{ route('pedido.editI', $pedido->id) }}" class="btn btn-primary">Editar</a>
                                @else
                                    <a href="{{ route('pedido.showF', $pedido->id) }}" class="btn btn-info">Ver</a>
                                    <a href="{{ route('pedido.editF', $pedido->id) }}" class="btn btn-primary">Editar</a>
                                @endif                                
                                <form action="{{ route('pedido.destroy', $pedido->id) }}" class="d-inline formulario-eliminar" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Borrar</button>
                                </form>
                                <a href="{{ route('pedido.verestados', $pedido->id) }}" class="btn btn-secondary ">Ver Estados</a>
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
             title: "Se guardó con éxito",
             showConfirmButton: false,
             timer: 1500
         });
     </script>
     @endif

     @if (session('eliminar')  == 'ok')
        <script>
            Swal.fire({
                title: "Eliminado!",
                text: "Se eliminó correctamente.",
                icon: "success"
             });
         </script>
     @endif;

     <script>
         $('.formulario-eliminar').submit(function(e){
             e.preventDefault();
             Swal.fire({
                 title: "Seguro?",
                 text: "Esto no se puede deshacer",
                 icon: "warning",
                 showCancelButton: true,
                 confirmButtonColor: "#3085d6",
                 cancelButtonColor: "#d33",
                 confirmButtonText: "Si, borrar"
             }).then((result) => {
                 if (result.isConfirmed) {
                     this.submit();
                 }
             });
         })
     </script>

@endsection
