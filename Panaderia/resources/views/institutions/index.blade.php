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
          <div class="card">
            <div class="card-header text-value-lg">
              Instituciones
              <div class="card-header-actions">
                <a class="card-header-action btn btn-lg btn-primary" role="button" href="{{ route('institutions.create')}}">
                  <svg class="c-icon mx-1 my-1">
                    <use href="{{ asset('icons/sprites/free.svg#cil-plus')}}"></use>
                  </svg>
                  <span class="mr-2">Nuevo</span>
                </a>
              </div>
            </div>
            <div class="card-body">
              <table class="table table-responsive-sm table-hover table-outline">
                <thead>
                  <tr>
                    <th scope="col">Nombre</th>
                    @if($admin)
                      <th scope="col">Organización</th>
                    @endif
                    <th scope="col">Dependencia</th>
                    <th scope="col">Tipo</th>
                    <th scope="col" style="text-align: center">CRUCH</th>
                    <th scope="col" style="text-align: center">SUA</th>
                    <th scope="col" style="text-align: center">Gratuidad</th>
                    <th scope="col">Ejecutivos</th>
                    <th scope="col">Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($institutions as $institution)
                  <tr>
                    <td scope="row">{{ $institution->name }}</td>
                    @if($admin)
                      <td scope="row">{{ $institution->organization}}</td>
                    @endif
                    <td scope="row">{{ $institution->dependency }}</td>
                    <td scope="row">{{ $institution->type }}</td>
                    <td scope="row">
                      <svg class="c-icon c-icon-xl" style="display: block; margin: auto;">
                        @if ($institution->cruch)
                        <use href="{{ asset('icons/sprites/free.svg#cil-check-circle')}}" fill="green"></use>
                        @else
                        <use href="{{ asset('icons/sprites/free.svg#cil-x-circle')}}" fill="red"></use>
                        @endif
                      </svg>
                    </td>
                    <td scope="row">
                      <svg class="c-icon c-icon-xl" style="display: block; margin: auto;">
                        @if ($institution->sua)
                        <use href="{{ asset('icons/sprites/free.svg#cil-check-circle')}}" fill="green"></use>
                        @else
                        <use href="{{ asset('icons/sprites/free.svg#cil-x-circle')}}" fill="red"></use>
                        @endif
                      </svg>
                    </td>
                    <td scope="row">
                      <svg class="c-icon c-icon-xl" style="display: block; margin: auto;">
                        @if ($institution->gratuidad)
                        <use href="{{ asset('icons/sprites/free.svg#cil-check-circle')}}" fill="green"></use>
                        @else
                        <use href="{{ asset('icons/sprites/free.svg#cil-x-circle')}}" fill="red"></use>
                        @endif
                      </svg>
                    </td>
                    <td scope="row"> {{ $institution->users}} / {{ $institution->max_users}}</td>
                    <td scope="row">
                      <div class="btn-group" role="group" aria-label="{{ 'Institution' . $institution->id .'Actions'}}">
                        <a role="button" class="btn btn-ghost-secondary" href="{{ route('institutions.show', $institution->id)}}" data-toggle="tooltip" data-placement="top" title="Ver institución">
                          <svg class="c-icon">
                            <use href="{{ asset('icons/sprites/free.svg#cil-external-link')}}"></use>
                          </svg>
                        </a>
                      {{--   --}}
                        <button class="btn btn-delete btn-ghost-danger" type="button" data-toggle="modal" data-target="{{'#DeleteInstitution' . $institution->id . 'Modal'}}">
                          <svg class="c-icon" data-toggle="tooltip" data-placement="top" title="Eliminar institutición" >
                            <use href="{{ asset('icons/sprites/free.svg#cil-trash ')}}" ></use>
                          </svg>
                        </button>
                      </div>
                    </td>
                  </tr>
                  @endforeach
                  @if (count($institutions) == 0)
                  <tr>
                    <td colspan="{{ $admin ? '9' : '8'}}" class="text-center text-value-lg">No ha creado ninguna Institución</td>
                  </tr>
                  @endif
                </tbody>
              </table>
              @if (count($institutions) > 0 && $admin)
                <ul class="pagination justify-content-end">
                  <li class="page-item {{ $institutions->onFirstPage() ? 'disabled' : ''}}">
                    <a class="page-link" href="{{ $institutions->previousPageUrl()}}" aria-labelledby="Anterior">
                      <span aria-hidden="true">&laquo;</span>
                    </a>
                  </li>
                  @for ($i = 1; $i <= $institutions->lastPage(); $i++)
                    <li class="page-item {{$institutions->currentPage() == $i ? 'active' : ''}}">
                      <a class="page-link" href="{{ $institutions->url($i)}}"> {{ $i }} </a>
                    </li>
                  @endfor
                  <li class="page-item {{ $institutions->currentPage() == $institutions->lastPage() ? 'disabled' : ''}}">
                    <a class="page-link" href="{{ $institutions->nextPageUrl()}}" aria-labelledby="Siguiente">
                      <span aria-hidden="true">&raquo;</span>
                    </a>
                  </li>
                </ul>
              @endif
            </div>
          </div>
          @foreach ($institutions as $institution)
            <div class="modal fade" id="{{ 'DeleteInstitution' . $institution->id . 'Modal'}}" tabindex="-1" role="dialog" aria-labelledby="{{ 'DeleteInstitution' . $institution->id . 'ModalLabel'}}" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="{{ 'DeleteInstitution' . $institution->id . 'ModalLabel'}}"> ¿Está seguro de eliminar esta institutición?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body content-center">

                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <form method="POST" action="{{ route('institutions.delete')}}">
                      @csrf
                      <input type="hidden" name="id" value="{{ $institution->id}}">
                      <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
@endsection

@section('javascript')
  <script>
    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    });

  </script>
@endsection
