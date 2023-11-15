@extends('layouts.panel')

@section('styles')
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
@endsection

@section('content')
    <div class="card shadow">
        <div class="card-header border-0">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="mb-0">Editar Enfermera</h3>
                </div>
                <div class="col text-right">
                    <a href="{{ url('/enfermera') }}" class="btn btn-sm btn-success">
                        <i class="fas fa-chevron-left"></i> Regresar
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>
                                <i class="fas fa-exclamation-triangle"></i> {{ $error }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ url('/enfermera/' . $enfermera->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="usuario">Usuario</label>
                    <input type="text" name="usuario" class="form-control" value="{{ old('usuario', $enfermera->usuario) }}" required>
                </div>
                <div class="form-group">
                    <label for="email">Correo</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $enfermera->email) }}" required>
                </div>

                 <!-- Selector de archivo y visualización de la imagen -->
                 <div class="flex items-center justify-center">
                    <input type="file" id="imagen" name="imagen" accept="image/*" style="display: none;" onchange="mostrarImagenSeleccionada()">
                    <label for="imagen" class="cursor-pointer">
                        Seleccionar Imagen
                    </label>
                    <img id="imagenSeleccionada" src="{{ asset('img/brand/' . $enfermera->imagen) }}" alt="Imagen seleccionada" style="max-width: 70%; max-height: 100px;">
                </div>

                <script>
                    function mostrarImagenSeleccionada() {
                        const inputImagen = document.getElementById('imagen');
                        const imagenSeleccionada = document.getElementById('imagenSeleccionada');

                        if (inputImagen.files && inputImagen.files[0]) {
                            const reader = new FileReader();

                            reader.onload = function (e) {
                                imagenSeleccionada.src = e.target.result;
                            };

                            reader.readAsDataURL(inputImagen.files[0]);
                        }
                    }
                </script>

                <div class="form-group">
                    <label for="nombres">Nombres</label>
                    <input type="text" name="nombres" class="form-control" value="{{ old('nombres', $enfermera->nombres) }}" required>
                </div>
                <div class="form-group">
                    <label for="primerApellido">Primer Apellido</label>
                    <input type="text" name="primerApellido" class="form-control" value="{{ old('primerApellido', $enfermera->primerApellido) }}" required>
                </div>
                <div class="form-group">
                    <label for="segundoApellido">Segundo Apellido</label>
                    <input type="text" name="segundoApellido" class="form-control" value="{{ old('segundoApellido', $enfermera->segundoApellido) }}" required>
                </div>
                <div class="form-group">
                    <label for="ci">Cédula</label>
                    <input type="text" name="ci" class= "form-control" value="{{ old('ci', $enfermera->ci) }}" required>
                </div>
                <div class="form-group">
                    <label for="fechaNacimiento">Fecha de Nacimiento</label>
                    <input type="date" name="fechaNacimiento" class="form-control" value="{{ old('fechaNacimiento', $enfermera->fechaNacimiento) }}" required>
                </div>
                <div class="form-group">
                    <label for="direccion">Dirección</label>
                    <input type="text" name="direccion" class="form-control" value="{{ old('direccion', $enfermera->direccion) }}" required>
                </div>
                <div class="form-group">
                    <label for="celular">Celular</label>
                    <input type="text" name="celular" class="form-control" value="{{ old('celular', $enfermera->celular) }}" required>
                </div>
                <div class="form-group">
                    <label for="sexo">Sexo</label>
                    <select name="sexo" class="form-control">
                        <option value="M"{{ old('sexo', $enfermera->sexo) == 'M' ? ' selected' : '' }}>Masculino</option>
                        <option value="F"{{ old('sexo', $enfermera->sexo) == 'F' ? ' selected' : '' }}>Femenino</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="specialties">Especialidades</label>
                    <select name="specialties[]" id="specialties" class="form-control selectpicker"
                        data-style="btn-primary" title="Seleccionar especialidades" multiple required>
                        @foreach ($specialties as $especialidad)
                            <option value="{{ $especialidad->id }}"{{ in_array($especialidad->id, $enfermera->specialties->pluck('id')->toArray()) ? ' selected' : '' }}>
                                {{ $especialidad->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-sm btn-primary">Guardar Cambios</button>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#specialties').selectpicker();
        });
    </script>
@endsection
