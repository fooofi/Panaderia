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
                <div class="card">
                    <div class="card-header text-value-xl"> {{ $career->name }}
                        @can($career->editPermission)
                            <div class="card-header-actions">
                                <a class="card-header-action btn btn-lg btn-primary" role="button" data-target="#EditCareerModal" data-toggle="modal">
                                    <span class="mx-2">Editar</span>
                                </a>
                            </div>
                        @endcan
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-7">
                                <div class="card-text text-value-lg" id="description"> {{ $career->description }}</div>
                                <br>
                                <div class="card-text text-muted"> {{ $career->institution_name }}</div>
                                <br>
                                <div>
                                    <label for="link" class="font-weight-bold">Facultad:</label>
                                    @if($career->campuses->count() == 0)
                                        <span>Sin Facultad</span>
                                    @endif
                                    <ul>
                                        @foreach($career->campuses as $campus)
                                            <li>
                                                <a class="text-decoration-none" href="{{ route('campuses.show', $campus->id) }}" id="link">{{ $campus->name }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div>
                                    <label for="type" class="font-weight-bold">Tipo de Carrera:</label>
                                    <a class="card-text text-decoration-none" id="type">{{ $career->career_type->name }}</a>
                                </div>
                                <div>
                                    <label for="regime" class="font-weight-bold">Regimen:</label>
                                    <a class="card-text text-decoration-none" id="regime">{{ $career->career_regime->name }}</a>
                                </div>
                                <div>
                                    <label for="area" class="font-weight-bold">Area:</label>
                                    <a class="card-text text-decoration-none" id="area">{{ $career->area->name }}</a>
                                </div>
                                <div>
                                    <label for="modality" class="font-weight-bold">Modalidad:</label>
                                    <a class="card-text text-decoration-none" id="modality">{{ $career->modality->name }}</a>
                                </div>
                                <div>
                                    <label for="semesters" class="font-weight-bold">Semestres:</label>
                                    <a class="card-text text-decoration-none" id="semesters">{{ $career->semesters }}</a>
                                </div>
                                <div>
                                    <label for="accreditation" class="font-weight-bold">Acreditacion:</label>
                                    <a class="card-text text-decoration-none" id="accreditation">{{ $career->accreditation }}</a>
                                </div>
                                <div>
                                    <label for="scholarship" class="font-weight-bold">Becas:</label>
                                    @if(@$career->scholarships->count() == 0)
                                        <span>Sin Becas</span>
                                    @endif
                                    <ul>
                                        @foreach(@$career->scholarships as $campus)
                                            <li>
                                                <span class="text-decoration-none">{{ $campus->name }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="card">
                                    <div class="card-header font-weight-bold">Imagen
                                        @can($career->editPermission)
                                            <div class="card-header-actions">
                                                @if($career->image)
                                                    <div class="card-header-action btn btn-danger" type="button" data-target="#DeleteImageModal" data-toggle="modal">
                                                        <span class="mx-1 my-2">Eliminar</span>
                                                    </div>
                                                @else
                                                    <div class="card-header-action btn btn-primary" type="button" data-toggle="modal" data-target="#AddImageModal">
                                                        <span class="mx-1 my-2">Añadir</span>
                                                    </div>
                                                @endif
                                            </div>

                                        @endcan
                                    </div>
                                    <div class="card-body">
                                        @if($career->image)
                                            <img class="img-fluid" src="{{ route('api.files.show', $career->image) }}">
                                        @else
                                            <svg class="img-fluid">
                                                <use href="{{ asset('icons/sprites/free.svg#cil-image-broken') }}"></use>
                                            </svg>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-4">
                                <label class="font-weight-bold">Folleto del curso</label>
                                <div class="card-deck">
                                    @if($career->brochure_pdf != null)
                                        <div class="card">
                                            <div class="card-footer">
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="{{ '#ViewBrochure' . $career->id . 'Modal' }}">Ver</button>
                                                    @can($career->editPermission)
                                                        <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="{{ '#DeleteBrochure' . $career->id . 'Modal' }}">Eliminar</button>
                                                    @endcan
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @can($career->editPermission)
                                        @if($career->brochure_pdf == null)
                                            <div class="card w-75">
                                                <div class="card-body">
                                                    <svg class="c-icon c-icon-4xl">
                                                        <use href="{{ asset('icons/sprites/free.svg#cil-plus') }}"></use>
                                                    </svg>
                                                    <a class="stretched-link" role="button" data-toggle="modal" data-target="{{ '#AddBrochure' . $career->id . 'Modal' }}"></a>
                                                </div>
                                            </div>
                                        @endif
                                    @endcan
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="font-weight-bold">Malla currilar del curso</label>
                                @if($career->curricular_mesh_pdf != null)
                                    <div class="card">
                                        <div class="card-footer">
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="{{ '#ViewCurricularMesh' . $career->id . 'Modal' }}">Ver</button>
                                                @can($career->editPermission)
                                                    <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="{{ '#DeleteCurricularMesh' . $career->id . 'Modal' }}">Eliminar</button>
                                                @endcan
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @can($career->editPermission)
                                    @if($career->curricular_mesh_pdf == null)
                                        <div class="card w-75">
                                            <div class="card-body">
                                                <svg class="c-icon c-icon-4xl">
                                                    <use href="{{ asset('icons/sprites/free.svg#cil-plus') }}"></use>
                                                </svg>
                                                <a class="stretched-link" role="button" data-toggle="modal" data-target="{{ '#AddCurricularMesh' . $career->id . 'Modal' }}"></a>
                                            </div>
                                        </div>
                                    @endif
                                @endcan
                            </div>
                            <div class="col-md-4">
                                <label class="font-weight-bold">Puntajes de Corte</label>
                                @if($score != null)
                                    <div class="card">
                                        <div class="card-footer">
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="{{ '#ViewScore' . $career->id . 'Modal' }}">Ver</button>
                                                @can($career->editPermission)
                                                    <form method="POST" action="{{ route('careers.score.delete') }}">
                                                        @csrf
                                                        <input type="hidden" name="institution" value="{{ $career->institution_id }}">
                                                        <input type="hidden" name="id" value="{{ $career->id }}">
                                                        <button type="submit" class="btn btn-secondary">Eliminar</button>
                                                    </form>
                                                @endcan
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @can($career->editPermission)
                                    @if($score == null)
                                        <div class="card w-75">
                                            <div class="card-body">
                                                <svg class="c-icon c-icon-4xl">
                                                    <use href="{{ asset('icons/sprites/free.svg#cil-plus') }}"></use>
                                                </svg>
                                                <a class="stretched-link" role="button" data-toggle="modal" data-target="{{ '#AddScore' . $career->id . 'Modal' }}"></a>
                                            </div>
                                        </div>
                                    @endif
                                @endcan
                            </div>
                        </div>
                    </div>

                    {{-- MODALS --}}
                    @if($score != null)
                        <div class="modal fade" id="{{ 'ViewScore' . $career->id . 'Modal' }}" tabindex="-1" role="dialog" aria-labelledby="ViewScoreModalLabel">
                            <div class="modal-dialog modal-xl" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="ViewScoreModalLabel">Editar Facultad</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form class="needs-validation" method="POST" action="{{ route('careers.score.create', $career->id) }}" novalidate>
                                        @csrf
                                        <div class="modal-body">
                                            <input type="hidden" id="institution_id" name="institution_id" value="{{ $career->institution_id }}">
                                            <div class="row">
                                                <div class="form-group col-md-3">
                                                    <label for="nem">NEM:</label>

                                                    <a class="card-text text-decoration-none" id="semesters">{{ $score->nem }}</a>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="ranking">Ranking:</label>

                                                    <a class="card-text text-decoration-none" id="semesters">{{ $score->ranking }}</a>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="math">Puntaje Matematica:</label>

                                                    <a class="card-text text-decoration-none" id="semesters">{{ $score->math }}</a>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="language">Puntaje Lenguaje:</label>

                                                    <a class="card-text text-decoration-none" id="semesters">{{ $score->language }}</a>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-3">
                                                    <label for="history_science">Puntaje Historia o Ciencias:</label>

                                                    <a class="card-text text-decoration-none" id="semesters">{{ $score->history_science }}</a>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="max_score">Puntaje Maximo:</label>

                                                    <a class="card-text text-decoration-none" id="semesters">{{ $score->max_score }}</a>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="avg_score">Puntaje Ponderado:</label>

                                                    <a class="card-text text-decoration-none" id="semesters">{{ $score->avg_score }}</a>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="min_score">Puntaje Minimo:</label>

                                                    <a class="card-text text-decoration-none" id="semesters">{{ $score->min_score }}</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                            {{-- <button type="submit" class="btn btn-primary">Enviar</button> --}}
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="modal fade" id="{{ 'ViewBrochure' . $career->id . 'Modal' }}" tabindex="-1" role="dialog" aria-labelledby="{{ 'ViewImage' . $career->id . 'ModalLabel' }}" aria-hidden="true">
                        <div class="modal-dialog modal-xl" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="{{ 'ViewBrochure' . $career->id . 'ModalLabel' }}"> Folleto </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body embed-responsive embed-responsive-16by9">
                                    @if($career->brochure_pdf != null)
                                        <iframe class="embed-responsive-item" src="{{ route('api.files.show', $career->brochure_pdf) }}">
                                        </iframe>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="{{ 'ViewCurricularMesh' . $career->id . 'Modal' }}" tabindex="-1" role="dialog" aria-labelledby="{{ 'ViewImage' . $career->id . 'ModalLabel' }}" aria-hidden="true">
                        <div class="modal-dialog modal-xl" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="{{ 'ViewCurricularMesh' . $career->id . 'ModalLabel' }}"> Imagen </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body embed-responsive embed-responsive-16by9">
                                    @if($career->curricular_mesh_pdf != null)
                                        <iframe class="embed-responsive-item" src="{{ route('api.files.show', $career->curricular_mesh_pdf) }}">
                                        </iframe>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    @can($career->editPermission)
                        <div class="modal fade" id="{{ 'AddBrochure' . $career->id . 'Modal' }}" tabindex="-1" role="dialog" aria-labelledby="AddBrochureModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="AddBrochureModalLabel">Agregar folleto del curso</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form method="POST" class="needs-validation" action="{{ route('careers.images.brochure.create') }}" enctype="multipart/form-data" novalidate>
                                        @csrf
                                        <input type="hidden" name="institution" value="{{ $career->institution_id }}">
                                        <input type="hidden" name="id" value="{{ $career->id }}">
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="brochure">Imagen o PDF</label>
                                                <input type="file" class="form-control-file" id="brochure" name="brochure" required>
                                                <div class="invalid-feedback">
                                                    Seleccione una imagen o PDF
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
                        <div class="modal fade" id="{{ 'DeleteBrochure' . $career->id . 'Modal' }}" tabindex="-1" role="dialog" aria-labelledby="DeleteBrochure" aria-hidden="true">
                            <div class="modal-dialog modal-xl" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="{{ 'DeleteBrochure' . $career->id . 'Modal' }}"> ¿Está seguro de eliminar esta imagen?</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body embed-responsive embed-responsive-16by9">
                                        @if($career->brochure_pdf != null)
                                            <iframe class="embed-responsive-item" src="{{ route('api.files.show', $career->brochure_pdf) }}">
                                            </iframe>
                                        @endif
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                        <form method="POST" action="{{ route('careers.images.brochure.delete') }}">
                                            @csrf
                                            <input type="hidden" name="institution" value="{{ $career->institution_id }}">
                                            <input type="hidden" name="id" value="{{ $career->id }}">
                                            <input type="hidden" name="image" value="{{ $career->brochure_pdf }}">
                                            <button type="submit" class="btn btn-primary">Eliminar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="{{ 'AddCurricularMesh' . $career->id . 'Modal' }}" tabindex="-1" role="dialog" aria-labelledby="AddCurricularMeshModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="AddCurricularMeshModalLabel">Agregar malla curricular</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form method="POST" class="needs-validation" action="{{ route('careers.images.curricularmesh.create', $career->id) }}" enctype="multipart/form-data" novalidate>
                                        <div class="modal-body">
                                            @csrf
                                            <input type="hidden" name="institution" value="{{ $career->institution_id }}">
                                            <input type="hidden" name="id" value="{{ $career->id }}">
                                            <div class="form-group">
                                                <label for="curricular_mesh">Imagen o PDF</label>
                                                <input type="file" class="form-control-file" id="curricular_mesh" name="curricular_mesh" required>
                                                <div class="invalid-feedback">
                                                    Seleccione una imagen o PDF
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
                        <div class="modal fade" id="{{ 'DeleteCurricularMesh' . $career->id . 'Modal' }}" tabindex="-1" role="dialog" aria-labelledby="DeleteCurricularMesh" aria-hidden="true">
                            <div class="modal-dialog modal-xl" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="{{ 'DeleteCurricularMesh' . $career->id . 'Modal' }}"> ¿Está seguro de eliminar esta imagen?</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body embed-responsive embed-responsive-16by9">
                                        @if($career->curricular_mesh_pdf != null)
                                            <iframe class="embed-responsive-item" src="{{ route('api.files.show', $career->curricular_mesh_pdf) }}">
                                            </iframe>
                                        @endif
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                        <form method="POST" action="{{ route('careers.images.curricularmesh.delete', $campus->id) }}">
                                            @csrf
                                            <input type="hidden" name="institution" value="{{ $career->institution_id }}">
                                            <input type="hidden" name="id" value="{{ $career->id }}">
                                            <input type="hidden" name="image" value="{{ $career->curricular_mesh_pdf }}">
                                            <button type="submit" class="btn btn-primary">Eliminar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="{{ 'AddScore' . $career->id . 'Modal' }}" tabindex="-1" role="dialog" aria-labelledby="AddScoreModalLabel">
                            <div class="modal-dialog modal-xl" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="AddScoreModalLabel">Editar Facultad</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form class="needs-validation" method="POST" action="{{ route('careers.score.create', $career->id) }}" novalidate>
                                        @csrf
                                        <div class="modal-body">
                                            <input type="hidden" id="institution_id" name="institution" value="{{ $career->institution_id }}">
                                            <input type="hidden" id="institution_id" name="id" value="{{ $career->id }}">
                                            <div class="row">
                                                <div class="form-group col-md-3">
                                                    <label for="nem">NEM</label>
                                                    <input type="number" class="form-control" id="nem" name="nem" placeholder="Ingrese NEM" value="" required />
                                                    <div class="invalid-feedback">
                                                        Ingrese NEM
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="ranking">Ranking</label>
                                                    <input type="number" class="form-control" id="ranking" name="ranking" placeholder="Ingrese Ranking" value="" required />
                                                    <div class="invalid-feedback">
                                                        Ingrese una Ranking
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="math">Puntaje Matematica</label>
                                                    <input type="number" class="form-control" id="math" name="math" placeholder="Ingrese puntaje de matematica" value="" required />
                                                    <div class="invalid-feedback">
                                                        Ingrese una puntaje
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="language">Puntaje Lenguaje</label>
                                                    <input type="number" class="form-control" id="language" name="language" placeholder="Ingrese puntaje de lenguaje" value="" required />
                                                    <div class="invalid-feedback">
                                                        Ingrese una puntaje
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-3">
                                                    <label for="history_science">Historia o Ciencias</label>
                                                    <input type="number" class="form-control" id="history_science" name="history_science" placeholder="Ingrese puntaje de Historia o ciencias" value="" required />
                                                    <div class="invalid-feedback">
                                                        Ingrese una puntaje
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="max_score">Puntaje Maximo</label>
                                                    <input type="number" class="form-control" id="max_score" name="max_score" placeholder="Ingrese puntaje de maximo" value="" required />
                                                    <div class="invalid-feedback">
                                                        Ingrese una puntaje
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="avg_score">Puntaje Ponderado</label>
                                                    <input type="number" class="form-control" id="avg_score" name="avg_score" placeholder="Ingrese puntaje Ponderado" value="" required />
                                                    <div class="invalid-feedback">
                                                        Ingrese una puntaje
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label for="min_score">Puntaje Minimo</label>
                                                    <input type="number" class="form-control" id="min_score" name="min_score" placeholder="Ingrese puntaje Minimo" value="" required />
                                                    <div class="invalid-feedback">
                                                        Ingrese una puntaje
                                                    </div>
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
                        <div class="modal fade" id="EditCareerModal" tabindex="-1" role="dialog" aria-labelledby="EditCampusModalLabel">
                            <div class="modal-dialog modal-xl" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="EditCampusModalLabel">Editar Facultad</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form class="needs-validation" method="POST" action="{{ route('careers.edit') }}" novalidate>
                                        @csrf
                                        <div class="modal-body">
                                            <input type="hidden" id="id" name="id" value="{{ $career->id }}">
                                            <input type="hidden" id="institution" name="institution" value="{{ $career->institution_id }}">
                                            <div class="form-row">
                                                <div class="form-group col-md-8">
                                                    <label for="name">Nombre</label>
                                                    <input type="text" class="form-control" id="name" name="name" value="{{ $career->name }}" required />
                                                    <div class="invalid-feedback">
                                                        Ingrese un nombre
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="type">Tipo de carrera</label>
                                                    <select class="custom-select" id="type" name="type" required>
                                                        <option value=0>Selecciona un tipo</option>
                                                        @foreach($types as $type)
                                                            <option value="{{ $type->id }}" {{ ( $type->id == $career->career_type->id) ? 'selected' : '' }}> {{ $type->name }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-8">
                                                    <label for="link">Página oficial</label>
                                                    <input type="url" class="form-control" id="link" name="link" value="{{ $career->link }}" required />
                                                    <div class="invalid-feedback">
                                                        Ingrese una URL valida
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="area">Area</label>
                                                    <select class="custom-select" id="area" name="area" required>
                                                        <option value=0>Selecciona un area</option>
                                                        @foreach($areas as $area)
                                                            <option value="{{ $area->id }}" {{ ( $area->id == $career->area->id) ? 'selected' : '' }}> {{ $area->name }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-8">
                                                    <label for="video">Url Video</label>
                                                    <input type="url" class="form-control" id="video" name="video" value="{{ $career->video }}" required />
                                                    <div class="invalid-feedback">
                                                        Ingrese una URL valida
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="accreditation">Acreditacion</label>
                                                    <select class="custom-select" id="accreditation" name="accreditation" required>
                                                        <option value=0>Selecciona un tipo</option>
                                                        @foreach($accreditations as $accreditation)
                                                            <option value="{{ $accreditation->id }}"> {{ $accreditation->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-8">
                                                    <label for="description">Descripción</label>
                                                    <input type="text" class="form-control" id="description" name="description" value="{{ $career->description }}" required />
                                                    <div class="invalid-feedback">
                                                        Ingrese una descripción
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="modality">Modalidad</label>
                                                    <select class="custom-select" id="modality" name="modality" required>
                                                        <option value=0>Selecciona una modalidad</option>
                                                        @foreach($modalities as $modality)
                                                            <option value="{{ $modality->id }}" {{ ( $modality->id == $career->modality->id) ? 'selected' : '' }}> {{ $modality->name }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label for="campuses">Facultades</label>
                                                    <div class="col-md-12">
                                                        <select class="form-control custom-select" id="campuses" name="campuses[]" multiple required>
                                                            @foreach($campuses as $campus)
                                                                <option value="{{ $campus->id }}"> {{ $campus->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="regime">Regimen</label>
                                                    <select class="custom-select" id="regime" name="regime" required>
                                                        <option value=0>Selecciona un regimen</option>
                                                        @foreach($regimes as $regime)
                                                            <option value="{{ $regime->id }}" {{ ( $regime->id == $career->career_regime->id) ? 'selected' : '' }}> {{ $regime->name }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="semesters">Semestres</label>
                                                    <input type="number" class="form-control" id="semesters" name="semesters" value="{{ $career->semesters }}" required />
                                                    <div class="invalid-feedback">
                                                        Debe ingresar un numero de semestres
                                                    </div>
                                                </div>
                                                <div class="form-row">
                                                    @foreach($scholarShipOwners as $scholarShipOwner)
                                                        <div class="form-group col-md-6">
                                                            <label for="scholarShipOwner">{{ $scholarShipOwner->name }} </label>
                                                            <div class="col-md-12">
                                                                <select class="form-control custom-select" id="scholarShipOwners{{ $scholarShipOwner->id }}" name="scholarShipOwners{{ $scholarShipOwner->id }}[]" multiple required>
                                                                    @foreach($scholarShipOwner->scholarships as $scholarship)
                                                                        <option value="{{ $scholarship->id }}"> {{ $scholarship->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    @endforeach
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
                        <div class="modal fade" id="AddImageModal" tabindex="-1" role="dialog" aria-labelledby="AddImageModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="AddImageModalLabel">Agregar imagen de la carrera</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                                    </div>
                                    <form method="POST" action="{{ route('careers.images.create') }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="image">Imagen</label>
                                                <input type="hidden" name="career" value="{{ $career->id }}">
                                                <input type="hidden" name="institution" value="{{ $career->institution_id }}">
                                                <input type="file" class="form-control-file" id="image" name="image" required>
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
                        <div class="modal fade" id="DeleteImageModal" tabindex="-1" role="dialog" aria-labelledby="DeleteImageModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="DeleteImageModalLabel">¿Está seguro de eliminar la imagen?</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                                    </div>
                                    <div class="modal-body content-center">
                                        <img class="img-fluid my-2 w-75" src="{{ route('api.files.show', $career->image) }}">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                        <form method="POST" action="{{ route('careers.images.delete') }}">
                                            @csrf
                                            <input type="hidden" name="institution" value="{{ $career->institution_id }}">
                                            <input type="hidden" name="career" value="{{ $career->id }}">
                                            <input type="hidden" name="image" value="{{ $career->image }}">
                                            <button type="submit" class="btn btn-danger">Eliminar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script>
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>
@endsection