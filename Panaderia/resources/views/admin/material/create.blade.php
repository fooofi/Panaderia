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
                    <div class="card-header text-value-lg">Crear Materia Prima</div>
                    <form class="needs-validation" method="POST" action="{{ route('admin.material.create') }}" novalidate>
                      @csrf
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-8">
                                    <label for="name">Nombre</label>
                                    <input type="text" class="form-control" id="name" name="name" required placeholder="Nombre del material">
                                    <div class="invalid-feedback">
                                        Ingrese un nombre válido
                                    </div>
                                </div>
                                <div class="form-group col-md-8">
                                    <label for="measure">Unidad de medida de la materia prima</label>
                                    <select class="custom-select" id="measure" name="measure" required>
                                        <option selected disabled value="">Selecciona la unidad de medida del producto</option>
                                        @foreach($measures as $measure)
                                            <option value="{{ $measure->id }}">{{ $measure->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        Seleccione una medida válida
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-8">
                                    <label for="stock">Stock inicial</label>
                                    <input type="number" min="0" class="form-control" id="stock" name="stock" required pattern="([0-9])" required placeholder="Stock actual del material">
                                    <div class="invalid-feedback">
                                        Ingrese un stock válido.
                                    </div>
                                </div>
                                <div class="form-group col-md-8">
                                    <label for="cost">Costo unitario en pesos</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">$</span>
                                        </div>
                                        <input type="number" min="0" class="form-control" id="cost" name="cost" placeholder="0" required aria-label="Amount (to the nearest dollar)">
                                        <div class="invalid-feedback">
                                            Ingrese un costo válido.
                                        </div>
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