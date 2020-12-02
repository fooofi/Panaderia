@extends('layouts.base')

@section('sidebar')
@include('layouts.sidebars.admin')
@endsection

@section('content')
  <div class="container-fluid">
    <div class="fade-id">
      <div class="row">
        <div class="col-md-12">
          @if ($errors->any())
            <div class="alert alert-danger" role="alert">
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{$error}}</li>
                @endforeach
              </ul>
            </div>
          @endif
          <div class="card">
            <div class="card-header text-value-lg">Crear un Despacho</div>
            <form class="needs-validation" method="POST" action="" novalidate>
              <div class="card-body">
              <div class="form-group col-md-8">
                  <label for="cliente_id">Cliente</label>
                    <select class="custom-select" id="cliente_id" name="cliente_id" required>
                      <option selected disabled value="">Selecciona el cliente</option>
                        <option value=""> </option>
                    </select>
                    <div class="invalid-feedback">
                      Seleccione un cliente válido
                    </div>
                  </div>
                  <div class="form-group col-md-8">
                  <label for="repartidor_id">Repartidor</label>
                    <select class="custom-select" id="repartidor_id" name="repartidor_id" required>
                      <option selected disabled value="">Selecciona el repartidor</option>
                        <option value=""> </option>
                    </select>
                    <div class="invalid-feedback">
                      Seleccione un repartidor válido
                    </div>
                  </div>
                  <div class="form-group col-md-8">
                  <label for="producto_id">Producto</label>
                    <select class="custom-select" id="producto_id" name="producto_id" required>
                      <option selected disabled value="">Selecciona el producto</option>
                        <option value=""> </option>
                    </select>
                    <div class="invalid-feedback">
                      Seleccione un producto válido
                    </div>
                  </div>
                  <div class="form-group col-md-8">
                    <label for="producto_cantidad">Cantidad</label>
                    <input type="number" min="0" class="form-control" id="producto_cantidad" name="producto_cantidad"  placeholder="Ingresa la cantidad del producto" required>
                    <div class="invalid-feedback">
                      Ingrese una cantidad válida
                    </div>
                  </div>
                  <div class="form-group col-md-8">
                    <label for="detalle_despacho">Detalle</label>
                    <input type="text" class="form-control" id="detalle_despacho" name="detalle_despacho"  placeholder="Ingresa detalle del despacho">
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
