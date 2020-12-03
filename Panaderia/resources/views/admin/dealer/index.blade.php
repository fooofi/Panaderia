@extends('layouts.base')

@section('sidebar')
@include('layouts.sidebars.admin')
@endsection

@section('content')
<div class="container-fluid">
    <div class="fade-in">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-value-lg">
                        Repartidores
                        <div class="card-header-actions">
                            <a class="card-header-action btn btn-lg btn-primary" role="button" href="{{ route('admin.dealer.create') }}">
                                <svg class="c-icon mx-1 my-1">
                                    <use href="{{ asset('icons/sprites/free.svg#cil-plus') }}"></use>
                                </svg>
                                <span class="mr-2">Nuevo</span>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-responsive-sm table-hover table-outline">
                            <thead>
                                <tr>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Rut</th>
                                    <th scope="col">Telefono</th>
                                    <th scope="col">Correo</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dealers as $dealer)
                                    <tr>
                                        <td scope="row">{{ $dealer->name . $dealer->lastname }}</td>
                                        <td scope="row">{{ $dealer->rut }}</td>
                                        <td scope="row">{{ $dealer->phone }}</td>
                                        <td scope="row">{{ $dealer->email }}</td>
                                        
                                        <td scope="row">
                                            <div class="btn-group" role="group" aria-label="">
                                                <a role="button" class="btn btn-ghost-secondary" href="#" data-toggle="tooltip" data-placement="top" title="Editar produccion">
                                                    <svg class="c-icon">
                                                        <use href="{{ asset('icons/sprites/free.svg#cil-external-link') }}"></use>
                                                    </svg>
                                                </a>
                                                <button class="btn btn-delete btn-ghost-danger" type="button" data-toggle="modal" data-target="{{ '#DeleteDealer' . $dealer->id . 'Modal' }}">
                                                    <svg class="c-icon" data-toggle="tooltip" data-placement="top" title="Eliminar producto">
                                                        <use href="{{ asset('icons/sprites/free.svg#cil-trash ') }}"></use>
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@foreach($dealers as $dealer)
    <div class="modal fade" id="{{ 'DeleteDealer' . $dealer->id . 'Modal' }}" tabindex="-1" role="dialog" aria-labelledby="{{ 'DeleteDealer' . $dealer->id . 'Modal' }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="{{ 'DeleteDealer' . $dealer->id . 'ModalLabel' }}"> ¿Está seguro de eliminar este repartidor?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('admin.dealer.delete') }}">
                    @csrf
                    {{-- <div class="modal-body">
                    </div> --}}
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <input type="hidden" name="id" value="{{ $dealer->id }}">
                        <button type="submit" class="btn btn-danger btn_user_delete">Eliminar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
@endsection
@section('javascript')
<script>
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    });
</script>
@endsection