<?php

class Model_inquiry extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}


	public function getInquiryData($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM inquiry where id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM inquiry";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getInquiryClient($id = null)
	{
		$sql = "SELECT * FROM inquiry WHERE client_id = ?";
		$query = $this->db->query($sql, array($id));
		return $query->result_array();
	}


	public function create($data)
	{
		if($data) {
			$insert = $this->db->insert('inquiry', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function update($data, $id)
	{
		if($data && $id) {
			$this->db->where('id', $id);
			$update = $this->db->update('inquiry', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($id)
	{
		if($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('inquiry');
			return ($delete == true) ? true : false;
		}
	}



}