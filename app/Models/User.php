<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'usuario',
        'email',
        'password',
        'imagen',
        'nombres',
        'primerApellido',
        'segundoApellido',
        'ci',
        'fechaNacimiento',
        'direccion',
        'celular',
        'sexo',
        'role'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'pivot'
    ];

    public static $rules = [
        'usuario' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
    ];

    public static function createPatient(array $data) {
        return self::create(
            [
                'usuario' => $data['usuario'],
                'email' => $data['email'],
                'role' => 'paciente',
                'password' => Hash::make($data['password']),

            ]
        );
    }

    public function specialties(){
        return $this->belongsToMany(Specialty::class)->withTimestamps();
    }

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopePatients($query){
        return $query->where('role', 'paciente');
    }
    public function scopeEnfermeras($query){
        return $query->where('role', 'enfermera');
    }

    public function asEnfermeraAppointments(){
        return $this->hasMany(Appointment::class, 'enfermera_id');
    }
    public function attendedAppointments(){
        return $this->asEnfermeraAppointments()->where('status', 'Atendida');
    }
    public function cancellAppointments(){
        return $this->asEnfermeraAppointments()->where('status', 'Cancelada');
    }

    public function asPatientAppointments(){
        return $this->hasMany(Appointment::class, 'patient_id');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function sendFCM($message) {
        return fcm()
        ->to([
            $this->device_token
        ])
        ->priority('high')
        ->timeToLive(0)
        ->notification([
            'title' => config('app.name'),
            'body' => $message,
        ])
        ->send();
    }

}
