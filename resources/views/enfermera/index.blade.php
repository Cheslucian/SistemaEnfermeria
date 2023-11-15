@extends('layouts.panel')

@section('content')
    <div class="card shadow">
        <div class="card-header border-0">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="mb-0">Enfermeras</h3>
                </div>
                <div class="col text-right">
                    <a href="{{ url('/enfermera/create') }}" class="btn btn-sm btn-primary">Nueva enfermera</a>
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
                        <th scope="col">usuario</th>
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
                    @forelse($enfermeras as $enfermera)
                        <tr>
                            <td><img src="{{ asset('img/brand/' . $enfermera->imagen) }}" alt="Foto" width="50"></td>
                            <th scope="row">{{ $enfermera->usuario }}</th>
                            <td>{{ $enfermera->email }}</td>
                            <td>{{ $enfermera->nombres }}</td>
                            <td>{{ $enfermera->primerApellido }}</td>
                            <td>{{ $enfermera->segundoApellido }}</td>
                            <td>{{ $enfermera->ci }}</td>
                            <td>{{ $enfermera->fechaNacimiento }}</td>
                            <td>{{ $enfermera->direccion }}</td>
                            <td>{{ $enfermera->celular }}</td>
                            <td>{{ $enfermera->sexo }}</td>
                            <td>
                                <a href="{{ url('/enfermera/'.$enfermera->id.'/edit') }}" class="btn btn-sm btn-primary">Editar</a>
                                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal-{{ $enfermera->id }}">Eliminar</button>
                            </td>
                        </tr>
                        <!-- Delete Modal -->
                        <div class="modal fade" id="deleteModal-{{ $enfermera->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel">Confirmar Eliminación</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        ¿Estás seguro de que deseas eliminar a {{ $enfermera->usuario }}?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                        <form action="{{ url('/enfermera/'.$enfermera->id) }}" method="POST">
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
                            <td colspan="12">No se encontraron enfermeras.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-body">
            {{ $enfermeras->links() }}
        </div>
    </div>
@endsection
