@extends('layouts.base')

@section('sidebar')
  @role('admin')
    @include('layouts.sidebars.admin')
  @endrole
  @role('manager')
    @include('layouts.sidebars.manager')
  @endrole
  @role('executive')
    @include('layouts.sidebars.executive')
  @endrole
@endsection

@section('content')
<div class="container-fluid">
    <div class="fade-in">
        <div class="row">
            <div class="col-md-12">
                @if($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card">
                    <div class="card-header text-value-xl"> {{ $campus->name }}
                        @can($campus->editPermission)
                            <div class="card-header-actions">
                                <button class="card-header-action btn btn-lg btn-primary" type="button" data-target="#EditCampusModal" data-toggle="modal">
                                    <span class="mx-1 my-2">Editar</span>
                                </button>
                            </div>
                        @endcan
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="card-text text-value-lg" id="description"> {{ $campus->description }}</div>
                                <br>
                                <div class="card-text text-muted"> {{ $campus->fullAddress }}</div>
                                <br>
                                <div>
                                    <label for="link" class="font-weight-bold">Página Oficial:</label>
                                    <a class="text-decoration-none" href="{{ $campus->link }}" id="link">{{ $campus->link }}</a>
                                </div>
                                <div>
                                    <label for="phone" class="font-weight-bold">Telefono:</label>
                                    <a class="card-text text-decoration-none" id="phone">{{ Str::substr($campus->phone, 0, 3) }} {{ $campus->phone[3] }} {{ Str::substr($campus->phone,4,8) }}</a>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div id="google-maps" data-lon="{{ $campus->location_lon }}" data-lat="{{ $campus->location_lat }}"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <hr>
                                <label class="font-weight-bold">Imagenes {{ $campus->images->count() }} / {{ $campus->maxImages }}</label>
                                <div class="card-group">
                                    @foreach($campus->images as $image)
                                        <div class="card">
                                            <div class="card-body">
                                                <img class="img-fluid" src="{{ route('api.files.show', $image->id) }}">
                                            </div>
                                            <div class="card-footer">
                                                <button type="button" class="btn btn-outline-secondary float-left" data-toggle="modal" data-target="{{ '#ViewImage' . $image->id . 'Modal' }}">Ver</button>
                                                @can($campus->editPermission)
                                                    <button type="button" class="btn btn-danger float-right" data-toggle="modal" data-target="{{ '#DeleteImage' . $image->id . 'Modal' }}">Eliminar</button>
                                                @endcan
                                            </div>
                                        </div>
                                    @endforeach
                                    @can($campus->editPermission)
                                        @if($campus->images->count() < $campus->maxImages)
                                            <div class="card">
                                                <div class="card-body content-center">
                                                    <svg class="img-fluid">
                                                        <use href="{{ asset('icons/sprites/free.svg#cil-image-plus') }}"></use>
                                                    </svg>
                                                </div>
                                                <div class="card-footer text-center">
                                                    <button class="btn btn-outline-secondary" type="button" data-toggle="modal" data-target="#AddImageModal">Añadir imagen</button>
                                                </div>
                                            </div>
                                        @endif
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                    @can($campus->editPermission)
                        <div class="modal fade" id="AddImageModal" tabindex="-1" role="dialog" aria-labelledby="AddImageModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="AddImageModalLabel">Agregar una nueva imagen</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form method="POST" class="needs-validation" action="{{ route('campuses.images.create') }}" enctype="multipart/form-data" novalidate>
                                        <div class="modal-body">
                                            @csrf
                                            <div class="form-group">
                                                <label for="image">Imagen</label>
                                                <input type="hidden" name="institution" value="{{ $campus->institution }}">
                                                <input type="hidden" name="id" value="{{ $campus->id }}">
                                                <input type="file" class="form-control-file" id="image" name="image" required>
                                                <div class="invalid-feedback">
                                                    Seleccione una imagen
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-primary">Enviar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endcan
                    @foreach($campus->images as $image)
                        <div class="modal fade" id="{{ 'ViewImage' . $image->id . 'Modal' }}" tabindex="-1" role="dialog" aria-labelledby="{{ 'ViewImage' . $image->id . 'ModalLabel' }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="{{ 'ViewImage' . $image->id . 'ModalLabel' }}"> Imagen {{ $loop->iteration }} </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <img class="img-fluid" src="{{ route('api.files.show', $image->id) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        @can($campus->editPermission)
                            <div class="modal fade" id="{{ 'DeleteImage' . $image->id . 'Modal' }}" tabindex="-1" role="dialog" aria-labelledby="{{ 'DeleteImage' . $image->id . 'ModalLabel' }}" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="{{ 'DeleteImage' . $image->id . 'ModalLabel' }}"> ¿Está seguro de eliminar esta imagen?</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body content-center">
                                            <img class="img-fluid h-50" src="{{ route('api.files.show', $image->id) }}">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                            <form method="POST" action="{{ route('campuses.images.delete') }}">
                                                @csrf
                                                <input type="hidden" name="institution" value="{{ $campus->institution }}">
                                                <input type="hidden" name="id" value="{{ $campus->id }}">
                                                <input type="hidden" name="image" value="{{ $image->id }}">
                                                <button type="submit" class="btn btn-danger">Eliminar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endcan
                    @endforeach
                    <div class="modal fade" id="EditCampusModal" tabindex="-1" role="dialog" aria-labelledby="EditCampusModalLabel">
                        <div class="modal-dialog modal-xl" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="EditCampusModalLabel">Editar Facultad</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form class="needs-validation" method="POST" action="{{ route('campuses.edit') }}" novalidate>
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $campus->id }}">
                                    <input type="hidden" name="institution" value="{{ $campus->institution }}">
                                    <div class="modal-body">
                                        <div class="form-row">
                                            <div class="form-group col-md-8">
                                                <label for="name">Nombre</label>
                                                <input type="text" class="form-control" id="name" name="name" value="{{ $campus->name }}" required />
                                                <div class="invalid-feedback">
                                                    Ingrese un nombre valido
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="link">Página oficial</label>
                                                <input type="url" class="form-control" id="link" name="link" value="{{ $campus->link }}" required />
                                                <div class="invalid-feedback">
                                                    Ingrese una URL valida
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-8">
                                                <label for="address">Dirección</label>
                                                <input type="text" class="form-control" id="address" name="address" value="{{ $campus->address }}" required />
                                                <div class="invalid-feedback">
                                                    Ingrese una dirección valida
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="phone">Telefono</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">+56</span>
                                                    </div>
                                                    <input type="text" class="form-control" id="phone" name="phone" value="{{ Str::after($campus->phone, '+56') }}" required />
                                                </div>
                                                <div class="invalid-feedback">
                                                    Ingrese un telefono valido
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label for="country">País</label>
                                                <select class="custom-select" id="country" required>
                                                    <option>Selecciona un país</option>
                                                    @foreach($countries as $country)
                                                        <option value="{{ $country->id }}" {{ $country->id  == $campus->country_id ? 'selected' : '' }}> {{ $country->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="region">Región</label>
                                                <select class="custom-select" id="region" required>
                                                    <option> Selecciona una región </option>
                                                    @foreach($regions as $region)
                                                        <option value="{{ $region->id }}" {{ $region->id  == $campus->region_id ? 'selected' : '' }}> {{ $region->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="province">Provincia</label>
                                                <select class="custom-select" id="province" required>
                                                    <option> Selecciona una provincia </option>
                                                    @foreach($provinces as $province)
                                                        <option value="{{ $province->id }}" {{ $province->id  == $campus->province_id ? 'selected' : '' }}> {{ $province->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-8">
                                                <label for="description">Descripción</label>
                                                <input type="text" class="form-control" id="description" name="description" value="{{ $campus->description }}" required />
                                                <div class="invalid-feedback">
                                                    Ingrese una descripción
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="commune">Comuna</label>
                                                <select class="custom-select" id="commune" name="commune" required>
                                                    <option> Selecciona una comuna </option>
                                                    @foreach($communes as $commune)
                                                        <option value="{{ $commune->id }}" {{ $commune->id  == $campus->commune_id ? 'selected' : '' }}> {{ $commune->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-primary">Enviar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script>
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();

    $("#country").change(function() {
        var url = window.location.origin + '/api/countries/' + $(this).val() + '/regions';
        if ($(this).val() == "0") {
            return;
        }
        $.getJSON(url, function(data) {
            var select = $("#region");
            select.empty();
            select.append('<option value=0>Selecciona una region</option>')
            $.each(data.regions, function(key, value) {
                select.append('<option value=' + value.id + '>' + value.name + '</option>');
            });
        });
    });

    $("#region").change(function() {
        var url = window.location.origin + '/api/countries/' + $('#country').val() + '/regions/' + $(this).val() + '/provinces';
        if ($(this).val() == "0") {
            return;
        }
        $.getJSON(url, function(data) {
            var select = $('#province');
            select.empty();
            select.append('<option value=0>Selecciona una provincia</option>')
            $.each(data.provinces, function(key, value) {
                select.append('<option value=' + value.id + '>' + value.name + '</option>');
            });
        });
    });

    $('#province').change(function() {
        var url = window.location.origin + '/api/countries/' + $('#country').val() + '/regions/' + $('#region').val() + '/provinces/' + $(this).val() + '/communes';
        if ($(this).val() == "0") {
            return;
        }
        $.getJSON(url, function(data) {
            var select = $('#commune');
            select.empty();
            select.append('<option value=0>Selecciona una comuna</option>')
            $.each(data.communes, function(key, value) {
                select.append('<option value=' + value.id + '>' + value.name + '</option>');
            });
        });
    });
</script>
@endsection