<?php

class Model_pending_client extends CI_Model
{
	public function __construct()
	{
		parent::__construct();

    }
    //--> Get the pending client data
	public function getPendingClientData($id = null)
	{
        if($id) 
        {
			$sql = "SELECT * FROM `pending_clients` WHERE id = '$id'";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM `pending_clients`";
		$query = $this->db->query($sql);
		return $query->result_array();
    }

    public function update($data,$id)
	{
		if($id) 
		{	
            $this->db->where('id', $id);
			$update = $this->db->update('pending_clients', $data);
			return ($update == true) ? true : false;
		}
	}
    

    public function remove($id)
	{
		if($id) 
		{
			$this->db->where('id', $id);
			$delete = $this->db->delete('pending_clients');
			return ($delete == true) ? true : false;
		}
	}

}