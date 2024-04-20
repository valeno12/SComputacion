@extends('adminlte::page')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="page-header">
                    <br>
                    <hr>
                    <div class="col-lg-12">
                        <a class="btn btn-success float-right" href="{{ route('proveedor.create') }}">Nuevo Proveedor&nbsp;&nbsp;<span class="fa fa-plus"></span></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">Gestión de Proveedores</div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th class="text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($proveedores as $proveedor)
                                    <tr>
                                        <td>{{ $proveedor->id }}</td>
                                        <td>{{ $proveedor->nombre }}</td>
                                        <td class="text-right">
                                            <a href="{{ route('proveedor.edit', $proveedor->id) }}" class="btn btn-primary">Editar</a>
                                            <form action="{{ route('proveedor.destroy', $proveedor->id) }}" class="d-inline formulario-eliminar" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Borrar</button>
                                            </form>
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
