@extends('layouts.app')
@section('title', 'Daily Report')
@section('content')
<main id="main" class="main">

    <div class="pagetitle">
      <h1>Daily Report</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Daily Report</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-12">
          <div class="row">
            <!-- Recent Sales -->
            <div class="col-12">
              <div class="card recent-sales overflow-auto">
                <div class="card-body">
                  <h5 class="card-title">Daily Report <span>| Today</span></h5>
                 <!-- Filter Date -->
                 <div class="row mb-5">
                 
                  <div class="col-md-3">
                    <button data-bs-target="#daily-report-modal" data-bs-toggle="modal"  class="badge bg-success  add-daily-report "><i class="bi bi-plus-lg"></i> Daily Report</button>
                  </div>
                 </div>
                 <div class="datatable-container">
                       <!-- data table start -->
                                    <table id="datatable-daily-report" class=" display" >
                                        <thead class="text-uppercase thead-report ">
                                            <tr>
                                               <th  class="th" > Date</th>
                                                <th class="th"  > Report</th>
                                                <th  class="th" > Trouble</th>
                                                <th  class="th" > Plan</th>
                                                <th class="th"  > Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                    <!-- data table end -->                       
                  </div>
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
                        <label for="exampleInputPassword1" class="form-label">Report</label>
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
        {{-- <div class="col-lg-4">
          <!-- Recent Activity -->
          <div class="card">
            <div class="card-body">
              <h5 class="card-title"> Format Daily Report</h5>
              <div class="activity">  
                <p>dashboard</p>          
              </div>
            </div>
          </div><!-- End Recent Activity -->
        </div><!-- End Right side columns --> --}}

      </div>
    </section>

  </main><!-- End #main -->
  @include('dashboard.daily-report-modal')
  @include('dashboard.edit-daily-report-modal')
  @include('dashboard.format-daily-modal')
 
@endsection

@section('script')
<script src="{{ asset('assets/js/dashboard.js') }}"></script>
@endsection