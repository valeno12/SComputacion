<?php

namespace App\Http\Controllers;

use App\Models\Estado;
use App\Models\Pedido;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $pedidos = Pedido::all();
    
        $conteoPedidosPorEstado = [];
    
        foreach ($pedidos as $pedido) {
            $estadoActual = $pedido->estados()->orderBy('pedido_estado.created_at', 'desc')->first();
            if ($estadoActual) {
                if (!isset($conteoPedidosPorEstado[$estadoActual->id])) {
                    $conteoPedidosPorEstado[$estadoActual->id] = 1;
                } else {
                    $conteoPedidosPorEstado[$estadoActual->id]++;
                }
            }
        }
        
        ksort($conteoPedidosPorEstado);
        
        $estados = Estado::pluck('nombre', 'id');

        $colores = [
            'success', 'info', 'warning', 'danger', 'primary', 'secondary'
        ];
        
        return view('home', compact('conteoPedidosPorEstado', 'estados','colores'));
    }
}
