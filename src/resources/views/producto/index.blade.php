@extends('adminlte::page')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="page-header">
                    <br>
                    <hr>
                    <div class="col-lg-12">
                        <a class="btn btn-success float-right" href="{{ route('producto.create') }}">Nuevo Producto&nbsp;&nbsp;<span class="fa fa-plus"></span></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">Gestión de Productos</div>
                    <div class="card-body">
                        <form action="{{ route('producto.index') }}" method="GET" class="form-inline mb-3">
                            <input class="form-control mr-sm-2" type="search" placeholder="Buscar por nombre o marca" aria-label="Buscar" name="q" value="{{ request('q') }}">
                            <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Buscar</button>
                        </form>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Marca</th>
                                    <th>Precio Proveedor</th>
                                    <th>Precio Venta</th>
                                    <th>Cantidad Disponible</th>
                                    <th class="text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($productos as $producto)
                                    <tr>
                                        <td>{{ $producto->id }}</td>
                                        <td>{{ $producto->nombre }}</td>
                                        <td>{{ $producto->marca }}</td>
                                        <td>${{ number_format($producto->precio, 2, ',', '.') }}</td>
                                        <td>${{ number_format($producto->precio * 1.3, 2, ',', '.') }}</td>
                                        <td>{{ $producto->cantidad_disponible }}</td>
                                        <td class="text-right">
                                            <a href="{{ route('producto.edit', $producto->id) }}" class="btn btn-primary">Editar</a>
                                            <form action="{{ route('producto.destroy', $producto->id) }}" class="d-inline formulario-eliminar" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Borrar</button>
                                            </form>
                                            <!-- Agregar más acciones si es necesario -->
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

@section('js')
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
