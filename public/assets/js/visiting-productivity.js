var dt;
var dtReport;

var showError = (field, message) => {
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




var columnsDataTable = [

  { data: 'nama_pegawai', className: 'text-center'},
  { data: 'client_name', className: 'text-center'},
  { data: 'working_type', className: 'text-center',
  render: function(data, type, row, meta){
    var status = '';
    if(row.working_type == 'Maintenance'){
      status = `<span class="badge bg-secondary">${row.working_type}</span>`;
    }else if(row.working_type == 'Support'){
      status = `<span class="badge bg-success">${row.working_type}</span>`;
    }else if(row.working_type == 'Error') {
      status = `<span class="badge bg-danger">${row.working_type}</span>`;
    }
    return status;
  }},
  {data: 'schedule', className: 'text-center',
  render: function (data, type, row, meta) {
    var date = moment(row.schedule).format("DD/MM/YYYY");
    return date;
}},
  {data: 'working_date', className: 'text-center',
  render: function (data, type, row, meta) {
    var date = '';
    if(row.working_date != null){
      date = moment(row.working_date).format("DD/MM/YYYY");
    } else {
      date = '-';
    }
  
    return date;
}},

     {data: 'action' , name : 'action', className: 'text-center'}
  

];


  var initDatatable = () => {
    dt =  $('#datatable-visiting-report').DataTable({
        // scrollX : 'auto',
        responsive: true,
        processing: true,
        serverSide: true,
        select: {
          style: 'single'
        },
        ajax: '/dashboard/datatable-productivity', 
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

    });
    dt.on('click', 'tr', function () {

      if ($(this).hasClass('selected-visiting-productivity')) {
        $(this).removeClass('selected-visiting-productivity');
      } else {
          dt.$('tr.selected-visiting-productivity').removeClass('selected-visiting-productivity');
          $(this).addClass('selected-visiting-productivity');
      }
        const selectedData = dt.row(this).data();
        // console.log(selectedData);

        timeLine(selectedData);
        console.log(selectedData);
        // const visiting_id = selectedData.visiting_id ;
  });
   
  }




  var addInput = () => {
    let newInput;
    $('.add-input').click(function (e) {
      e.preventDefault();



      const form = document.getElementById('formVisiting');
      newInput = document.createElement('div');
      newInput.classList.add('mb-3', 'new-input');
      newInput.innerHTML = `
          <hr>
          <div class="row">
              <div class="col-sm-3">
                  <div class="mb-3">
                      <label for="client-name" class="form-label">Client Name</label>
                      <select class="client-name-select2" name="client_name[]" style="width: 100%" required>
                      </select>
                  </div>
              </div>
              <div class="col-sm-3">
                  <div class="mb-3">
                      <label for="pic" class="form-label">PIC</label>
                      <select class="client-pic-select2" name="pic[]" style="width: 100%"></select>
                  </div>
              </div>
              <div class="col-sm-3">
                  <div class="mb-3">
                      <label for="schedule" class="form-label">Schedule Date</label>
                      <input type="text" name="schedule[]" class="form-control datepicker" id="schedule">
                  </div>
              </div>
              <div class="col-sm-2">
                  <div class="mb-3">
                      <label for="working" class="form-label">Working Type</label>
                      <input type="text" name="type_working[]" class="form-control" id="working">
                  </div>
              </div>
              <div class="col-sm-1">
                  <button type="button" class="btn btn-danger delete-input"><i class="bi bi-trash"></i></button>
              </div>
          </div>
      `;

      const addInformation = document.querySelector('.add-form');
      addInformation.parentNode.insertBefore(newInput, addInformation);

      initializeNewInput(newInput);
  });

           // Validation function for Select2
   
 

  function initializeNewInput(newInput) {
    
        setTimeout(function () {
            newInput.style.opacity = 1;
            // Initialize datepicker for the new input field
            newInput.querySelectorAll('.datepicker').forEach(function (datepicker) {
                $(datepicker).daterangepicker({
                    singleDatePicker: true,
                    locale: {
                        format: 'DD/MM/YYYY',
                    },
                });
            });

            // Initialize select2 for the new select field
            newInput.querySelectorAll('.client-name-select2').forEach(function (select) {
                $(select).prop("required", true); 
                $(select).select2({
                    dropdownParent: $('#add-data-modal'),
                    theme: 'classic',
                    placeholder : 'Select Client',
                    allowClear: true,
                    ajax: {
                      url: '/dashboard/select-client',
                      dataType: 'json',
                      delay: 250,
                      data: function (params) {
                        return {
                          query: params.term // search term
                        };
                      },
                      processResults: function (data, params) {
              
                        // parse the results into the format expected by Select2
                        // since we are using custom formatting functions we do not need to
                        // alter the remote JSON data, except to indicate that infinite
                        // scrolling can be used
                        // params.page = params.page || 1;
              
                        return {
                          results: $.map(data, function (item) {
                            var additionalText = ''
                            var PrefixText = ''
                            PrefixText = item.client_id + " - "
                            // additionalText = " ["+item.general_code+"]"
              
                            return {
                              text: PrefixText + item.client_name + additionalText,
                              id: item.client_id
                            }
                          })
                        };
                      },
                      cache: true
                    },
                    escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
                    // minimumInputLength: 0,
                    // tags: true, // for create new tags
                    language: {
                      inputTooShort: function () {
                        return 'Input is too short';
                      },
                      errorLoading: function () {
                        return `There's error on our side`;
                      },
                      noResults: function () {
                        return 'There are no result based on your search';
                      }
                    }
                }).on('change', function () {
                  validateSelect2($(this));
              });
            });


            newInput.querySelectorAll('.client-pic-select2').forEach(function (select) {
                
                $(select).select2({
                    dropdownParent: $('#add-data-modal'),
                    theme: 'classic',
                    placeholder : 'Select PIC',
                    allowClear: true,
                    ajax: {
                      url: '/dashboard/select-pic',
                      dataType: 'json',
                      delay: 250,
                      data: function (params) {
                        return {
                          query: params.term // search term
                        };
                      },
                      processResults: function (data, params) {
              
                        // parse the results into the format expected by Select2
                        // since we are using custom formatting functions we do not need to
                        // alter the remote JSON data, except to indicate that infinite
                        // scrolling can be used
                        // params.page = params.page || 1;
              
                        return {
                          results: $.map(data, function (item) {
                            var additionalText = ''
                            var PrefixText = ''
                            PrefixText = item.employee_id + " - "
                            // additionalText = " ["+item.general_code+"]"
              
                            return {
                              text: PrefixText + item.employee_name + additionalText,
                              id: item.employee_id
                            }
                          })
                        };
                      },
                      cache: true
                    },
                    escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
                    // minimumInputLength: 0,
                    // tags: true, // for create new tags
                    language: {
                      inputTooShort: function () {
                        return 'Input is too short';
                      },
                      errorLoading: function () {
                        return `There's error on our side`;
                      },
                      noResults: function () {
                        return 'There are no result based on your search';
                      }
                    }
                }).on('change', function () {
                  validateSelect2($(this));
              });
            });
        }, 10);
    
        // Handle deletion of the input field when the "Delete" button is clicked
        const deleteButton = newInput.querySelector('.delete-input');
        deleteButton.addEventListener('click', function () {
            // Remove the input element and its surrounding elements
            newInput.parentNode.removeChild(newInput);
        });
 
     // Validation function for Select2
      }

      function validateSelect2(select2Element = null) {

        if (select2Element == null) {
            select2Element.addClass('is-invalid');
        } else {
            select2Element.removeClass('is-invalid');
        }
    }
}





  $(document).ready(function() {


    $('#schedule').daterangepicker({
        singleDatePicker: true,
        locale: {
            format: 'DD/MM/YYYY',
        },
    });

    $('#type_working').select2({
      dropdownParent: $('#add-data-modal'),
      placeholder : 'Select Client',
      theme: 'classic',
  });


    $('.client-name').select2({
        dropdownParent: $('#add-data-modal'),
        placeholder : 'Select Client',
        theme: 'classic',
        allowClear: true,
        ajax: {
          url: '/dashboard/select-client',
          dataType: 'json',
          delay: 250,
          data: function (params) {
            return {
              query: params.term // search term
            };
          },
          processResults: function (data, params) {
  
            // parse the results into the format expected by Select2
            // since we are using custom formatting functions we do not need to
            // alter the remote JSON data, except to indicate that infinite
            // scrolling can be used
            // params.page = params.page || 1;
  
            return {
              results: $.map(data, function (item) {
                var additionalText = ''
                var PrefixText = ''
                PrefixText = item.client_id + " - "
                // additionalText = " ["+item.general_code+"]"
  
                return {
                  text: PrefixText + item.client_name + additionalText,
                  id: item.client_id
                }
              })
            };
          },
          cache: true
        },
        escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
        // minimumInputLength: 0,
        // tags: true, // for create new tags
        language: {
          inputTooShort: function () {
            return 'Input is too short';
          },
          errorLoading: function () {
            return `There's error on our side`;
          },
          noResults: function () {
            return 'There are no result based on your search';
          }
        }
    });

    $('.client-name').select2({
        dropdownParent: $('#add-data-modal'),
        placeholder : 'Select Client',
        theme: 'classic',
        allowClear: true,
        ajax: {
          url: '/dashboard/select-client',
          dataType: 'json',
          delay: 250,
          data: function (params) {
            return {
              query: params.term // search term
            };
          },
          processResults: function (data, params) {
  
            // parse the results into the format expected by Select2
            // since we are using custom formatting functions we do not need to
            // alter the remote JSON data, except to indicate that infinite
            // scrolling can be used
            // params.page = params.page || 1;
  
            return {
              results: $.map(data, function (item) {
                var additionalText = ''
                var PrefixText = ''
                PrefixText = item.client_id + " - "
                // additionalText = " ["+item.general_code+"]"
  
                return {
                  text: PrefixText + item.client_name + additionalText,
                  id: item.client_id
                }
              })
            };
          },
          cache: true
        },
        escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
        // minimumInputLength: 0,
        // tags: true, // for create new tags
        language: {
          inputTooShort: function () {
            return 'Input is too short';
          },
          errorLoading: function () {
            return `There's error on our side`;
          },
          noResults: function () {
            return 'There are no result based on your search';
          }
        }
    });


    $('.pic').select2({
        dropdownParent: $('#add-data-modal'),
        placeholder : 'Select PIC',
        theme: 'classic',
        allowClear: true,
        ajax: {
          url: '/dashboard/select-pic',
          dataType: 'json',
          delay: 250,
          data: function (params) {
            return {
              query: params.term // search term
            };
          },
          processResults: function (data, params) {
  
            // parse the results into the format expected by Select2
            // since we are using custom formatting functions we do not need to
            // alter the remote JSON data, except to indicate that infinite
            // scrolling can be used
            // params.page = params.page || 1;
  
            return {
              results: $.map(data, function (item) {
                var additionalText = ''
                var PrefixText = ''
                PrefixText = item.employee_id + " - "
                // additionalText = " ["+item.general_code+"]"
  
                return {
                  text: PrefixText + item.employee_name + additionalText,
                  id: item.employee_id
                }
              })
            };
          },
          cache: true
        },
        escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
        // minimumInputLength: 0,
        // tags: true, // for create new tags
        language: {
          inputTooShort: function () {
            return 'Input is too short';
          },
          errorLoading: function () {
            return `There's error on our side`;
          },
          noResults: function () {
            return 'There are no result based on your search';
          }
        }
    });

    $('#edit_client_name').select2({
        dropdownParent: $('#edit-data-modal'),
        placeholder : 'Select Client',
        theme: 'classic',
        allowClear: true,
        ajax: {
          url: '/dashboard/select-client',
          dataType: 'json',
          delay: 250,
          data: function (params) {
            return {
              query: params.term // search term
            };
          },
          processResults: function (data, params) {
  
            // parse the results into the format expected by Select2
            // since we are using custom formatting functions we do not need to
            // alter the remote JSON data, except to indicate that infinite
            // scrolling can be used
            // params.page = params.page || 1;
  
            return {
              results: $.map(data, function (item) {
                var additionalText = ''
                var PrefixText = ''
                PrefixText = item.client_id + " - "
                // additionalText = " ["+item.general_code+"]"
  
                return {
                  text: PrefixText + item.client_name + additionalText,
                  id: item.client_id
                }
              })
            };
          },
          cache: true
        },
        escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
        // minimumInputLength: 0,
        // tags: true, // for create new tags
        language: {
          inputTooShort: function () {
            return 'Input is too short';
          },
          errorLoading: function () {
            return `There's error on our side`;
          },
          noResults: function () {
            return 'There are no result based on your search';
          }
        }
    });


    $('#edit_pic').select2({
        dropdownParent: $('#edit-data-modal'),
        placeholder : 'Select PIC',
        theme: 'classic',
        allowClear: true,
        ajax: {
          url: '/dashboard/select-pic',
          dataType: 'json',
          delay: 250,
          data: function (params) {
            return {
              query: params.term // search term
            };
          },
          processResults: function (data, params) {
  
            // parse the results into the format expected by Select2
            // since we are using custom formatting functions we do not need to
            // alter the remote JSON data, except to indicate that infinite
            // scrolling can be used
            // params.page = params.page || 1;
  
            return {
              results: $.map(data, function (item) {
                var additionalText = ''
                var PrefixText = ''
                PrefixText = item.employee_id + " - "
                // additionalText = " ["+item.general_code+"]"
  
                return {
                  text: PrefixText + item.employee_name + additionalText,
                  id: item.employee_id
                }
              })
            };
          },
          cache: true
        },
        escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
        // minimumInputLength: 0,
        // tags: true, // for create new tags
        language: {
          inputTooShort: function () {
            return 'Input is too short';
          },
          errorLoading: function () {
            return `There's error on our side`;
          },
          noResults: function () {
            return 'There are no result based on your search';
          }
        }
    });

});



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

  var formCreate = () => {

   $('#add-data-modal').submit(function (e) { 
    e.preventDefault();

         const client_name = $('#client_name').val();
         const pic = $('#pic').val();
         const schedule = $('#schedule').val();
         const type_working = $('#type_working').val();

         const formData = {
          client_name : client_name,
          pic : pic,
          schedule : schedule,
          type_working : type_working
         }

            const form = $('#add-data-modal');

            $.ajax({
                type: "POST",
                url: "/dashboard/create-visiting",
                data: formData,
                success: function (response) {
                    if (response.status == 200) {
                      form.find('select').val(null).trigger('change');
                      form.trigger('reset');
                      $('#add-data-modal').modal('hide');
                      dt.ajax.reload();
                      toastMixin.fire({
                        animation: true,
                        title: 'Data saved Successfully!'
                      });
                    }else if(response.status == 400){
                
                      showError('client_name', response.messages.client_name);
                      showError('pic', response.messages.pic);
                      showError('schedule', response.messages.schedule);
                      showError('type_working', response.messages.type_working);
                    }
                }
            });
          });
};   

var editVisitingProductivity = () => {

  $('body').on('click', '.edit-data-modal', function (e) {

    const id =  $(this).data('id');

    $.ajax({
      type: "GET",
      url: "/dashboard/edit-visiting-productivity/" + id,
      success: function (res) {



        $('#id-visiting').data('id', res.id);

        var dataClients = {
          id: res.client_id,
          text: res.clients.name
      };
      
      var newOption = new Option(dataClients.text, dataClients.id, false, false);
      $('#edit_client_name').append(newOption).trigger('change');


        var dataPIC = {
          id: res.employee_id,
          text: res.employees.nama_pegawai
      };
      
      var newOption = new Option(dataPIC.text, dataPIC.id, false, false);
      $('#edit_pic').append(newOption).trigger('change');


      $('#edit_schedule').daterangepicker({
        startDate: moment(res.schedule).format("DD/MM/YYYY"),
        singleDatePicker: true,
        locale: {
            format: 'DD/MM/YYYY',
        },
    });


    $('#edit_type_working').val(res.working_type);
      
      }
    });
  });
}


var formEdit = () => {
  $('#formVisitingEdit').submit(function (e) { 
    e.preventDefault();

    const id = $('#id-visiting').data('id');

    var formData = $('#formVisitingEdit').serialize();


    $.ajax({
      type: "PUT",
      url: "/dashboard/update-visiting-productivity/" + id,
      data: formData ,
      success: function (response) {
        if (response.status == 200) {
          $('#edit-data-modal').modal('hide');
          dt.ajax.reload();
          toastMixin.fire({
            animation: true,
            title: 'Data Updated Successfully!'
          });
        }else if(response.status == 400){
        
    
          showError('edit_client_name', response.messages.client_name);
          showError('edit_pic', response.messages.pic);
          showError('edit_schedule', response.messages.schedule);
          showError('edit_type_working', response.messages.type_working);
        }
      }
    });
    
  });
}

var deleteVisitingProductivity = () => {
  $('body').on('click', '.delete-visiting-productivity', function (e) {

    const id =  $(this).data('id');

    $.ajax({
      type: "DELETE",
      url: "/dashboard/delete-visiting-productivity/" + id,
      success: function (response) {
        dt.ajax.reload();
        toastMixin.fire({
          animation: true,
          title: 'Data Deleted Successfully!'
        });
      }
    });
  });
}



function workingTypeInformation(){

    $.ajax({
      type: "GET",
      url: "/dashboard/working-type-information",
      success: function (response) {
        $('#info-maintenance').text(`${response.maintenance}/${response.total_maintenance}`);
        $('#info-support').text(`${response.support}/${response.total_support}`);
        $('#info-error').text(`${response.error}/${response.total_error}`);
      }
    });
}


function timeLine(selectedData) {

  $('#activity-timeline').empty();



  var formData = {
    employee_id : selectedData.employee_id,
    schedule : selectedData.schedule
  }


  $.ajax({
    type: "GET",
    url: "/dashboard/recent-activity",
    data: formData,
    success: function (res) {
      console.log(res);
     const count =  res.length;
      // console.log(count);

      if(count > 1){
 // List item timeline
  var timelineItems = [
    {
      label: res[0].depature_location,
      time: moment(res[0].depature_time).format('HH:mm'),
      badgeClass: 'text-success',
      content:  res[0].depature_location
    },
    {
      label: res[0].location,
      time: moment(res[0].checkin_location).format('HH:mm'),
      badgeClass: 'text-warning',
      content: res[0].location
    },
    {
      label: 'Maintenance',
      time: res[0].maintenance + ' Min',
      badgeClass: 'text-danger',
      content: 'Maintanance'
    },
    {
      label: 'Report Time',
      time: moment(res[0].report_time).format('HH:mm'),
      badgeClass: 'text-primary',
      content: 'Report Time'
    },
  ];

       timelineItems.forEach(function(item, index) {

      var activityItem = `
        <div class="activity-item d-flex">
          <div class="activite-label" id="activity-${item.label.toLowerCase()}">${item.time}</div>
          <i class='bi bi-circle-fill activity-badge ${item.badgeClass} align-self-start'></i>
          <div class="activity-content">${item.content}</div>
        </div>`;
  
      var $activityItem = $(activityItem);
  
      // Tambahkan class 'show' secara bertahap untuk memicu animasi
      setTimeout(function() {
        $activityItem.addClass('show');
      }, index * 200); // 200ms delay antara setiap item
  
      // Tambahkan item ke timeline
      $('#activity-timeline').append($activityItem);
    });


  res.shift();
var times = [];
  res.forEach(function(item, index) { 
     times = [
      {
        label: item.depature_location,
        time: moment(item.depature_time).format('HH:mm'),
        badgeClass: 'text-success',
        content: item.depature_location
      },
      {
        label: item.location,
        time: moment(item.checkin_location).format('HH:mm'),
        badgeClass: 'text-warning',
        content: item.location
      },
      {
        label: 'Maintenance',
        time: item.maintenance + ' Min',
        badgeClass: 'text-danger',
        content: 'Maintanance'
      },
      {
        label: 'Report Time',
        time: moment(item.report_time).format('HH:mm'),
        badgeClass: 'text-primary',
        content: 'Report Time'
      },
      {
        label: item.checkout_location,
        time: moment(item.checkout).format('HH:mm'),
        badgeClass: 'text-info',
        content: item.checkout_location
      },
    ];

  });

  
  times.forEach(function(item, index) {
    if(item.time !=  'Invalid date' && item.time != 'null Min' ){
    var activityItem2 = `
      <div class="activity-item d-flex">
        <div class="activite-label" id="activity-${item.label}">${item.time}</div>
        <i class='bi bi-circle-fill activity-badge ${item.badgeClass} align-self-start'></i>
        <div class="activity-content">${item.content}</div>
      </div>`;
    }
    var $activityItem2 = $(activityItem2);

    // Tambahkan class 'show' secara bertahap untuk memicu animasi
    setTimeout(function() {
      $activityItem2.addClass('show');
    }, index * 1000); // 200ms delay antara setiap item

    // Tambahkan item ke timeline
    $('#activity-timeline').append($activityItem2);
  });


      } else {
          // List item timeline
  var timelineItemsSingle = [
    {
      label: res[0].depature_location,
      time: moment(res[0].depature_time).format('HH:mm'),
      badgeClass: 'text-success',
      content: res[0].depature_location
    },
    {
      label: res[0].location,
      time: moment(res[0].checkin_location).format('HH:mm'),
      badgeClass: 'text-warning',
      content: res[0].location
    },
    {
      label: 'Maintanance',
      time: res[0].maintenance + ' Min',
      badgeClass: 'text-danger',
      content: 'Maintanance'
    },
    {
      label: 'Report Time',
      time: moment(res[0].report_time).format('HH:mm'),
      badgeClass: 'text-primary',
      content: 'Report Time'
    },
    {
      label: res[0].checkout_location,
      time: moment(res[0].checkout).format('HH:mm'),
      badgeClass: 'text-info',
      content: res[0].checkout_location
    },
  ];

       timelineItemsSingle.forEach(function(item, index) {
        if(item.time !=  'Invalid date' && item.time != 'null Min' ){
      var activityItem = `
        <div class="activity-item d-flex">
          <div class="activite-label" id="activity-${item.label}">${item.time}</div>
          <i class='bi bi-circle-fill activity-badge ${item.badgeClass} align-self-start'></i>
          <div class="activity-content">${item.content}</div>
        </div>`;
        }
      var $activityItem = $(activityItem);
  
      // Tambahkan class 'show' secara bertahap untuk memicu animasi
      setTimeout(function() {
        $activityItem.addClass('show');
      }, index * 200); // 200ms delay antara setiap item
  
      // Tambahkan item ke timeline
      $('#activity-timeline').append($activityItem);
    });

      }
    }
  });



}

var checkInLocation = () => {
  $('body').on('click', '.checkin-visiting-productivity', function (e) {

  const id  =  $(this).data('id');

  $.ajax({
    type: "PUT",
    url: "/dashboard/checkin-location/" + id,
    success: function (response) {
      timeLine();
      toastMixin.fire({
        animation: true,
        title: response.message
      });
    },
    error: function (xhr, status, error) {
      console.error("AJAX request error:", status, error);
    }
  });


  });
}

// var checkDepatureOffice = () => {
//   $.ajax({
//     type: "GET",
//     url: "/dashboard/check-depature",
//     success: function (response) {
//       console.log(response);
//       if (response.exits === true) {
//         moment.locale('id');
//         const checkin = moment(response.data.checkin).format('HH:mm');
//         $('#result-depature-office').text(checkin);
//       }else if(response.exits === false) {
//         $('#result-depature-office').text('Check In');
//       }
      
//     },
//     error: function (xhr, status, error) {
//       console.error("AJAX request error:", status, error);
//     }
//   });
// }




// var recentActivity = () => {
// $.ajax({
//   type: "GET",
//   url: "/dashboard/recent-activity",
//   success: function (response) {
    
//   }
// });
// }

// var redirectScanCheckIn = (visiting_id = '') => {
//   $('#scan-checkin').click(function (e) { 
//     e.preventDefault();

//     if(visiting_id == ''){
//       toastMixin.fire({
//         title: 'Pilih data di datatable terlebih dahulu',
//         icon: 'error'
//       });
//       return
//     }
//    alert(visiting_id);
//   });
// }

var redirectScanCheckIn = () => {
  $('body').on('click', '.checkin-depature-office', function (e) {
  const id =  $(this).data('id');

  window.location.href = "/dashboard/scan-barcode/" + id;

  });
}

var redirectScanCheckOut = () => {
  $('body').on('click', '.visiting-productivity-arrived', function (e) {
  const id =  $(this).data('id');

  window.location.href = "/dashboard/scan-barcode-checkout/" + id;

  });
}

var redirectDetailReport = () => {
  $('body').on('click', '.visiting-productivity-report', function (e) { 

    const id =  $(this).data('id');

    window.location.href = "/dashboard/detail-report/" + id;
  });
}

var detailReport = () => {
  var visiting_id = $('#visiting_id').val();

  $.ajax({
    type: "GET",
    url: "/dashboard/detail-report-information/" + visiting_id,
    success: function (response) {
   
      const created_time = moment(response.created_visiting_productivity).format('DD/MM/YYYY');
      $('#detail-created').text('| ' + created_time);
      $('#detail-client-name').text(response.client_name);
      if(response.report_time != null){
        const reportTime = moment(response.report_time).format('HH:mm');
        $('#detail-report').text(reportTime);
      }
      if(response.checkin_location != null){
        const checkinLocation = moment(response.checkin_location).format('HH:mm');
        $('#detail-checkin').text(checkinLocation);
      }
      if(response.maintenance != null){
        $('#detail-maintenence').text(response.maintenance + ' minute');
      }
      
    }
  });

}



var createVisitingProductivityReport = () => {
  $('#formVisitingProductivity').submit(function (e) { 
    e.preventDefault();

    var formData = new FormData(this);
    var form = $(this);

    $.ajax({
      type: "POST",
      url: "/dashboard/create-visiting-productivity-report",
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.status == 200) {
          dtReport.ajax.reload();
          detailReport();
          form.trigger('reset');
          $('#visiting-productivity-report-modal').modal('hide');
          toastMixin.fire({
            animation: true,
            title: 'Data Saved Successfully!'
          });
        }else if(response.status == 400){    
          showError('report', response.messages.report);
          showError('file', response.messages.file);
        }
      
      }
    });
  });
}




var columnsDataTableReport = [

  { data: 'visiting_id', className: 'text-center',
  render: function(data, type, row, meta){
    return meta.row + meta.settings._iDisplayStart + 1;
  }
},
  { data: 'report', className: 'text-start',
  render: function (data, type, row) {
    if (type === 'display') {
    return $('<div/>').html(data).text();
    } else  {
      return data;
    }
     }
    },
    {
      data: 'file',
      className: 'text-center image-cell',
      render: function(data, type, row) {
        var img = '';
        if(row.file != null){
          img =  `<img src="/storage/${row.file}" alt="Image" />`;
        } else {
          img =  `-`;
        }
        return img ;
      }
    },
  {data: 'action' , name : 'action', className: 'text-center'}
  
];

var datatableReport = () => {
  var visiting_id = $('#visiting_id').val();

  dtReport = $('#datatable-report').DataTable({
    responsive: true,
    processing: true,
    serverSide: true,
    ajax: '/dashboard/datatable-report/' + visiting_id,
    columns: columnsDataTableReport,
    language: {
      processing: '<div class="loading-indicator mb-4">Loading...</div>',
    },
    columnDefs: [
      {
        targets: 0,
        checkboxes: {
          selectRow: true,
        },
      },
    ],
  });

  $('#datatable-report').on('click', '.image-cell', function () {
    // Reinitialize Magnific Popup after each DataTable redraw
    $('#zoom-img-modal').modal('show');
  
    // Use DataTable API to get data for the clicked row
    const rowIndex = dtReport.row($(this).closest('tr')).index();
    const rowData = dtReport.row(rowIndex).data();
  
    $('#zoomed-image').attr('src', '/storage/' + rowData.file);
  });

  $('#datatable-report').on('click', 'tr', function () {
  
    if ($(this).hasClass('selected')) {
      $(this).removeClass('selected');
    } else {
      dtReport.$('tr.selected').removeClass('selected');
      $(this).addClass('selected');
    }
    const selectedData = dtReport.row(this).data();
    console.log(selectedData);
    // const visiting_id = selectedData.visiting_id ;
  });
};


  var editReport = () => {
    $('body').on('click', '.edit-report', function(e){
     const id  =  $(this).data('id');
      $.ajax({
        type: "GET",
        url: "/dashboard/edit-report-detail/" + id,
        success: function (res) {
       
          $('#edit-report-detail-modal').modal('show');
          $('#edit_report').val(res.report);
          $('#edit-filename').text(res.file_name);
          $('#edit-file-hidden').val(res.file);
          $('#edit-visiting-id').val(res.id);
        }
      });
    });
  }


  var updateReport = () => {
    $('#formUpdateReportDetail').submit(function (e) { 
      e.preventDefault();

      var formData = new FormData(this);

      $.ajax({
        type: "POST",
        url: "/dashboard/update-report-detail",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          if (response.status == 200) {
            dtReport.ajax.reload();
            $('#edit-report-detail-modal').modal('hide');
            toastMixin.fire({
              animation: true,
              title: response.message
            });
          }else if(response.status == 400){    
            showError('edit_report', response.messages.edit_report);
            showError('edit-file', response.messages.edit_file);
          }else if(response.status == 404){
            toastMixin.fire({
              title: response.message,
              icon: 'error'
            });
          }
        }
      });
      
      
    });
  }

  var deleteReport = () => {
    $('body').on('click', '.delete-report', function(){
      
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
            url: "/dashboard/delete-report-detail/" + id,
            success: function (response) {
              dtReport.ajax.reload();
              toastMixin.fire({
                animation: true,
                title: response.message
              });
            }
          });
        }
      }); 
    }); 
  }


  


document.addEventListener('DOMContentLoaded', function(){
    initDatatable();
    addInput();
    formCreate();
    showError();
    editVisitingProductivity();
    formEdit();
    deleteVisitingProductivity();
    // checkDepatureOffice();
    // recentActivity();
    checkInLocation();
    redirectScanCheckIn();
    redirectScanCheckOut();
    createVisitingProductivityReport();
    // checkReportVisitingProductivity();
    redirectDetailReport();
    datatableReport();
    editReport();
    updateReport();
    detailReport();
    deleteReport();
    workingTypeInformation();
});