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
								<th>Alamat</th>
								<th>Up</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php
								foreach($data['supplier'] as $row) :
							?>
							<tr>
								<td><?= $row['supplier_kode']; ?></td>
								<td><?= $row['supplier_nama']; ?></td>
								<td><?= $row['supplier_alamat']; ?></td>
								<td><?= $row['supplier_up']; ?></td>
								<td>
									<button type="button" class="btn btn-success btn-xs show-tooltip btnEdit" title="Edit" data-supplier-kode="<?= $row['supplier_kode']; ?>" data-supplier-nama="<?= $row['supplier_nama']; ?>" data-supplier-alamat="<?= $row['supplier_alamat']; ?>" data-supplier-up="<?= $row['supplier_up']; ?>"><i class="fa fa-edit"></i></button>
									<button type="button" class="btn btn-danger btn-xs show-tooltip btnDelete" title="Hapus" data-supplier-kode="<?= $row['supplier_kode']; ?>"><i class="fa fa-trash"></i></button>
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
        <p class="modal-title"><i class="fa fa-plus"></i> Supplier</p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form id="form">
      	<div class="modal-body">
        	<div class="row mb-1">
        		<label class="col-sm-3 text-sm">Nama Supplier</label>
        		<div class="col-sm-9">
        			<input type="text" name="supplier_nama" class="form-control form-control-sm" placeholder="Masukan Nama Supplier" autocomplete="off" required />
        		</div>
        	</div>
        	<div class="row mb-1">
        		<label class="col-sm-3 text-sm">Alamat</label>
        		<div class="col-sm-9">
        			<textarea class="form-control" name="supplier_alamat" required></textarea>
        		</div>
        	</div>
        	<div class="row mb-1">
        		<label class="col-sm-3 text-sm">Up</label>
        		<div class="col-sm-9">
        			<input type="text" name="supplier_up" class="form-control form-control-sm" placeholder="Masukan Up" autocomplete="off" required />
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
        <p class="modal-title"><i class="fa fa-edit"></i> Edit</p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form id="form">
      	<div class="modal-body">
        	<div class="row mb-1">
        		<label class="col-sm-3 text-sm">Nama Supplier</label>
        		<div class="col-sm-9">
        			<input type="text" name="supplier_nama" class="form-control form-control-sm" placeholder="Masukan Nama Supplier" autocomplete="off" required />
        		</div>
        	</div>
        	<div class="row mb-1">
        		<label class="col-sm-3 text-sm">Alamat</label>
        		<div class="col-sm-9">
        			<textarea class="form-control" name="supplier_alamat" required></textarea>
        		</div>
        	</div>
        	<div class="row mb-1">
        		<label class="col-sm-3 text-sm">Up</label>
        		<div class="col-sm-9">
        			<input type="text" name="supplier_up" class="form-control form-control-sm" placeholder="Masukan Up" autocomplete="off" required />
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
	    		url: "<?= base_url('supplier/store'); ?>",
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
				$form.supplier_kode = $(this).data('supplier-kode');
				$('input[name="supplier_nama"]', $modalEdit).val($(this).data('supplier-nama'));
				$('textarea[name="supplier_alamat"]', $modalEdit).val($(this).data('supplier-alamat'));
				$('input[name="supplier_up"]', $modalEdit).val($(this).data('supplier-up'));
				$modalEdit.modal('show');
			});

			$form.on('submit', function(event){
				event.preventDefault();
				$form.btnSubmitLadda.ladda('start');

				$.ajax({
	    		url: `<?= base_url('supplier/update/'); ?>${$form.supplier_kode}`,
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
				$form.supplier_kode = $(this).data('supplier-kode');
				$modalDelete.modal('show');
			});

			$form.on('submit', function(event){
				event.preventDefault();
				$form.btnSubmitLadda.ladda('start');

				$.ajax({
	    		url: `<?= base_url('supplier/delete/'); ?>${$form.supplier_kode}`,
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
