<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Log;
use Auth;

class LogAction
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($request->isMethod('post') || $request->isMethod('put') || $request->isMethod('delete')) {
            $action = $request->isMethod('post') ? 'INSERT' : ($request->isMethod('put') ? 'UPDATE' : 'DELETE');
            $table = $request->segment(1); // Suponiendo que el nombre de la tabla está en la URL
            $record_id = $request->route('id'); // Asumiendo que el ID del registro está en la URL
            $executedSQL = ''; // Lógica para obtener la consulta SQL ejecutada
            $reverseSQL = ''; // Lógica para obtener la consulta SQL de reversa

            Log::create([
                'action' => $action,
                'table' => $table,
                'record_id' => $record_id,
                'executedSQL' => $executedSQL,
                'reverseSQL' => $reverseSQL,
                'user_name' => Auth::user()->name ?? 'Usuario no autenticado'
            ]);
        }

        return $response;
    }
}
