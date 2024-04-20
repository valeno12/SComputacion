<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');
        $clientes = Cliente::where('nombre', 'ilike', '%' . $query . '%')
                            ->orWhere('apellido', 'ilike', '%' . $query . '%')
                            ->orWhere('dni', 'ilike', $query . '%')
                            ->get();
        return view('cliente.index', ['clientes' => $clientes]);
    }

    public function destroy($id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->delete();
        return redirect()->route('cliente.index')->with('eliminar', 'ok');
    }

    public function create()
    {
        return view('cliente.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'dni' => 'required|string|max:10|unique:cliente',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
        ]);

        Cliente::create($request->all());

        return redirect()->route('cliente.index')->with('success', 'ok');
    }

    public function edit($id)
    {
        $cliente = Cliente::findOrFail($id);
        return view('cliente.edit', compact('cliente'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'dni' => 'required|string|max:10|unique:cliente,dni,' . $id,
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'mail' => 'required|email|max:255',
        ]);
        $cliente = Cliente::findOrFail($id);
        $cliente->update($request->all());

        return redirect()->route('cliente.index')->with('success', 'ok');
    }


    public function show($id)
    {
        $cliente = Cliente::findOrFail($id);
        return view('cliente.show', compact('cliente'));
    }

}
