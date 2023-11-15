<?php namespace App\Services;

use App\Interfaces\HorarioServiceInterface;
use App\Models\Appointment;
use App\Models\Horarios;
use Carbon\Carbon;

class HorarioService implements HorarioServiceInterface {

    private function getDayFromDate($date){
        $dateCarbon = new Carbon($date);
        $i = $dateCarbon->dayOfWeek;
        $day = ($i==0 ? 6 : $i-1);
        return $day;
    }

    public function isAvailableInterval($date, $enfermeraId, Carbon $start){
        $exists = Appointment::where('enfermera_id', $enfermeraId)
                ->where('scheduled_date', $date)
                ->where('scheduled_time', $start->format('H:i:s'))
                ->exists();

        return !$exists;
    }

    public function getAvailableIntervals($date, $enfermeraId){
        $horario = Horarios::where('active', true)
            ->where('day', $this->getDayFromDate($date))
            ->where('user_id', $enfermeraId)
            ->first([
                'morning_start', 'morning_end',
                'afternoon_start', 'afternoon_end'
            ]);
        if($horario){
            $morningIntervalos = $this->getIntervalos(
                $horario->morning_start, $horario->morning_end, $enfermeraId, $date
            );

            $afternoonIntervalos = $this->getIntervalos(
                $horario->afternoon_start, $horario->afternoon_end, $enfermeraId, $date
            );
        }else {
            $morningIntervalos = [];
            $afternoonIntervalos = [];
        }

        $data = [];
        $data['morning'] =  $morningIntervalos;
        $data['afternoon'] =  $afternoonIntervalos;
        return $data;
    }

    private function getIntervalos($start, $end, $enfermeraId, $date){
        $start = new Carbon($start);
        $end = new Carbon($end);

        $intervalos = [];
        while($start < $end) {
            $intervalo = [];
            $intervalo['start'] = $start->format('g:i A');

            $available = $this->isAvailableInterval($date, $enfermeraId, $start);

            $start->addMinutes(30);
            $intervalo['end'] = $start->format('g:i A');

            if($available){
                $intervalos []= $intervalo;
            }


        }
        return $intervalos;

    }
}
