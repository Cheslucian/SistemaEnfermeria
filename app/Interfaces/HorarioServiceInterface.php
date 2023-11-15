<?php namespace App\Interfaces;

use Carbon\Carbon;

interface HorarioServiceInterface {
    public function isAvailableInterval($date, $enfermeraId, Carbon $start);
    public function getAvailableIntervals($date, $enfermeraId);
}
