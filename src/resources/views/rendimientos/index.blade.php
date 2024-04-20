@extends('adminlte::page')

@section('title', 'Rendimientos por Mes')

@section('content_header')
    <h1>Rendimientos por Mes</h1>
@endsection

@section('content')
<div class="row mt-3">
    <div class="col-md-6">
        <!-- Selector de mes y año -->
        <form method="GET" action="{{ route('rendimientos.index') }}">
            @csrf
            <div class="form-group">
                <label for="selectedYear">Selecciona el año:</label>
                <select name="selectedYear" id="selectedYear" class="form-control">
                    @for ($year = date('Y'); $year >= 2020; $year--)
                        <option value="{{ $year }}" @if ($selectedYear == $year) selected @endif>{{ $year }}</option>
                    @endfor
                </select>
            </div>
            <div class="form-group">
                <label for="selectedMonth">Selecciona el mes:</label>
                <select name="selectedMonth" id="selectedMonth" class="form-control">
                    @foreach (['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'] as $index => $month)
                        <option value="{{ $index + 1 }}" @if ($selectedMonth == $index + 1) selected @endif>{{ $month }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary mb-2">Mostrar Rendimientos</button>
        </form>
    </div>
    <div class="col-md-6 d-flex align-items-center"> <!-- Utiliza Flexbox para centrar verticalmente -->
        <div class="info-box bg-yellow">
            <span class="info-box-icon"><i class="fa fa-dollar"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Ganancia del mes</span>
                <span class="info-box-number">${{ number_format($gananciaMes, 2) }}</span>
            </div>
        </div>
    </div>
</div>



<div class="row">
    <div class="col-md-6">
        <!-- Widget para mostrar los gastos -->
        <div class="info-box bg-red">
            <span class="info-box-icon"><i class="fa fa-dollar"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Gastos del mes</span>
                <span class="info-box-number">
                    @if ($gastosPorMes->isNotEmpty())
                        @foreach($gastosPorMes as $gasto)
                            ${{ number_format($gasto->total_gastos, 2) }}
                        @endforeach
                    @else
                        No hay datos disponibles para este mes y año.
                    @endif
                </span>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <!-- Widget para mostrar los cobros -->
        <div class="info-box bg-green">
            <span class="info-box-icon"><i class="fa fa-dollar"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Cobros del mes</span>
                <span class="info-box-number">
                    @if ($gananciasPorMes->isNotEmpty())
                        @foreach($gananciasPorMes as $ganancia)
                            ${{ number_format($ganancia->total_ganancias, 2) }}
                        @endforeach
                    @else
                        No hay datos disponibles para este mes y año.
                    @endif
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Tabla para mostrar los detalles de cobros y gastos -->
<div class="row mt-3">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-red">
                Detalles de Gastos del Mes
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Precio Unitario</th>
                            <th>Precio Total</th>
                            <th>Cantidad</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($detalleCobrosGastos as $detalle)
                            @if(isset($detalle['gastos']))
                                @foreach($detalle['gastos'] as $gasto)
                                    <tr>
                                        <td>{{ $gasto->producto->nombre }} {{ $gasto->producto->marca }}</td>
                                        <td>${{ number_format($gasto->precio , 2, ',', '.') }}</td>
                                        <td>${{ number_format(($gasto->precio * $gasto->cantidad), 2, ',', '.') }}</td>
                                        <td>{{ $gasto->cantidad }}</td>
                                        <td>{{ \Carbon\Carbon::parse($gasto->fecha)->format('d/m/Y') }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-success">
                Detalles de Cobros del Mes
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Precio</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($detalleCobrosGastos as $detalle)
                            @if(isset($detalle['cobros']))
                                @foreach($detalle['cobros'] as $cobro)
                                    <tr>
                                        <td>{{ $cobro->codigo }}</td>
                                        <td>${{ number_format($cobro->presupuesto, 2) }}</td>
                                        <td>{{ \Carbon\Carbon::parse($cobro->fecha_pago)->format('d/m/Y') }}</td>
                                        <td>
                                            <a href="{{ route('pedido.showF', $cobro->id) }}" class="btn btn-primary">
                                                <i class="fas fa-eye"></i> <!-- Icono de ojo -->
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="col-md-6" id="chartContainer" style="display: none;">
        <canvas id="pieChart" style="max-width: 400px; margin: 0 auto;"></canvas>
</div>
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
<script>
    var proveedores = {!! json_encode($proveedores) !!};
    if (proveedores.length > 0) {
        document.getElementById('chartContainer').style.display = 'block';

        var proveedoresLabels = [];
        var cantidadPedidos = [];

        proveedores.forEach(function(proveedor) {
            proveedoresLabels.push(proveedor.proveedor.nombre);
            cantidadPedidos.push(proveedor.cantidad_pedidos);
        });

        var ctx = document.getElementById('pieChart').getContext('2d');
        var pieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: proveedoresLabels,
                datasets: [{
                    label: 'Cantidad de Pedidos por Proveedor',
                    data: cantidadPedidos,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)', // Rojo
                        'rgba(54, 162, 235, 0.7)', // Azul
                        'rgba(255, 205, 86, 0.7)', // Amarillo
                        'rgba(75, 192, 192, 0.7)', // Verde
                        'rgba(153, 102, 255, 0.7)', // Púrpura
                        'rgba(255, 159, 64, 0.7)', // Naranja
                        // Agrega más colores según necesites
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Cantidad de Pedidos por Proveedor'
                    }
                }
            }
        });
    }
</script>
@endsection
