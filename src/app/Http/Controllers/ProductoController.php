<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Proovedor;
use Illuminate\Http\Request;
use App\Models\MovimientoStock;
use App\Models\Proveedor;
use Illuminate\Http\JsonResponse;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::all();
        return view('producto.index', compact('productos'));
    }

    public function create()
    {
        return view('producto.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'marca' => 'required|string|max:255',
            'proveedor'=> 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'cantidad_disponible' => 'required|integer|min:0',
        ]);
        $producto = Producto::where('nombre', $request->nombre)
                        ->where('marca', $request->marca)
                        ->first();

        if ($producto) {
            $producto->update([
                'cantidad_disponible' => $producto->cantidad_disponible + $request->cantidad_disponible,
                'precio' => $request->precio
            ]);
        } else {
        $producto = Producto::create($request->all());
        }

        $proveedor = Proveedor::where('nombre', $request->proveedor)->first();

        if(!$proveedor){
            $proveedor = Proveedor::create([
                'nombre' => $request->proveedor,
            ]);
        }

        MovimientoStock::create([
            'producto_id' => $producto->id,
            'tipo_movimiento' => 'entrada',
            'cantidad' => $request->cantidad_disponible,
            'proveedor_id' => $proveedor->id,
            'precio' => $request->precio,
            'fecha' => now(),
        ]);

        return redirect()->route('producto.index')->with('success', 'ok');
    }

    public function show(Producto $producto)
    {
        return view('producto.show', compact('producto'));
    }

    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        return view('producto.edit', compact('producto'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'marca' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
        ]);
        $producto = Producto::findOrFail($id);
        $producto->update($request->all());

        return redirect()->route('producto.index')->with('success', 'ok');
    }

    public function destroy($id)
    {
        $producto=Producto::findOrFail($id);
        $producto->delete();
        return redirect()->route('producto.index')->with('eliminado', 'ok');
    }

    public function buscarNombre(Request $request) : JsonResponse
    {
        $query = $request->input('q');
        $nombres = Producto::where('nombre', 'ilike',  $query . '%')
                    ->groupBy('nombre')
                    ->pluck('nombre');
        return response()->json($nombres);
    }

    public function buscarMarca(Request $request) : JsonResponse
    {
        $query = $request->input('q');
        $nombres = Producto::where('marca', 'ilike',  $query . '%')
                    ->groupBy('marca')
                    ->pluck('marca');
        return response()->json($nombres);
    }
}
