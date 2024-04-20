<?php

namespace App\Http\Controllers;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProveedorController extends Controller
{
    public function index()
    {
        $proveedores = Proveedor::all();
        return view('proveedor.index', compact('proveedores'));
    }

    public function destroy($id)
    {
        $proveedor = Proveedor::findOrFail($id);
        $proveedor->delete();
        return redirect()->route('proveedor.index')->with('eliminar', 'ok');
    }

    public function create()
    {
        return view('proveedor.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);
        Proveedor::create($request->all());
        return redirect()->route('proveedor.index')->with('success', 'ok');
    }

    public function edit($id)
    {
        $proveedor = Proveedor::findOrFail($id);
        return redirect()->route('proveedor.edit')->with('success', 'ok');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);
        $proveedor = Proveedor::findOrFail($id);
        $proveedor->update($request->all());

        return redirect()->route('proveedor.index')->with('success', 'ok');
    }

    public function buscarNombre(Request $request) : JsonResponse
    {
        $query = $request->input('q');
        $nombres = Proveedor::where('nombre', 'ilike', '%' . $query . '%')
                    ->groupBy('nombre')
                    ->pluck('nombre');
        return response()->json($nombres);
    }
}
