<style>
    /* Gaya untuk input dan select tidak valid */
    input.error, select.error {
      border-color: red;
    }
  
    /* Gaya untuk pesan kesalahan */
    label.error {
      color: red;
    }
  </style>
        <!-- Modal -->
           <div class="modal fade" id="edit-data-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Visity Productivity</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form  method="POST" id="formVisitingEdit">
                      @method('put')
                      <input type="hidden" data-id="" id="id-visiting">
                      <!-- start row -->
                      <div class="row">
                          <div class="col-sm-3">
                              <div class="mb-3">
                                  <label  class="form-label">Client Name</label>
                                  <select style="width: 100%" class="client-name" id="edit_client_name"  name="client_name">
                                  </select>
                                  <div class="invalid-feedback"></div>
                              </div>
                          </div>
                          <div class="col-sm-3">
                              <div class="mb-3">
                                  <label class="form-label">PIC</label> <br>
                                  <select style="width: 100%"  name="pic"  class="edit_pic" id="edit_pic">
                                  </select>
                                  <div class="invalid-feedback"></div>
                              </div>
                          </div>
                          <div class="col-sm-3">
                              <div class="mb-3">
                                  <label  class="form-label">Schedule Date</label>
                                  <input type="text" name="schedule" class="form-control" id="edit_schedule">
                                  <div class="invalid-feedback"></div>
                              </div>
                          </div>
                          <div class="col-sm-3">
                              <div class="mb-3">
                                  <label  class="form-label">Working Type</label>
                                  <input type="text" name="type_working" class="form-control" id="edit_type_working">
                                  <div class="invalid-feedback"></div>
                              </div>
                          </div>
                      </div>                    
                  <!-- end row -->
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-success"
              style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;">
              Update Data
            </button>
          </form>
                  </div>
                </div>
              </div>
            </div>  