@extends('layouts.app')
@section('title', 'Scan Barcode')
@section('content')
<main id="main" class="main">

    <div class="pagetitle">
      <h1>Scan Barcode </h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Scan Barcode Arrived to Office</li>
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
                <div id="reader" class="visiting_id" data-id="{{ $id }}" width="600px"></div>
            </div><!-- End Recent Sales -->
          </div>
        </div><!-- End Left side columns -->
      </div>
    </section>

  </main><!-- End #main --> 
@endsection

@section('script')
<script src="https://raw.githack.com/mebjas/html5-qrcode/master/minified/html5-qrcode.min.js"></script>
<script src="{{ asset('assets/js/scan-barcode-checkout.js') }}"></script>
@endsection