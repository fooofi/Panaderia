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
                Facultades
              </div>
              <div class="card-body">
                <h4>No has agregado ninguna institución</h4>
              </div>
            </div>
          @endif
          @foreach ($institutions as $institution)
            <div class="card">
              <div class="card-header text-value-lg">
                {{ $institution->name}}
                @unlessrole('executive')
                <div class="card-header-actions">
                  <a class="card-header-action btn btn-lg btn-primary" role="button" href="{{ route('campuses.create', ['institution' => $institution->id])}}">
                    <span class="mx-1 my-2">Añadir</span>
                  </a>
                </div>
                @endunlessrole
              </div>
              <div class="card-body">
                @if (count($institution->campuses) == 0)
                  <h4>No has agregado ninguna facultad.</h4>
                @else
                  <div class="card-columns">
                    @foreach ($institution->campuses as $campus)
                    <div class="card">
                      <div class="card-header">{{ $campus->name }}</div>
                      <div class="card-body">
                        <div class="card-text"> Dirección: {{ $campus->address }}</div>
                        <div class="card-text"> Comuna: {{ $campus->commune }}</div>
                        <div class="card-text"> Región: {{ $campus->commune->province->region }}</div>
                      </div>
                      <div class="card-footer clearfix">
                        <a class="btn btn-outline-secondary float-left" role="button" href="{{ route('campuses.show', $campus->id)}}"> Ver facultad </a>
                        <a class="btn btn-outline-secondary float-right" role="button" href="{{ $campus->link }}"> Página Oficial </a>
                      </div>
                    </div>
                    @endforeach
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
