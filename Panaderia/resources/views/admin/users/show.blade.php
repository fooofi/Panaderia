@extends('layouts.base')

@section('sidebar')
@if($admin)
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
                <div class="card">
                    <div class="card-header text-value-xl"> {{ $user->name }}
                        @can($user->editPermission)
                            <div class="card-header-actions">
                                <a class="card-header-action btn btn-lg btn-primary" role="button" data-target="#EditUserModal" data-toggle="modal">
                                    <span class="mx-2">Editar</span>
                                </a>
                            </div>
                        @endcan
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-7">
                                <div>
                                    <label for="name" class="font-weight-bold">Nombre completo:</label>
                                    <a class="card-text text-decoration-none" id="name">{{ $user->name . ' ' . $user->lastname }}</a>
                                </div>
                                <div>
                                    <label for="rut" class="font-weight-bold">RUN:</label>
                                    <a class="card-text text-decoration-none" id="rut">{{ $user->rut }}</a>
                                </div>
                                <div>
                                    <label for="area" class="font-weight-bold">Organizacion:</label>
                                    <a class="card-text text-decoration-none" id="area">{{ $user->organization ? $user->organization->fantasy_name : '-' }}</a>
                                </div>
                                <div>
                                    <label for="email" class="font-weight-bold">Email:</label>
                                    <a class="card-text text-decoration-none" id="email">{{ $user->email }}</a>
                                </div>
                                <div>
                                    <label for="role" class="font-weight-bold">Tipo de usuario:</label>
                                    <a class="card-text text-decoration-none" id="role">{{ $user->roles->first() ? $user->roles->first()->name : 'Sin rol' }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="EditUserModal" tabindex="-1" role="dialog" aria-labelledby="EditUserModalLabel">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="EditUserModalLabel">Editar Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="needs-validation" method="POST" action="{{ route('users.edit') }}" novalidate>
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="id" name="id" value="{{ $user->id }}">
                        {{-- <input type="hidden" id="institution" name="institution" value="{{ $career->institution_id }}"> --}}
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="name">Nombre</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required />
                                <div class="invalid-feedback">
                                    Ingrese un nombre
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="lastname">Apellido</label>
                                <input type="text" class="form-control" id="lastname" name="lastname" value="{{ $user->lastname }}" required />
                                <div class="invalid-feedback">
                                    Ingrese un Apellido
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            {{-- <div class="form-group col-md-6">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required />
                            <div class="invalid-feedback">
                                Ingrese un Email
                            </div>
                        </div> --}}
                        <div class="form-group col-md-4">
                            <label for="rut">RUN</label>
                            <input type="text" class="form-control" id="rut" name="rut" required pattern="([0-9]+-[0-9Kk])" value="{{ $user->rut }}" placeholder="Run del Administrador">
                            <div class="invalid-feedback">
                                Ingrese un Run valido.
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="user_type">Tipo de usuario</label>
                            <select class="custom-select" id="user_type" name="user_type" required>
                                {{-- <option value=1>Ejecutivo</option>
                                    <option value=2>Manager</option> --}}
                                <option value="1" {{ ( $user->roles->first()->name == "executive") ? 'selected' : '' }}> Ejecutivo </option>
                                <option value="2" {{ ( $user->roles->first()->name == "manager") ? 'selected' : '' }}> Manager </option>
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
                    <div class="form-row">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Enviar</button>
            </div>
            </form>
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