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
                        Produccion
                        <div class="card-header-actions">
                            <a class="card-header-action btn btn-lg btn-primary" role="button" href="#">
                                <span class="mx-1 my-2">Añadir</span>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')

@endsection