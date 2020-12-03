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
                    <div class="card-header text-value-lg">Crear Repartidor</div>
                    <form class="needs-validation" method="POST" action="{{ route('admin.dealer.create') }}" novalidate>
                        @csrf
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="name">Nombre</label>
                                    <input type="text" class="form-control" id="name" name="name" required placeholder="Nombre del repartidor">
                                    <div class="invalid-feedback">
                                        Ingrese un nombre válido
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="lastname">Apellido</label>
                                    <input type="text" class="form-control" id="lastname" name="lastname" required placeholder="Apellido del repartidor">
                                    <div class="invalid-feedback">
                                        Ingrese un apellido válido
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="rut">RUN</label>
                                    <input type="text" class="form-control" id="rut" name="rut" required pattern="([0-9]+-[0-9Kk])" placeholder="Run del usuario">
                                    <div class="invalid-feedback">
                                        Ingrese un Run valido.
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="phone">Telefono de contacto</label>
                                    <input type="phone" min="0" class="form-control" id="phone" name="phone" required placeholder="+569 92590935">
                                    <div class="invalid-feedback">
                                        Ingrese un Telefono válido.
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="email">Email</label>
                                    <input type="email" min="0" class="form-control" id="email" name="email" required placeholder="Correo de contacto">
                                    <div class="invalid-feedback">
                                        Ingrese un phone válido.
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