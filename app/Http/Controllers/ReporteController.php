<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\CounterHelper;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Productos más vendidos
        $productosMasVendidos = DB::select("SELECT p.nombre, SUM(dv.cantidad) as total_vendido
            FROM detalles dv
            INNER JOIN productos p ON dv.id_producto = p.id
            GROUP BY p.nombre
            ORDER BY total_vendido DESC
            LIMIT 5");

        // Ventas por mes
        $ventasPorMes = DB::table('ventas')
            ->select(DB::raw('EXTRACT(MONTH FROM fecha) as mes'), DB::raw('SUM(total) as total_ventas'))
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        $count = CounterHelper::incrementCounter('reporte');

        return Inertia::render('Reportes/Index', [
            'productosMasVendidos' => $productosMasVendidos,
            'ventasPorMes' => $ventasPorMes,
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
