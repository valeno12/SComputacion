@extends('adminlte::page')

@section('title', 'Detalles del Pedido (Estado Inicial)')

@section('content_header')
    <h1 class="m-0 text-dark">Detalle del Pedido</h1>
@endsection

@section('css')
    <style>
        @media print {
            /* Estilo para la página de impresión */
            @page {
                size: landscape; /* Orientación horizontal */
            }
            .rotated-page {
                transform: rotate(90deg); /* Rotar la página 90 grados */
                transform-origin: left top 0; /* Establecer el origen de la transformación */
                width: 100vh; /* Establecer el ancho de la página al alto de la ventana */
                height: 100vw; /* Establecer la altura de la página al ancho de la ventana */
                overflow: hidden; /* Ocultar el desbordamiento */
                page-break-after: always; /* Forzar un salto de página después de esta página */
            }
            /* Oculta el botón de imprimir en la impresión */
            .btn-print {
                display: none;
            }
            /* Oculta los botones de editar y volver en la impresión */
            .print-only {
                display: none;
            }
            /* Oculta el título en la impresión */
            .card-header {
                display: none;
            }
        }
    </style>
@endsection

@section('content')
    <div class="printable-content">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Detalles del Pedido (Estado Inicial)</h5>
            </div>
            <div class="card-body">
                <dl class="row">
                    <div class="col-sm-6">
                        <dt>Código:</dt>
                        <dd>{{ $pedido->codigo }}</dd>

                        <dt>Nombre y Apellido:</dt>
                        <dd>{{ $pedido->cliente->nombre }} {{ $pedido->cliente->apellido }}</dd>

                        <dt>DNI del Cliente:</dt>
                        <dd>{{ $pedido->cliente->dni }}</dd>

                        <dt>Equipo:</dt>
                        <dd>{{ $pedido->equipo }}</dd>

                        <dt>Estado de Ingreso:</dt>
                        <dd>{{ $pedido->estado_ingreso }}</dd>

                        <dt>Fecha de Ingreso:</dt>
                        <dd>{{ \Carbon\Carbon::parse($pedido->fecha_ingreso)->format('d/m/Y') }}</dd>

                        <dt>Cargador:</dt>
                        <dd>{{ $pedido->cargador ? 'Sí' : 'No' }}</dd>

                    </div>
                </dl>
            </div>
            <div class="card-footer">
                <a href="{{ route('pedido.editI', $pedido->id) }}" class="btn btn-primary print-only">Editar</a>
                <a href="{{ route('pedido.index') }}" class="btn btn-primary print-only">Volver</a>
                <button class="btn btn-primary float-right btn-print" onclick="window.print()">
                    <i class="fas fa-print"></i> Imprimir
                </button>
            </div>
        </div>
    </div>
@endsection
