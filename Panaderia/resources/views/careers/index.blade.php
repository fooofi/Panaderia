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
      @role('admin')
        <div class="row">
          <div class="col-md-12">
            <div class="card w-100">
              <div class="card-body">
                <h5>Organización</h5>
                <select class="custom-select" id="organization" name="organization">
                  <option {{ $organization_id ? '' : 'selected'}} value="0">Seleccione una organización</option>
                  @foreach ($organizations as $organization)
                  <option value="{{ $organization->id}}" {{ $organization_id == $organization->id? 'selected' : ''}}>{{$organization->name}} </option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
        </div>
      @endrole
      <div class="row">
        <div class="col-md-12">
          @if(count($institutions) == 0)
              <div class="card">
                  <div class="card-header text-value-lg">
                    Carreras
                  </div>
                  <div class="card-body">
                    <h4>No has agregado ninguna institución</h4>
                  </div>
              </div>
          @endif
          @foreach($institutions as $institution)
            <div class="card">
              <div class="card-header text-value-lg">
                {{ $institution->name }}
                @unlessrole('executive')
                  <div class="card-header-actions">
                    <a class="card-header-action btn btn-lg btn-primary" role="button" href="{{ route('careers.create', ['institution' => $institution->id]) }}">
                      <svg class="c-icon mx-1 my-2">
                        <use href="{{ asset('icons/sprites/free.svg#cil-plus') }}"></use>
                      </svg>
                      <span class="mr-2">Nuevo</span>
                    </a>
                  </div>
                @endunlessrole
              </div>
              <div class="card-body">
                @if($institution->campuses == 0)
                  <h4>No has agregado ninguna facultad.</h4>
                @else
                  <div class="card-columns">
                    @if(count($institution->careers) == 0)
                      <h4>No has agregado ninguna carrera.</h4>
                    @else
                      @foreach($institution->careers as $career)
                        <div class="card">
                          <div class="card-header">{{ $career->name }}</div>
                          <div class="card-body">
                            {{-- <div class="card-text"> {{ $career->description }}</div> --}}
                            <div class="card-text">
                              Area: {{ $career->area  }}
                            </div> 
                            <div class="card-text ">
                              Modalidad: {{ $career->modality  }}
                            </div>
                            {{-- <div class="card-text ">
                              {{ $career->scholarships->name  }}
                            </div> --}}
                            <div class="card-text">
                              Semestres: {{ $career->semesters }}
                            </div>
                          </div>
                          <div class="card-footer clearfix">
                            <a class="btn btn-outline-secondary float-left" role="button" href="{{ route('careers.show', $career->id) }}"> Ver carrera </a>
                            <a class="btn btn-outline-secondary float-right" role="button" href="{{ $career->link }}"> Página Oficial </a>
                          </div>
                        </div>
                      @endforeach
                    @endif
                  </div>
                @endif
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
    $("#organization").change(function(){
      if($(this).val() == "0"){
        window.location = window.location.href.split('?')[0]
        return;
      }
      window.location=window.location.href.split('?')[0] + "?organization=" + $(this).val()
    });
  </script>
  @endsection