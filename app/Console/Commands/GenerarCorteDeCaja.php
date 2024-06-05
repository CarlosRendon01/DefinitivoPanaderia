<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Venta;
use PDF;
use Carbon\Carbon;

class GenerarCorteDeCaja extends Command
{
    protected $signature = 'reporte:corte-de-caja';
    protected $description = 'Genera el reporte de corte de caja del día y lo descarga';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $fechaHoy = Carbon::today();
        $ventasDelDia = Venta::with('productos')->whereDate('created_at', $fechaHoy)->get();
        $totalVentas = $ventasDelDia->sum('total');
        $montoInicial = 500; // Ajusta esto según tus necesidades
        $totalConInicial = $totalVentas + $montoInicial;
        $totalGanancia = $totalVentas / 3;

        $pdf = PDF::loadView('ventas.corteDeCaja', compact('totalVentas', 'totalGanancia', 'ventasDelDia', 'totalConInicial', 'montoInicial'));

        $directory = 'C:\Users\ANGEN\OneDrive\Escritorio\Cortes'; // Cambia esto por la ruta absoluta deseada
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true); // Crear la carpeta si no existe
        }

        $filePath = $directory . '/corte-de-caja-' . $fechaHoy->format('Y-m-d') . '.pdf';
        $pdf->save($filePath);
        
        $this->info('Corte de caja generado y guardado en ' . $filePath);
    }
}
