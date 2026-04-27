<div class="modal fade bd-example-modal-xl" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
              <p>Apakah kamu yakin apan menghapus data ini?</p>
            </div>
            <div class="modal-footer justify-content-between" style="">
              <form id="destroy" action="" method="POST" style="" >
                  {{csrf_field()}}
                  {{method_field('DELETE')}}
                  <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                  <button type="submit" class="btn btn-danger">Hapus Data</button>
              </form>
            </div>

        </div>
    </div>
</div>
