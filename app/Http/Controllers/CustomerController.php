<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    

    public function index(Request $request)
    {
        // Validar que el filtro sea opcional pero, si está presente, siga el formato correcto
        $validatedData = $request->validate([
            'mes' => 'nullable|date_format:Y-m', // Formato "Año-Mes" (YYYY-MM)
        ]);

        // Obtener el filtro o usar el mes actual si no se proporciona
        $mesFiltro = $validatedData['mes'] ?? now()->format('Y-m');

        // Calcular rango de fechas del mes
        $inicioMes = Carbon::createFromFormat('Y-m', $mesFiltro)->startOfMonth();
        $finMes = Carbon::createFromFormat('Y-m', $mesFiltro)->endOfMonth();

        // Obtener usuarios en el rango
        $users = Customer::whereBetween('created_at', [$inicioMes, $finMes])
            ->paginate(10);

        return response()->json($users);
    }




    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'uid' => 'required|string|unique:customers',
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'cc' => 'required|string|max:20',
            'telefono' => 'required|string|max:20',
            'email' => 'required|email|unique:customers',
            'saldo_acumulado' => 'nullable|numeric|min:0',
        ]);

        $user = Customer::create([
            'uid' => $validatedData['uid'],
            'nombre' => $validatedData['nombre'],
            'apellido' => $validatedData['apellido'],
            'cc' => $validatedData['cc'],
            'telefono' => $validatedData['telefono'],
            'email' => $validatedData['email'],
            'saldo_acumulado' => $validatedData['saldo_acumulado'] ?? 0,
        ]);

        return response()->json(['message' => 'Usuario creado exitosamente.', 'user' => $user], 201);
    }

    public function filterByCC(Request $request)
    {
        $validatedData = $request->validate([
            'cc' => 'required|string|max:20',
        ]);

        $user = Customer::where('cc', $validatedData['cc'])->first();

        if ($user) {
            return response()->json($user);
        } else {
            return response()->json(['message' => 'Usuario no encontrado.'], 404);
        }
    }

    public function filterByUID(Request $request)
    {
        $validatedData = $request->validate([
            'uid' => 'required|string',
        ]);

        $user = Customer::where('uid', $validatedData['uid'])->first();

        if ($user) {
            return response()->json($user);
        } else {
            return response()->json(['message' => 'Usuario no encontrado.'], 404);
        }
    }

    public function update(Request $request, $cc)
    {
        // Buscar el usuario por "cc"
        $user = Customer::where('cc', $cc)->firstOrFail();

        // Validar los datos recibidos
        $validatedData = $request->validate([
            'uid' => 'required|string|unique:customers,uid,' . $user->id, // Validar el UID pero excluir el actual usuario
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'cc' => 'required|string|max:20', // Puedes quitar esta validación si no quieres actualizar el "cc"
            'telefono' => 'required|string|max:20',
            'email' => 'required|email|unique:customers,email,' . $user->id, // Validar el email pero excluir el actual usuario
            'saldo_acumulado' => 'nullable|numeric|min:0',
        ]);

        // Actualizar los datos del usuario
        $user->update($validatedData);

        // Retornar una respuesta exitosa
        return response()->json(['message' => 'Usuario actualizado exitosamente.', 'user' => $user]);
    }

   

    public function updateSaldoAcumulado(Request $request, $uid)
    {
        // Validar el saldo adicional
        $validatedData = $request->validate([
            'saldo_adicional' => 'required|numeric',
        ]);

        // Buscar al usuario por UID
        $user = Customer::where('uid', $uid)->first();

        // Verificar que el usuario exista
        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado.'], 404);
        }

        // Calcular el nuevo saldo acumulado
        $nuevoSaldo = $user->saldo_acumulado + $validatedData['saldo_adicional'];

        // Validar que el saldo no sea negativo (opcional, según tus reglas de negocio)
        if ($nuevoSaldo < 0) {
            return response()->json(['message' => 'los puntos no puede ser negativo.'], 400);
        }

        // Actualizar el saldo acumulado
        $user->saldo_acumulado = $nuevoSaldo;

        // Guardar los cambios
        $user->save();

        // Retornar la respuesta con el nuevo saldo
        return response()->json([
            'message' => 'Puntos actualizado exitosamente.',
            'saldo_acumulado' => $user->saldo_acumulado,
        ]);
    }


    public function searchByUIDOrCC(Request $request)
    {
        // Validamos el input
        $validatedData = $request->validate([
            'query' => 'required|string',
        ]);

        $query = $validatedData['query'];

        // Buscamos por UID o por CC
        $user = Customer::where('uid', $query)
            ->orWhere('cc', $query)
            ->first();

        // Verificamos si se encontró el usuario
        if ($user) {
            return response()->json($user);
        } else {
            return response()->json(['message' => 'Usuario no encontrado.'], 404);
        }
    }

    public function destroy($id)
    {
        $user = Customer::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Usuario eliminado exitosamente.');
    }
}
