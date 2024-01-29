

$.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });


  var dt;

  var showError = (field, message) => {

    console.log(field, message);
    if(!message){
        $('#' + field)
        .addClass('is-valid')
        .removeClass('is-invalid')
        .siblings('.invalid-feedback')
        .text('');
    } else {
        $('#' + field)
        .addClass('is-invalid')
        .removeClass('is-valid')
        .siblings('.invalid-feedback')
        .text(message);
    }
}



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



 

var columnsDataTable = [
  {data: 'created_time', className: 'text-start',
  render: function (data, type, row, meta) {
    var date = moment(row.created_time).format("DD/MM/YYYY");
    return date;
}},
  { data: 'report', className: 'text-start', 
  render: function (data, type, row) {
  if (type === 'display') {
  return $('<div/>').html(data).text();
  } else  {
    return data;
  }
   }
 },
  {data: 'trouble', className: 'text-start',
  render: function (data, type, row) {
    if (type === 'display') {
    return $('<div/>').html(data).text();
    } else  {
      return data;
    }
     }},
  {data: 'plan', className: 'text-start',
  render: function (data, type, row) {
    if (type === 'display') {
    return $('<div/>').html(data).text();
    } else  {
      return data;
    }
     }},
     {data: 'action' , name : 'action', className: 'text-start'}
  

];


  var initDatatable = () => {

      dt =  $('#datatable-daily-report').DataTable({
      paging: false,
      scrollY: '400px',
      scrollX: '100%',
      select: {
        style: 'single'
      },
      responsive: true,
      processing: true,
      autoWidth: false,
      serverSide: true,
      ajax: 'dashboard/datatable', 
      columns: columnsDataTable,
      language: {
        processing: '<div class="loading-indicator mb-4">Loading...</div>'
    },
      columnDefs: [{
        "targets": 0,
        "checkboxes": {
          'selectRow' : true 
        }
      }],
      // fixedColumns: true  
  });

  dt.on('click', 'tr', function () {

    if ($(this).hasClass('selected')) {
      $(this).removeClass('selected');
    } else {
        dt.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
    }
      const selectedData = dt.row(this).data();
      const patient_id = selectedData.id;
});

  }


  $('.sidebar').click(function () {
    $('#datatable-daily-report').DataTable().columns.adjust();
});


var create = () => {

  $('#formDailyReport').submit(function (e) { 
    e.preventDefault();
  
    $('#formCreateBtn').prop('disabled', true);
    var formData = $('#formDailyReport').serialize();
    var form  = $('#formDailyReport');
  
    console.log(formData);
  
    $.ajax({
      type: "POST",
      url: "dashboard/create-daily-report",
      data: formData,
      success: function (response) {
        if(response.status == 400){
         showError('report', response.messages.report);
         showError('plan', response.messages.plan);
         $('#formCreateBtn').prop('disabled', false);
        } else if(response.status == 200){
          $('#formCreateBtn').prop('disabled', false);
          dt.ajax.reload();
          form.trigger('reset');
          $('#daily-report-modal').modal('hide');
          toastMixin.fire({
            animation: true,
            title: response.message
          });
        }  
      }             
    }); 
  });
  }
  



var formatDailyReport = () => {

  $('body').on('click', '.daily-format-report', function (e) {

   const id =  $(this).data('id');

  $.ajax({
    type: "GET",
    url: "dashboard/daily-format-report/" + id,
    success: function (res) {
      moment.locale('id');
      $('#detail-pembuka').html(`Bismillah <br>  ▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬ <br> Daily Report <br> ▬▬▬▬▬▬▬▬▬▬▬▬▬▬▬ `);
      $('#detail-pegawai').html(`${res.nama_pegawai} <br> ${res.departemen} - ${res.cabang}`);
      $('#detail-pekerjaan').html(`* ${moment(res.created_time).format("dddd, DD/MM/YYYY")} <br>`);
      $('#detail-report').html(`➡️ PEKERJAAN : <br> ${res.report} `);
      $('#detail-trouble').html(`➡️ KENDALA : <br> ${res.trouble} `);
      $('#detail-plan').html(`➡️ PLAN HARI INI : <br> ${res.plan} `);
    }
  });
    
  });

}


var detailEdit = () => {
  $('body').on('click', '.edit-daily-report', function(){

    const id = $(this).data('id');

    $.ajax({
      type: "GET",
      url: "dashboard/detail-edit-daily-report/" + id,
      success: function (res) {
        console.log(res.id);
        $('#id-daily').data('id-daily', res.id);
        $('#edit_report').val(res.report);
        $('#edit_trouble').val(res.trouble);
        $('#edit_plan').val(res.plan);
      }
    });
  });
}


var formUpdate = () => {
$('#edit-daily-report-modal').submit(function (e) { 
  e.preventDefault();

  $('#formUpdateBtn').prop('disabled', true);

 const report = $('#edit_report').val();
 const trouble = $('#edit_trouble').val();
 const plan = $('#edit_plan').val();


var formData = {
  edit_report : report,
  edit_trouble : trouble,
  edit_plan : plan
}

  const id = $('#id-daily').data('id-daily');

  // alert(report);

  $.ajax({
    type: "PUT",
    url: "dashboard/update-daily-report/" + id,
    data: formData,
    success: function (response) {
      console.log(response);
      if(response.status == 400){
        showError('edit_report', response.messages.edit_report);
        showError('edit_plan', response.messages.edit_plan);
        $('#formUpdateBtn').prop('disabled', false);
       } else if(response.status == 200){
         $('#formUpdateBtn').prop('disabled', false);
         dt.ajax.reload();
         $('#edit-daily-report-modal').modal('hide');
         toastMixin.fire({
           animation: true,
           title: response.message
         });
       }  
    }
  });

 
});
}


var deleteDailyReport = () => {
  $('body').on('click', '.delete-daily-report', function(e){
    const id = $(this).data('id');


    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {

   $.ajax({
      type: "DELETE",
      url: "dashboard/delete-daily-report/" + id,
      success: function (response) {
        dt.ajax.reload();
        toastMixin.fire({
          animation: true,
          title: 'Deleted Successfully!'
        });
      }
    });
      }
    });  
  });
}


function copyToClipboard(text) {
  const textarea = document.createElement('textarea');
  textarea.value = 'dadasdas';
  document.body.appendChild(textarea);
  textarea.select();
console.log(text);
console.log(textarea);
  try {
    document.execCommand('copy');
    alert('Text copied to clipboard!');
  } catch (err) {
    console.error('Unable to copy text to clipboard', err);
  } finally {
    document.body.removeChild(textarea);
  }
}

var copyText = () => {
$('.copy-text').click(function (e) { 
  e.preventDefault();




  var copyText = document.getElementById("detail-report");
  copyText.select();
  copyText.setSelectionRange(0, 99999);
  console.log(textToCopy);

navigator.clipboard.write(textToCopy);

  
});

}


document.addEventListener('DOMContentLoaded', function () {
    create();
    showError();
    initDatatable();
    formatDailyReport();
    detailEdit();
    formUpdate();
    deleteDailyReport();
    copyText();
});




     