<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\CounterHelper;
use Inertia\Inertia;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productos = \DB::table('productos')
            ->select('productos.*', 'inventarios.stock')
            ->join('inventarios', 'productos.id_inventario', '=', 'inventarios.id')
            ->get();

        foreach ($productos as $producto) {
            // Verificar si el archivo existe antes de asignar la URL
            if ($producto->foto && \Storage::exists('public/' . $producto->foto)) {
                $producto->foto_url = asset('storage/' . $producto->foto);
            } else {
                $producto->foto_url = null;
            }
        }

        $count = CounterHelper::incrementCounter('producto');

        return Inertia::render('Productos/Index', [
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
        $inventarios = \DB::table('inventarios')->get();
        $promociones = \DB::table('promociones')->get();

        return Inertia::render('Productos/Create', [
            'inventarios' => $inventarios,
            'promociones' => $promociones
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $path = null;
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('public/images');
            $relativePath = str_replace('public/', '', $path);
        }

        \DB::table('productos')->insert([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'id_inventario' => $request->inventario,
            'id_promocion' => $request->promocion,
            'precio' => $request->precio,
            'foto' => $relativePath ?? null,
        ]);

        return redirect()->route('producto_home')
            ->with('success', 'Producto creado con éxito');
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
        $producto = \DB::table('productos')->where('id', $id)->first();
        $inventarios = \DB::table('inventarios')->get();
        $promociones = \DB::table('promociones')->get();

        // Verificar si el archivo existe antes de asignar la URL
        if ($producto->foto && \Storage::exists('public/' . $producto->foto)) {
            $producto->foto_url = asset('storage/' . $producto->foto);
        } else {
            $producto->foto_url = null;
        }

        return Inertia::render('Productos/Edit', [
            'producto' => $producto,
            'inventarios' => $inventarios,
            'promociones' => $promociones
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
        try {
            $data = [
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'id_inventario' => $request->inventario,
                'id_promocion' => $request->promocion,
                'precio' => $request->precio,
            ];

            if ($request->hasFile('foto')) {
                // Obtener el producto actual para eliminar la foto anterior si existe
                $producto = \DB::table('productos')->where('id', $id)->first();
                if ($producto && $producto->foto) {
                    \Storage::delete('public/' . $producto->foto);
                }

                $path = $request->file('foto')->store('public/images');
                $data['foto'] = str_replace('public/', '', $path);
            }

            \DB::table('productos')->where('id', $id)->update($data);

            return redirect()->route('producto_home')
                ->with('success', 'Producto actualizado con éxito');
        } catch (\Exception $e) {
            \Log::error('Error actualizando producto: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Error al actualizar el producto: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        \DB::table('productos')->where('id', $id)->delete();
        return redirect()->route('producto_home')->with('success', 'Producto eliminado con exito');
    }
}
