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
                        Materias primas
                        <div class="card-header-actions">
                            <a class="card-header-action btn btn-lg btn-primary" role="button" href="{{ route('admin.material.create') }}">
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
                                    <th scope="col">Stock</th>
                                    <th scope="col">Medida</th>
                                    <th scope="col">Costo</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($materials as $material)
                                    <tr>
                                        <td scope="row">{{ $material->name }}</td>
                                        <td scope="row">{{ $material->stock }}</td>
                                        <td scope="row">{{ $material->measure }}</td>
                                        <td scope="row"> @money($material->cost) </td>
                                        <td scope="row">
                                            <div class="btn-group" role="group" aria-label="">
                                                <a role="button" class="btn btn-ghost-secondary" href="#" data-toggle="tooltip" data-placement="top" title="Editar produccion">
                                                    <svg class="c-icon">
                                                        <use href="{{ asset('icons/sprites/free.svg#cil-external-link') }}"></use>
                                                    </svg>
                                                </a>
                                                <button class="btn btn-delete btn-ghost-danger" type="button" data-toggle="modal" data-target="{{ '#DeleteMaterial' . $material->id . 'Modal' }}">
                                                    <svg class="c-icon" data-toggle="tooltip" data-placement="top" title="Eliminar producto">
                                                        <use href="{{ asset('icons/sprites/free.svg#cil-trash ') }}"></use>
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                @if(count($materials) == 0)
                                    <tr>
                                        <td class="text-center text-value-lg">No ha creado ninguna producción</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@foreach($materials as $material)
    <div class="modal fade" id="{{ 'DeleteMaterial' . $material->id . 'Modal' }}" tabindex="-1" role="dialog" aria-labelledby="{{ 'DeleteMaterial' . $material->id . 'Modal' }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="{{ 'DeleteMaterial' . $material->id . 'ModalLabel' }}"> ¿Está seguro de eliminar esta materia prima?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('admin.material.delete') }}">
                    @csrf
                    <div class="modal-body">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <input type="hidden" name="id" value="{{ $material->id }}">
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