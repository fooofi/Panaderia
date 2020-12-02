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
            <div class="card-header text-value-lg">Crear Material</div>
            <form class="needs-validation" method="POST" action="" novalidate>
              <div class="card-body">
                <div class="form-row">
                  <div class="form-group col-md-8">
                    <label for="material_name">Nombre</label>
                    <input type="text" class="form-control" id="material_name" name="material_name" required placeholder="Nombre del material">
                    <div class="invalid-feedback">
                      Ingrese un nombre válido
                    </div>
                  </div>
                  <div class="form-group col-md-8">
                  <label for="material_type">Medida</label>
                    <select class="custom-select" id="material_type" name="material_type" required>
                      <option selected disabled value="">Selecciona la unidad de medida del material</option>
                        <option value=""> </option>
                    </select>
                    <div class="invalid-feedback">
                      Seleccione una medida válida
                    </div>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-8">
                    <label for="material_stock">Stock</label>
                    <input type="number" min="0" class="form-control" id="material_stock" name="material_stock" required pattern="([0-9])" required placeholder="Stock actual del material">
                    <div class="invalid-feedback">
                      Ingrese un stock válido.
                    </div>
                  </div>
                  <div class="form-group col-md-8">
                    <label for="material_costo">Costo</label>
                    <input type="number" min="0" class="form-control" id="material_costo" name="material_costo"  placeholder="Costo actual del material">
                    <div class="invalid-feedback">
                      Ingrese un costo válido.
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
