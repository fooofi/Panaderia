@extends('layouts.base')

@section('sidebar')
@if($admin)
    @include('layouts.sidebars.admin')
@else
    @include('layouts.sidebars.manager')
@endif
@endsection

@section('content')

<div class="container-fluid">
    <div class="fade-in">

        @if($admin)
            <div class="row">
                <div class="col-md-12">
                    <div class="card w-100">
                        <div class="card-body">
                            <h5>Organización</h5>
                            <select class="custom-select" id="organization" name="organization">
                                <option {{ $organization_id ? '' : 'selected' }} value="0">Seleccione una organización</option>
                                @foreach($organizations as $organization)
                                    <option value="{{ $organization->id }}" {{ $organization_id == $organization->id? 'selected' : '' }}>{{ $organization->name }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-md-12">
                @if(count($organizations) == 0)
                    <div class="card">
                        <div class="card-header text-value-lg">
                            Organizationes
                        </div>
                        <div class="card-body">
                            <h4>No has agregado ninguna Organizacion</h4>
                        </div>
                    </div>
                @endif
                @foreach($users as $organization)
                    <div class="card">
                        <div class="card-header text-value-lg">
                            Usuarios de {{ $organization->fantasy_name }}
                            <div class="card-header-actions">
                                <a class="card-header-action btn btn-lg btn-primary" role="button" href="{{ route('users.create', ['organization' => $organization->id]) }}">
                                    <span class="mx-1 my-2">Añadir</span>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-responsive-sm table-hover table-outline">
                                <thead>
                                    <tr>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Apellido</th>
                                        <th scope="col">Rut</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Rol</th>
                                        <th scope="col">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($organization->users as $user)
                                        <tr>
                                            <td scope="row">{{ $user->name }}</td>
                                            <td scope="row">{{ $user->lastname }}</td>
                                            <td scope="row">{{ $user->rut }}</td>
                                            <td scope="row">{{ $user->email }}</td>
                                            <td scope="row">{{ $user->role }}</td>
                                            {{-- <td scope="row">{{ $user-> }}</td> --}}
                                            <td scope="row">
                                                <div class="btn-group" role="group" aria-label="{{ 'User' . $user->id .'Actions' }}">
                                                    <a role="button" class="btn btn-ghost-secondary" href="{{ route('users.show', $user->id) }}" data-toggle="tooltip" data-placement="top" title="Ver usuario">
                                                        <svg class="c-icon">
                                                            <use href="{{ asset('icons/sprites/free.svg#cil-external-link') }}"></use>
                                                        </svg>
                                                    </a>

                                                    <button class="btn btn-ghost-danger" type="button" data-toggle="modal" data-target="{{ '#DeleteUser' . $user->id . 'Modal' }}">
                                                        <svg class="c-icon" data-toggle="tooltip" data-placement="top" title="Eliminar Usuario">
                                                            <use href="{{ asset('icons/sprites/free.svg#cil-x-circle') }}"></use>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>


                                    @endforeach
                                    @if(count($organization->users) == 0)
                                        <tr>
                                            <td colspan="6" class="text-center text-value-lg"> No ha creado ninguna usuario</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            @if(count($users) > 0)
                                <ul class="pagination justify-content-end">
                                    <li class="page-item{{ $users->onFirstPage() ? ' disabled' : '' }} ">
                                        <a class="page-link" href="{{ $users->previousPageUrl() }}" aria-labelledby="Anterior">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                    @for($page=1; $page <= $users->lastPage(); $page++)
                                        <li class="page-item{{ $users->currentPage() == $page ? ' active' : '' }}">
                                            <a class="page-link" href="{{ $users->url($page) }}">{{ $page }}</a>
                                        </li>
                                    @endfor
                                    <li class="page-item{{ $users->currentPage() == $users->lastPage() ? ' disabled' : '' }}">
                                        <a class="page-link" href="{{ $users->nextPageUrl() }}" aria-labelledby="Siguiente">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                </ul>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        @foreach($users as $organizations)
            @foreach($organizations->users as $user)
                <div class="modal fade" id="{{ 'DeleteUser' . $user->id . 'Modal' }}" tabindex="-1" role="dialog" aria-labelledby="{{ 'DeleteUser' . $user->id . 'ModalLabel' }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="{{ 'DeleteUser' . $user->id . 'ModalLabel' }}"> ¿Está seguro de eliminar este usuario?</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body content-center">

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                <form method="POST" action="{{ route('users.delete') }}">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $user->id }}">
                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endforeach
    </div>
</div>
@endsection

@section('javascript')
<script>
    $("#organization").change(function() {
        if ($(this).val() == "0") {
            window.location = window.location.href.split('?')[0]
            return;
        }
        window.location = window.location.href.split('?')[0] + "?organization=" + $(this).val()
    });
</script>
@endsection