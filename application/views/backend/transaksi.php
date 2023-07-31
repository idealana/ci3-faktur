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
								<th>No. Faktur</th>
								<th>Supplier</th>
								<th>Tanggal</th>
								<th>Status</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php
								foreach($data['transaksi'] as $row) :
							?>
							<tr>
								<td><?= $row['tr_kode']; ?></td>
								<td><?= $row['tr_no_faktur']; ?></td>
								<td><?= $row['supplier_nama']; ?></td>
								<td><?= $row['tr_tanggal']; ?></td>
								<td><?= $row['tr_status']; ?></td>
								<td>
									<button type="button" class="btn btn-secondary btn-xs show-tooltip btnDetail" title="Detail" data-tr-kode="<?= $row['tr_kode']; ?>"><i class="fa fa-eye"></i></button>
									<a href="<?= base_url('transaksi/print/'.$row['tr_kode']); ?>" target="_blank" rel="noopener" class="btn btn-primary btn-xs show-tooltip" title="Cetak"><i class="fa fa-print"></i></a>
									<?php if($row['tr_status'] === "Pending") : ?>
										<button type="button" class="btn btn-success btn-xs show-tooltip btnEdit" title="Edit" data-tr-kode="<?= $row['tr_kode']; ?>"><i class="fa fa-edit"></i></button>
										<button type="button" class="btn btn-info btn-xs show-tooltip btnEditStatus" title="Ubah Status" data-tr-kode="<?= $row['tr_kode']; ?>" data-tr-status="<?= $row['tr_status']; ?>"><i class="fa fa-edit"></i></button>
										<button type="button" class="btn btn-danger btn-xs show-tooltip btnDelete" data-tr-kode="<?= $row['tr_kode']; ?>" title="Hapus"><i class="fa fa-trash"></i></button>
									<?php endif; ?>
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
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <p class="modal-title"><i class="fa fa-plus"></i> Transaksi</p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form id="form">
      	<div class="modal-body max-h">
        	<div class="row mb-1">
        		<div class="col-sm-4">
        			<label class="text-sm mb-0">No. Faktur</label>
        			<input type="text" name="no_faktur" class="form-control form-control-sm" placeholder="Masukan Nomor Faktur" autocomplete="off" required />
        		</div>
        		<div class="col-sm-4">
        			<label class="text-sm mb-0">Supplier</label>
        			<select class="custom-select custom-select-sm" name="supplier_kode" required>
        				<option value="">-- Pilih Supplier --</option>
        				<?php foreach($data['supplier'] as $row) : ?>
        					<option value="<?= $row['supplier_kode']; ?>"><?= $row['supplier_nama']; ?></option>
        				<?php endforeach; ?>
        			</select>
        		</div>
        		<div class="col-sm-4">
        			<label class="text-sm mb-0">Tanggal</label>
        			<input type="date" name="tanggal" class="form-control form-control-sm" required />
        		</div>
        	</div>

	        <p class="mb-0">Daftar Barang</p>
	        <table class="table table-bordered mt-2">
						<thead>
							<tr class="text-center">
								<th>Barang</th>
								<th>Satuan</th>
								<th>Jumlah</th>
								<th>Harga</th>
								<th>Total Harga</th>
								<th>#</th>
							</tr>
						</thead>
						<tbody class="barang_list"></tbody>
						<tfoot>
							<tr>
								<th colspan="4" class="text-center">Total</th>
								<th class="item_all_total_harga text-right">0</th>
								<th></th>
							</tr>
						</tfoot>
					</table>
        	<div class="text-center">
        		<button type="button" class="btn btn-primary btn-sm btnAddItem">Tambah</button>
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

<!-- Modal Detail -->
<div class="modal fade" data-backdrop="static" id="modalDetail" style="display: none;" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <p class="modal-title"><i class="fa fa-eye"></i> Detail</p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form id="form">
      	<div class="modal-body"></div>
	      <div class="modal-footer justify-content-between">
	        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">
	          <i class="fa fa-times"></i>
	          <span>Tutup</span>
	        </button>
	      </div>
	    </form>
    </div>
  </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" data-backdrop="static" id="modalEdit" style="display: none;" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <p class="modal-title"><i class="fa fa-edit"></i> Transaksi</p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form id="form">
      	<div class="modal-body max-h">
        	<div class="row mb-1">
        		<div class="col-sm-4">
        			<label class="text-sm mb-0">No. Faktur</label>
        			<input type="text" name="no_faktur" class="form-control form-control-sm" placeholder="Masukan Nomor Faktur" autocomplete="off" required />
        		</div>
        		<div class="col-sm-4">
        			<label class="text-sm mb-0">Supplier</label>
        			<select class="custom-select custom-select-sm" name="supplier_kode" required>
        				<?php foreach($data['supplier'] as $row) : ?>
        					<option value="<?= $row['supplier_kode']; ?>"><?= $row['supplier_nama']; ?></option>
        				<?php endforeach; ?>
        			</select>
        		</div>
        		<div class="col-sm-4">
        			<label class="text-sm mb-0">Tanggal</label>
        			<input type="date" name="tanggal" class="form-control form-control-sm" required />
        		</div>
        	</div>

	        <p class="mb-0">Daftar Barang</p>
	        <table class="table table-bordered mt-2">
						<thead>
							<tr class="text-center">
								<th>Barang</th>
								<th>Satuan</th>
								<th>Jumlah</th>
								<th>Harga</th>
								<th>Total Harga</th>
								<th>#</th>
							</tr>
						</thead>
						<tbody class="barang_list"></tbody>
						<tfoot>
							<tr>
								<th colspan="4" class="text-center">Total</th>
								<th class="item_all_total_harga text-right">0</th>
								<th></th>
							</tr>
						</tfoot>
					</table>
        	<div class="text-center">
        		<button type="button" class="btn btn-primary btn-sm btnAddItem">Tambah</button>
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

<!-- Modal Edit Status -->
<div class="modal fade" data-backdrop="static" id="modalEditStatus" style="display: none;" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <p class="modal-title"><i class="fa fa-edit"></i> Ubah Status</p>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <form id="form">
      	<div class="modal-body max-h">
      		<div class="row">
      			<label class="col-sm-3 text-sm">Status</label>
      			<div class="col-sm-9">
		      		<select class="custom-select custom-select-sm" name="status" required>
		    				<option value="Pending">Pending</option>
		    				<option value="Approve">Approve</option>
		    				<option value="Reject">Reject</option>
		    			</select>
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

<script type="text/html" id="template_barang">
	<tr class="row_{index}">
		<td width="30%">
			<select class="custom-select custom-select-sm slc_barang" name="items[{index}][barang_kode]" data-row="row_{index}">
				<option value="">-- Pilih Barang --</option>
				<?php foreach($data['barang'] as $row) : ?>
					<option value="<?= $row['barang_kode']; ?>" data-satuan="<?= $row['satuan_nama']; ?>" data-harga="<?= $row['barang_harga']; ?>">
						<?= $row['barang_kode']; ?> | <?= $row['barang_nama']; ?>
					</option>
				<?php endforeach; ?>
			</select>
		</td>
		<td class="item_satuan">-</td>
		<td width="15%">
			<input type="number" min="1" name="items[{index}][jumlah]" value="1" data-row="row_{index}" class="form-control form-control-sm item_jumlah" required />
		</td>
		<td class="item_harga text-right">0</td>
		<td class="item_total_harga text-right">0</td>
		<td width="3%">
			<button type="button" class="btn btn-danger btn-xs btnDeleteRow" data-row="row_{index}">
				<i class="fa fa-times"></i>
			</button>
		</td>
	</tr>
</script>
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
	    		url: "<?= base_url('transaksi/store'); ?>",
	    		method: "POST",
	    		dataType: "JSON",
	    		data: $(this).serialize(),
	    	})
	    	.done((response, text, xhr) => {
	    		if(xhr.status !== 200) return;

	    		const { message, title } = response;
	    		showToastr('success', message, title);

	    		$(this)[0].reset();
	    		$(`.barang_list`, $(this)).children().remove();
	    		addRowItem($('.barang_list', $(this)));

	    		setTimeout(() => location.reload(), RELOAD_TIME);
	    	})
	    	.fail(error => {
	    		errorHandler(error);
	    	})
	    	.always(() => {
	    		$form.btnSubmitLadda.ladda('stop');
	    	});
			});

			$('.btnAddItem', $form).on('click', function(){
				addRowItem($('.barang_list', $form));
			});

			$form.on('click', '.btnDeleteRow', function(){
				const rowIndex = $(this).data('row');
				$(`.barang_list > .${rowIndex}`, $form).remove();
				countAllTotalHarga($form);
			});

			addRowItem($('.barang_list', $form));
		}

		// Delete Data
		const DataDelete = () => {
			const $modalDelete = $('#modalDelete');
			const $form = $('#form', $modalDelete);
			$form.btnSubmitLadda = $('button[type="submit"]', $form).ladda();

			$mainTable.on('click', '.btnDelete', function(){
				$form.tr_kode = $(this).data('tr-kode');
				$modalDelete.modal('show');
			});

			$form.on('submit', function(event){
				event.preventDefault();
				$form.btnSubmitLadda.ladda('start');

				$.ajax({
	    		url: `<?= base_url('transaksi/delete/'); ?>${$form.tr_kode}`,
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

		// Detail Data
		const DataDetail = () => {
			const $modalDetail = $('#modalDetail');

			$mainTable.on('click', '.btnDetail', function(){
				$('.modal-body', $modalDetail).html('<p class="mb-0 text-xs">Sedang Memuat...</p>');
				$modalDetail.modal('show');

				$.ajax({
	    		url: `<?= base_url('transaksi/get_detail/'); ?>${$(this).data('tr-kode')}`,
	    		dataType: "JSON",
	    	})
	    	.done((response, text, xhr) => {
	    		if(xhr.status !== 200) return;
	    		$('.modal-body', $modalDetail).html(response.html);
	    	})
	    	.fail(error => {
	    		errorHandler(error);
	    	})
			});
		}

		// Edit Data --------------------------------------------
		const DataEdit = () => {
			const $modalEdit = $('#modalEdit');
			const $form = $('#form', $modalEdit);
			$form.btnSubmitLadda = $('button[type="submit"]', $form).ladda();

			$('.btnAddItem', $form).on('click', function(){
				addRowItem($('.barang_list', $form));
			});

			$form.on('click', '.btnDeleteRow', function(){
				const rowIndex = $(this).data('row');
				$(`.barang_list > .${rowIndex}`, $form).remove();
				countAllTotalHarga($form);
			});

			$mainTable.on('click', '.btnEdit', function(){
				$form.tr_kode = $(this).data('tr-kode');
				$(`.barang_list`, $form).children().remove();

				$.ajax({
	    		url: `<?= base_url('transaksi/get_edit/'); ?>${$form.tr_kode}`,
	    		dataType: "JSON",
	    	})
	    	.done((response, text, xhr) => {
	    		if(xhr.status !== 200) return;

	    		$modalEdit.modal('show');

	    		const { tr, tr_barang } = response;
	    		
	    		$('input[name="no_faktur"]', $modalEdit).val(tr.no_faktur);
					$('select[name="supplier_kode"]', $modalEdit).val(tr.supplier_kode).change();
					$('input[name="tanggal"]', $modalEdit).val(tr.tanggal);

					for(let tr_b of tr_barang) {
						addRowItem($(`.barang_list`, $form));

						const $lastChildren = $(`.barang_list`, $form).children().last();
						$('.slc_barang', $lastChildren).val(tr_b.barang_kode).change();
						$('.item_jumlah', $lastChildren).val(tr_b.jumlah).change();
					}
	    	})
	    	.fail(error => {
	    		errorHandler(error);
	    	});
			});

			$form.on('submit', function(event){
				event.preventDefault();
				$form.btnSubmitLadda.ladda('start');

				$.ajax({
	    		url: `<?= base_url('transaksi/update/'); ?>${$form.tr_kode}`,
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

		// Edit Status --------------------------------------------
		const DataEditStatus = () => {
			const $modalEditStatus = $('#modalEditStatus');
			const $form = $('#form', $modalEditStatus);
			$form.btnSubmitLadda = $('button[type="submit"]', $form).ladda();

			$mainTable.on('click', '.btnEditStatus', function(){
				$form.tr_kode = $(this).data('tr-kode');
				$('select[name="status"]', $modalEditStatus).val($(this).data('tr-status')).change();
				$modalEditStatus.modal('show');
			});

			$form.on('submit', function(event){
				event.preventDefault();
				$form.btnSubmitLadda.ladda('start');

				$.ajax({
	    		url: `<?= base_url('transaksi/update_status/'); ?>${$form.tr_kode}`,
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

		let index = 0;
		const addRowItem = ($parentElemet) => {
			let template_barang = $('#template_barang').text();
			template_barang = template_barang.replace(/{index}/g, index);
			const $template_barang = $(template_barang);

			if($parentElemet.children().length === 0) {
				$template_barang.find('.btnDeleteRow').remove();
			}

			$parentElemet.append($template_barang);
			index++;
		}

		const eventSlcBarang = () => {
			$(document).on('change', '.slc_barang', function(){
				const $rowIndex = $(`.${$(this).data('row')}`);

				$('.item_satuan', $rowIndex).html('-');
				$('.item_harga', $rowIndex).html('0');
				$('.item_total_harga', $rowIndex).html('0');

				if($(this).val() != "") {
					const $selected = $(this).find('option:selected');
					$('.item_satuan', $rowIndex).html($selected.data('satuan'));
					$('.item_harga', $rowIndex).html(formatNumber($selected.data('harga')));

					const itemTotalHarga = parseInt($selected.data('harga')) * parseInt($('.item_jumlah', $rowIndex).val());
					if(! isNaN(itemTotalHarga)) {
						$('.item_total_harga', $rowIndex).html(formatNumber(itemTotalHarga));
					}
				}

				countAllTotalHarga($($(this)[0].form));
			});
		}

		const eventJumlahBarang = () => {
			$(document).on('keyup change', '.item_jumlah', function(){
				const $rowIndex = $(`.${$(this).data('row')}`);

				const itemHarga = $('.slc_barang', $rowIndex).find('option:selected').data('harga');
				const itemTotalHarga = parseInt(itemHarga) * parseInt($(this).val());

				$('.item_total_harga', $rowIndex).html('0');

				if(! isNaN(itemTotalHarga)) {
					$('.item_total_harga', $rowIndex).html(formatNumber(itemTotalHarga));
				}

				countAllTotalHarga($($(this)[0].form));
			});
		}

		const countAllTotalHarga = ($parentElemet) => {
			let total = 0;
			$('.item_total_harga', $parentElemet).each((i, e) => {
				total += parseInt($(e).html().replace(/,/g, ''));
			});

			const result = isNaN(total) ? '' : formatNumber(total);
			$('.item_all_total_harga', $parentElemet).html(result);
		}

		// init
		DataAdd();
		DataDelete();
		DataDetail();
		DataEdit();
		DataEditStatus();
		eventSlcBarang();
		eventJumlahBarang();
  });
</script>
