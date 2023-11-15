<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppointment;
use App\Interfaces\HorarioServiceInterface;
use App\Models\Appointment;
use App\Models\CancelledAppointment;
use App\Models\Specialty;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{

    public function index(){

        $role = auth()->user()->role;

        if($role == 'admin'){
            //Admin
            $confirmedAppointments = Appointment::all()
            ->where('status', 'Confirmada');
            $pendingAppointments = Appointment::all()
            ->where('status', 'Reservada');
            $oldAppointments = Appointment::all()
            ->whereIn('status', ['Atendida','Cancelada']);
        }elseif($role == 'enfermera'){
            //Enfermera
            $confirmedAppointments = Appointment::all()
            ->where('status', 'Confirmada')
            ->where('enfermera_id', auth()->id());
            $pendingAppointments = Appointment::all()
            ->where('status', 'Reservada')
            ->where('enfermera_id', auth()->id());
            $oldAppointments = Appointment::all()
            ->whereIn('status', ['Atendida','Cancelada'])
            ->where('enfermera_id', auth()->id());
        }elseif($role == 'paciente'){
            //Pacientes
            $confirmedAppointments = Appointment::all()
            ->where('status', 'Confirmada')
            ->where('patient_id', auth()->id());
            $pendingAppointments = Appointment::all()
            ->where('status', 'Reservada')
            ->where('patient_id', auth()->id());
            $oldAppointments = Appointment::all()
            ->whereIn('status', ['Atendida','Cancelada'])
            ->where('patient_id', auth()->id());
        }


        return view('appointments.index',
        compact('confirmedAppointments', 'pendingAppointments', 'oldAppointments', 'role') );
    }

    public function create(HorarioServiceInterface $horarioServiceInterface) {
        $specialties = Specialty::all();

        $specialtyId = old('specialty_id');
        if ($specialtyId) {
            $specialty = Specialty::find($specialtyId);
            $enfermeras = $specialty->users;
        } else {
            $enfermeras = collect();
        }

        $date = old('scheduled_date');
        $enfermeraId = old('enfermera_id');
        if ($date && $enfermeraId) {
            $intervals = $horarioServiceInterface->getAvailableIntervals($date, $enfermeraId);
        }else {
            $intervals = null;
        }

        return view('appointments.create', compact('specialties', 'enfermeras', 'intervals'));
    }

    public function store(StoreAppointment $request, HorarioServiceInterface $horarioServiceInterface) {

        $created = Appointment::createForPatient($request, auth()->id());

        if($created)
            $notification = 'La cita se ha realizado correctamente.';
        else
            $notification = 'Error al resgistrar la cita médica.';

        return redirect('/miscitas')->with(compact('notification'));
    }

    public function cancel(Appointment $appointment, Request $request) {

        if($request->has('justification')){
            $cancellation = new CancelledAppointment();
            $cancellation->justification = $request->input('justification');
            $cancellation->cancelled_by_id = auth()->id();

            $saved = $appointment->cancellation()->save($cancellation);
            $nameEnfermera = $appointment->enfermera->usuario;
            $dateAppointment = $appointment->scheduled_date;
            $timeAppointment = $appointment->scheduled_time_12;

            if ($saved)
                $appointment->patient->sendFCM("Su cita médica con el médico: $nameEnfermera, para la fecha: $dateAppointment a las $timeAppointment fue cancelada.");
        }

        $appointment->status = 'Cancelada';
        $appointment->save();
        $notification = 'La cita se ha cancelado correctamente.';

        return redirect('/miscitas')->with(compact('notification'));
    }

    public function confirm(Appointment $appointment) {

        $appointment->status = 'Confirmada';
        $saved = $appointment->save();
        $nameEnfermera = $appointment->enfermera->usuario;
        $dateAppointment = $appointment->scheduled_date;
        $timeAppointment = $appointment->scheduled_time_12;

        if ($saved)
            $appointment->patient->sendFCM("Su cita médica con el médico: $nameEnfermera, para la fecha: $dateAppointment a las $timeAppointment fue confirmada.");

        $notification = 'La cita se ha confirmado correctamente.';

        return redirect('/miscitas')->with(compact('notification'));
    }

    public function formCancel(Appointment $appointment) {
        if($appointment->status == 'Confirmada' || 'Reservada'){
            $role = auth()->user()->role;
            return view('appointments.cancel', compact('appointment', 'role'));
        }
        return redirect('/miscitas');

    }

    public function show(Appointment $appointment){
        $role = auth()->user()->role;
        return view('appointments.show', compact('appointment', 'role'));
    }

    public function generatePDF(Appointment $appointment)
        {
            $data = [
                'title' => 'Informe de Cita Médica',
                'appointment' => $appointment,
            ];

            $pdf = PDF::loadView('reports.appointment', $data);

            return $pdf->download('informe_cita.pdf');
        }

    public function generarReporte()
    {
        $citas = DB::table('appointments AS a')
            ->join('users AS enf', 'a.enfermera_id', '=', 'enf.id')
            ->join('users AS pac', 'a.patient_id', '=', 'pac.id')
            ->select(
                'scheduled_date',
                'scheduled_time',
                'type',
                'description',
                'enf.nombres AS nomEnfermera',
                'enf.primerApellido AS ap1Enfermera',
                'enf.segundoApellido AS ap2Enfermera',
                'pac.nombres AS nomPaciente',
                'pac.primerApellido AS ap1Paciente',
                'pac.segundoApellido AS ap2Paciente',
                'status'
            )
            ->get();

        $pdf = PDF::loadView('appointments.report', compact('citas'));

        if ($pdf) {
            return $pdf->stream('citas.pdf');
        } else {
            // Manejo de error
            return response()->json(['error' => 'Error al generar el informe'], 500);
        }
    }
}

