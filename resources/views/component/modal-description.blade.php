
<!-- Modal -->
<div class="modal fade" id="modal-description" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-title">Form</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form autocomplete="OFF" id="form-description" method="post">
          @csrf
          <div id="form-method">
          </div>
          <input type="text" name="id" class="form-control" style="display: none" id="id">
          <div class="form-group">
            <label for="name" class="col-form-label">Nama</label>
            <input required type="text" name="name" class="form-control" id="name">
          </div>
          <div class="form-group">
            <label for="description" class="col-form-label">Deskripsi</label>
            <textarea class="form-control" name="description" id="description"></textarea>
          </div>
          <hr>
          <div class="row">
            <div class="col-12 text-right">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" id="btn-modal-description"><i class="fas fa-save"></i> Simpan</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>