<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MainModel extends CI_Model
{
	public function getWhere($tableName, $where = array())
	{
		return $this->db->get_where($tableName, $where);
	}

	public function getDataWhere($tableName, $where = array())
	{
		return $this->getWhere($tableName, $where)->result_array();
	}

	public function getDataWhereIn($tableName, $columnName, $ids)
	{
		$this->db->where_in($columnName, $ids);
		return $this->db->get($tableName)->result_array();
	}

	public function findDataWhere($tableName, $where)
	{
		return $this->getWhere($tableName, $where)->row_array();
	}

	public function find_or_invalid($tableName, $where)
	{
		$data = $this->findDataWhere($tableName, $where);
		if(empty($data)) {
			$this->output->set_status_header(404);
			echo json_encode(array('message' => 'Data tidak valid'));
			exit;
		}
		return $data;
	}

	public function joins($joins)
	{
		foreach ($joins as $keyJoin => $valJoin) {
			$condition = $valJoin[0];
			$type = empty($valJoin[1]) ? 'left' : $valJoin[0];
			$this->db->join($keyJoin, $condition, $type);
		}
		return $this;
	}

	public function store($tableName, $data)
	{
		$this->db->insert($tableName, $data);
		return $this;
	}

	public function update($tableName, $data, $where)
	{
		$this->db->update($tableName, $data, $where);
		return $this;
	}

	public function getInsertId()
	{
		return $this->db->insert_id();
	}

	public function select($columns)
	{
		$this->db->select($columns);
		return $this;
	}

	public function whereIn($columnName, $ids)
	{
		$this->db->where_in($columnName, $ids);
		return $this;
	}

	public function deletes($tableName, $columnName, $ids)
	{
		$this->whereIn($columnName, $ids);
		$this->db->delete($tableName);
		return $this;
	}

	public function delete_wheres($table_name, $wheres = array())
	{
		return $this->db->where($wheres)->delete($table_name);
	}

	public function getDataBarang()
	{
		return $this
			->select('m_barang.*')
			->select('(SELECT satuan_nama FROM m_satuan WHERE m_satuan.satuan_id = m_barang.satuan_id) AS satuan_nama')
			->getDataWhere('m_barang');
	}

	public function queryTransaksi()
	{
		return $this
			->select('transaksi.*')
			->select('(SELECT supplier_nama FROM m_supplier WHERE m_supplier.supplier_kode = transaksi.supplier_kode) AS supplier_nama');
	}

	public function queryTransaksiPrint()
	{
		return $this
			->select('transaksi.*, m_supplier.supplier_nama, m_supplier.supplier_alamat, m_supplier.supplier_up')
			->joins(array(
				'm_supplier' => array('m_supplier.supplier_kode = transaksi.supplier_kode'),
			));
	}

	public function getDataTransaksi()
	{
		return $this
			->queryTransaksi()
			->getDataWhere('transaksi');
	}

	public function getTransaksiBarangByKode($tr_kode)
	{
		return $this
			->select('transaksi_barang.*, m_barang.barang_nama, m_satuan.satuan_nama')
			->joins(array(
				'm_barang' => array('m_barang.barang_kode = transaksi_barang.barang_kode'),
				'm_satuan' => array('m_satuan.satuan_id = m_barang.satuan_id'),
			))
			->getDataWhere('transaksi_barang', array('tr_kode' => $tr_kode));
	}

	public function generateCodeItem($prefix = "PR")
	{
		$getCode = $this
			->select('MAX(barang_kode) as barang_kode')
			->getDataWhere('m_barang');

		$highestCode = $getCode[0]['barang_kode'];

		$number = (int) substr($highestCode, 2, 2);
		$number++;

		return $prefix . sprintf("%02s", $number);
	}

	public function generateSupplierCode($prefix = "SP")
	{
		$getCode = $this
			->select('MAX(supplier_kode) as supplier_kode')
			->getDataWhere('m_supplier');

		$highestCode = $getCode[0]['supplier_kode'];

		$number = (int) substr($highestCode, 2, 3);
		$number++;

		return $prefix . sprintf("%03s", $number);
	}

	public function generateTransactionCode($prefix = "TR")
	{
		$getCode = $this
			->select('MAX(tr_kode) as tr_kode')
			->getDataWhere('transaksi');

		$highestCode = $getCode[0]['tr_kode'];

		$number = (int) substr($highestCode, 2, 4);
		$number++;

		return $prefix . sprintf("%04s", $number);
	}

	public function query_satuan_delete()
	{
		$this->db
			->where("NOT EXISTS (SELECT NULL FROM m_barang WHERE m_barang.satuan_id = m_satuan.satuan_id)", NULL, false);
		return $this;
	}

	public function query_supplier_delete()
	{
		$this->db
			->where("NOT EXISTS (SELECT NULL FROM transaksi WHERE m_supplier.supplier_kode = transaksi.supplier_kode)", NULL, false);
		return $this;
	}

	public function query_barang_delete()
	{
		$this->db
			->where("NOT EXISTS (SELECT NULL FROM transaksi_barang WHERE m_barang.barang_kode = transaksi_barang.barang_kode)", NULL, false);
		return $this;
	}
}
