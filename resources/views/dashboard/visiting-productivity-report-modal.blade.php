    <!-- Modal -->
    <style>
        trix-toolbar [data-trix-button-group="file-tools"] {
  display: none;
}
                 </style>
                 <div class="modal fade" id="visiting-productivity-report-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h1 class="modal-title fs-5" id="exampleModalLabel">Report</h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <form method="POST" href="{{ url('dashboard/create-visiting-productivity') }}"  id="formVisitingProductivity"  enctype="multipart/form-data">
                            @csrf
                            <input class="form-control" type="hidden" name="visiting_id" id="visiting_id">
                            <!-- start row -->
                            <label  class="mt-4"><b>Report</b><span class="text-danger ml-2">*</span></label>
                            <div class="report">
                                <input id="report" type="hidden" name="report">
                                <trix-editor input="report"></trix-editor>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="mt-3">
                              <label  class="form-label">Upload File</label>
                              <input class="form-control" type="file" name="file" id="file">
                              <div class="invalid-feedback"></div>
                            </div>
                        <!-- end row -->
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success center" id="formVisitingProductivityBtn">Save changes</button>
                          </div>  
                          </form>
                        </div>   
                      </div>
                    </div>
                  </div>  