@extends('adminlte::page')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="page-header">
                    <br>
                    <hr>
                    <h2>Detalles del Cliente</h2>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">Información del Cliente</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>DNI:</strong> {{ $cliente->dni }}</p>
                                <p><strong>Nombre:</strong> {{ $cliente->nombre }}</p>
                                <p><strong>Apellido:</strong> {{ $cliente->apellido }}</p>
                                <p><strong>Domicilio:</strong> {{ $cliente->direccion }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Teléfono:</strong> {{ $cliente->telefono }}</p>
                                <p><strong>Correo Electrónico:</strong> {{ $cliente->mail }}</p>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <a href="{{ route('cliente.edit', $cliente->id) }}" class="btn btn-primary">Editar</a>
                                <a href="{{ route('cliente.index') }}" class="btn btn-primary">Volver</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

