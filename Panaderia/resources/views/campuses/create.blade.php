@extends('layouts.base')

@section('sidebar')
  @if ($admin)
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
              <div class="card-header text-value-lg">Crear Facultad</div>
              <form class="needs-validation" method="POST" action="{{ route('campuses.create')}}" novalidate>
                @csrf
                <input type="hidden" id="institution" name="institution" value="{{ $institution_id}}">
                <div class="card-body">
                  <div class="form-row">

                    <div class="form-group col-md-8">
                      <label for="name">Nombre</label>
                      <input type="text" class="form-control" id="name" name="name" placeholder="Nombre de la facultad" required />
                      <div class="invalid-feedback">
                        Ingrese un nombre valido
                      </div>
                    </div>
                    <div class="form-group col-md-4">
                      <label for="link">Página oficial</label>
                      <input type="url" class="form-control" id="link" name="link" required />
                      <div class="invalid-feedback">
                        Ingrese una URL valida
                      </div>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-8">
                      <label for="address">Dirección</label>
                      <input type="text" class="form-control" id="address" name="address" placeholder="Dirección de la facultad" required />
                      <div class="invalid-feedback">
                        Ingrese una dirección valida
                      </div>
                    </div>
                    <div class="form-group col-md-4">
                      <label for="phone">Telefono</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">+56</span>
                        </div>
                        <input type="text" class="form-control" id="phone" name="phone" pattern="[0-9]+" minlength="9" maxlength="9" required />
                      </div>
                      <div class="invalid-feedback">
                        Ingrese un telefono valido
                      </div>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-4">
                      <label for="country">País</label>
                      <select class="custom-select" id="country" required>
                        <option>Selecciona un país</option>
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
                        <option > Selecciona una provincia </option>
                      </select>
                    </div>


                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-8">
                      <label for="description">Descripción</label>
                      <textarea  class="form-control" id="description" name="description" rows="6" cols="50" placeholder="Descripción breve de la facultad" required ></textarea>
                      <div class="invalid-feedback">
                        Ingrese una descripción
                      </div>
                    </div>
                    <div class="form-group col-md-4">
                      <label for="commune">Comuna</label>
                      <select class="custom-select" id=commune name="commune" required>
                        <option > Selecciona una comuna </option>
                      </select>
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
