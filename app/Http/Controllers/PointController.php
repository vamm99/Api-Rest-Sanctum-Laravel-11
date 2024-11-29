<?php

namespace App\Http\Controllers;

use App\Models\Point;
use Illuminate\Http\Request;

class PointController extends Controller
{

    public function index()
    {
        $spots = Point::pluck('puntos');  // 'name' es el nombre del campo
        return $spots;
    }

    public function update(Request $request)
    {

        // Buscar el primer registro o crear uno nuevo si no existe
        $spot = Point::firstOrCreate(
            [],  // No hay condición, simplemente busca el primer registro disponible
            ['puntos' => 10]  // Si no existe, se crea con el valor de 10 puntos
        );

        // Si el registro ya existe, actualiza el valor de puntos
        $spot->puntos = $request->puntos;
        $spot->save();

        // Devolver una respuesta con el nuevo valor de puntos
        return response()->json([
            'message' => 'Puntos procesados correctamente',
            'puntos' => $spot->puntos
        ]);
    }

    public function prueba()
    {
        return response()->json([
            'message' => 'Hola mundo'
        ]);
    }
}
