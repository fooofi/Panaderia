@extends ('layouts.base')

@section('sidebar')
  @include('layouts.sidebars.manager')
@endsection

@section('content')

  <div class="container-fluid">
    <div class="fade-in">
      <div class="row">
        <div class="col-sm-6 col-lg-3">
          <div class="card text-white bg-primary">
            <div class="card-body pb-0">
              <div class="text-value-lg">9.823</div>
              <div>Visitas diarias</div>
            </div>
            <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
              <canvas class="chart" id="card-chart1" height="70"></canvas>
            </div>
          </div>
        </div>
        <!-- /.col-->
        <div class="col-sm-6 col-lg-3">
          <div class="card text-white bg-info">
            <div class="card-body pb-0">
              <div class="text-value-lg">9.823</div>
              <div>Visitas semanales</div>
            </div>
            <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
              <canvas class="chart" id="card-chart2" height="70"></canvas>
            </div>
          </div>
        </div>
        <!-- /.col-->
        <div class="col-sm-6 col-lg-3">
          <div class="card text-white bg-warning">
            <div class="card-body pb-0">
              <div class="text-value-lg">9.823</div>
              <div>Visitas actuales</div>
            </div>
            <div class="c-chart-wrapper mt-3" style="height:70px;">
              <canvas class="chart" id="card-chart3" height="70"></canvas>
            </div>
          </div>
        </div>
        <!-- /.col-->
        <div class="col-sm-6 col-lg-3">
          <div class="card text-white bg-danger">
            <div class="card-body pb-0">
              <div class="text-value-lg">
                <svg class="c-icon c-icon-xl">
                  <use href="{{ asset('assets/icons/free.svg#cil-dollar') }}"></use>
                </svg>
                30%
              </div>
              <div>Conversion</div>
            </div>
            <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
              <canvas class="chart" id="card-chart4" height="70"></canvas>
            </div>
          </div>
        </div>
        <!-- /.col-->
      </div>
      <!-- /.row-->
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-sm-5">
              <h2 class="card-title mb-0">Visitas</h2>
              <div class="small text-muted">Noviembre 2020</div>
            </div>
            <!-- /.col-->
            <div class="col-sm-7 d-none d-md-block">
              <div class="btn-group btn-group-toggle float-right mr-3" data-toggle="buttons">
                <label class="btn btn-outline-secondary">
                  <input id="option1" type="radio" name="options" autocomplete="off"> Diarias
                </label>
                <label class="btn btn-outline-secondary active">
                  <input id="option2" type="radio" name="options" autocomplete="off" checked=""> Semanales
                </label>
                <label class="btn btn-outline-secondary">
                  <input id="option3" type="radio" name="options" autocomplete="off"> Mensuales
                </label>
              </div>
            </div>
            <!-- /.col-->
          </div>
          <!-- /.row-->
          <div class="c-chart-wrapper" style="height:300px;margin-top:40px;">
            <canvas class="chart" id="main-chart" height="300"></canvas>
          </div>
        </div>
        <div class="card-footer">
          <div class="row text-center">
            <div class="col-sm-12 col-md mb-sm-2 mb-0">
              <div class="text-muted">Visitas</div><strong>100 Usuarios</strong>
              <div class="progress progress-xs mt-2">
                <div class="progress-bar bg-success" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
            <div class="col-sm-12 col-md mb-sm-2 mb-0">
              <div class="text-muted">Unicos</div><strong>20 Usuarios (20%)</strong>
              <div class="progress progress-xs mt-2">
                <div class="progress-bar bg-info" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
            <div class="col-sm-12 col-md mb-sm-2 mb-0">
              <div class="text-muted">Carreras visitadas</div><strong>120 Carreras (80%)</strong>
              <div class="progress progress-xs mt-2">
                <div class="progress-bar bg-warning" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
            <div class="col-sm-12 col-md mb-sm-2 mb-0">
              <div class="text-muted">Usuarios Contactados</div><strong>80 Usuarios (80%)</strong>
              <div class="progress progress-xs mt-2">
                <div class="progress-bar bg-danger" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /.card-->
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header mb-0 text-value-xl">Contactos</div>
            <div class="card-body">
              <div class="row">
                <div class="col-sm-6">
                  <div class="row">
                    <div class="col-6">
                      <div class="c-callout c-callout-info"><small class="text-muted">Usuarios Contactados</small>
                        <div class="text-value-lg">1,223</div>
                      </div>
                    </div>
                    <!-- /.col-->
                    <div class="col-6">
                      <div class="c-callout c-callout-danger"><small class="text-muted">Usuarios Recurrentes</small>
                        <div class="text-value-lg">2,623</div>
                      </div>
                    </div>
                    <!-- /.col-->
                  </div>
                  <!-- /.row-->
                  <hr class="mt-0">
                  <div class="progress-group mb-4">
                    <div class="progress-group-prepend"><span class="progress-group-text">Lunes</span></div>
                    <div class="progress-group-bars">
                      <div class="progress progress-xs">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 34%" aria-valuenow="34" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <div class="progress progress-xs">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 78%" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                  </div>
                  <div class="progress-group mb-4">
                    <div class="progress-group-prepend"><span class="progress-group-text">Martes</span></div>
                    <div class="progress-group-bars">
                      <div class="progress progress-xs">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 56%" aria-valuenow="56" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <div class="progress progress-xs">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 94%" aria-valuenow="94" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                  </div>
                  <div class="progress-group mb-4">
                    <div class="progress-group-prepend"><span class="progress-group-text">Miercoles</span></div>
                    <div class="progress-group-bars">
                      <div class="progress progress-xs">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 12%" aria-valuenow="12" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <div class="progress progress-xs">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 67%" aria-valuenow="67" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                  </div>
                  <div class="progress-group mb-4">
                    <div class="progress-group-prepend"><span class="progress-group-text">Jueves</span></div>
                    <div class="progress-group-bars">
                      <div class="progress progress-xs">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 43%" aria-valuenow="43" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <div class="progress progress-xs">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 91%" aria-valuenow="91" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                  </div>
                  <div class="progress-group mb-4">
                    <div class="progress-group-prepend"><span class="progress-group-text">Viernes</span></div>
                    <div class="progress-group-bars">
                      <div class="progress progress-xs">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 22%" aria-valuenow="22" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <div class="progress progress-xs">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 73%" aria-valuenow="73" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                  </div>
                  <div class="progress-group mb-4">
                    <div class="progress-group-prepend"><span class="progress-group-text">Sabado</span></div>
                    <div class="progress-group-bars">
                      <div class="progress progress-xs">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 53%" aria-valuenow="53" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <div class="progress progress-xs">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 82%" aria-valuenow="82" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                  </div>
                  <div class="progress-group mb-4">
                    <div class="progress-group-prepend"><span class="progress-group-text">Domingo</span></div>
                    <div class="progress-group-bars">
                      <div class="progress progress-xs">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 9%" aria-valuenow="9" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                      <div class="progress progress-xs">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 69%" aria-valuenow="69" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.col-->
                <div class="col-sm-6">
                  <div class="row">
                    <div class="col-6">
                      <div class="c-callout c-callout-warning"><small class="text-muted">Visitas totales</small>
                        <div class="text-value-lg">78,623</div>
                      </div>
                    </div>
                    <!-- /.col-->
                  </div>
                  <!-- /.row-->
                  <hr class="mt-0">
                </div>
                <!-- /.col-->
              </div>
              <!-- /.row--><br>
              <table class="table table-responsive-sm table-hover table-outline mb-0">
                <thead class="thead-light">
                <tr>
                  <th class="text-center">
                    <svg class="c-icon">
                      <use href="{{ asset('assets/icons/free.svg#cil-people') }}"></use>
                    </svg>
                  </th>
                  <th>Agente</th>
                  <th>Eficiencia</th>
                  <th class="text-center">Usuarios contactados</th>
                  <th>Actividad</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                  <td class="text-center">
                    <div class="c-avatar"><img class="c-avatar-img" src="{{ asset('assets/img/avatars/1.jpg') }}" alt="user@email.com"><span class="c-avatar-status bg-success"></span></div>
                  </td>
                  <td>
                    <div>Yiorgos Avraamu</div>
                  </td>
                  <td>
                    <div class="clearfix">
                      <div class="float-left"><strong>30%</strong></div>
                      <div class="float-right"><small class="text-muted">01 de Noviembre - 30 de Noviembre</small></div>
                    </div>
                    <div class="progress progress-xs">
                      <div class="progress-bar bg-success" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </td>
                  <td>
                    <div class="text-center">
                      <svg class="c-icon c-icon-2xl">
                        <use href="assets/icons/free.svg#cil-dollar"></use>
                      </svg>
                      <strong>200</strong>
                    </div>
                  </td>
                  <td>
                    <div class="small text-muted">Ultimo contacto</div><strong>Hace 10 segundos.</strong>
                  </td>
                </tr>
                <tr>
                  <td class="text-center">
                    <div class="c-avatar"><img class="c-avatar-img" src="{{ asset('assets/img/avatars/1.jpg') }}" alt="user@email.com"><span class="c-avatar-status bg-danger"></span></div>
                  </td>
                  <td>
                    <div>Avram Tarasios</div>
                  </td>
                  <td>
                    <div class="clearfix">
                      <div class="float-left"><strong>10%</strong></div>
                      <div class="float-right"><small class="text-muted">01 de Noviembre - 30 de Noviembre</small></div>
                    </div>
                    <div class="progress progress-xs">
                      <div class="progress-bar bg-info" role="progressbar" style="width: 10%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </td>
                  <td>
                    <div class="text-center">
                      <svg class="c-icon c-icon-2xl">
                        <use href="assets/icons/free.svg#cil-dollar"></use>
                      </svg>
                      <strong>100</strong>
                    </div>
                  </td>
                  <td>
                    <div class="small text-muted">Ultimo contacto</div><strong>Hace 5 minutos.</strong>
                  </td>
                </tr>
                <tr>
                  <td class="text-center">
                    <div class="c-avatar"><img class="c-avatar-img" src="{{ asset('assets/img/avatars/1.jpg') }}" alt="user@email.com"><span class="c-avatar-status bg-warning"></span></div>
                  </td>
                  <td>
                    <div>Quintin Ed</div>
                  </td>
                  <td>
                    <div class="clearfix">
                      <div class="float-left"><strong>60%</strong></div>
                      <div class="float-right"><small class="text-muted">01 de Noviembre - 30 de Noviembre</small></div>
                    </div>
                    <div class="progress progress-xs">
                      <div class="progress-bar bg-warning" role="progressbar" style="width: 74%" aria-valuenow="74" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </td>
                  <td>
                    <div class="text-center">
                      <svg class="c-icon c-icon-2xl">
                        <use href="assets/icons/free.svg#cil-dollar"></use>
                      </svg>
                      <strong>200</strong>
                    </div>
                  </td>
                  <td>
                    <div class="small text-muted">Ultimo contacto</div><strong>Hace 1 hora.</strong>
                  </td>
                </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <!-- /.col-->
      </div>
      <!-- /.row-->
    </div>
  </div>

@endsection

@section('javascript')

  <script src="{{ asset('js/Chart.min.js') }}"></script>
  <script src="{{ asset('js/coreui-chartjs.bundle.js') }}"></script>
  <script src="{{ asset('js/main.js') }}" defer></script>

@endsection
