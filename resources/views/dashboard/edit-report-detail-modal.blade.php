<div class="modal" tabindex="-1" id="edit-report-detail-modal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Visiting Prductivity Report</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form method="POST" href="{{ url('dashboard/update-report-detail') }}"  id="formUpdateReportDetail"  enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <input class="form-control" type="hidden" name="edit_visiting_id" id="edit-visiting-id">
            <div class="row mb-3">
              <label for="inputText" class="col-sm col-form-label">Report    <span class="text-danger">*</span></label>
              <div class="col-sm-12">
                <input id="edit-report" type="hidden" name="edit_report">
                <trix-editor id="edit_report" input="edit-report"></trix-editor>
                <div class="invalid-feedback"></div>
              </div>
            </div>
            <div class="row mb-3">
              <label for="inputEmail" class="col-sm- col-form-label">Upload File</label>
              <div class="col-sm-12">
                <p style="font-style: italic; color:orange;" id="edit-filename"></p>
                <input class="form-control" type="file" name="edit_file" id="edit-file">
                <input type="hidden" name="edit_file_hidden" id="edit-file-hidden">
                <div class="invalid-feedback"></div>
              </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary"  id="edit-report" >Update Report</button>
        </div>
      </form>
      </div>
    </div>
  </div>