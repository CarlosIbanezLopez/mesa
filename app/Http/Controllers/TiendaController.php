<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\CounterHelper;

class TiendaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productos = \DB::table('productos')->get();
        $promociones = \DB::table('promociones')->get();
        $count = CounterHelper::incrementCounter('tienda');

        return view('tienda.tienda_index', compact('productos', 'promociones', 'count'));

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
        // dd($request->all());
        $total = 0;
        foreach ($request->productos as $producto) {
            $total += $producto['subtotal'];
        }

        $ventaId = \DB::table('ventas')->insertGetId([
            'id_users' => auth()->id(),
            'fecha' => now(),
            'total' => $total, // Total de la compra
        ]);

        // Insertar en tabla pagos
        \DB::table('pagos')->insert([
            'id_venta' => $ventaId,
            'metodo' => 'QR',
            'monto' => $total, // Total de la compra
        ]);
        // dd($request->all());
        // Insertar los detalles de la venta
        foreach ($request->productos as $producto) {
            \DB::table('detalles')->insert([
                'id_venta' => $ventaId,
                'id_producto' => $producto['id'],
                'cantidad' => $producto['cantidad'],
                'subtotal' => $producto['subtotal'],
            ]);
        }


        // Actualizar el stock de cada producto
        foreach ($request->productos as $producto) {
            $idInventario = \DB::table('productos')->where('id', $producto['id'])->value('id_inventario');
            $stockActual = \DB::table('inventarios')->where('id', $idInventario)->value('stock');
            $nuevoStock = $stockActual - $producto['cantidad'];

            \DB::table('inventarios')->where('id', $idInventario)->update(['stock' => $nuevoStock]);
        }
        // Redirigir con un mensaje de éxito
        return redirect()->route('checkout', ['ventaId' => $ventaId])->with('success', 'Compra realizada con exito');
    }

    
    public function detallesVenta($id)
    {
        // Obtener la venta y sus detalles
        $venta = \DB::table('ventas')->where('id', $id)->first();

        // Obtener los productos relacionados con la venta desde la tabla 'detalles'
        $detalles = \DB::table('detalles')
            ->join('productos', 'detalles.id_producto', '=', 'productos.id')
            ->where('detalles.id_venta', $id)
            ->select('productos.nombre', 'detalles.cantidad', 'detalles.subtotal', 'productos.precio')
            ->get();

        // Pasar los detalles de la venta a la vista
        return view('tienda.compra_detalle', compact('venta', 'detalles'));
    }
    
    public function misCompras()
    {
        $ventas = \DB::table('ventas')->where('id_users', auth()->id())->get();
        return view('tienda.compras_index', compact('ventas'));
    }

    public function checkout($ventaId)
    {
        // Obtener la venta y sus detalles
        $venta = \DB::table('ventas')->where('id', $ventaId)->first();

        // Obtener los productos relacionados con la venta desde la tabla 'detalles'
        $detalles = \DB::table('detalles')
            ->join('productos', 'detalles.id_producto', '=', 'productos.id')
            ->where('detalles.id_venta', $ventaId)
            ->select('productos.nombre', 'detalles.cantidad', 'detalles.subtotal', 'productos.precio')
            ->get();

        // Pasar los detalles de la venta a la vista
        return view('tienda.checkout', compact('venta', 'detalles'));
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
