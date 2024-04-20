@extends('adminlte::page')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Editar Producto</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('producto.update', $producto->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="nombre">Nombre:</label>
                                <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $producto->nombre }}" required>
                            </div>

                            <div class="form-group">
                                <label for="marca">Marca:</label>
                                <input type="text" name="marca" id="marca" class="form-control" value="{{ $producto->marca }}" required>
                            </div>

                            <div class="form-group">
                                <label for="precio">Precio unitario:</label>
                                <input type="number" name="precio" id="precio" class="form-control" value="{{ $producto->precio }}" required step="0.01">
                            </div>

                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection