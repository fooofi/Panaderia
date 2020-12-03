@extends('layouts.base')

@section('sidebar')
@include('layouts.sidebars.admin')
@endsection

@section('content')
<div class="container-fluid">
    <div class="fade-id">
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
                    <div class="card-header text-value-lg">Crear Producto</div>
                    <form class="needs-validation" method="POST" action="{{ route('admin.product.create') }}" novalidate>
                        @csrf
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-8">
                                    <label for="product_name">Nombre</label>
                                    <input type="text" class="form-control" id="product_name" name="product_name" required placeholder="Nombre del producto">
                                    <div class="invalid-feedback">
                                        Ingrese un nombre válido
                                    </div>
                                </div>
                                <div class="form-group col-md-8">
                                    <label for="product_measure">Unidad de medida del producto</label>
                                    <select class="custom-select" id="product_measure" name="product_measure" required>
                                        <option selected disabled value="">Selecciona la unidad de medida del producto</option>
                                        @foreach($measures as $measure)
                                            <option value="{{ $measure->id }}">{{ $measure->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        Seleccione una medida válida
                                    </div>
                                </div>
                                <div class="form-group col-md-8">
                                    <label for="product_type">Tipo de producto</label>
                                    <select class="custom-select" id="product_type" name="product_type" required>
                                        <option selected disabled value="">Selecciona un tipo de producto</option>
                                        @foreach($types_product as $type)
                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        Seleccione una tipo válido
                                    </div>
                                </div>
                            </div>

                            <br>
                            <h4>Materiales</h4>
                            <br>
                            @foreach($materials as $material)
                                <div class="form-row">
                                    <div class="form-group col-md-1"></div>
                                    <div class="form-group col-md-2">
                                        <label class="c-switch c-switch-lg c-switch-pill c-switch-primary">
                                            <label for="material_checkbox-{{ $material->id }}" class="text-nowrap">{{ $material->name }}</label>
                                            <input type="checkbox" class="c-switch-input" name="material_checkbox-{{ $material->id }}" id="material_checkbox-{{ $material->id }}">
                                            <span class="c-switch-slider"></span>
                                        </label>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="product_quantity">Cantidad</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                            </div>
                                            <input type="number" class="form-control" id="product_quantity-{{ $material->id }}" name="product_quantity-{{ $material->id }}" min="0" minlength="9" maxlength="9" />
                                        </div>
                                        <div class="invalid-feedback">
                                            Ingrese una cantidad válida
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Medida</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">{{ $material->type_measure }}</span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            @endforeach
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