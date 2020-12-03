@extends ('layouts.base')

@section('sidebar')
  @include('layouts.sidebars.admin')
@endsection

@section('content')
  <div class="container-fluid">
    <div class="fade-in">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header text-value-lg">Dashboard</div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <div id="executive-chart" data-source=""></div>
                </div>
              </div>
              <br />
              <div class="row">
                <div class="col-md-12">
                  <div class="card-deck">
                    <div class="card text-white bg-primary">
                      <div class="card-body d-flex justify-content-between align-content-start">
                        <div>
                          <div class="text-value-lg">{{$countProduction}}</div>
                          <div>Producciones de Hoy</div>
                        </div>
                      </div>
                    </div>
                    <div class="card text-white bg-warning">
                      <div class="card-body d-flex justify-content-between align-content-start">
                        <div>
                          <div class="text-value-lg">{{$countOrder}}</div>
                          <div>Despachos de Hoy</div>
                        </div>
                      </div>
                    </div>
                    <div class="card text-white bg-success">
                      <div class="card-body d-flex justify-content-between align-content-start">
                        <div>
                          <div class="text-value-lg">@money($totalIncome)</div>
                          <div>Recaudación de Hoy</div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="container-fluid">
    <div class="fade-in">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-value-lg">
                        Producción de Hoy 
                        <div class="card-header-actions">
                            <a class="card-header-action btn btn-lg btn-primary" role="button" href="{{ route('admin.production.create') }}">
                                <svg class="c-icon mx-1 my-1">
                                    <use href="{{ asset('icons/sprites/free.svg#cil-plus') }}"></use>
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
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Producto</th>
                                    <th scope="col">Cantidad</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Costo</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($productions as $production)
                                    <tr>
                                        <td scope="row">{{ $production->id }}</td>
                                        <td scope="row">{{ $production->name }}</td>
                                        <td scope="row">{{ $production->product }}</td>
                                        <td scope="row">{{ $production->quantity }}</td>
                                        <td scope="row">{{ $production->date }}</td>
                                        <td scope="row"> @money($production->cost) </td>
                                        <td scope="row">
                                            <div class="btn-group" role="group" aria-label="">
                                                <a role="button" class="btn btn-ghost-secondary" href="#" data-toggle="tooltip" data-placement="top" title="Editar produccion">
                                                    <svg class="c-icon">
                                                        <use href="{{ asset('icons/sprites/free.svg#cil-external-link') }}"></use>
                                                    </svg>
                                                </a>
                                                
                                                <button class="btn btn-delete btn-ghost-danger" type="button" data-toggle="modal" data-target="{{ '#DeleteProduction' . $production->id . 'Modal' }}">
                                                    <svg class="c-icon" data-toggle="tooltip" data-placement="top" title="Eliminar producto">
                                                        <use href="{{ asset('icons/sprites/free.svg#cil-trash ') }}"></use>
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                @if(count($productions) == 0)
                                    <tr>
                                        <td class="text-center text-value-lg">No ha creado ninguna producción</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@foreach($productions as $production)
    <div class="modal fade" id="{{ 'DeleteProduction' . $production->id . 'Modal' }}" tabindex="-1" role="dialog" aria-labelledby="{{ 'DeleteProduction' . $production->id . 'Modal' }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="{{ 'DeleteProduction' . $production->id . 'ModalLabel' }}"> ¿Está seguro de eliminar esta produccion?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('admin.production.delete') }}">
                    @csrf
                    <div class="modal-body">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <input type="hidden" name="id" value="{{ $production->id }}">
                        <button type="submit" class="btn btn-danger btn_user_delete">Eliminar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
<div class="container-fluid">
    <div class="fade-in">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-value-lg">
                        Despachos de Hoy
                        <div class="card-header-actions">
                            <a class="card-header-action btn btn-lg btn-primary" role="button" href="{{ route('admin.order.create') }}">
                                <svg class="c-icon mx-1 my-1">
                                    <use href="{{ asset('icons/sprites/free.svg#cil-plus') }}"></use>
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
                                    <th scope="col">Productos</th>
                                    <th scope="col">Detalle</th>
                                    <th scope="col">Precio</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td scope="row">{{ $order->id }}</td>
                                        <td scope="row">{{ $order->date }}</td>
                                        <td scope="row">{{ $order->client }}</td>
                                        <td scope="row">{{ $order->dealer }}</td>
                                    
                                        <td scope="row">
                                            <ul>
                                                @if(count($order->productions) != 0)
                                                    @foreach($order->productions as $production)
                                                        <li>{{ $production->product_name }} - {{ $production->production_name }} - {{ $production->quantity }} {{ $production->measure }}</li>
                                                    @endforeach
                                                @endif
                                            </ul>
                                        </td>
                                        <td scope="row">{{ $order->detail }}</td>
                                        <td scope="row"> @money($order->total_to_pay) </td>
                                        <td scope="row">
                                            <div class="btn-group" role="group" aria-label="">
                                                <a role="button" class="btn btn-ghost-secondary" href="#" data-toggle="tooltip" data-placement="top" title="Editar produccion">
                                                    <svg class="c-icon">
                                                        <use href="{{ asset('icons/sprites/free.svg#cil-external-link') }}"></use>
                                                    </svg>
                                                </a>                          
                                                <button class="btn btn-delete btn-ghost-danger" type="button" data-toggle="modal" data-target="{{ '#DeleteOrder' . $order->id . 'Modal' }}">
                                                    <svg class="c-icon" data-toggle="tooltip" data-placement="top" title="Eliminar despacho">
                                                        <use href="{{ asset('icons/sprites/free.svg#cil-trash ') }}"></use>
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                @if(count($orders) == 0)
                                    <tr>
                                        <td class="text-center text-value-lg">No ha creado ningun despacho</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@foreach($orders as $order)
    <div class="modal fade" id="{{ 'DeleteOrder' . $order->id . 'Modal' }}" tabindex="-1" role="dialog" aria-labelledby="{{ 'DeleteOrder' . $order->id . 'Modal' }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="{{ 'DeleteOrder' . $order->id . 'ModalLabel' }}"> ¿Está seguro de eliminar esta produccion?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('admin.order.delete') }}">
                    @csrf
                    <div class="modal-body">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <input type="hidden" name="id" value="{{ $order->id }}">
                        <button type="submit" class="btn btn-danger btn_user_delete">Eliminar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
@endsection

@section('javascript')
    
@endsection
