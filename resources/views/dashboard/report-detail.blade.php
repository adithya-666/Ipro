@extends('layouts.app')
@section('title', 'Report Detail')
@section('content')
<style>
trix-toolbar [data-trix-button-group="file-tools"] {
display: none;
}
</style>
<main id="main" class="main">

  <div class="pagetitle">
    <h1>Detail Report</h1>
  </div><!-- End Page Title -->

  <section class="section">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <!-- Report Form -->
            <form method="POST" href="{{ url('dashboard/create-visiting-productivity') }}"  id="formVisitingProductivity"  enctype="multipart/form-data">
              @csrf
              <input class="form-control" type="hidden" name="visiting_id" value="{{ $id }}" id="visiting_id">
              <div class="row mb-3">
                <label for="inputText" class="col-sm col-form-label">Report    <span class="text-danger">*</span></label>
                <div class="col-sm-12">
                  <input id="report" type="hidden" name="report">
                  <trix-editor input="report"></trix-editor>
                  <div class="invalid-feedback"></div>
                </div>
              </div>
              <div class="row mb-3">
                <label for="inputEmail" class="col-sm- col-form-label">Upload File</label>
                <div class="col-sm-12">
                  <input class="form-control" type="file" name="file" id="file">
                  <div class="invalid-feedback"></div>
                </div>
              </div>
              <button type="submit" class="btn btn-success center" id="formVisitingProductivityBtn">Save changes</button>
            </form>
            <!-- End Form -->

          </div>
        </div>
      </div>
    </div>
    <div class="row">
            <!-- Recent Sales -->
            <div class="col-12">
              <div class="card recent-sales overflow-auto">
                <div class="card-body">
                  <h5 class="card-title">Report Detail <span id="detail-created"></span></h5>
                  <hr>
                  <div class="row">
                    <div class="col-lg-3">
                      <p class="fw-bold">Depature :</p>
                      <p class="fw-bold">Client Name :</p>
                      <p class="fw-bold">Check In :</p>
                    </div>
                    <div class="col-lg-3">
                      <p id="detail-depature">-</p>
                      <p id="detail-client-name">-</p>
                      <p id="detail-checkin">-</p>
                    </div>
                    <div class="col-lg-3">
                      <p class="fw-bold" >Maintanence :</p>
                      <p class="fw-bold" >Report :</p>
                      <p class="fw-bold" >Arrived :</p>
                    </div>
                    <div class="col-lg-3">
                      <p id="detail-maintenence">-</p>
                      <p id="detail-report">-</p>
                      <p id="detail-arrived">-</p>
                    </div>
                  </div>
                  <hr>
                 <!-- Filter Date -->
                 <div class="row mb-3">
                 </div>
                       <!-- data table start -->
                       <div class="content-datatable">
                                    <table id="datatable-report" class="table  table-striped text-center" style="width: 100%;">
                                        <thead class="table  bg-primary text-capitalize  ">
                                            <tr>
                                               <th width="15%">No</th>
                                                <th width="15%">Report</th>
                                                <th width="15%">Image</th>
                                                <th width="15%">Action</th>
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
  </section>

</main><!-- End #main -->
@include('dashboard.edit-report-detail-modal')
@include('dashboard.zoom-img-modal')
@endsection

@section('script')
<script src="{{ asset('assets/js/visiting-productivity.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/hammer.js/2.0.8/hammer.min.js"></script>
@endsection