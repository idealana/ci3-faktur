<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi extends CI_Controller {

	/**
	 * @var string
	 */
	private $_base_route;

	public function __construct()
	{
		parent::__construct();

		// Login Check
		Auth::authorization_check();

		$this->_base_route = $this->router->directory . $this->router->class;
	}

	public function index()
	{
		$title = 'Transaksi';
		$data_transaksi = $this->MainModel->getDataTransaksi();
		$data_supplier = $this->MainModel->getDataWhere('m_supplier');
		$data_barang = $this->MainModel->getDataBarang();

		return $this->load->view('templates/backend', array(
			'title'   => $title,
			'content' => 'backend/transaksi',
			'data' => array(
				'transaksi' => $data_transaksi,
				'supplier' => $data_supplier,
				'barang' => $data_barang,
			),
			'breadcrumbs' => array(
  			array('title' => 'Dashboard', 'link' => site_url('dashboard')),
  			array('title' => $title, 'link' => '#'),
  		),
  		'assets' => array(
  			'css' => array(
	  			'plugins/datatables-bs4/css/dataTables.bootstrap4.min.css',
  			),
  			'js' => array(
	  			'plugins/datatables/jquery.dataTables.min.js',
	  			'plugins/datatables-bs4/js/dataTables.bootstrap4.min.js',
  			),
  		),
		));
	}

	public function store()
	{
		$this->db->trans_begin();

		try {
			$now = date('Y-m-d H:i:s');

			$tr_kode = $this->MainModel->generateTransactionCode();
			$this->MainModel->store('transaksi', array(
				'tr_kode' => $tr_kode,
				'tr_no_faktur' => $this->input->post('no_faktur', true),
				'supplier_kode' => $this->input->post('supplier_kode', true),
				'tr_tanggal' => date('Y-m-d', strtotime($this->input->post('tanggal', true))),
				'created_at' => $now,
				'updated_at' => $now,
			));

			$items = $this->input->post('items', true);
			foreach($items as $item) {
				$find_item = $this->MainModel
					->select('barang_harga')
					->findDataWhere('m_barang', array('barang_kode' => $item['barang_kode']));
				
				if(empty($find_item)) continue;

				$total_harga = $item['jumlah'] * $find_item['barang_harga'];

				$where_tr_b = array('tr_kode' => $tr_kode, 'barang_kode' => $item['barang_kode']);
				$cek_barang = $this->MainModel->findDataWhere('transaksi_barang', $where_tr_b);

				if(empty($cek_barang)) {
					$this->MainModel->store('transaksi_barang', array(
						'tr_kode' => $tr_kode,
						'barang_kode' => $item['barang_kode'],
						'jumlah' => $item['jumlah'],
						'harga' => $find_item['barang_harga'],
						'total_harga' => $total_harga,
						'created_at' => $now,
						'updated_at' => $now,
					));

					continue;
				}

				$jumlah_barang = $item['jumlah'] + $cek_barang['jumlah'];
				$this->MainModel->update('transaksi_barang', array(
					'jumlah' => $jumlah_barang,
					'total_harga' => $find_item['barang_harga'] * $jumlah_barang,
					'updated_at' => $now,
				), $where_tr_b);				
			}

			if($this->db->trans_status() === FALSE) {
				throw new \Exception("Gagal ketika menyimpan data. Transaction Rollback", 500);
			}

			$this->db->trans_commit();

			echo json_encode(array(
				'message' => 'Data berhasil disimpan',
				'title' => 'Sukses',
			));

		} catch(\Exception $error) {
			$this->db->trans_rollback();
			Helper::error_handler($error);
		}
	}

	public function delete($kode = null)
	{
		$this->db->trans_begin();

		try {
			$where = array('tr_kode' => $kode);

			$this->MainModel->delete_wheres('transaksi', $where);
			$this->MainModel->delete_wheres('transaksi_barang', $where);

			if($this->db->trans_status() === FALSE) {
				throw new \Exception("Gagal ketika menghapus data. Transaction Rollback", 500);
			}

			$this->db->trans_commit();

			echo json_encode(array(
				'message' => 'Data berhasil dihapus',
				'title' => 'Sukses',
			));

		} catch(\Exception $error) {
			$this->db->trans_rollback();
			Helper::error_handler($error);
		}
	}

	public function get_detail($kode = null)
	{
		try {
			$where = array('tr_kode' => $kode);

			$transaksi = $this->MainModel
				->queryTransaksi()
				->find_or_invalid('transaksi', $where);

			$transaksi_barang = $this->MainModel->getTransaksiBarangByKode($kode);

			ob_start();
			
			$this->detail_transaksi(array(
				'transaksi' => $transaksi,
				'transaksi_barang' => $transaksi_barang,
			));

			$html = ob_get_clean();

			echo json_encode(array(
				'html' => $html,
			));

		} catch(\Exception $error) {
			Helper::error_handler($error);
		}
		exit;
	}

	public function get_edit($kode = null)
	{
		try {
			$where = array('tr_kode' => $kode);
			$transaksi = $this->MainModel->find_or_invalid('transaksi', $where);
			$transaksi_barang = $this->MainModel->getTransaksiBarangByKode($kode);

			echo json_encode(array(
				'tr' => array(
					'no_faktur' => $transaksi['tr_no_faktur'],
					'supplier_kode' => $transaksi['supplier_kode'],
					'tanggal' => $transaksi['tr_tanggal'],
				),
				'tr_barang' => $transaksi_barang,
			));

		} catch(\Exception $error) {
			Helper::error_handler($error);
		}
	}

	public function update($tr_kode = null)
	{
		$this->db->trans_begin();

		try {
			$now = date('Y-m-d H:i:s');
			$where = array('tr_kode' => $tr_kode);
			
			// Update Transaksi
			$this->MainModel->update('transaksi', array(
				'tr_no_faktur' => $this->input->post('no_faktur', true),
				'supplier_kode' => $this->input->post('supplier_kode', true),
				'tr_tanggal' => date('Y-m-d', strtotime($this->input->post('tanggal', true))),
				'updated_at' => $now,
			), $where);

			// Delete Transaksi Barang
			$this->MainModel->delete_wheres('transaksi_barang', $where);

			// Insert Transaksi Barang
			$items = $this->input->post('items', true);
			foreach($items as $item) {
				$find_item = $this->MainModel
					->select('barang_harga')
					->findDataWhere('m_barang', array('barang_kode' => $item['barang_kode']));
				
				if(empty($find_item)) continue;

				$total_harga = $item['jumlah'] * $find_item['barang_harga'];

				$this->MainModel->store('transaksi_barang', array(
					'tr_kode' => $tr_kode,
					'barang_kode' => $item['barang_kode'],
					'jumlah' => $item['jumlah'],
					'harga' => $find_item['barang_harga'],
					'total_harga' => $total_harga,
					'created_at' => $now,
					'updated_at' => $now,
				));
			}

			if($this->db->trans_status() === FALSE) {
				throw new \Exception("Gagal ketika menyimpan data. Transaction Rollback", 500);
			}

			$this->db->trans_commit();

			echo json_encode(array(
				'message' => 'Data berhasil disimpan',
				'title' => 'Sukses',
			));

		} catch(\Exception $error) {
			$this->db->trans_rollback();
			Helper::error_handler($error);
		}
	}

	public function update_status($tr_kode = null)
	{
		$this->db->trans_begin();

		try {
			$now = date('Y-m-d H:i:s');
			$where = array('tr_kode' => $tr_kode);
			$status = $this->input->post('status', true);
			
			// Update Transaksi
			$this->MainModel->update('transaksi', array(
				'tr_status' => $status,
				'updated_at' => $now,
			), $where);

			// Update Stok Barang
			if($status === "Approve") {
				$tr_barang = $this->MainModel
					->select('barang_kode, jumlah')
					->getDataWhere('transaksi_barang', $where);

				foreach($tr_barang as $tr_b) {
					$barang_kode = $tr_b['barang_kode'];
					$jumlah = $tr_b['jumlah'];
					$this->db->query("UPDATE m_barang SET barang_stok = barang_stok + '$jumlah' WHERE barang_kode = '$barang_kode'");
				}
			}

			if($this->db->trans_status() === FALSE) {
				throw new \Exception("Gagal ketika menyimpan data. Transaction Rollback", 500);
			}

			$this->db->trans_commit();

			echo json_encode(array(
				'message' => 'Data berhasil disimpan',
				'title' => 'Sukses',
			));

		} catch(\Exception $error) {
			$this->db->trans_rollback();
			Helper::error_handler($error);
		}
	}

	private function detail_transaksi($data)
	{
		$tr = $data['transaksi'];

		?>
		<div class="text-xs">
			<div class="row">
				<label class="col-sm-3 mb-0">Kode Transaksi</label>
				<div class="col-sm-9"><?= $tr['tr_kode']; ?></div>
			</div>
			<div class="row">
				<label class="col-sm-3 mb-0">No. Faktur</label>
				<div class="col-sm-9"><?= $tr['tr_no_faktur']; ?></div>
			</div>
			<div class="row">
				<label class="col-sm-3 mb-0">Supplier</label>
				<div class="col-sm-9"><?= $tr['supplier_nama']; ?></div>
			</div>
			<div class="row">
				<label class="col-sm-3 mb-0">Tanggal</label>
				<div class="col-sm-9"><?= $tr['tr_tanggal']; ?></div>
			</div>
			<div class="row">
				<label class="col-sm-3 mb-0">Status</label>
				<div class="col-sm-9"><?= $tr['tr_status']; ?></div>
			</div>
			<table class="table table-bordered mt-2">
				<thead>
					<tr class="text-center">
						<th>Kode</th>
						<th>Nama</th>
						<th>Satuan</th>
						<th>Jumlah</th>
						<th>Harga</th>
						<th>Total Harga</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$count_jumlah = 0;
						$count_harga = 0;
						$count_total_harga = 0;
					?>
					<?php foreach($data['transaksi_barang'] as $tr_barang) : ?>
						<?php
							$count_jumlah += $tr_barang['jumlah'];
							$count_harga += $tr_barang['harga'];
							$count_total_harga += $tr_barang['total_harga'];
						?>
						<tr>
							<td class="text-center"><?= $tr_barang['barang_kode']; ?></td>
							<td><?= $tr_barang['barang_nama']; ?></td>
							<td><?= $tr_barang['satuan_nama']; ?></td>
							<td class="text-right"><?= $tr_barang['jumlah']; ?></td>
							<td class="text-right"><?= number_format((float) $tr_barang['harga'], 0, '.', ','); ?></td>
							<td class="text-right"><?= number_format((float) $tr_barang['total_harga'], 0, '.', ','); ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
				<tfoot>
					<tr>
						<th colspan="3" class="text-center">Total</th>
						<th class="text-right"><?= $count_jumlah; ?></th>
						<th class="text-right"><?= number_format((float) $count_harga, 0, '.', ','); ?></th>
						<th class="text-right"><?= number_format((float) $count_total_harga, 0, '.', ','); ?></th>
					</tr>
				</tfoot>
			</table>
		</div>
		<div class="text-center">
			<a href="<?= base_url('transaksi/print/'.$tr['tr_kode']); ?>" target="_blank" rel="noopener" class="btn btn-primary btn-sm show-tooltip" title="Cetak"><i class="fa fa-print"></i> Cetak</a>
		</div>
		<?php
	}

	public function print($tr_kode = null)
	{
		ini_set('display_errors', 0);
		require_once APPPATH."/third_party/html2pdf/html2pdf.class.php";

		$where = array('tr_kode' => $tr_kode);

		$transaksi = $this->MainModel
			->queryTransaksiPrint()
			->find_or_invalid('transaksi', $where);

		$transaksi_barang = $this->MainModel->getTransaksiBarangByKode($tr_kode);

		ob_start();
    ?>
    <style>
    	h4, p {
    		margin: 0;
    	}

    	.table-item {
    		width: 100%;
    		border-collapse: collapse;
    	}

    	.table-item th, .table-item td {
    		padding: 3px;
    	}
    </style>
    <table>
    	<tr>
    		<td width="500">
    			<h4>PT. Bhinneka Sangkuriang Transport</h4>
    			<p>Jl. Gedebage Selatan No.121A,</p>
    			<p>Cisaranten Kidul, Kec. Gedebage,</p>
    			<p>Kota Bandung, Jawa Barat 40552</p>
    		</td>
    		<td>
    			<p>Kepada Yth :</p>
    			<h4><?= $transaksi['supplier_nama']; ?></h4>
    			<p><?= $transaksi['supplier_alamat']; ?></p>
    			<p>Up : <?= $transaksi['supplier_up']; ?></p>
    		</td>
    	</tr>
    </table>

    <div style="margin-bottom: 30px;"></div>
    <p style="margin-bottom: 3px;">No. Faktur : 034/TD/XII/2023</p>
    <table class="table-item" border="1">
			<tr align="center" bgcolor="#b9d2f7">
				<th width="80">Kode</th>
				<th width="130">Nama</th>
				<th width="100">Satuan</th>
				<th width="100">Jumlah</th>
				<th width="120">Harga</th>
				<th width="120">Total Harga</th>
			</tr>

			<?php
				$count_jumlah = 0;
				$count_harga = 0;
				$count_total_harga = 0;

				foreach($transaksi_barang as $tr_b) :
					$count_jumlah += $tr_b['jumlah'];
					$count_harga += $tr_b['harga'];
					$count_total_harga += $tr_b['total_harga'];
			?>
			<tr>
				<td align="center"><?= $tr_b['barang_kode']; ?></td>
				<td><?= $tr_b['barang_nama']; ?></td>
				<td><?= $tr_b['satuan_nama']; ?></td>
				<td align="right"><?= $tr_b['jumlah']; ?></td>
				<td align="right"><?= number_format((float) $tr_b['harga'], 0, '.', ','); ?></td>
				<td align="right"><?= number_format((float) $tr_b['total_harga'], 0, '.', ','); ?></td>
			</tr>
			<?php
				endforeach;
			?>

			<tr align="right">
				<th colspan="3" align="center">Total</th>
				<th><?= $count_jumlah; ?></th>
				<th><?= number_format((float) $count_harga, 0, '.', ','); ?></th>
				<th><?= number_format((float) $count_total_harga, 0, '.', ','); ?></th>
			</tr>
		</table>
		<table style="margin-top: 1em;">
    	<tr>
    		<td width="200" align="center">
    			<p style="margin-bottom: 50px;">Purchasing</p>
    			<p style="font-weight: bold;">Ilham</p>
    		</td>
    		<td width="300"></td>
    		<td width="200" align="center">
    			<p style="margin-bottom: 50px;">Cirebon, <?= date('d F Y', strtotime($transaksi['tr_tanggal'])); ?></p>
    			<p style="font-weight: bold;"><?= $transaksi['supplier_up']; ?></p>
    		</td>
    	</tr>
    </table>
    <?php
    $content = ob_get_clean();

    try {
      $html2pdf = new HTML2PDF('P', 'A4', 'fr');
      $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
      $html2pdf->Output("transaksi_{$tr_kode}.pdf");
    }
    catch(HTML2PDF_exception $e) {
      echo $e;
      exit;
    }
	}
}
