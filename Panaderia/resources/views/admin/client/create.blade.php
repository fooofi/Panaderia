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
                    <div class="card-header text-value-lg">Crear Cliente</div>
                    <form class="needs-validation" method="POST" action="{{ route('admin.client.create') }}" novalidate>
                        @csrf
                        <div class="card-body">
                            <div class="form-row  col-md-6">
                                <div class="form-group col-md-4">
                                    <label for="name">Nombre</label>
                                    <input type="text" class="form-control" id="name" name="name" required placeholder="Nombre del cliente">
                                    <div class="invalid-feedback">
                                        Ingrese un nombre válido
                                    </div>
                                </div>
                            </div>
                            <div class="form-row  col-md-6">
                                <div class="form-group col-md-4">
                                    <label for="phone">Telefono de contacto</label>
                                    <input type="phone" min="0" class="form-control" id="phone" name="phone" required placeholder="+569 92590935">
                                    <div class="invalid-feedback">
                                        Ingrese un Telefono válido.
                                    </div>
                                </div>
                            </div>
                            <div class="form-row  col-md-6">
                                <div class="form-group col-md-4">
                                    <label for="direction">Direccion</label>
                                    <input type="direction" min="0" class="form-control" id="direction" name="direction" required placeholder="Direccion del local">
                                    <div class="invalid-feedback">
                                        Ingrese una direccion válida.
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