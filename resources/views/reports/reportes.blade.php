@extends('layouts.panel')

@section('content')
    <div class="card shadow">
        <div class="card-header border-0">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="mb-0">Generar Reportes</h3>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-8">
                    <form id="reporte-form" name="reporte-form" method="GET" action="{{ route('reportes.index') }}" class="form-inline">
                        @csrf
                        <div class="form-group">
                            <label for="fecha_inicio" class="mr-2">Fecha de inicio:</label>
                            <input type="date" name="fecha_inicio" class="form-control "id="fecha_inicio" required>
                        </div>

                        <div class="form-group ml-2">
                            <label for="fecha_fin" class="mr-2">Fecha de fin:</label>
                            <input type="date" name="fecha_fin" class="form-control" id="fecha_fin" required>
                        </div>

                        <div class="form-group ml-2">
                            <label for="search" class="mr-2">Buscar:</label>
                            <input type="text" id="search" class="form-control" placeholder="Buscar...">
                        </div>
                        <button type="submit" class="btn btn-primary ml-2">Generar Reporte</button>
                        <input type="submit" class="btn btn-success" value="Descargar" id="descargar" name="descargar" />

                    </form>
                </div>

            <!-- Espacio para mostrar los resultados en una tabla -->
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th># Cita</th>
                            <th>Enfermera</th>
                            <th>Especialidad</th>
                            <th>Paciente</th>
                            <th>Síntomas</th>
                            <th>Tipo de consulta</th>
                            <th>Fecha de Cita</th>
                            <th>Hora de Cita</th>
                            <th>Estado</th>
                            <!-- Agrega más columnas según la información que desees mostrar -->
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Aquí va el cuerpo de la tabla, si tienes datos para mostrar -->
                        @forelse ($resultados as $cita)
                            <tr>
                                <td>{{ $cita->id }}</td>
                                <td>{{ $cita->enfermera->usuario }}</td>
                                <td>{{ $cita->specialty->nombre }}</td>
                                <td>{{ $cita->patient->usuario }}</td>
                                <td>{{ $cita->description }}</td>
                                <td>{{ $cita->type }}</td>
                                <td>{{ $cita->scheduled_date }}</td>
                                <td>{{ $cita->getScheduledTime12Attribute() }}</td>
                                <td>{{ $cita->status}}</td>
                                <!-- Agrega más celdas según la información que desees mostrar -->
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">No hay resultados para mostrar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $resultados->links() }}
            <!-- Espacio para mostrar los resultados de búsqueda -->
            <div id="search-results">
                <!-- Aquí se mostrarán los resultados de búsqueda -->
                <h4>Resultados de la búsqueda:</h4>
                <!-- Puedes utilizar un bucle para mostrar los resultados -->
                <!-- Ejemplo: -->
                <ul>
                    <td>{{ $cita->id }}</td>
                    <td>{{ $cita->enfermera->usuario }}</td>
                    <td>{{ $cita->type }}</td>
                </ul>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/report/reportes.js') }}"></script>

@endsection

