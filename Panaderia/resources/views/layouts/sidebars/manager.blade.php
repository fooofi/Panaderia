<ul class="c-sidebar-nav">
  <li class="c-sidebar-item">
    <a class="c-sidebar-nav-link" href="{{ route('dashboard')}}">
      <svg class="c-sidebar-nav-icon">
        <use href="{{ asset("icons/sprites/free.svg#cil-newspaper") }}"></use>
      </svg>
      <div>Dashboard</div>
    </a>
  </li>
  @can('institutions')
    <li class="c-sidebar-item">
      <a class="c-sidebar-nav-link" href="{{ route('institutions')}}">
        <svg class="c-sidebar-nav-icon">
          <use href="{{ asset("icons/sprites/free.svg#cil-institution") }}"></use>
        </svg>
        <div>Instituciones</div>
      </a>
    </li>
  @endcan
  @cannot('institutions')
    <li class="c-sidebar-item">
      <a class="c-sidebar-nav-link" href="{{ route('institutions.show', auth()->user()->institutionId())}}">
        <svg class="c-sidebar-nav-icon">
          <use href="{{ asset('icons/sprites/free.svg#cil-institution')}}"></use>
        </svg>
        <div>Institución</div>
      </a>
    </li>
  @endcan
  
  @can('campuses')
    <li class="c-sidebar-item">
      <a class="c-sidebar-nav-link" href="{{ route('campuses')}}">
        <svg class="c-sidebar-nav-icon">
          <use href="{{ asset('icons/sprites/free.svg#cil-building')}}"></use> 
        </svg>
        <div>Facultades</div>
      </a>
    </li>
  @endcan

  @can('careers')
    <li class="c-sidebar-item">
      <a class="c-sidebar-nav-link" href="{{ route('careers')}}">
        <svg class="c-sidebar-nav-icon">
          <use href="{{ asset('icons/sprites/free.svg#cil-school')}}"></use> 
        </svg>
        <div>Carreras</div>
      </a>
    </li>
  @endcan
</ul>