<div class="row">
	<div class="col-md-12">
		<div class="card card-info card-outline shadow-sm">
			<div class="card-body">
				<div class="mb-2">
					<button class="btn btn-primary btn-sm text-xs show-tooltip" title="Tambah" data-toggle="modal" data-target="#modalAdd" type="button">
						<i class="fa fa-plus"></i>
					</button>
				</div>
				<div class="table-responsive">
					<table class="table table-bordered table-hover" id="mainTable">
						<thead>
							<tr>
								<th>ID</th>
								<th>Nama Satuan</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php
								foreach($data['satuan'] as $row) :
							?>
							<tr>
								<td><?= $row['satuan_id']; ?></td>
								<td><?= $row['satuan_nama']; ?></td>
								<td>
									<button type="button" class="btn btn-success btn-xs show-tooltip btnEdit" title="Edit" data-satuan-id="<?= $row['satuan_id']; ?>" data-satuan-nama="<?= $row['satuan_nama']; ?>"><i class="fa fa-edit"></i></button>
									<button type="button" class="btn btn-danger btn-xs show-tooltip btnDelete" title="Hapus" data-satuan-id="<?= $row['satuan_id']; ?>"><i class="fa fa-trash"></i></button>
								</td>
							</tr>
							<?php
								endforeach;
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" data-backdrop="static" id="modalAdd" style="display: none;" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <p class="modal-title"><i class="fa fa-plus"></i> Satuan</p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form id="form">
      	<div class="modal-body">
        	<div class="row">
        		<div class="col-sm-3">
        			<label class="text-sm">Nama Satuan</label>
        		</div>
        		<div class="col-sm-9">
        			<input type="text" name="satuan_nama" class="form-control form-control-sm" placeholder="Masukan Nama Satuan" autocomplete="off" required />
        		</div>
        	</div>
      	</div>
	      <div class="modal-footer justify-content-between">
	        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">
	          <i class="fa fa-times"></i>
	          <span>Tutup</span>
	        </button>
	        <button type="submit" class="btn btn-success btn-sm" data-style="slide-up">
	          <i class="fa fa-check"></i>
	          <span>Simpan</span>
	        </button>
	      </div>
	    </form>
    </div>
  </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" data-backdrop="static" id="modalEdit" style="display: none;" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <p class="modal-title"><i class="fa fa-edit"></i> Satuan</p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form id="form">
      	<div class="modal-body">
        	<div class="row">
        		<div class="col-sm-3">
        			<label class="text-sm">Nama Satuan</label>
        		</div>
        		<div class="col-sm-9">
        			<input type="text" name="satuan_nama" class="form-control form-control-sm" placeholder="Masukan Nama Satuan" autocomplete="off" required />
        		</div>
        	</div>
      	</div>
	      <div class="modal-footer justify-content-between">
	        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">
	          <i class="fa fa-times"></i>
	          <span>Tutup</span>
	        </button>
	        <button type="submit" class="btn btn-success btn-sm" data-style="slide-up">
	          <i class="fa fa-check"></i>
	          <span>Simpan</span>
	        </button>
	      </div>
	    </form>
    </div>
  </div>
</div>

<!-- Modal Hapus -->
<div class="modal fade" data-backdrop="static" id="modalDelete" style="display: none;" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <p class="modal-title"><i class="fa fa-trash"></i> Hapus Data</p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form id="form">
      	<div class="modal-body">
        	<p class="mb-0 text-sm">Anda yakin ingin menghapus data ini?</p>
      	</div>
	      <div class="modal-footer justify-content-between">
	        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">
	          <i class="fa fa-times"></i>
	          <span>Tutup</span>
	        </button>
	        <button type="submit" class="btn btn-danger btn-sm" data-style="slide-up">
	          <i class="fa fa-trash"></i>
	          <span>Hapus</span>
	        </button>
	      </div>
	    </form>
    </div>
  </div>
</div>

<script type="text/javascript">
	$(function(){
		const RELOAD_TIME = 1500; // 1,5 second

		// DataTable -----------------------------------------------
		const $mainTable = $("#mainTable");

		$mainTable.dataTable = $mainTable.DataTable({
      "responsive": true,
      "autoWidth": false,
      "ordering": false,
    });

		// Add Data ---------------------------------------------
		const DataAdd = () => {
			const $modalAdd = $('#modalAdd');
			const $form = $('#form', $modalAdd);
			$form.btnSubmitLadda = $('button[type="submit"]', $form).ladda();
			
			$form.on('submit', function(event){
				event.preventDefault();
				$form.btnSubmitLadda.ladda('start');

				$.ajax({
	    		url: "<?= base_url('satuan/store'); ?>",
	    		method: "POST",
	    		dataType: "JSON",
	    		data: $(this).serialize(),
	    	})
	    	.done((response, text, xhr) => {
	    		if(xhr.status !== 200) return;

	    		const { message, title } = response;
	    		showToastr('success', message, title);

	    		$modalAdd.modal('hide');

	    		setTimeout(() => location.reload(), RELOAD_TIME);
	    	})
	    	.fail(error => {
	    		errorHandler(error);
	    	})
	    	.always(() => {
	    		$form.btnSubmitLadda.ladda('stop');
	    	});
			});
		}

		// Edit Data --------------------------------------------
		const DataEdit = () => {
			const $modalEdit = $('#modalEdit');
			const $form = $('#form', $modalEdit);
			$form.btnSubmitLadda = $('button[type="submit"]', $form).ladda();

			$mainTable.on('click', '.btnEdit', function(){
				$form.satuan_id = $(this).data('satuan-id');
				$('input[name="satuan_nama"]', $modalEdit).val($(this).data('satuan-nama'));
				$modalEdit.modal('show');
			});

			$form.on('submit', function(event){
				event.preventDefault();
				$form.btnSubmitLadda.ladda('start');

				$.ajax({
	    		url: `<?= base_url('satuan/update/'); ?>${$form.satuan_id}`,
	    		method: "POST",
	    		dataType: "JSON",
	    		data: $(this).serialize(),
	    	})
	    	.done((response, text, xhr) => {
	    		if(xhr.status !== 200) return;

	    		const { message, title } = response;
	    		showToastr('success', message, title);

	    		setTimeout(() => location.reload(), RELOAD_TIME);
	    	})
	    	.fail(error => {
	    		errorHandler(error);
	    	})
	    	.always(() => {
	    		$form.btnSubmitLadda.ladda('stop');
	    	});
			});
		}

		// Delete Data
		const DataDelete = () => {
			const $modalDelete = $('#modalDelete');
			const $form = $('#form', $modalDelete);
			$form.btnSubmitLadda = $('button[type="submit"]', $form).ladda();

			$mainTable.on('click', '.btnDelete', function(){
				$form.satuan_id = $(this).data('satuan-id');
				$modalDelete.modal('show');
			});

			$form.on('submit', function(event){
				event.preventDefault();
				$form.btnSubmitLadda.ladda('start');

				$.ajax({
	    		url: `<?= base_url('satuan/delete/'); ?>${$form.satuan_id}`,
	    		method: "POST",
	    		dataType: "JSON",
	    	})
	    	.done((response, text, xhr) => {
	    		if(xhr.status !== 200) return;

	    		const { message, title } = response;
	    		showToastr('success', message, title);

	    		$modalDelete.modal('hide');

	    		setTimeout(() => location.reload(), RELOAD_TIME);
	    	})
	    	.fail(error => {
	    		errorHandler(error);
	    	})
	    	.always(() => {
	    		$form.btnSubmitLadda.ladda('stop');
	    	});
			});
		}

		// init
		DataAdd();
		DataEdit();
		DataDelete();
	});
</script>
