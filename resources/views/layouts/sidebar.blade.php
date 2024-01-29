
<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link" href="{{ url('dashboard') }}">
          <i class="bi bi-dash-circle"></i>
          <span>Daily Report</span>
        </a>
      </li>
      <!-- End Dashboard Nav -->
      <li class="nav-item">
        <a class="nav-link" href="{{ url('dashboard/visiting-productivity') }}">
          <i class="bi bi-grid"></i>
          <span>SD Visiting Productivity </span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ url('dashboard/visiting-productivity') }}">
          <i class="bi bi-grid"></i>
          <span>TSD Visiting Productivity </span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ url('dashboard/visiting-productivity') }}">
          <i class="bi bi-grid"></i>
          <span>PD Visiting Productivity </span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ url('dashboard/visiting-productivity') }}">
          <i class="bi bi-grid"></i>
          <span>SEDD Visiting Productivity </span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ url('dashboard/visiting-productivity') }}">
          <i class="bi bi-grid"></i>
          <span>Visiting Productivity</span>
        </a>
      </li>
      <!-- End Dashboard Nav -->

  

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>Masters</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{ url('dashboard/visiting-productivity') }}">
              <i class="bi bi-circle"></i><span>Clients</span>
            </a>
          </li>
        </ul>
      </li><!-- End Components Nav -->

      

    </ul>

  </aside>
  <!-- End Sidebar-->
