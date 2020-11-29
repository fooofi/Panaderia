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
            <div class="card-header text-value-lg">
              Organizaciones
              <div class="card-header-actions">
                <a class="card-header-action btn btn-lg btn-primary" role="button" href="{{ route('admin.organizations.create')}}">             
                  <span class="mx-1 my-2">Añadir</span>
                </a>
              </div>
            </div>
            <div class="card-body">
              <table class="table table-responsive-sm table-hover table-outline">
                <thead>
                  <tr>
                    <th scope="col">Nombre formal</th>
                    <th scope="col">Nombre de fantasía</th>
                    <th scope="col">Rut</th>
                    <th scope="col">Comuna</th>
                    <th scope="col">Tipo</th>
                    <th scope="col">Usuarios</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($organizations as $organization)
                  <tr>
                    <td scope="row">{{ $organization->business_name }}</td>
                    <td scope="row">{{ $organization->fantasy_name }}</td>
                    <td scope="row">{{ $organization->rut }}</td>
                    <td scope="row">{{ $organization->commune->name}}</td>
                    <td scope="row">{{ $organization->organization_type->name }}</td>
                    <td scope="row">{{ $organization->users->count() }}</td>
                  </tr>    
                  @endforeach

                  @if (count($organizations)== 0)
                      <tr>
                        <td colspan="6" class="text-center text-value-lg"> No ha creado ninguna Organization</td>
                      </tr>
                  @endif
                </tbody>
              </table>
              @if(count($organizations) > 0)
              <ul class="pagination justify-content-end">
                <li class="page-item{{ $organizations->onFirstPage() ? ' disabled' : ''}} ">
                  <a class="page-link" href="{{ $organizations->previousPageUrl()}}" aria-labelledby="Anterior">
                    <span aria-hidden="true">&laquo;</span>
                  </a>
                </li>
                @for ($page=1; $page <= $organizations->lastPage(); $page++)
                  <li class="page-item{{$organizations->currentPage() == $page ? ' active' : ''}}">
                    <a class="page-link" href="{{$organizations->url($page)}}" >{{ $page }}</a>
                  </li>
                @endfor
                
                <li class="page-item{{ $organizations->currentPage() == $organizations->lastPage() ? ' disabled' : ''}}">
                  <a class="page-link" href="{{ $organizations->nextPageUrl()}}" aria-labelledby="Siguiente">
                    <span aria-hidden="true">&raquo;</span>
                  </a>
                </li>
              </ul>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('javascript')
    
@endsection