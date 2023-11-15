@extends('layouts.panel')

@section('content')
    <div class="card shadow">
        <div class="card-header border-0">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="mb-0">Pacientes</h3>
                </div>
                <div class="col text-right">
                    <a href="{{ url('/paciente/create') }}" class="btn btn-sm btn-primary">Nuevo paciente</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if(session('notification'))
                <div class="alert alert-success" role="alert">
                     {{ session('notification') }}
                </div>
            @endif
        </div>
        <div class="table-responsive">
            <table class="table align-items-center table-flush">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">Foto</th>
                        <th scope="col">Usuario</th>
                        <th scope="col">Correo</th>
                        <th scope="col">Nombres</th>
                        <th scope="col">Primer Apellido</th>
                        <th scope="col">Segundo Apellido</th>
                        <th scope="col">C.I</th>
                        <th scope="col">Fecha de Nacimiento</th>
                        <th scope="col">Dirección</th>
                        <th scope="col">Celular</th>
                        <th scope="col">Sexo</th>
                        <th scope="col">Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pacientes as $paciente)
                        <tr>
                            <td><img src="{{ asset('img/brand/' . $paciente->imagen) }}" alt="Foto" width="50"></td>
                            <th scope="row">{{ $paciente->usuario }}</th>
                            <td>{{ $paciente->email }}</td>
                            <td>{{ $paciente->nombres }}</td>
                            <td>{{ $paciente->primerApellido }}</td>
                            <td>{{ $paciente->segundoApellido }}</td>
                            <td>{{ $paciente->ci }}</td>
                            <td>{{ $paciente->fechaNacimiento }}</td>
                            <td>{{ $paciente->direccion }}</td>
                            <td>{{ $paciente->celular }}</td>
                            <td>{{ $paciente->sexo }}</td>
                            <td>
                                <a href="{{ url('/paciente/'.$paciente->id.'/edit') }}" class="btn btn-sm btn-primary">Editar</a>
                                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal-{{ $paciente->id }}">Eliminar</button>
                            </td>
                        </tr>
                        <!-- Delete Modal -->
                        <div class="modal fade" id="deleteModal-{{ $paciente->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel">Confirmar Eliminación</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        ¿Estás seguro de que deseas eliminar a {{ $paciente->nombres }}?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                        <form action="{{ url('/paciente/'.$paciente->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Eliminar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="12">No se encontraron pacientes.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-body">
            {{ $pacientes->links() }}
        </div>
    </div>
@endsection
