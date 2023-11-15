<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\HorarioServiceInterface;
use App\Models\Horarios;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    public function hours(Request $request, HorarioServiceInterface $horarioServiceInterface){

        $rules = [
            'date' => 'required|date_format:"Y-m-d"',
            'enfermera_id' => 'required|exists:users,id'
        ];
        $this->validate($request, $rules);

        $date = $request->input('date');
        $enfermeraId = $request->input('enfermera_id');

        return $horarioServiceInterface->getAvailableIntervals($date, $enfermeraId);
    }


}
