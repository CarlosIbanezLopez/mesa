<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\CounterHelper;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class InventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inventarios = \DB::table('inventarios')->get();
        $count = CounterHelper::incrementCounter('inventario');

        return Inertia::render('Inventario/Index', [
            'inventarios' => $inventarios,
            'count' => $count
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Inventario/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        \DB::table('inventarios')->insert([
            'stock' => $request->stock,
            'fecha_actualizacion' => $request->fecha_actualizacion,
        ]);

        return redirect()->route('inventario_home')
            ->with('success', 'Inventario creado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $inventario = \DB::table('inventarios')->where('id', $id)->first();

        return Inertia::render('Inventario/Edit', [
            'inventario' => $inventario
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $stock_actual = \DB::table('inventarios')->where('id', $id)->value('stock');
        $stock_nuevo = $stock_actual + $request->stock_a_añadir;

        \DB::table('inventarios')->where('id', $id)->update([
            'stock' => $stock_nuevo,
            'fecha_actualizacion' => $request->fecha_actualizacion,
        ]);

        return redirect()->route('inventario_home')
            ->with('success', 'Inventario actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        \DB::table('inventarios')->where('id', $id)->delete();

        return redirect()->route('inventario_home')
            ->with('success', 'Inventario eliminado con éxito');
    }
}
