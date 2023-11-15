@extends('layouts.panel')

@section('content')
    <div class="card shadow">
        <div class="card-header border-0">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="mb-0">Editar Paciente</h3>
                </div>
                <div class="col text-right">
                    <a href="{{ url('/paciente') }}" class="btn btn-sm btn-success">
                        <i class="fas fa-chevron-left"></i> Regresar
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger" role="alert">
                        <i class="fas fa-exclamation-triangle"></i> <strong>¡Error!</strong> {{ $error }}
                    </div>
                @endforeach
            @endif
            <form action="{{ url('/paciente/'.$paciente->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="usuario">Usuario</label>
                    <input type="text" name="usuario" class="form-control" value="{{ old('usuario', $paciente->usuario) }}" required>
                </div>
                <div class="form-group">
                    <label for="email">Correo</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $paciente->email) }}" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" name="password" class="form-control">
                </div>
                 <!-- Selector de archivo y visualización de la imagen -->
                 <div class="flex items-center justify-center">
                    <input type="file" id="imagen" name="imagen" accept="image/*" style="display: none;" onchange="mostrarImagenSeleccionada()">
                    <label for="imagen" class="cursor-pointer">
                        Seleccionar Imagen
                    </label>
                    <img id="imagenSeleccionada" src="{{ asset('img/brand/' . $paciente->imagen) }}" alt="Imagen seleccionada" style="max-width: 70%; max-height: 100px;">
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
                    <input type="text" name="nombres" class="form-control" value="{{ old('nombres', $paciente->nombres) }}" required>
                </div>
                <div class="form-group">
                    <label for="primerApellido">Primer Apellido</label>
                    <input type="text" name= "primerApellido" class="form-control" value="{{ old('primerApellido', $paciente->primerApellido) }}" required>
                </div>
                <div class="form-group">
                    <label for="segundoApellido">Segundo Apellido</label>
                    <input type="text" name="segundoApellido" class="form-control" value="{{ old('segundoApellido', $paciente->segundoApellido) }}" required>
                </div>
                <div class="form-group">
                    <label for="ci">Cédula</label>
                    <input type="text" name="ci" class="form-control" value="{{ old('ci', $paciente->ci) }}" required>
                </div>
                <div class="form-group">
                    <label for="fechaNacimiento">Fecha de Nacimiento</label>
                    <input type="date" name="fechaNacimiento" class="form-control" value="{{ old('fechaNacimiento', $paciente->fechaNacimiento) }}" required>
                </div>
                <div class="form-group">
                    <label for="direccion">Dirección</label>
                    <input type="text" name="direccion" class="form-control" value="{{ old('direccion', $paciente->direccion) }}" required>
                </div>
                <div class="form-group">
                    <label for="celular">Celular</label>
                    <input type="text" name="celular" class="form-control" value="{{ old('celular', $paciente->celular) }}" required>
                </div>
                <div class="form-group">
                    <label for="sexo">Sexo</label>
                    <select name="sexo" class="form-control">
                        <option value="M"{{ old('sexo', $paciente->sexo) == 'M' ? ' selected' : '' }}>Masculino</option>
                        <option value="F"{{ old('sexo', $paciente->sexo) == 'F' ? ' selected' : '' }}>Femenino</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-sm btn-primary">Guardar Paciente</button>
            </form>
        </div>
    </div>
@endsection
