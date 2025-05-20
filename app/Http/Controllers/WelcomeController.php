<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Venta;
use App\Models\Cliente;

class WelcomeController extends Controller
{
    public function index()
{
    // Sumar la cantidad total de productos disponibles
    $totalProductos = Producto::where('estado', 'disponible')->sum('stock');

    // Contar la cantidad total de ventas registradas
    $totalVentas = Venta::count();

    // Contar la cantidad total de clientes registrados
    $totalClientes = Cliente::count();

    // Contar la cantidad de productos agotados (stock = 0)
    $totalProductosAgotados = Producto::where('stock', 0)->count();

    // Obtener productos con bajo stock (3 o menos unidades)
    $productosBajoStock = Producto::where('stock', '<=', 3)->get();

    // Obtener los productos más vendidos (top 5)
    $productosMasVendidos = Producto::whereHas('ventas') // Solo productos con ventas
        ->withCount('ventas') // Contar el número de ventas
        ->orderByDesc('ventas_count') // Ordenar por número de ventas (descendente)
        ->take(5) // Limitar a los 5 más vendidos
        ->get();

    // Pasar las variables a la vista
    return view('welcome', compact(
        'totalProductos',
        'totalVentas',
        'totalClientes',
        'totalProductosAgotados',
        'productosBajoStock',
        'productosMasVendidos'
    ));
}
}