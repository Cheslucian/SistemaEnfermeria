<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class PacienteController extends Controller
{
    public function index()
    {
        $pacientes = User::where('estado', 1)->paginate(10);
        return view('paciente.index', compact('pacientes'));
    }

    public function create()
    {
        return view('paciente.create');
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
            'role'=>'patient',
        ]);

         $paciente = new User;
         $paciente->usuario = $request->usuario;
         $paciente->email = $request->email;
         $paciente->password = bcrypt($request->password);
         $paciente->nombres = $request->nombres;
         $paciente->primerApellido = $request->primerApellido;
         $paciente->segundoApellido = $request->segundoApellido;
         $paciente->ci = $request->ci;
         $paciente->fechaNacimiento = $request->fechaNacimiento;
         $paciente->direccion = $request->direccion;
         $paciente->celular = $request->celular;
         $paciente->sexo = $request->sexo;
         $paciente->estado = 1;
         $paciente->role = 'paciente';

         if ($request->hasFile('imagen')) {
            $rutaGuardarImg = 'img/brand';
            $imagenPerfil = date('YmdHis') . "." . $request->file('imagen')->getClientOriginalExtension();
            $request->file('imagen')->move($rutaGuardarImg, $imagenPerfil);
            $paciente->imagen = $imagenPerfil;
        }
        $paciente->save();

        return redirect()->route('paciente.index')->with('notification', 'paciente creada con éxito.');
    }

    public function show($id)
    {
        $paciente = User::find($id);
        return view('paciente.show', compact('paciente'));
    }

    public function edit($id)
    {
        $paciente = User::find($id);
        return view('paciente.edit', compact('paciente'));
    }

    public function update(Request $request, $id)
    {
        $paciente = User::find($id);

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
            $paciente->imagen = $imagenPerfil;
        }

        $paciente->usuario = $request->usuario;
        $paciente->email = $request->email;
        $paciente->nombres = $request->nombres;
        $paciente->primerApellido = $request->primerApellido;
        $paciente->segundoApellido = $request->segundoApellido;
        $paciente->ci = $request->ci;
        $paciente->fechaNacimiento = $request->fechaNacimiento;
        $paciente->direccion = $request->direccion;
        $paciente->celular = $request->celular;
        $paciente->sexo = $request->sexo;
        $paciente->save();

        return redirect()->route('paciente.index')->with('notification', 'paciente actualizada con éxito.');
    }

    public function destroy($id)
    {
        $paciente = User::find($id);
        $paciente->estado = 0;
        $paciente->save();

        return redirect()->route('paciente.index')->with('notification', 'paciente eliminada con éxito.');
    }
}
