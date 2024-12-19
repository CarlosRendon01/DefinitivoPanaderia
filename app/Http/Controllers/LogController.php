<?php

namespace App\Http\Controllers;
use Carbon\Carbon;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LogController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver-log')->only('index');
    }

    public function index()
    {
        $logs = DB::table('logs')
            ->select('id',  DB::raw('DATE_FORMAT(created_at, "%d de %M de %Y - %H:%i:%s") as formatted_date'), 'action', 'table', 'record_id', 'executedSQL', 'reverseSQL', 'user_name')
            ->orderBy('created_at', 'desc')
            ->paginate(30); // Ajusta el número de registros por página como prefieras
            date_default_timezone_set('America/Mexico_City');
        return view('logs.index', compact('logs'));
        
    }
}