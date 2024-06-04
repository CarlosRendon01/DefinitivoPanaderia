  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="{{ url('/') }}">
        <div class="d-flex align-items-center">
          <img class="navbar-brand-full app-header-logo" src="https://i.ibb.co/D5sLS9N/baker-817282.png" width="50" alt="Student Icon">
          <span class="brand-name ml-2">EL TRIUNFO</span>
        </div>
      </a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
      <a href="{{ url('/') }}">
        <img class="navbar-brand-full" src="https://i.ibb.co/D5sLS9N/baker-817282.png" width="60px" alt="Student Icon"/>
      </a>
    </div>
    <ul class="sidebar-menu">
      @include('layouts.menu')
    </ul>
  </aside>
  <style>
    #sidebar-wrapper {
      background-color: #f4f4f9;
      transition: all 0.3s;
    }

    .sidebar-brand a {
      display: flex;
      align-items: center;
      justify-content: center;
      text-decoration: none;
      padding: 10px 0;
    }

    .brand-name {
      font-family: 'Arial', sans-serif;
      font-size: 24px;
      font-weight: bold;
      color: #fff;
      background: linear-gradient(to right, #543310, #543310);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      padding: 0 10px;
    }

    .sidebar-menu {
      list-style: none;
      padding: 20px 10px;
    }

    .sidebar-menu li a {
      display: block;
      color: #333;
      padding: 10px;
      border-radius: 4px;
      transition: color 0.3s, background-color 0.3s;
    }

    .sidebar-menu li a:hover {
      color: #fff;
      background-color: #1f068a;
      text-decoration: none;
    }

    .app-header-logo {
      transition: transform 0.3s ease-in-out;
    }

    .app-header-logo:hover {
      transform: scale(1.1);
    }

    .sidebar-brand-sm {
      display: none;
    }

    @media (max-width: 768px) {
      .sidebar-brand-sm {
        display: block;
      }
      .sidebar-brand {
        display: none;
      }
    }
  </style>

