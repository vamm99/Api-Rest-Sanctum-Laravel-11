<?php

namespace App\Http\Controllers;

use App\Events\RFIDTagReadEvent;
use App\Models\Customer;
use Illuminate\Http\Request;

class RFIDTagController extends Controller
{
    public $uid;
    //
    public function store(Request $request)
    {

        // Obtiene el UID del ESP32
        $this->uid = $request->input('UIDresult');

        // Busca el UID en la base de datos
        $user = Customer::where('uid', $this->uid)->first();

        if ($user) {
            // Si el UID existe, emite un evento con los datos del usuario
            RFIDTagReadEvent::dispatch($this->uid, $user->toArray());
            return response()->json(['status' => 'success', 'data' => $user]);
        } else {
            // Si el UID no existe, emite un evento indicando que no fue encontrado
            RFIDTagReadEvent::dispatch($this->uid, null);

            return response()->json(['status' => 'error', 'message' => 'UID no registrado']);
        }
    }
}
