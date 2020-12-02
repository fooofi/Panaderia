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
              Despachos
              <div class="card-header-actions">
                <a class="card-header-action btn btn-lg btn-primary" role="button" href="{{ route('admin.order.create')}}">
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
                    <th scope="col">ID</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Cliente</th>
                    <th scope="col">Repartidor</th>
                    <th scope="col">Producto</th>
                    <th scope="col">Cantidad</th>
                    <th scope="col">Detalle</th>
                    <th scope="col">Precio</th>
                    <th scope="col">Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td scope="row">1</td>
                    <td scope="row">02/12/2020</td>
                    <td scope="row">Sra Juana</td>
                    <td scope="row">Daniel</td>
                    <td scope="row">Marraqueta</td>
                    <td scope="row">15 kg</td>
                    <td scope="row">se necesita que llegue a la hora</td>
                    <td scope="row">$12.000</td>
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
