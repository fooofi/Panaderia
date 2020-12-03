@extends('layouts.base')

@section('sidebar')
@include('layouts.sidebars.admin')
@endsection

@section('content')

          <div class="container-fluid">
            <div class="fade-in">
              <div class="card">
                  <div class="card-header">Reporte de Costos
                  </div>
                  <div class="card-body">
                    <div class="c-chart-wrapper">
                      <canvas id="canvas-2"></canvas>
                    </div>
                  </div>
              </div>
            </div>
          </div>

@endsection

@section('javascript')
    <script src="{{ asset('js/Chart.min.js') }}"></script>
    <script src="{{ asset('js/coreui-chartjs.bundle.js') }}"></script>
    <script src="{{ asset('js/charts.js') }}"></script>

    <script>
        const random = () => Math.round(Math.random() * 100000)

        // eslint-disable-next-line no-unused-vars
        const barChart = new Chart(document.getElementById('canvas-2'), {
        type: 'bar',
        data: {
            labels : ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'],
            datasets : [
            {
                backgroundColor : 'rgba(255, 79, 79, 0.5)',
                borderColor : 'rgba(220, 220, 220, 0.8)',
                highlightFill: 'rgba(220, 220, 220, 0.75)',
                highlightStroke: 'rgba(220, 220, 220, 1)',
                data : [random(), random(), random(), random(), random(), random(), random()]
            },
            {
                backgroundColor : 'rgba(36, 44, 48, 0.5)',
                borderColor : 'rgba(151, 187, 205, 0.8)',
                highlightFill : 'rgba(151, 187, 205, 0.75)',
                highlightStroke : 'rgba(151, 187, 205, 1)',
                data : [random(), random(), random(), random(), random(), random(), random()]
            }
            ]
        },
        options: {
            responsive: true
        }
        })
    </script>

@endsection