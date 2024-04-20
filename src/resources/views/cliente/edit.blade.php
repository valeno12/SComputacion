@extends('adminlte::page')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="page-header">
                    <br>
                    <hr>
                    <h2>Editar Cliente</h2>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">Editar Información del Cliente</div>
                    <div class="card-body">
                        <form action="{{ route('cliente.update', $cliente->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="dni">DNI:</label>
                                <input type="text" class="form-control" id="dni" name="dni" value="{{ $cliente->dni }}">
                            </div>
                            <div class="form-group">
                                <label for="nombre">Nombre:</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $cliente->nombre }}">
                            </div>
                            <div class="form-group">
                                <label for="apellido">Apellido:</label>
                                <input type="text" class="form-control" id="apellido" name="apellido" value="{{ $cliente->apellido }}">
                            </div>
                            <div class="form-group">
                                <label for="domicilio">Domicilio:</label>
                                <input type="text" class="form-control" id="direccion" name="direccion" value="{{ $cliente->direccion }}">
                            </div>
                            <div class="form-group">
                                <label for="telefono">Teléfono:</label>
                                <input type="text" class="form-control" id="telefono" name="telefono" value="{{ $cliente->telefono }}">
                            </div>
                            <div class="form-group">
                                <label for="mail">Correo Electrónico:</label>
                                <input type="email" class="form-control" id="mail" name="mail" value="{{ $cliente->mail }}">
                            </div>
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                            <a href="{{ route('cliente.index') }}" class="btn btn-secondary">Cancelar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
