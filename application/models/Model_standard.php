<?php

class Model_standard extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}


	//--> Get active information
	public function getActiveStandard()
	{
		$sql = "SELECT * FROM standard WHERE active = ?";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();
	}

	//--> Get the standard data
	public function getStandardData($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM standard WHERE id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM standard";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	// get the clause for the standard

	public function getStandardClause($standard_id)
	{
		$sql = "SELECT *
				FROM clause 
				WHERE standard_id = ?
				ORDER BY name";
		$query = $this->db->query($sql, array($standard_id));
		return $query->result_array();
	}

	public function create($data)
	{
		if($data) {
			$insert = $this->db->insert('standard', $data);
			return ($insert == true) ? true : false;
		}
	}

	public function update($data, $id)
	{
		if($data && $id) {
			$this->db->where('id', $id);
			$update = $this->db->update('standard', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($id)
	{
		if($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('standard');
			return ($delete == true) ? true : false;
		}
	}

	//---> Validate if the mineral type is used in table Consultation
	public function checkIntegrity($id)
	{
		$num_rows = 0;
		
		$sql = "SELECT * FROM consultation WHERE standard_id = ?";
		$query = $this->db->query($sql, array($id));
		$num_rows = $num_rows + $query->num_rows();

		$sql = "SELECT * FROM clause WHERE standard_id = ?";
		$query = $this->db->query($sql, array($id));
		$num_rows = $num_rows + $query->num_rows();

		return $num_rows;

	}

}

