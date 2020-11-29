@extends('layouts.base')

@section('sidebar')
@include('layouts.sidebars.manager')
@endsection

@section('content')
<div class="container-fluid">
    <div class="fade-in">
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
                @foreach($institutions as $institution)
                    <div class="card">
                        <div class="card-header text-value-lg">
                            {{ $institution->name }}
                            <div class="card-header-actions">
                                <a class="card-header-action btn btn-lg btn-primary" role="button" href="{{ route('manager.careers.create', ['institution' => $institution->id]) }}">
                                    <svg class="c-icon mx-1 my-2">
                                        <use href="{{ asset('icons/sprites/free.svg#cil-plus') }}"></use>
                                    </svg>
                                    <span class="mr-2">Nuevo</span>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            @if(count($institution->campuses) == 0)
                                <h4>No has agregado ninguna facultad.</h4>
                            @else
                                <div class="card-columns">
                                    @if($count == 0)
                                        <h4>No has agregado ninguna carrera.</h4>
                                    @else
                                        @foreach($institution->campuses as $campus)
                                            @foreach($campus->careers as $career)
                                                <div class="card">
                                                    <div class="card-header">{{ $career->name }}</div>
                                                    <div class="card-body">
                                                        {{-- <div class="card-text"> {{ $career->description }}</div> --}}
                                                        <div class="card-text">
                                                            Area: {{ $career->area->name  }}
                                                        </div> 
                                                        <div class="card-text ">
                                                            Modalidad: {{ $career->modality->name  }}
                                                        </div>
                                                        {{-- <div class="card-text ">
                                                            {{ $career->scholarships->name  }}
                                                        </div> --}}
                                                        <div class="car-text">
                                                            Semestres: {{ $career->semesters }}
                                                        </div>
                                                    </div>
                                                    <div class="card-footer clearfix">
                                                        <a class="btn btn-outline-primary float-left" role="button" href="{{ route('manager.careers.show', $campus->id) }}"> Ver
                                                            carrera </a>
                                                        <a class="btn btn-outline-primary float-right" role="button" href="{{ $campus->link }}">
                                                            Página Oficial </a>
                                                    </div>
                                                </div>
                                            @endforeach
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

@endsection