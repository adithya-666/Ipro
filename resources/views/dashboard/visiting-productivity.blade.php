@extends('layouts.app')
@section('title', 'Visiting Productivity')
@section('content')
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Visiting Productivity</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="row">

            <!-- Sales Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card sales-card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Maintenance <span>| This Month</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-gear-wide-connected"></i>
                    </div>
                    <div class="ps-3">
                      <h6 id="info-maintenance"></h6>
                      {{-- <span class="text-success small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">increase</span> --}}

                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Sales Card -->

            <!-- Revenue Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card revenue-card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Support <span>| This Month</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-plus-circle"></i>
                    </div>
                    <div class="ps-3">
                      <h6 id="info-support"></h6>
                      {{-- <span class="text-success small pt-1 fw-bold">8%</span> <span class="text-muted small pt-2 ps-1">increase</span> --}}

                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Revenue Card -->

            <!-- Customers Card -->
            <div class="col-xxl-4 col-xl-12">

              <div class="card info-card customers-card">

       

                <div class="card-body">
                  <h5 class="card-title">Error <span>| This Month</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-exclamation-circle"></i>
                    </div>
                    <div class="ps-3">
                      <h6 id="info-error"></h6>
                      {{-- <span class="text-danger small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">decrease</span> --}}

                    </div>
                  </div>

                </div>
              </div>

            </div>
            <!-- End Customers Card -->


            <!-- P -->
        
              {{-- <div class="col-xxl-6 col-xl-12">
                <div class="card info-card customers-card">

                  <div class="card-body">
                    <h5 class="card-title">Depature From Office</h5>
                    <div class="d-flex align-items-center">
                      <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-arrow-up-right-circle"></i>
                      </div>
                      <div class="ps-3">
                        <a id="scan-checkin" href="{{ url('/dashboard/scan-barcode') }}">
                        <h6 id="result-depature-office"></h6>
                      </a>
                      </div>
                    </div>
  
                  </div>
                </div>
              </div>

              <div class="col-xxl-6 col-xl-12">
                <div class="card info-card customers-card">
                  <div class="card-body">
                    <h5 class="card-title">Arrived To Office</h5>
  
                    <div class="d-flex align-items-center">
                      <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-arrow-down-left-circle"></i>
                      </div>
                      <div class="ps-3">
                        <h6>16:55</h6>
                      </div>
                    </div>
  
                  </div>
                </div>
              </div> --}}
         
            <!-- Recent Sales -->
            <div class="col-12">
              <div class="card recent-sales overflow-auto">
                <div class="card-body">
                  <h5 class="card-title">Visiting Productivity <span>| Today</span></h5>
                 <!-- Filter Date -->
                 <div class="row mb-3">
                  <div class="col-md-9">
                    @can('access', ['manager', 'Software Engineering Development Departement'])
                    <button type="button" data-bs-target="#add-data-modal" data-bs-toggle="modal"  class="btn btn-success add-document"
                    style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">
                    <i class="bi bi-plus-lg"></i> Add Data
                    </button>
                    @endcan
                  </div>
                 </div>
                       <!-- data table start -->
                       <div class="content-datatable">
                                    <table id="datatable-visiting-report" class="display" style="width: 100%;">
                                        <thead class=" text-uppercase">
                                            <tr>
                                               <th width="15%">PIC</th>
                                                <th  width="20%">Client Name</th>
                                                <th width="15%">Working Type</th>
                                                <th width="15%">Schedule Date</th>
                                                <th width="15%">Working Date</th>
                                                <th  width="15%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                        </tbody>
                                    </table>
                                    </div>
                    <!-- data table end -->
                </div>
              </div>
            </div><!-- End Recent Sales -->
          </div>
        </div><!-- End Left side columns -->

             <!-- Modal -->
             <div class="modal fade" id="modal-report" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Visiting Report</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form>
                      <!-- start row -->
                      <div class="row">
                    <div class="col-lg-12">
                      <div class="mb-3">
                        <label  class="form-label">Report</label>
                        <div class="quill-editor-default">
                          <p>Hello World!</p>
                          <p>This is Quill <strong>default</strong> editor</p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- end row -->
                  <div class="input-group mb-3">
                    <input type="file" class="form-control" id="inputGroupFile02">
                    <label class="input-group-text" for="inputGroupFile02">Upload</label>
                  </div>
                    </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-success center">Save changes</button>
                  </div>
                </div>
              </div>
            </div>  


        <!-- Right side columns -->
        <div class="col-lg-4">

          <!-- Recent Activity -->
          <div class="card">
            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>

                <li><a class="dropdown-item" href="#">Today</a></li>
                <li><a class="dropdown-item" href="#">This Month</a></li>
                <li><a class="dropdown-item" href="#">This Year</a></li>
              </ul>
            </div>

            <div class="card-body">
              <h5 class="card-title">Recent Activity <span>| Today</span></h5>
              <div class="activity" id="activity-timeline">

              </div>
            </div>
          </div><!-- End Recent Activity -->
        </div><!-- End Right side columns -->

      </div>
    </section>

  </main><!-- End #main -->


  @include('dashboard.add-data-modal')
  @include('dashboard.edit-visiting-productivity-modal')
  @endsection

  @section('script')
  <script src="{{ asset('assets/js/visiting-productivity.js') }}"></script>
  @endsection