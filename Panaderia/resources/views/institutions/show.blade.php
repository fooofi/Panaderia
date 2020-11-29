@extends('layouts.base')

@section('sidebar')
  @role('admin')
    @include('layouts.sidebars.admin')
  @endrole
  @role('manager')
    @include('layouts.sidebars.manager')
  @endrole
  @role('executive')
    @include('layouts.sidebars.executive')
  @endrole
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
            <div class="card-header text-value-xl"> {{ $institution->name }}
            @can($institution->editPermission)
              <div class="card-header-actions">
                <button class="card-header-action btn btn-lg btn-primary" type="button" data-target="#EditInstitutionModal" data-toggle="modal">
                  <span class="mx-1 my-2">
                    Editar
                  </span>
                </button>
              </div>
            @endcan
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-7">
                  <div class="font-weight-bold">
                    <span>¿Es miembro del CRUCh?</span>
                    <label class="c-switch c-switch-pill c-switch-primary ml-2" style="margin-bottom: -0.5rem">
                      <input type="checkbox" disabled class="c-switch-input" {{ $institution->cruch ? 'checked' : ''}}>
                      <span class="c-switch-slider"></span>
                    </label>
                  </div>
                  <div class="font-weight-bold">
                    <span>¿Es miembro del Sistema Único de Admisión?</span>
                    <label class="c-switch c-switch-pill c-switch-primary ml-2" style="margin-bottom: -0.5rem">
                      <input type="checkbox" disabled class="c-switch-input" {{ $institution->sua ? 'checked' : ''}}>
                      <span class="c-switch-slider"></span>
                    </label>
                  </div>
                  <div class="font-weight-bold">
                    <span>¿Posee gratuidad?</span>
                    <label class="c-switch c-switch-pill c-switch-primary ml-2" style="margin-bottom: -0.5rem">
                      <input type="checkbox" disabled class="c-switch-input" {{ $institution->gratuidad ? 'checked' : ''}}>
                      <span class="c-switch-slider"></span>
                    </label>
                  </div>
                  <br>
                  <div class="font-weight-bold">
                    <label>Página Oficial:</label>
                    <a class="font-weight-normal" href="{{$institution->link}}" target="_blank"> {{ $institution->link}} </a>
                  </div>
                  <div class="font-weight-bold">
                    <label>Telefono:</label>
                    <a class="font-weight-normal">
                      @if(strlen($institution->phone) > 7)
                      {{ Str::substr($institution->phone, 0, 3)}} {{ $institution->phone[3] }} {{ Str::substr($institution->phone,4,8)}}
                      @else
                        {{ $institution->phone}}
                      @endif
                    </a>
                  </div>
                  <div class="font-weight-bold">
                    <label>Tipo de institución:</label>
                    <a class="font-weight-normal"> {{ $institution->type}}</a>
                  </div>
                  <div class="font-weight-bold">
                    <label>Gestión de la institución:</label>
                    <a class="font-weight-normal"> {{ $institution->dependency}}</a>
                  </div>
                </div>
                <div class="col-md-5">
                  <div class="card">
                    <div class="card-header font-weight-bold">Logo
                      @can($institution->editPermission)
                        <div class="card-header-actions">
                          @if ($institution->logo)
                            <div class="card-header-action btn btn-danger" type="button" data-target="#DeleteLogoModal" data-toggle="modal">
                              <span class="mx-1 my-2">Eliminar</span>
                            </div>
                          @else
                            <div class="card-header-action btn btn-primary" type="button" data-toggle="modal" data-target="#AddLogoModal">
                              <span class="mx-1 my-2">Añadir</span>
                            </div>
                          @endif
                        </div>

                      @endcan
                    </div>
                    <div class="card-body">
                      @if ($institution->logo)
                        <img class="img-fluid" src="{{ route('api.files.show', $institution->logo)}}">
                      @else
                        <svg class="img-fluid">
                          <use href="{{asset('icons/sprites/free.svg#cil-image-broken')}}"></use>
                        </svg>
                      @endif
                    </div>
                  </div>
                  <div class="card">
                    <div class="card-header font-weight-bold">Banner
                      @can($institution->editPermission)
                        <div class="card-header-actions">
                          @if ($institution->banner)
                            <div class="card-header-action btn btn-danger" type="button" data-toggle="modal" data-target="#DeleteBannerModal">
                              <span class="mx-1 my-2">Eliminar</span>
                            </div>
                          @else
                            <div class="card-header-action btn btn-primary" type="button" data-toggle="modal" data-target="#AddBannerModal">
                              <span class="mx-1 my-2">Añadir</span>
                            </div>
                          @endif
                        </div>

                      @endcan
                    </div>
                    <div class="card-body">
                      @if ($institution->banner)
                        <img class="img-fluid" src="{{ route('api.files.show', $institution->banner)}}">
                      @else
                        <svg class="img-fluid">
                          <use href="{{asset('icons/sprites/free.svg#cil-image-broken')}}"></use>
                        </svg>
                      @endif
                    </div>
                  </div>
                  <div class="card">
                    <div class="card-header font-weight-bold">Icono
                      @can($institution->editPermission)
                        <div class="card-header-actions">
                          @if ($institution->icon)
                            <div class="card-header-action btn btn-danger" type="button" data-toggle="modal" data-target="#DeleteIconModal">
                              <span class="mx-1 my-2">Eliminar</span>
                            </div>
                          @else
                            <div class="card-header-action btn btn-primary" type="button" data-toggle="modal" data-target="#AddIconModal">
                              <span class="mx-1 my-2">Añadir</span>
                            </div>
                          @endif
                        </div>

                      @endcan
                    </div>
                    <div class="card-body">
                      @if ($institution->icon)
                        <img class="img-fluid" src="{{ route('api.files.show', $institution->icon)}}">
                      @else
                        <svg class="img-fluid">
                          <use href="{{asset('icons/sprites/free.svg#cil-image-broken')}}"></use>
                        </svg>
                      @endif
                    </div>
                  </div>
                </div>
                @can($institution->editPermission)
                  <div class="modal fade" id="DeleteLogoModal" tabindex="-1" role="dialog" aria-labelledby="DeleteLogoModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="DeleteLogoModalLabel">¿Está seguro de eliminar el logo?</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                        </div>
                        <div class="modal-body content-center">
                          <img class="img-fluid my-2 w-75" src="{{ route('api.files.show', $institution->logo)}}">
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                          <form method="POST" action="{{ route('institutions.logo.delete')}}">
                            @csrf
                            <input type="hidden" name="institution" value="{{$institution->id}}">
                            <input type="hidden" name="image" value="{{ $institution->logo}}">
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="modal fade" id="DeleteBannerModal" tabindex="-1" role="dialog" aria-labelledby="DeleteBannerModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="DeleteBannerModalLabel">¿Está seguro de eliminar el banner?</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                        </div>
                        <div class="modal-body content-center">
                          <img class="img-fluid my-2 w-75" src="{{ route('api.files.show', $institution->banner)}}">
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                          <form method="POST" action="{{ route('institutions.banner.delete')}}">
                            @csrf
                            <input type="hidden" name="institution" value="{{$institution->id}}">
                            <input type="hidden" name="image" value="{{$institution->banner}}">
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="modal fade" id="DeleteIconModal" tabindex="-1" role="dialog" aria-labelledby="DeleteIconModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="DeleteIconModalLabel">¿Está seguro de eliminar el icono?</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                        </div>
                        <div class="modal-body content-center">
                          <img class="img-fluid my-2 w-75" src="{{ route('api.files.show', $institution->icon)}}">
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                          <form method="POST" action="{{ route('institutions.icon.delete')}}">
                            @csrf
                            <input type="hidden" name="institution" value="{{$institution->id}}">
                            <input type="hidden" name="image" value="{{$institution->icon}}">
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="modal fade" id="AddLogoModal" tabindex="-1" role="dialog" aria-labelledby="AddLogoModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="AddLogoModalLabel">Agregar el logo de la institución</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                        </div>
                        <form method="POST" action="{{ route('institutions.logo.create')}}" enctype="multipart/form-data">
                          @csrf
                          <div class="modal-body">
                            <div class="form-group">
                              <label for="logo">Logo</label>
                              <input type="hidden" name="institution" value="{{$institution->id}}">
                              <input type="file" class="form-control-file" id="logo" name="logo" required>
                              <div class="invalid-feedback">
                                Seleccione una imagen
                              </div>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Añadir</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  <div class="modal fade" id="AddBannerModal" tabindex="-1" role="dialog" aria-labelledby="AddBannerModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="AddBannerModalLabel">Agregar el banner de la institución</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                        </div>
                        <form method="POST" action="{{ route('institutions.banner.create')}}" enctype="multipart/form-data">
                          @csrf
                          <div class="modal-body">
                            <div class="form-group">
                              <label for="banner">Logo</label>
                              <input type="hidden" name="institution" value="{{$institution->id}}">
                              <input type="file" class="form-control-file" id="banner" name="banner" required>
                              <div class="invalid-feedback">
                                Seleccione una imagen
                              </div>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Añadir</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  <div class="modal fade" id="AddIconModal" tabindex="-1" role="dialog" aria-labelledby="AddIconModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="AddIconModalLabel">Agregar el icono de la institución</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                        </div>
                        <form method="POST" action="{{ route('institutions.icon.create')}}" enctype="multipart/form-data">
                          @csrf
                          <div class="modal-body">
                            <div class="form-group">
                              <label for="icon">Icono</label>
                              <input type="hidden" name="institution" value="{{$institution->id}}">
                              <input type="file" class="form-control-file" id="icon" name="icon" required>
                              <div class="invalid-feedback">
                                Seleccione una imagen
                              </div>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Añadir</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  <div class="modal fade" id="EditInstitutionModal" tabindex="-1" role="dialog" aria-labelledby="EditInstitutionModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="EditInstitutionModalLabel">Editar institución</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                        </div>
                        <form method="POST" action="{{ route('institutions.edit')}}" class="needs-validation" novalidate>
                          @csrf
                          <input type="hidden" name="institution" value="{{ $institution->id}}">
                          <div class="modal-body">
                            <div class="form-row">
                              <div class="form-group col-md-8">
                                <label for="name">Nombre</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $institution->name}}" required />
                                <div class="invalid-feedback">
                                  Ingrese un nombre valido.
                                </div>
                              </div>
                              <div class="form-group col-md-4">
                                <label for="dependency">Dependencia</label>
                                <select class="custom-select" id="dependency" name="dependency" required>
                                  <option selected disabled value="">Selecciona una dependencia</option>
                                  @foreach ($dependencies as $dependency)
                                    <option value="{{$dependency->id}}" {{ $dependency->name == $institution->dependency ? 'selected': ''}}> {{ $dependency->name}} </option>
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
                                <input type="url" class="form-control" id="link" name="link" value="{{ $institution->link}}" required>
                                <div class="invalid-feedback">
                                  Ingrese un url valido.
                                </div>
                              </div>
                              <div class="form-group col-md-4">
                                <label for="type">Tipo</label>
                                <select class="custom-select" id="type" name="type" required>
                                  <option selected disabled value="">Selecciona un tipo de institución</option>
                                  @foreach ($types as $type)
                                    <option value="{{$type->id}}" {{ $type->name == $institution->type ? 'selected': ''}}> {{$type->name}} </option>
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
                                  <input type="text" class="form-control" id="phone" name="phone" pattern="[0-9]+" minlength="9" maxlength="9" value="{{ Str::after($institution->phone, '+56') }}" required />
                                </div>
                                <div class="invalid-feedback">
                                  Ingrese un telefono valido
                                </div>
                              </div>
                              <div class="col-md-1"></div>
                              <div class="form-group col-md-2">
                                <label class="c-switch c-switch-lg c-switch-pill c-switch-primary">
                                  <label for="cruch" class="text-nowrap">¿Pertenece al Cruch?</label>
                                  <input type="checkbox" class="c-switch-input" name="cruch" id="cruch" {{ $institution->cruch ? 'checked' : ''}}>
                                  <span class="c-switch-slider"></span>
                                </label>
                              </div>
                              <div class="col-md-1"></div>
                              <div class="form-group col-md-2">
                                <label class="c-switch c-switch-lg c-switch-pill c-switch-primary">
                                  <label for="sua" class="text-nowrap">¿Sistema Único de Admisión?</label>
                                  <input type="checkbox" class="c-switch-input" name="sua" id="sua" {{ $institution->sua ? 'checked' : ''}}>
                                  <span class="c-switch-slider"></span>
                                </label>
                              </div>
                              <div class="col-md-1"></div>
                              <div class="form-group col-md-1">
                                <label class="c-switch c-switch-lg c-switch-pill c-switch-primary">
                                  <label for="gratuidad" class="text-nowrap">¿Gratuidad?</label>
                                  <input type="checkbox" class="c-switch-input" name="gratuidad" id="gratuidad" {{ $institution->gratuidad ? 'checked' : ''}}>
                                  <span class="c-switch-slider"></span>
                                </label>
                              </div>
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
                @endcan
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('javascript')

@endsection
