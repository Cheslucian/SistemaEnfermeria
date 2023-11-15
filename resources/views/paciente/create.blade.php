@extends('layouts.panel')

@section('content')
    <div class="card shadow">
        <div class="card-header border-0">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="mb-0">Nuevo Paciente</h3>
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
            @if(session('success'))
                <div class="alert alert-success" role="alert">
                     <i class="fas fa-check"></i> <strong>¡Éxito!</strong> {{ session('success') }}
                </div>
            @endif
            <form action="{{ url('/paciente') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="usuario">Usuario</label>
                    <input type="text" name="usuario" class="form-control" value="{{ old('usuario') }}" required>
                </div>
                <div class="form-group">
                    <label for="email">Correo</label>
                    <input type="email" name="email" class= "form-control" value="{{ old('email') }}" required>
                </div>
                <div class="flex items-center justify-center">
                    <input type="file" id="imagen" name="imagen" accept="image/*" style="display: none;" onchange="mostrarImagenSeleccionada()">
                    <label for="imagen" class="cursor-pointer">
                        Seleccionar Imagen
                    </label>
                    <img id="imagenSeleccionada" src="" alt="Imagen seleccionada" style="max-width: 70%; max-height: 100px; display: none;">
                </div>

                <script>
                    function mostrarImagenSeleccionada() {
                        const inputImagen = document.getElementById('imagen');
                        const imagenSeleccionada = document.getElementById('imagenSeleccionada');

                        if (inputImagen.files && inputImagen.files[0]) {
                            const reader = new FileReader();

                            reader.onload = function (e) {
                                imagenSeleccionada.src = e.target.result;
                                imagenSeleccionada.style.display = 'block';
                            };

                            reader.readAsDataURL(inputImagen.files[0]);
                        }
                    }
                </script>
                <div class="form-group">
                    <label for="nombres">Nombres</label>
                    <input type="text" name="nombres" class="form-control" value="{{ old('nombres') }}" required>
                </div>
                <div class="form-group">
                    <label for="primerApellido">Primer Apellido</label>
                    <input type="text" name="primerApellido" class="form-control" value="{{ old('primerApellido') }}" required>
                </div>
                <div class="form-group">
                    <label for="segundoApellido">Segundo Apellido</label>
                    <input type="text" name="segundoApellido" class="form-control" value="{{ old('segundoApellido') }}" required>
                </div>
                <div class="form-group">
                    <label for="ci">Cédula</label>
                    <input type="text" name="ci" class="form-control" value="{{ old('ci') }}" required>
                </div>
                <div class="form-group">
                    <label for="fechaNacimiento">Fecha de Nacimiento</label>
                    <input type="date" name="fechaNacimiento" class="form-control" value="{{ old('fechaNacimiento') }}" required>
                </div>
                <div class="form-group">
                    <label for="direccion">Dirección</label>
                    <input type="text" name="direccion" class="form-control" value="{{ old('direccion') }}" required>
                </div>
                <div class="form-group">
                    <label for="celular">Celular</label>
                    <input type="text" name="celular" class="form-control" value="{{ old('celular') }}" required>
                </div>
                <div class="form-group">
                    <label for="sexo">Sexo</label>
                    <select name="sexo" class="form-control">
                        <option value="M"{{ old('sexo') == 'M' ? ' selected' : '' }}>Masculino</option>
                        <option value="F"{{ old('sexo') == 'F' ? ' selected' : '' }}>Femenino</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-sm btn-primary">Crear Paciente</button>
            </form>
        </div>
    </div>
@endsection
