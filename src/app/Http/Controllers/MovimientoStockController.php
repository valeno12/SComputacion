<?php

namespace App\Http\Controllers;
use App\Models\MovimientoStock;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MovimientoStockController extends Controller
{
    public function entradas()
    {
        $movimientos = MovimientoStock::where('tipo_movimiento', 'entrada')
            ->orderBy('fecha', 'desc')
            ->paginate(10);

        $movimientos->transform(function ($movimiento) {
            $movimiento->fecha = Carbon::parse($movimiento->fecha);
            return $movimiento;
        });

        return view('historial.entradas', compact('movimientos'));
    }

    public function salidas()
    {
        $movimientos = MovimientoStock::where('tipo_movimiento', 'salida')->orderBy('fecha', 'desc')->paginate(10);
        return view('historial.salidas', compact('movimientos'));
    }
}
