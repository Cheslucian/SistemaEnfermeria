<?php
    use Illuminate\Support\Str;
?>

@extends('layouts.panel')

@section('content')

    <div class="card shadow">
        <div class="card-header border-0">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="mb-0">Registrar nueva cita</h3>
                </div>
                <div class="col text-right">
                    <a href="{{ url('/pacientes') }}" class="btn btn-sm btn-success">
                        <i class="fas fa-chevron-left"></i>
                        Regresar</a>
                </div>
            </div>
        </div>

        <div class="card-body">

            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger" role="alert">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Por favor!!</strong> {{ $error }}
                    </div>
                @endforeach
            @endif

            <form action="{{ url('/reservarcitas') }}" method="POST">
                @csrf

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="specialty">Especialidad</label>
                        <select name="specialty_id" id="specialty" class="form-control">
                            <option value="">Seleccionar especialidad</option>

                            @foreach ($specialties as $especialidad)
                                <option value="{{ $especialidad->id }}"
                                    @if(old('specialty_id') == $especialidad->id) selected @endif>
                                    {{ $especialidad->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="enfermera">Enfermera</label>
                        <select name="enfermera_id" id="enfermera" class="form-control" required>
                            @foreach ($enfermeras as $enfermera)
                            <option value="{{ $enfermera->id }}"
                                @if(old('enfermera_id') == $enfermera->id) selected @endif>
                                {{ $enfermera->usuario }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>


                <div class="form-group">
                    <label for="date">Fecha</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                        </div>
                        <input class="form-control datepicker"
                        id="date" name="scheduled_date"
                        placeholder="Seleccionar fecha"
                        type="date" value="{{ old('scheduled_date'), date('Y-m-d') }}"
                        data-date-format="yyyy-mm-dd"
                        data-date-start-date="{{ date('Y-m-d') }}"
                        data-date-end-date="+30d">
                    </div>
                </div>
                <div class="form-group">
                    <label for="hours">Hora de atención</label>
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <h4 class="m-3" id="titleMorning"></h4>
                                <div id="hoursMorning">
                                    @if($intervals)
                                        <h4 class="m-3">En la mañana</h4>
                                        @foreach ($intervals['morning'] as $key => $interval)
                                            <div class="custom-control custom-radio mb-3">
                                            <input type="radio" id="intervalMorning{{ $key }}" name="scheduled_time" value="{{ $interval['start'] }}" class="custom-control-input">
                                            <label class="custom-control-label" for="intervalMorning{{ $key }}">{{ $interval['start'] }} - {{ $interval['end'] }}</label>
                                            </div>
                                        @endforeach
                                    @else
                                        <mark>
                                            <small class="text-warning display-5">
                                                Selecciona una Enfermera y una fecha, para ver las horas.
                                            </small>
                                        </mark>
                                    @endif
                                </div>
                            </div>
                            <div class="col">
                                <h4 class="m-3" id="titleAfternoon"></h4>
                                <div id="hoursAfternoon">
                                    @if($intervals)
                                        <h4 class="m-3">En la tarde</h4>
                                        @foreach ($intervals['afternoon'] as $key => $interval)
                                            <div class="custom-control custom-radio mb-3">
                                            <input type="radio" id="intervalAfternoon{{ $key }}" name="scheduled_time" value="{{ $interval['start'] }}" class="custom-control-input">
                                            <label class="custom-control-label" for="intervalAfternoon{{ $key }}">{{ $interval['start'] }} - {{ $interval['end'] }}</label>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Tipo de consulta</label>
                    <div class="custom-control custom-radio mt-3 mb-3">
                        <input type="radio" id="type1" name="type" class="custom-control-input"
                        @if(old('type') == 'PrimerosAxuilio') checked @endif value="PrimerosAxuilio">
                        <label class="custom-control-label" for="type1">Primeros Axuilio</label>
                    </div>
                    <div class="custom-control custom-radio mb-3">
                        <input type="radio" id="type2" name="type" class="custom-control-input"
                        @if(old('type') == 'Curaciones') checked @endif value="Curaciones">
                        <label class="custom-control-label" for="type2">Curaciones</label>
                    </div>
                    <div class="custom-control custom-radio mb-5">
                        <input type="radio" id="type3" name="type" class="custom-control-input"
                        @if(old('type') == 'Inyectables') checked @endif value="Inyectables">
                        <label class="custom-control-label" for="type3">Inyectables</label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Síntomas</label>
                    <textarea name="description" id="description" type="text" class="form-control"
                    rows="5" placeholder="Descripción breve de sus síntomas..." required></textarea>
                </div>

                <button type="submit" class="btn btn-sm btn-primary">Guardar</button>
            </form>
        </div>

    </div>

@endsection

@section('scripts')

<script src="{{ asset('js/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}} "></script>

<script src="{{ asset('/js/appointments/create.js') }}" >
</script>

@endsection
