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
								<th>Kode</th>
								<th>Nama</th>
								<th>Satuan</th>
								<th>Harga</th>
								<th>Stok</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php
								foreach($data['barang'] as $row) :
							?>
							<tr>
								<td><?= $row['barang_kode']; ?></td>
								<td><?= $row['barang_nama']; ?></td>
								<td><?= $row['satuan_nama']; ?></td>
								<td><?= number_format((float) $row['barang_harga'], 0, '.', ','); ?></td>
								<td><?= $row['barang_stok']; ?></td>
								<td>
									<button type="button" class="btn btn-success btn-xs show-tooltip btnEdit" title="Edit" data-barang-kode="<?= $row['barang_kode']; ?>" data-barang-nama="<?= $row['barang_nama']; ?>" data-barang-harga="<?= $row['barang_harga']; ?>" data-satuan-id="<?= $row['satuan_id']; ?>"><i class="fa fa-edit"></i></button>
									<button type="button" class="btn btn-danger btn-xs show-tooltip btnDelete" data-barang-kode="<?= $row['barang_kode']; ?>" title="Hapus"><i class="fa fa-trash"></i></button>
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
        <p class="modal-title"><i class="fa fa-plus"></i> Barang</p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form id="form">
      	<div class="modal-body">
        	<div class="row mb-1">
        		<label class="col-sm-3 text-sm">Nama</label>
        		<div class="col-sm-9">
        			<input type="text" name="barang_nama" class="form-control form-control-sm" placeholder="Masukan Nama Barang" autocomplete="off" required />
        		</div>
        	</div>
        	<div class="row mb-1">
        		<label class="col-sm-3 text-sm">Satuan</label>
        		<div class="col-sm-9">
        			<select class="custom-select custom-select-sm" name="satuan_id" required>
        				<option value="">-- Pilih Satuan --</option>
        				<?php foreach($data['satuan'] as $row) : ?>
        					<option value="<?= $row['satuan_id']; ?>"><?= $row['satuan_nama']; ?></option>
        				<?php endforeach; ?>
        			</select>
        		</div>
        	</div>
        	<div class="row mb-1">
        		<label class="col-sm-3 text-sm">Harga</label>
        		<div class="col-sm-9">
        			<input type="number" name="barang_harga" class="form-control form-control-sm" placeholder="Masukan Harga Barang" min="1" required />
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
        <p class="modal-title"><i class="fa fa-edit"></i> Barang</p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form id="form">
      	<div class="modal-body">
        	<div class="row mb-1">
        		<label class="col-sm-3 text-sm">Nama</label>
        		<div class="col-sm-9">
        			<input type="text" name="barang_nama" class="form-control form-control-sm" placeholder="Masukan Nama Barang" autocomplete="off" required />
        		</div>
        	</div>
        	<div class="row mb-1">
        		<label class="col-sm-3 text-sm">Satuan</label>
        		<div class="col-sm-9">
        			<select class="custom-select custom-select-sm" name="satuan_id" required>
        				<?php foreach($data['satuan'] as $row) : ?>
        					<option value="<?= $row['satuan_id']; ?>"><?= $row['satuan_nama']; ?></option>
        				<?php endforeach; ?>
        			</select>
        		</div>
        	</div>
        	<div class="row mb-1">
        		<label class="col-sm-3 text-sm">Harga</label>
        		<div class="col-sm-9">
        			<input type="number" name="barang_harga" class="form-control form-control-sm" placeholder="Masukan Harga Barang" min="1" required />
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
	    		url: "<?= base_url('barang/store'); ?>",
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
				$form.barang_kode = $(this).data('barang-kode');
				$('input[name="barang_nama"]', $modalEdit).val($(this).data('barang-nama'));
				$('input[name="barang_harga"]', $modalEdit).val($(this).data('barang-harga'));
				$('select[name="satuan_id"]', $modalEdit).val($(this).data('satuan-id')).change();
				$modalEdit.modal('show');
			});

			$form.on('submit', function(event){
				event.preventDefault();
				$form.btnSubmitLadda.ladda('start');

				$.ajax({
	    		url: `<?= base_url('barang/update/'); ?>${$form.barang_kode}`,
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
				$form.barang_kode = $(this).data('barang-kode');
				$modalDelete.modal('show');
			});

			$form.on('submit', function(event){
				event.preventDefault();
				$form.btnSubmitLadda.ladda('start');

				$.ajax({
	    		url: `<?= base_url('barang/delete/'); ?>${$form.barang_kode}`,
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
