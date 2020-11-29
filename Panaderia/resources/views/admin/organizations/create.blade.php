@extends('layouts.base')

@section('sidebar')
  @include('layouts.sidebars.admin')
@endsection

@section('content')
  <div class="container-fluid">
    <div class="fade-in">
      <div class="row">
        <div class="col-md-12">
          @if($errors->any())
            <div class="alert alert-danger" role="alert">
              <ul>
                @foreach ($errors->all() as $error)
                    <li> {{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif
          <div class="card">
            <div class="card-header text-value-lg">Crear Organización</div>
            <form class="needs-validation" method="POST" action="{{ route('admin.organizations.create') }}" novalidate>
              <div class="card-body">
                @csrf
                <div class="form-row">
                  <div class="form-group col-md-8">
                    <label for="fantasy_name">Nombre</label>
                      <input type="text" class="form-control" id="fantasy_name" name="fantasy_name" placeholder="Nombre de la empresa" required>
                  </div>

                  <div class="form-group col-md-4">
                    <label for="rut">Rut</label>
                    <input type="text" class="form-control" id="rut" placeholder="Rut de la empresa" name="rut" required pattern="([0-9]+-[0-9Kk])">
                    <div class="invalid-feedback">
                      Ingrese un Rut valido.
                    </div>

                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-8">
                    <label for="business_name">Razón social</label>
                      <input type="text" class="form-control" id="business_name" name="business_name" placeholder="Razón social de la empresa" required>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="type">Tipo de empresa</label>
                    <select class="custom-select" id="type" name="type" required>
                      <option>Selecciona un tipo de organización</option>
                      @foreach ($types as $type)
                          <option value="{{ $type->id }}"> {{ $type->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label for="country">País</label>
                    <select class="custom-select" id="country" required>
                      <option value="0">Selecciona un país</option>
                      @foreach($countries as $country)
                        <option value="{{ $country->id}}"> {{ $country->name }}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="form-group col-md-4">
                    <label for="region">Región</label>
                    <select class="custom-select" id="region" required>
                      <option> Selecciona una región </option>
                    </select>
                  </div>

                  <div class="form-group col-md-4">
                    <label for="province">Provincia</label>
                    <select class="custom-select" id="province" required>
                      <option> Selecciona una provincia </option>
                    </select>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-8">
                    <label for="address">Dirección</label>
                    <input type="text" class="form-control" id="address" name="address" placeholder="Dirección de la empresa" required>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="commune">Comuna</label>
                    <select class="custom-select" id=commune name="commune" required>
                      <option> Selecciona una comuna </option>
                    </select>
                  </div>
                </div>

                <br>
                <h4>Administrador</h4>
                <br>

                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="user_name">Nombre</label>
                    <input type="text" class="form-control" id="user_name" name="user_name" required placeholder="Nombre del Administrador">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="user_lastname">Apellido</label>
                    <input type="text" class="form-control" id="user_lastname" name="user_lastname" required placeholder="Apellido del Administrador">
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="user_email">Email</label>
                    <input type="email" class="form-control" id="user_email" name="user_email" required placeholder="Email del Administrador">
                    <div class="invalid-feedback">
                      Ingrese un email valido.
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="user_rut">RUN</label>
                    <input type="text" class="form-control" id="user_rut" name="user_rut" required pattern="([0-9]+-[0-9Kk])" placeholder="Run del Administrador">
                    <div class="invalid-feedback">
                      Ingrese un Run valido.
                    </div>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="user_password">Contraseña</label>
                    <input type="password" class="form-control" id="user_password" name="user_password" required minlength="8">
                    <div class="invalid-feedback">
                      La contraseña debe tener un largo minimo de 8 caracteres.
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="user_password_confirmation">Confirmar contraseña</label>
                    <input type="password" class="form-control" id="user_password_confirmation" name="user_password_confirmation" required minlength="8">
                    <div class="invalid-feedback">
                      La contraseña no coincide.
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

    $("#country").change(function(){
      var url = window.location.origin +'/api/countries/' + $(this).val() + '/regions';
      if($(this).val() == "0"){
        return;
      }
      $.getJSON(url, function(data) {
        var select = $("#region");
        select.empty();
        select.append('<option value=0>Selecciona una region</option>')
        $.each(data.regions, function(key, value) {
          select.append('<option value=' + value.id + '>' + value.name +'</option>');
        });
      });
    });

    $("#region").change(function(){
      var url = window.location.origin + '/api/countries/' + $('#country').val() + '/regions/'+ $(this).val() + '/provinces';
      if($(this).val() == "0"){
        return;
      }
      $.getJSON(url, function(data){
        var select = $('#province');
        select.empty();
        select.append('<option value=0>Selecciona una provincia</option>')
        $.each(data.provinces, function(key, value){
          select.append('<option value=' + value.id + '>' + value.name + '</option>');
        });
      });
    });

    $('#province').change(function(){
      var url = window.location.origin + '/api/countries/' + $('#country').val() + '/regions/'+ $('#region').val() + '/provinces/' + $(this).val() + '/communes';
      if($(this).val() == "0"){
        return;
      }
      $.getJSON(url, function(data){
        var select = $('#commune');
        select.empty();
        select.append('<option value=0>Selecciona una comuna</option>')
        $.each(data.communes, function(key, value){
          select.append('<option value=' + value.id + '>' + value.name + '</option>');
        });
      });
    });
  </script>
@endsection
