$(document).ready(function () {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });


    // Sweet Alert Set Up
var toastMixin = Swal.mixin({
  toast: true,
  icon: 'success',
  title: 'General Title',
  animation: false,
  position: 'top-right',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
});





    function onScanSuccess(decodedText, decodedResult) {
        // alert(decodedText);
  
        let id = decodedText;                
        html5QrcodeScanner.clear().then(_ => {
          const visiting_id = $('.visiting_id').data('id');
        
            $.ajax({ 
                url: "/dashboard/process-scan-barcode/" + visiting_id,
                type: 'POST',            
                data: {
                    qr_code : id
                },            
                success: function (response) { 
                    console.log(response);
                    if(response.status == 200){
                      toastMixin.fire({
                        animation: true,
                        title: response.message
                      });
                      window.location.href = "/dashboard/visiting-productivity";
                    }else{
                        alert('gagal');
                    }
                    
                }
            });   
        }).catch(error => {
            alert('something wrong');
        });
        
    }
      
      function onScanFailure(error) {
        // handle scan failure, usually better to ignore and keep scanning.
        // for example:
        // console.warn(`Code scan error = ${error}`);
      }
      
      let html5QrcodeScanner = new Html5QrcodeScanner(
        "reader",
        { fps: 10, qrbox: {width: 250, height: 250} },
        /* verbose= */ false);
      html5QrcodeScanner.render(onScanSuccess, onScanFailure);  
});