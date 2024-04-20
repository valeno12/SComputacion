@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
<div class="row">
  @foreach($conteoPedidosPorEstado as $estadoId => $cantidad)
  <div class="col-lg-3 col-6">
    <!-- small box -->
    <div class="small-box bg-{{ $colores[$estadoId % count($colores)] }}">
      <div class="inner">
        <h3>{{ $cantidad }}</h3>
        <p>{{ $estados[$estadoId] }}</p>
      </div>
      <div class="icon">
        <i class="fas fa-shopping-cart"></i>
      </div>
    </div>
  </div>
  @endforeach
</div>
@endsection
