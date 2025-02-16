<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\CounterHelper;
use Inertia\Inertia;

class PromocionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $promociones = \DB::table('promociones')->get();
        $count = CounterHelper::incrementCounter('promocion');

        return Inertia::render('Promociones/Index', [
            'promociones' => $promociones,
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
        return Inertia::render('Promociones/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        \DB::table('promociones')->insert([
            'descuento' => $request->descuento,
            'fecha_final' => $request->fecha_final,
        ]);
        return redirect()->route('promocion_home')->with('success', 'Promocion creada con exito');
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
        $promocion = \DB::table('promociones')->where('id', $id)->first();

        return Inertia::render('Promociones/Edit', [
            'promocion' => $promocion
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
        \DB::table('promociones')->where('id', $id)->update([
            'descuento' => $request->descuento,
            'fecha_final' => $request->fecha_final,
        ]);
        return redirect()->route('promocion_home')->with('success', 'Promocion actualizada con exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        \DB::table('promociones')->where('id', $id)->delete();
        return redirect()->route('promocion_home')->with('success', 'Promocion eliminada con exito');
    }
}
