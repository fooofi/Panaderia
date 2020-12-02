@extends('layouts.base')

@section('sidebar')
@include('layouts.sidebars.admin')
@endsection

@section('content')
  <div class="container-fluid">
    <div class="fade-in">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header text-value-lg">
              Productos
              <div class="card-header-actions">
                <a class="card-header-action btn btn-lg btn-primary" role="button" href="{{ route('admin.product.create')}}">
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
                    <th scope="col">Medida</th>
                    <th scope="col">Materiales</th>
                    <th scope="col">Costo</th>
                    <th scope="col">Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td scope="row">Marraqueta</td>
                    <td scope="row">Kilos</td>
                    <td scope="row">
                    <ul>
                        <li>Harina</li>
                        <li>Manteca</li>
                        <li>Sal</li>
                    </ul> 
                    </td>
                    <td scope="row">$1.200</td>
                    <td scope="row">
                      <div class="btn-group" role="group" aria-label="">
                        <a role="button" class="btn btn-ghost-secondary" href="#" data-toggle="tooltip" data-placement="top" title="Editar material">
                          <svg class="c-icon">
                            <use href="{{ asset('icons/sprites/free.svg#cil-external-link')}}"></use>
                          </svg>
                        </a>
                      {{--   --}}
                        <button class="btn btn-delete btn-ghost-danger" type="button" data-toggle="modal" data-target="">
                          <svg class="c-icon" data-toggle="tooltip" data-placement="top" title="Eliminar material" >
                            <use href="{{ asset('icons/sprites/free.svg#cil-trash ')}}" ></use>
                          </svg>
                        </button>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
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
