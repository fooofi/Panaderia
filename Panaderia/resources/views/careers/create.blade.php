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
                    <div class="card-header text-value-lg">Crear Carrera</div>
                    <form class="needs-validation" method="POST" action="{{ route('careers.create') }}" novalidate>
                        @csrf
                        <input type="hidden" id="institution" name="institution" value="{{ $institution_id }}">
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-8">
                                    <label for="name">Nombre</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Nombre de la carrera" required />
                                    <div class="invalid-feedback">
                                        Ingrese un nombre valido
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="type">Tipo de carrera</label>
                                    <select class="custom-select" id="type" name="type" required>
                                        <option value=0>Selecciona un tipo</option>
                                        @foreach($types as $type)
                                            <option value="{{ $type->id }}"> {{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-8">
                                    <label for="link">Página oficial</label>
                                    <input type="url" class="form-control" id="link" name="link" placeholder="URL de la carrera" required />
                                    <div class="invalid-feedback">
                                        Ingrese una URL valida
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="modality">Modalidad</label>
                                    <select class="custom-select" id="modality" name="modality" required>
                                        <option value=0>Selecciona un modalidad</option>
                                        @foreach($modalities as $modality)
                                            <option value="{{ $modality->id }}"> {{ $modality->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-8">
                                    <label for="video">Url del Video</label>
                                    <input type="url" class="form-control" id="video" name="video" placeholder="URL del video de la carrera" required>
                                    <div class="invalid-feedback">
                                        Ingrese un url valido.
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="area">Area</label>
                                    <select class="custom-select" id="area" name="area" required>
                                        <option value=0>Selecciona un area</option>
                                        @foreach($areas as $area)
                                            <option value="{{ $area->id }}"> {{ $area->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="campuses">Facultades</label>
                                    <div class="col-md-12">
                                        <select class="form-control custom-select" id="campuses" name="campuses[]" multiple required>
                                            @foreach($campuses as $campus)
                                                <option value="{{ $campus->id }}"> {{ $campus->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="semesters">Semestres</label>
                                    <input type="number" class="form-control" id="semesters" name="semesters" min="1" placeholder="Semestres de la  carrera" required />
                                    <div class="invalid-feedback">
                                        Debe ingresar un numero de semestres
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="regime">Regimen</label>
                                    <div class="col-md-12">
                                        <select class="form-control custom-select" id="regime" name="regime" required>
                                            <option value="0"> Selecciona un tipo de regimen</option>
                                            @foreach($regimes as $regime)
                                                <option value="{{ $regime->id }}"> {{ $regime->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="accreditation">Acreditacion</label>
                                    <select class="custom-select" id="accreditation" name="accreditation" required>
                                        <option value=0>Selecciona un tipo</option>
                                        @foreach($accreditations as $accreditation)
                                            <option value="{{ $accreditation->id }}"> {{ $accreditation->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                @foreach($scholarShipOwners as $scholarShipOwner)
                                <div class="form-group col-md-4">
                                    <label for="scholarShipOwner">{{ $scholarShipOwner->name }} </label>
                                    <div class="col-md-12">
                                        <select class="form-control custom-select" id="scholarShipOwners{{ $scholarShipOwner->id }}" name="scholarShipOwners{{ $scholarShipOwner->id }}[]" multiple required>
                                            @foreach($scholarShipOwner->scholarships as $scholarship)
                                                <option value="{{ $scholarship->id }}"> {{ $scholarship->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @endforeach
                                
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="description">Descripción</label>
                                    <textarea  class="form-control" id="description" name="description" rows="6" cols="50" placeholder="Descripción breve de la carrera" required ></textarea>
                                    <div class="invalid-feedback">
                                        Ingrese una descripción
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-primary float-right mb-2" type="submit">Enviar</button>
                        </div>
                    </form>
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
</script>
@endsection