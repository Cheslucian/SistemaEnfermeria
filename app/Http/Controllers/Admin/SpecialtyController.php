<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Specialty;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;


class SpecialtyController extends Controller
{
    public function index()
    {
        $specialties = Specialty::where('estado', 1)->get();
        return view('specialties.index', compact('specialties'));
    }

    public function create()
    {
        return view('specialties.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:255',
                Rule::unique('specialties')->where(function ($query) {
                    return $query->where('estado', 1);
                }),
                'regex:/^[a-zA-Z0-9]+$/',
                'not_regex:/\s/',
                'not_regex:/[!@#$%^&*()_+|~=`{}\[\]:";\'<>?,.\/\\-]/',
                'no_repeated_characters',
            ],
            'descripcion' => 'nullable|string',
        ]);

        $specialty = new Specialty;
        $specialty->nombre = $request->nombre;
        $specialty->descripcion = $request->descripcion;
        $specialty->estado = 1;
        $specialty->save();

        return redirect()->route('specialties.index')->with('success', 'Especialidad creada con éxito.');
    }

    public function edit($id)
    {
        $specialty = Specialty::find($id);
        return view('specialties.edit', compact('specialty'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:255',
                Rule::unique('specialties')->ignore($id)->where(function ($query) {
                    return $query->where('estado', 1);
                }),
                'regex:/^[a-zA-Z0-9]+$/',
                'not_regex:/\s/',
                'not_regex:/[!@#$%^&*()_+|~=`{}\[\]:";\'<>?,.\/\\-]/',
                'no_repeated_characters',
            ],
            'descripcion' => 'nullable|string',
        ]);

        $specialty = Specialty::find($id);
        $specialty->nombre = $request->nombre;
        $specialty->descripcion = $request->descripcion;
        $specialty->save();

        return redirect()->route('specialties.index')->with('success', 'Especialidad actualizada con éxito.');
    }

    public function destroy($id)
    {
        $specialty = Specialty::find($id);
        $specialty->estado = 0;
        $specialty->save();

        return redirect()->route('specialties.index')->with('success', 'Especialidad eliminada con éxito.');
    }


}
