@extends('adminlte::page')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="page-header">
                    <br>
                    <hr>
                    <div class="col-lg-12">
                        <a class="btn btn-success float-right" href="{{ route('cliente.create') }}">Nuevo Cliente&nbsp;&nbsp;<span class="fa fa-plus"></span></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">Gestión de Clientes</div>
                    <div class="card-body">

                        <!-- Tabla de clientes con paginación -->
                        <table class="table table-striped" id="clientesTable">
                            <thead>
                                <tr>
                                    <th>DNI</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>E-Mail</th>
                                    <th class="text-right">Acciones</th> <!-- Aquí eliminamos las flechas -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($clientes as $cliente)
                                    <tr>
                                        <td>{{ $cliente->dni }}</td>
                                        <td>{{ $cliente->nombre }}</td>
                                        <td>{{ $cliente->apellido }}</td>
                                        <td>{{ $cliente->mail }}</td>
                                        <td class="text-right">
                                            <a href="{{ route('cliente.edit', $cliente->id) }}" class="btn btn-primary">Editar</a>
                                            <form action="{{ route('cliente.destroy', $cliente->id) }}" class="d-inline formulario-eliminar" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Borrar</button>
                                            </form>
                                            <a href="{{ route('cliente.show', $cliente->id) }}" class="btn btn-info">Ver</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
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
            // Inicializar DataTables y configurar paginación
            $('#clientesTable').DataTable({
                "paging": true,
                "ordering": false, // Esto deshabilita la ordenación por columnas
                "searching": true // Esto habilita la búsqueda
            });

            // Configurar el campo de búsqueda
            $('#searchInput').on('keyup', function() {
                $('#clientesTable').DataTable().search($(this).val()).draw();
            });
        });
    </script>
@endsection
