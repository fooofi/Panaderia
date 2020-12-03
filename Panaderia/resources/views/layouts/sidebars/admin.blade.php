<ul class="c-sidebar-nav">
  <li class="c-sidebar-item">
    <a class="c-sidebar-nav-link" href="{{'/'}}">
      <svg class="c-sidebar-nav-icon">
        <use href="{{ asset("icons/sprites/free.svg#cil-compass") }}"></use>
      </svg>
      <div>Dashboard</div>
    </a>
  </li>
  <li class="c-sidebar-item c-sidebar-nav-dropdown">
    <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
      <svg class="c-sidebar-nav-icon">
        <use href="{{ asset("icons/sprites/free.svg#cil-calendar-check") }}"></use>
      </svg>
      <div>Producción</div>
    </a>
      <ul class="c-sidebar-nav-dropdown-items">
        <li class="c-sidebar-nav-item">
          <a class="c-sidebar-nav-link" href="{{ route('admin.production')}}">
            <svg class="c-sidebar-nav-icon">
              <use href="{{ asset("icons/sprites/free.svg#cil-basket") }}"></use>
            </svg>
            <div>Producción Diaria</div>
          </a>
        </li>
        <li class="c-sidebar-nav-item">
          <a class="c-sidebar-nav-link" href="{{ route('admin.product')}}">
            <svg class="c-sidebar-nav-icon">
              <use href="{{ asset("icons/sprites/free.svg#cil-restaurant") }}"></use>
            </svg>
            <div>Productos</div>
          </a>
        </li>
        <li class="c-sidebar-nav-item">
          <a class="c-sidebar-nav-link" href="{{ route('admin.material')}}">
            <svg class="c-sidebar-nav-icon">
              <use href="{{ asset("icons/sprites/free.svg#cil-leaf") }}"></use>
            </svg>
            <div>Material</div>
          </a>
        </li>
      </ul>
  </li>
  <li class="c-sidebar-item">
    <a class="c-sidebar-nav-link" href="{{ route('admin.order')}}">
      <svg class="c-sidebar-nav-icon">
        <use href="{{ asset("icons/sprites/free.svg#cil-car-alt") }}"></use>
      </svg>
      <div>Despacho</div>
    </a>
  </li>
  <li class="c-sidebar-item c-sidebar-nav-dropdown">
    <a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle" href="#">
      <svg class="c-sidebar-nav-icon">
        <use href="{{ asset("icons/sprites/free.svg#cil-chart-line") }}"></use>
      </svg>
      <div>Reportes</div>
    </a>
      <ul class="c-sidebar-nav-dropdown-items">
        <li class="c-sidebar-nav-item">
          <a class="c-sidebar-nav-link" href="{{ route('admin.report')}}">
            <svg class="c-sidebar-nav-icon">
              <use href="{{ asset("icons/sprites/free.svg#cil-chart-line") }}"></use>
            </svg>
            <div>Semanal</div>
          </a>
        </li>
        <li class="c-sidebar-nav-item">
          <a class="c-sidebar-nav-link" href="{{ route('admin.cost')}}">
            <svg class="c-sidebar-nav-icon">
              <use href="{{ asset("icons/sprites/free.svg#cil-chart-line") }}"></use>
            </svg>
            <div>Costo</div>
          </a>
        </li>
      </ul>
  </li>
  <li class="c-sidebar-item">
    <a class="c-sidebar-nav-link" href="{{ route('admin.dealer')}}">
      <svg class="c-sidebar-nav-icon">
        <use href="{{ asset("icons/sprites/free.svg#cil-running") }}"></use>
      </svg>
      <div>Repartidores</div>
    </a>
  </li>
  <li class="c-sidebar-item">
    <a class="c-sidebar-nav-link" href="{{ route('admin.client')}}">
      <svg class="c-sidebar-nav-icon">
        <use href="{{ asset("icons/sprites/free.svg#cil-people") }}"></use>
      </svg>
      <div>Clientes</div>
    </a>
  </li>


</ul>