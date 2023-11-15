<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAppointment;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function index() {
        $user = Auth::guard('api')->user();
        $appointments = $user->asPatientAppointments()
            ->with(['specialty' => function ($query) {
                $query->select('id', 'nombre');
            }
            , 'enfermera' => function ($query) {
                $query->select('id', 'usuario');
            }
            ])
            ->get([
                "id",
                "scheduled_date",
                "scheduled_time",
                "type",
                "description",
                "enfermera_id",
                "specialty_id",
                "created_at",
                "status"
            ]);
        return $appointments;
    }

    public function store(StoreAppointment $request) {
        $patientId = Auth::guard('api')->id();
        $appointment = Appointment::createForPatient($request, $patientId);

        if($appointment)
            $success = true;
        else
            $success = false;

        return compact('success');
    }
    public function rate($id, Request $request) {
        // Obtener el modelo de la cita por su ID
        $appointment = Appointment::find($id);

        // Verificar si la cita existe
        if (!$appointment) {
            // Manejar el caso en que la cita no existe
            return response()->json(['error' => 'Cita no encontrada'], 404);
        }

        // Verificar si la solicitud contiene una calificación válida
        if ($request->has('rating')) {
            $rating = $request->input('rating');

            // Validar la calificación (ajusta este rango según sea necesario)
            if ($rating >= 0 && $rating <= 5) {
                // Asignar la calificación al modelo de cita
                $appointment->rating = $rating;

                // Guardar el modelo de cita con la calificación
                $appointment->save();

                // Log para verificar que la calificación se guarda correctamente
                \Log::info("Calificación guardada para la cita ID {$appointment->id}: $rating");

                // Respondemos con éxito
                return response()->json(['success' => true]);
            } else {
                // Manejar el caso en que la calificación no es válida
                return response()->json(['error' => 'Calificación no válida'], 400);
            }
        } else {
            // Manejar el caso en que no se proporcionó la calificación en la solicitud
            return response()->json(['error' => 'Calificación no proporcionada en la solicitud'], 400);
        }
    }
}
