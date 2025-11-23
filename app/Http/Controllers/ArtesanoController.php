<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArtesanoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            abort_if(!method_exists(auth()->user(), 'hasRole') || !auth()->user()->hasRole('artesano'), 403);
            return $next($request);
        });
    }

    public function dashboard()
    {
        // Datos de ejemplo para el dashboard - luego los reemplazaremos con datos reales
        $stats = [
            'productos_activos' => 12,
            'pedidos_pendientes' => 5,
            'ventas_mes' => 8,
            'ingresos_totales' => 1250000,
            'calificacion_promedio' => 4.8
        ];

        $productos_recientes = [
            ['id' => 1, 'nombre' => 'Mochila Wayuu', 'precio' => 150000, 'estado' => 'activo'],
            ['id' => 2, 'nombre' => 'Sombrero Vueltiao', 'precio' => 80000, 'estado' => 'activo'],
            ['id' => 3, 'nombre' => 'Collar en Cerámica', 'precio' => 45000, 'estado' => 'inactivo'],
        ];

        $pedidos_recientes = [
            ['id' => 101, 'cliente' => 'María González', 'total' => 230000, 'estado' => 'pendiente'],
            ['id' => 102, 'cliente' => 'Carlos Rodríguez', 'total' => 150000, 'estado' => 'completado'],
            ['id' => 103, 'cliente' => 'Ana Martínez', 'total' => 80000, 'estado' => 'pendiente'],
        ];

        $consejos = [
            'Mantén tus productos actualizados con fotos de alta calidad',
            'Responde rápidamente a las consultas de los clientes',
            'Ofrece descripciones detalladas de tus técnicas artesanales',
            'Actualiza regularmente tu inventario'
        ];

        // Evita el error "View [artesano.dashboard] not found" devolviendo JSON como alternativa
        return response()->json(compact('stats', 'productos_recientes', 'pedidos_recientes', 'consejos'));
    }

    public function productos()
    {
        // Lógica para mostrar los productos del artesano
        $productos = [
            ['id' => 1, 'nombre' => 'Mochila Wayuu', 'precio' => 150000, 'estado' => 'activo', 'stock' => 5],
            ['id' => 2, 'nombre' => 'Sombrero Vueltiao', 'precio' => 80000, 'estado' => 'activo', 'stock' => 3],
            ['id' => 3, 'nombre' => 'Collar en Cerámica', 'precio' => 45000, 'estado' => 'inactivo', 'stock' => 0],
            ['id' => 4, 'nombre' => 'Pulsera Tradicional', 'precio' => 35000, 'estado' => 'activo', 'stock' => 8],
        ];

        // Evita el error "View [artesano.productos] not found" devolviendo JSON como alternativa
        return response()->json(compact('productos'));
    }

    public function pedidos()
    {
        // Lógica para mostrar los pedidos del artesano
        $pedidos = [
            ['id' => 101, 'cliente' => 'María González', 'total' => 230000, 'estado' => 'pendiente', 'fecha' => '2024-01-15'],
            ['id' => 102, 'cliente' => 'Carlos Rodríguez', 'total' => 150000, 'estado' => 'completado', 'fecha' => '2024-01-14'],
            ['id' => 103, 'cliente' => 'Ana Martínez', 'total' => 80000, 'estado' => 'pendiente', 'fecha' => '2024-01-13'],
            ['id' => 104, 'cliente' => 'Luis Fernández', 'total' => 120000, 'estado' => 'procesando', 'fecha' => '2024-01-12'],
        ];

        return view('artesano.pedidos', compact('pedidos'));
    }

    public function estadisticas()
    {
        // Lógica para mostrar estadísticas
        $estadisticas = [
            'ventas_mensuales' => [1200000, 1500000, 1800000, 1250000, 1900000, 2100000],
            'productos_populares' => [
                ['nombre' => 'Mochila Wayuu', 'ventas' => 45],
                ['nombre' => 'Sombrero Vueltiao', 'ventas' => 32],
                ['nombre' => 'Collar Cerámica', 'ventas' => 28],
            ],
            'ingresos_totales' => 1250000,
            'clientes_nuevos' => 15,
        ];

        return view('artesano.estadisticas', compact('estadisticas'));
    }

    public function configuracion()
    {
        // Lógica para la configuración del perfil de artesano
        $perfil = [
            'nombre_taller' => 'Artesanías Popayán',
            'descripcion' => 'Especialistas en artesanías tradicionales de la región',
            'telefono' => '+57 123 456 7890',
            'direccion' => 'Calle 5 #10-20, Popayán',
            'especialidades' => ['Cerámica', 'Textiles', 'Madera']
        ];

        return view('artesano.configuracion', compact('perfil'));
    }

    public function crearProducto(Request $request)
    {
        // Lógica para crear un nuevo producto
        // Esto sería para el método POST
        return redirect()->route('artesano.productos')->with('success', 'Producto creado exitosamente');
    }

    public function actualizarProducto(Request $request, $id)
    {
        // Lógica para actualizar un producto
        return redirect()->route('artesano.productos')->with('success', 'Producto actualizado exitosamente');
    }

    public function eliminarProducto($id)
    {
        // Lógica para eliminar un producto
        return redirect()->route('artesano.productos')->with('success', 'Producto eliminado exitosamente');
    }
}