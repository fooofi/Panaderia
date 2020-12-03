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
                    <div class="card-header text-value-lg">Crear un Despacho</div>
                    <form class="needs-validation" method="POST" action="{{ route('admin.order.create') }}" novalidate>
                        @csrf
                        <div class="card-body">
                            <div class="form-group col-md-8">
                                <label for="client">Cliente</label>
                                <select class="custom-select" id="client" name="client" required>
                                    <option selected disabled value="">Selecciona cliente</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Seleccione un cliente válido
                                </div>
                            </div>
                            <div class="form-group col-md-8">
                                <label for="dealer">Repartidor</label>
                                <select class="custom-select" id="dealer" name="dealer" required>
                                    <option selected disabled value="">Selecciona el repartidor</option>
                                    @foreach($dealers as $dealer)
                                        <option value="{{ $dealer->id }}">{{ $dealer->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Seleccione un repartidor válido
                                </div>
                            </div>
                            <div class="form-group col-md-8">
                                <label for="detail">Detalle</label>
                                <input type="text" class="form-control" id="detail" name="detail" placeholder="Ingresa detalle del despacho">
                            </div>
                            <div class="col-lg-12">
                                <br>
                                <h4>Productos</h4>
                                <br>
                                @foreach($productions as $production)
                                    <div class="form-row">
                                        <div class="form-group col-md-1"></div>
                                        <div class="form-group col-md-2">
                                            <label class="c-switch c-switch-lg c-switch-pill c-switch-primary">
                                                <label for="production_checkbox-{{ $production->id }}" class="text-nowrap">{{ $production->name }}</label>
                                                <input type="checkbox" class="c-switch-input" name="production_checkbox-{{ $production->id }}" id="production_checkbox-{{ $production->id }}">
                                                <span class="c-switch-slider"></span>
                                            </label>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="production_quantity">Cantidad</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                </div>
                                                <input type="number" class="form-control" id="production_quantity-{{ $production->id }}" name="production_quantity-{{ $production->id }}" min="0" minlength="9" maxlength="9" />
                                            </div>
                                            <div class="invalid-feedback">
                                                Ingrese una cantidad válida
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="">Medida</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">{{ $production->measure }}</span>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                @endforeach
                            </div>
                            <br>
                            <div class="form-group col-md-8">
                                <label for="total_to_pay">Total a pagar</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input type="number" min="0" class="form-control" id="total_to_pay" name="total_to_pay" placeholder="0" required aria-label="Amount (to the nearest dollar)">
                                    <div class="invalid-feedback">
                                        Ingrese un monto válido.
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