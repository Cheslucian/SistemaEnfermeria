<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PDF;


class ReportesController extends Controller
{
    public function index(Request $request){
            $fechaInicio = $request->input('fecha_inicio');
            $fechaFin = $request->input('fecha_fin');
            $search = $request->input('search');
            $download = $request->input('descargar');

            $query = Appointment::query();

            if ($fechaInicio && $fechaFin) {
                $query->whereBetween('scheduled_date', [$fechaInicio, $fechaFin]);
            }

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('enfermera_id', 'like', "%$search%")
                        ->orWhere('patient_id', 'like', "%$search%")
                        ->orWhere('specialty_id', 'like', "%$search%")
                        ->orWhere('type', 'like', "%$search%")
                        ->orWhere('status', 'like', "%$search%")
                        ->orWhere('description', 'like', "%$search%");
                });
            }

            // Agrega paginación y especifica que deseas 10 resultados por página
            $resultados = $query->orderBy('scheduled_date')->paginate(10);

            if($download){
                $pdf = PDF::loadView('reports.pdf', compact('resultados'));

                $pdfName = 'reporte_' . now()->format('YmdHis') . '.pdf';

                return $pdf->download($pdfName);
            }

            return view('reports.reportes', compact('resultados'));


        }

}
