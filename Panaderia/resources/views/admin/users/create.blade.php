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
                            @foreach($errors->all() as $error)
                                <li> {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card">
                    <div class="card-header text-value-lg">Crear Usuario</div>
                    <form class="needs-validation" method="POST" action="{{ route('users.create') }}" novalidate>
                        @csrf
                        <input type="hidden" id="organization_id" name="organization_id" value="{{ $organization_id }}">
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="name">Nombre</label>
                                    <input type="text" class="form-control" id="name" name="name" required placeholder="Nombre del usuario">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="lastname">Apellido</label>
                                    <input type="text" class="form-control" id="lastname" name="lastname" required placeholder="Apellido del usuario">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required placeholder="Email del usuario">
                                    <div class="invalid-feedback">
                                        Ingrese un email valido.
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">

                                <div class="form-group col-md-4">
                                    <label for="rut">RUN</label>
                                    <input type="text" class="form-control" id="rut" name="rut" required pattern="([0-9]+-[0-9Kk])" placeholder="Run del usuario">
                                    <div class="invalid-feedback">
                                        Ingrese un Run valido.
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="user_type">Tipo de usuario</label>
                                    <select class="custom-select" id="user_type" name="user_type" required>
                                        <option value=1>Ejecutivo</option>
                                        <option value=2>Manager</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4" >
                                    <label for="institution_id">Institucion</label>
                                    <select class="custom-select" id="institution_id" name="institution_id" required>
                                        <option value=0>Selecciona una</option>
                                        @foreach($institutions as $institution)
                                            <option value="{{ $institution->id }}"> {{ $institution->name }}</option>
                                        @endforeach
                                    </select>
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
  {{-- <script>
    $( document ).ready(function() {

    
      if($("#user_type").children("option:selected").val() != "1")
      {
        $('#institution_id').prop( "disabled", true );
        return;
      }
      $("#user_type").change(function(){

        if($(this).children("option:selected").val() == "1")
        {
          $('#institution_id').prop( "disabled", false );
          return;
        }else{
          $('#institution_id').prop( "disabled", true );
        }
      });
    });
  </script> --}}
@endsection