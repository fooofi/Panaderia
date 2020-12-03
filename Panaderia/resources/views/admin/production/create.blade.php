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
                    <div class="card-header text-value-lg">Ingresar Produccion</div>
                    <form class="needs-validation" method="POST" action="{{ route('admin.production.create') }}" novalidate>
                        @csrf
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    
                                    <label for="name">Nombre descriptivo</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        </div>
                                        <input required type="text" class="form-control" id="name" name="name" placeholder="ej: pan de la tarde" />
                                    </div>
                                    <div class="invalid-feedback">
                                        Ingrese una cantidad válida
                                    </div>
                                
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="product">Producto elaborado</label>
                                    <select class="custom-select" id="product" name="product" required>
                                        <option selected disabled value="">Selecciona un producto</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        Seleccione un producto válido
                                    </div>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="quantity">Cantidad producida</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        </div>
                                        <input required type="number" class="form-control" id="quantity" name="quantity" min="0"  minlength="0" maxlength="9" placeholder="0"/>
                                    </div>
                                    <div class="invalid-feedback">
                                        Ingrese una cantidad válida
                                    </div>
                                </div>
                            </div>
                            {{-- TODO: esta perdida en que tipo esta ? --}}
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="decrease">Perdida observada</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">$</span>
                                        </div>
                                        <input type="number" class="form-control" id="decrease" name="decrease" min="0"  minlength="0" maxlength="9" value = '0' placeholder="0" />
                                    </div>
                                    <div class="invalid-feedback">
                                        Ingrese una cantidad válida
                                    </div>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="quantity_in_quintals">Cantidad en quintales</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                        </div>
                                        <input type="number" class="form-control" id="quantity_in_quintals" name="quantity_in_quintals" min="0"  minlength="0" maxlength="9" placeholder="0" />
                                    </div>
                                    <div class="invalid-feedback">
                                        Ingrese una cantidad válida
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