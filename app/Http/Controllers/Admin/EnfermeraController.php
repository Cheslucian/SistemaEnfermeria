<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Specialty;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class EnfermeraController extends Controller
{
    public function index()
    {
        $enfermeras = User::where('role', 'enfermera')->where('estado', 1)->paginate(10);
        return view('enfermera.index', compact('enfermeras'));
    }

    public function create()
    {
        $specialties = Specialty::all();
        return view('enfermera.create', compact('specialties'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'usuario' => 'required|string|max:255|regex:/^(?!.*(\S)\1)[A-Za-z0-9\s\-\'\(\)\/\,]+$/',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'imagen' => 'required|image|mimes:jpeg,png,svg|max:1024',
            'nombres' => 'required|string|regex:/^[A-Za-z\s\-\'\(\)\/\,]+$/',
            'primerApellido' => 'required|string|max:80|regex:/^(?!.*(\S)\1)[A-Za-z0-9\s\-\'\(\)\/\,]+$/',
            'segundoApellido' => 'nullable|string|max:80|regex:/^(?!.*(\S)\1)[A-Za-z0-9\s\-\'\(\)\/\,]+$/',
            'ci' => 'required|string|max:15|regex:/^[0-9]+$/',
            'fechaNacimiento' => 'required|date',
            'direccion' => 'required|string|regex:/^[A-Za-z0-9\s\-\'\(\)\/\,.,#]+$/',
            'celular' => 'required|string|max:12|regex:/^[0-9]+$/',
            'sexo' => 'required|string|max:1|in:M,F',
            'role' => 'enfermera',
        ]);

                $enfermera = new User;
                $enfermera->usuario = $request->usuario;
                $enfermera->email = $request->email;
                $enfermera->password = bcrypt($request->password);
                $enfermera->nombres = $request->nombres;
                $enfermera->primerApellido = $request->primerApellido;
                $enfermera->segundoApellido = $request->segundoApellido;
                $enfermera->ci = $request->ci;
                $enfermera->fechaNacimiento = $request->fechaNacimiento;
                $enfermera->direccion = $request->direccion;
                $enfermera->celular = $request->celular;
                $enfermera->sexo = $request->sexo;
                $enfermera->estado = 1;
                $enfermera->role = 'enfermera';
                $enfermera->save();

        if ($request->hasFile('imagen')) {
            $rutaGuardarImg = 'img/brand';
            $imagenPerfil = date('YmdHis') . "." . $request->file('imagen')->getClientOriginalExtension();
            $request->file('imagen')->move($rutaGuardarImg, $imagenPerfil);
            $enfermera->imagen = $imagenPerfil;
        }

        $enfermera->specialties()->attach($request->input('specialties'));

        return redirect()->route('enfermera.index')->with('notification', 'Enfermera creada con éxito.');
    }

    public function show($id)
    {
        $enfermera = User::find($id);
        return view('enfermera.show', compact('enfermera'));
    }

    public function edit($id)
    {
        $enfermera = User::enfermeras()->findOrFail($id);
        $specialties = Specialty::all(); // Corregido: Nombre de variable
        $specialty_ids = $enfermera->specialties()->pluck('specialties.id');

        return view('enfermera.edit', compact('enfermera', 'specialties', 'specialty_ids'));
    }

    public function update(Request $request, $id)
    {
        $enfermera = User::find($id);

        $rules = [
            'usuario' => 'required|string|max:255|regex:/^(?!.*(\S)\1)[A-Za-z0-9\s\-\'\(\)\/\,]+$/',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048|dimensions:min_width=100,min_height=100',
            'nombres' => 'required|string|regex:/^[A-Za-z\s\-\'\(\)\/\,]+$/',
            'primerApellido' => 'required|string|max:80|regex:/^(?!.*(\S)\1)[A-Za-z0-9\s\-\'\(\)\/\,]+$/',
            'segundoApellido' => 'nullable|string|max:80|regex:/^(?!.*(\S)\1)[A-Za-z0-9\s\-\'\(\)\/\,]+$/',
            'ci' => 'required|string|max:15|regex:/^[0-9]+$/',
            'fechaNacimiento' => 'required|date',
            'direccion' => 'required|string|regex:/^[A-Za-z0-9\s\-\'\(\)\/\,.,#]+$/',
            'celular' => 'required|string|max:12|regex:/^[0-9]+$/',
            'sexo' => 'required|string|max:1|in:M,F',
        ];

        if ($request->hasFile('imagen')) {
            $rules['imagen'] = 'required|image|mimes:jpeg,png,jpg,gif';
        }

        $request->validate($rules);

        if ($request->hasFile('imagen')) {
            $rutaGuardarImg = 'img/brand';
            $imagenPerfil = date('YmdHis'). "." . $request->file('imagen')->getClientOriginalExtension();
            $request->file('imagen')->move($rutaGuardarImg, $imagenPerfil);
            $enfermera->imagen = $imagenPerfil;
        }

        $enfermera->usuario = $request->usuario;
        $enfermera->email = $request->email;
        $enfermera->nombres = $request->nombres;
        $enfermera->primerApellido = $request->primerApellido;
        $enfermera->segundoApellido = $request->segundoApellido;
        $enfermera->ci = $request->ci;
        $enfermera->fechaNacimiento = $request->fechaNacimiento;
        $enfermera->direccion = $request->direccion;
        $enfermera->celular = $request->celular;
        $enfermera->sexo = $request->sexo;

        $enfermera->save();

        // Actualiza las especialidades
        $enfermera->specialties()->sync($request->input('specialties'));

        return redirect()->route('enfermera.index')->with('notification', 'Enfermera actualizada con éxito.');
    }

    public function destroy($id)
    {

        $enfermera = User::find($id);
        if ($enfermera->imagen) {
            Storage::delete($enfermera->imagen);
        }
        $enfermera->estado = 0;
        $enfermera->save();


        return redirect()->route('enfermera.index')->with('notification', 'Enfermera eliminada con éxito.');
    }
}
