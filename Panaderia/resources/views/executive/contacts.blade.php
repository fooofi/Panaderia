@extends ('layouts.base')

@section('sidebar')
  @include('layouts.sidebars.executive')
@endsection

@section('content')
  <div class="container-fluid">
    <div class="fade-in">
      <div class="row">
        <div class="col-md-12">
          @if($error =  Session::get('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <strong>{{ $error }}</strong>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          @endif
          <div class="card">
            <div class="card-header text-value-lg">Contactos</div>
            <div class="card-body">
              <div id="contact-table" data-contacturl="{{ route('executive.messages')}}" data-dataurl="{{ route('executive.contacts.list')}}"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('javascript')
    
@endsection