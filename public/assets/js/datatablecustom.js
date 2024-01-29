var dt;

var daterangepicker = () => {
    $('#daterangepicker').daterangepicker({
      "showButtonPanel": true,
      "ranges": {
        'Hari ini': [moment(), moment()],
        'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        '7 Hari lalu': [moment().subtract(6, 'days'), moment()],
        '30 Hari Lalu': [moment().subtract(29, 'days'), moment()],
        'Bulan ini': [moment().startOf('month'), moment().endOf('month')],
        'Bulan Lalu': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
      },
   
  }, function(start, end, label) {
    console.log("New date range selected: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
  
    const startDate = start.format('YYYY-MM-DD');
    const endDate = end.format('YYYY-MM-DD');
    const newUrl = 'dashboard/datatable?date_from=' + startDate + '&date_to=' + endDate;
    dt.ajax.url(newUrl).load();
  });
  
  }


var initDatatable = () => {
  dt =  $('#dataTable').DataTable({
      // scrollX : 'auto',
      responsive: true,
  });

 
}


$(document).ready(function() {
    initDatatable();
    daterangepicker();

    ClassicEditor
    .create( document.querySelector( '#editor' ) )
    .catch( error => {
        console.error( error );
    } );
});