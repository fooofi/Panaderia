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
          @isset($successfull)
            @if($successfull)
                <div class="alert alert-light" role="alert">
                  <ul>
                    <li> Contraseña cambiada exitosamente</li>
                  </ul>
                </div>
            @endif
          @endisset
          <div class="card">
            <div class="card-header text-value-lg">Cambiar Contraseña</div>
            <form class="needs-validation" method="POST" action="{{ route('user.password') }}" novalidate>
              <div class="card-body">
                @csrf
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="old_password">Contraseña actual</label>
                    <input type="password" class="form-control" id="old_password" name="old_password" required minlength="8">
                    <div class="invalid-feedback">
                      Contraseña invalida.
                    </div>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="new_password">Nueva contraseña</label>
                    <input type="password" class="form-control" id="new_password" name="new_password" required minlength="8">
                    <div class="invalid-feedback">
                      La contraseña debe tener un largo minimo de 8 caracteres.
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="new_password_confirmation">Confirmar nueva contraseña</label>
                    <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required minlength="8">
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


