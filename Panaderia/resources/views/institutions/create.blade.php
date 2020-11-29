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
            <div class="card-header text-value-lg">Crear Institución</div>
            <form class="needs-validation" method="POST" action="{{ route('institutions.create')}}" novalidate>
              @csrf
              <div class="card-body">
                @if ($admin)
                  <div class="form-row">
                    <div class="form-group col-md-12">
                      <label for="organization">Organización</label>
                      <select class="custom-select" id="organization" name="organization" required>
                        <option selected disabled>Seleccione una organización</option>
                        @foreach ($organizations as $organization)
                          <option value="{{$organization->id}}"> {{ $organization->name}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                @else
                  <input type="hidden" name="organization" value="{{$organization_id}}">
                @endif
                <div class="form-row">
                  <div class="form-group col-md-8">
                    <label for="name">Nombre</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Nombre de la institución" required />
                    <div class="invalid-feedback">
                      Ingrese un nombre valido.
                    </div>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="dependency">Dependencia</label>
                    <select class="custom-select" id="dependency" name="dependency" required>
                      <option selected disabled value="">Selecciona una dependencia</option>
                      @foreach ($dependencies as $dependency)
                        <option value="{{$dependency->id}}"> {{ $dependency->name}} </option>
                      @endforeach
                    </select>
                    <div class="invalid-feedback">
                      Selecciona una dependencia
                    </div>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-8">
                    <label for="link">Página Oficial</label>
                    <input type="url" class="form-control" id="link" name="link" required>
                    <div class="invalid-feedback">
                      Ingrese un url valido.
                    </div>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="type">Tipo</label>
                    <select class="custom-select" id="type" name="type" required>
                      <option selected disabled value="">Selecciona un tipo de institución</option>
                      @foreach ($types as $type)
                        <option value="{{$type->id}}"> {{$type->name}} </option>
                      @endforeach
                    </select>
                    <div class="invalid-feedback">
                      Selecciona un tipo de institución
                    </div>
                  </div>
                </div>
                <div class="form-row">
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
                  <div class="form-group col-md-1"></div>
                  <div class="form-group col-md-2">
                    <label class="c-switch c-switch-lg c-switch-pill c-switch-primary">
                      <label for="cruch" class="text-nowrap">¿Pertenece al Cruch?</label>
                      <input type="checkbox" class="c-switch-input" name="cruch" id="cruch">
                      <span class="c-switch-slider"></span>
                    </label>
                  </div>
                  <div class="col-md-1"></div>
                  <div class="form-group col-md-2">
                    <label class="c-switch c-switch-lg c-switch-pill c-switch-primary">
                      <label for="sua" class="text-nowrap">¿Sistema Único de Admisión?</label>
                      <input type="checkbox" class="c-switch-input" name="sua" id="sua">
                      <span class="c-switch-slider"></span>
                    </label>
                  </div>
                  <div class="col-md-1"></div>
                  <div class="form-group col-md-2">
                    <label class="c-switch c-switch-lg c-switch-pill c-switch-primary">
                      <label for="gratuidad" class="text-nowrap">¿Gratuidad?</label>
                      <input type="checkbox" class="c-switch-input" name="gratuidad" id="gratuidad">
                      <span class="c-switch-slider"></span>
                    </label>
                  </div>
                </div>

                <br>
                <h4>Administrador</h4>
                <br>

                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="user_name">Nombre</label>
                    <input type="text" class="form-control" id="user_name" name="user_name" required placeholder="Nombre del Administrador">
                    <div class="invalid-feedback">
                      Ingrese un nombre valido
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="user_lastname">Apellido</label>
                    <input type="text" class="form-control" id="user_lastname" name="user_lastname" required placeholder="Apellido del Administrador">
                    <div class="invalid-feedback">
                      Ingrese un apellido valido
                    </div>
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
  </script>
@endsection
