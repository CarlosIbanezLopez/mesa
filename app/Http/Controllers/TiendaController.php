<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\CounterHelper;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TiendaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productos = DB::table('productos')
            ->select('productos.*', 'promociones.descuento')
            ->leftJoin('promociones', 'productos.id_promocion', '=', 'promociones.id')
            ->get();

        foreach ($productos as $producto) {
            $producto->foto_url = $producto->foto ? asset('storage/' . $producto->foto) : null;
            if ($producto->descuento) {
                $producto->precio_descuento = $producto->precio - ($producto->precio * ($producto->descuento / 100));
            } else {
                $producto->precio_descuento = $producto->precio;
            }
        }

        $count = CounterHelper::incrementCounter('tienda');

        return Inertia::render('Tienda/Index', [
            'productos' => $productos,
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
        try {
            $total = 0;
            foreach ($request->productos as $producto) {
                $total += $producto['subtotal'];
            }

            $ventaId = DB::table('ventas')->insertGetId([
                'id_users' => auth()->id(),
                'fecha' => now(),
                'total' => $total,
            ]);

            DB::table('pagos')->insert([
                'id_venta' => $ventaId,
                'metodo' => 'QR',
                'monto' => $total,
            ]);

            foreach ($request->productos as $producto) {
                DB::table('detalles')->insert([
                    'id_venta' => $ventaId,
                    'id_producto' => $producto['id'],
                    'cantidad' => $producto['cantidad'],
                    'subtotal' => $producto['subtotal'],
                ]);

                $idInventario = DB::table('productos')
                    ->where('id', $producto['id'])
                    ->value('id_inventario');

                DB::table('inventarios')
                    ->where('id', $idInventario)
                    ->decrement('stock', $producto['cantidad']);
            }

            return redirect()->route('checkout', ['ventaId' => $ventaId]);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al procesar la compra: ' . $e->getMessage()]);
        }
    }

    public function checkout($ventaId)
    {
        $venta = DB::table('ventas')->where('id', $ventaId)->first();

        $detalles = DB::table('detalles')
            ->join('productos', 'detalles.id_producto', '=', 'productos.id')
            ->where('detalles.id_venta', $ventaId)
            ->select('productos.nombre', 'detalles.cantidad', 'detalles.subtotal', 'productos.precio')
            ->get();

        return Inertia::render('Tienda/Checkout', [
            'venta' => $venta,
            'detalles' => $detalles
        ]);
    }

    public function misCompras()
    {
        $ventas = DB::table('ventas')
            ->where('id_users', auth()->id())
            ->orderBy('fecha', 'desc')
            ->get();

        return Inertia::render('Tienda/MisCompras', [
            'ventas' => $ventas
        ]);
    }

    public function detallesVenta($id)
    {
        $venta = DB::table('ventas')->where('id', $id)->first();

        $detalles = DB::table('detalles')
            ->join('productos', 'detalles.id_producto', '=', 'productos.id')
            ->where('detalles.id_venta', $id)
            ->select('productos.nombre', 'detalles.cantidad', 'detalles.subtotal', 'productos.precio')
            ->get();

        return Inertia::render('Tienda/DetalleVenta', [
            'venta' => $venta,
            'detalles' => $detalles
        ]);
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
