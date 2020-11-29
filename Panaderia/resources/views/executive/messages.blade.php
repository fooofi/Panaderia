@extends ('layouts.base')

@section('sidebar')
  @include('layouts.sidebars.executive')
@endsection

@section('content')
  <div class="container-fluid">
    <div class="fade-in">
      <div class="row">
        <div class="col-md-12">
          <div id="twilio-chat" data-identity="{{ auth()->user()->id}}" data-token="{{ $token }}"></div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('javascript')
    
@endsection