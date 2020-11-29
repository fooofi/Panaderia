

    <div class="c-wrapper">
        <header class="c-header c-header-light c-header-fixed c-header-with-subheader">
          <button class="c-header-toggler c-class-toggler d-lg-none mr-auto" type="button" data-target="#sidebar" data-class="c-sidebar-show">
            <span class="c-header-toggler-icon"></span>
          </button>
          <a class="c-header-brand d-sm-none" href="#">
            <svg class="c-header-brand" width="97" height="46">
              <use href="{{ asset("assets/brand/mundohome-base-white-svg") }}"></use>
            </svg>
          </a>
          <button class="c-header-toggler c-class-toggler ml-3 d-md-down-none" type="button" data-target="#sidebar" data-class="c-sidebar-lg-show" responsive="true">
            <span class="c-header-toggler-icon"></span>
          </button>

          <ul class="c-header-nav ml-auto mr-4">
            <li class="c-header-nav-item dropdown">
              <a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <div class="c-avatar">
                  <svg class="c-avatar-sm">
                    <use href="{{ asset('icons/sprites/free.svg#cil-settings')}}"></use>
                  </svg>
                </div>
              </a>
              <div class="dropdown-menu dropdown-menu-right pt-0">
                <h6 class="dropdown-header" >{{ auth()->user()->name . ' ' . auth()->user()->lastname}}</h6>
                <a class="dropdown-item" href="">
                  <svg class="c-icon mr-2">
                    <use href="{{ asset('icons/sprites/free.svg#cil-https') }}"></use>
                  </svg>
                  Cambiar contraseña
                </a>
                <div class="dropdown-divider"></div>
                <form action="{{ route('logout') }}" method="POST">
                  @csrf
                <button class="dropdown-item" type="submit">
                  <svg class="c-icon mr-2">
                    <use href="{{ asset('icons/sprites/free.svg#cil-account-logout') }}"></use>
                  </svg>
                    Salir
                  </button>
                </form>
              </div>
            </li>
          </ul>
      </header>
