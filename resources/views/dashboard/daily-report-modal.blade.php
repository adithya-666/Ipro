    <!-- Modal -->
    <style>
        trix-toolbar [data-trix-button-group="file-tools"] {
  display: none;
}
    </style>
                 <div class="modal fade" id="daily-report-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h1 class="modal-title fs-5" id="exampleModalLabel">Add Data</h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <form method="POST" href="{{ url('dashboard/create-daily-report') }}" class="formCreate" id="formDailyReport">
                            @csrf
                            <!-- start row -->
                            <label  class="mt-4"><b>Report</b><span class="text-danger ml-2">*</span></label>
                            <div class="report">
                                <input id="report" type="hidden" name="report">
                                <trix-editor input="report"></trix-editor>
                                <div class="invalid-feedback"></div>
                            </div>
                            <label  class="mt-4"><b>Trouble</b></label>
                            <div class="trouble">
                                <input id="trouble" type="hidden" value="Alhamdulilah Tidak Ada Kendala, Running Well" name="trouble">
                                <trix-editor input="trouble" ></trix-editor>
                            </div>
                            <label  class="mt-4"><b>Plan</b><span class="text-danger ml-2">*</span></label>
                            <div class="plan">
                                <input id="plan" type="hidden" name="plan">
                                <trix-editor input="plan"></trix-editor>
                                <div class="invalid-feedback"></div>
                            </div>
                        <!-- end row -->
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success center" id="formCreateBtn">Save changes</button>
                          </div>
                   
                          </form>
                        </div>
                       
                      </div>
                    </div>
                  </div>  