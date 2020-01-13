<?php

class Model_client extends CI_Model
{
	public function __construct()
	{
		parent::__construct();

	}



	public function getClientDataById($id)
	{
		$sql = "SELECT client.*,(SELECT name FROM user WHERE client.updated_by = user.id) AS 'updated_by' 
		FROM client where client.id = ?";
		$query = $this->db->query($sql, array($id));
		return $query->row_array();

	}


	public function getActiveClientData()
	{
		$sql = "SELECT * FROM client WHERE active = ?
		 ORDER BY company_name ASC";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();

	}


	//--> Get the data for a specific consultant or for all

	public function getClientByConsultant($consultant)
	{

		if ($consultant == 'all') {
			$sql = "SELECT client.*,consultant_id,consultation_no
			FROM client
			     LEFT JOIN consultation ON consultation.client_id = client.id
			ORDER by company_name";
	    } else {

			$sql = "SELECT client.*,consultant_id,consultation_no
			FROM client
			        LEFT JOIN consultation ON consultation.client_id = client.id
		    WHERE consultation.consultant_id LIKE '%$consultant%'
			ORDER by company_name";
	    }

		$query = $this->db->query($sql);
		return $query->result_array();
	}


	//--> Get the data for a specific client

	public function getClientByClient($trn)
	{

		$sql = "SELECT client.*,consultant_id,consultation_no
		FROM client
		        LEFT JOIN consultation ON consultation.client_id = client.id
	    WHERE client.trn = $trn";

		$query = $this->db->query($sql);
		return $query->result_array();
	}



	public function getClientConsultationData()
	{
		$sql = "SELECT consultation.id as 'id',company_name,
		description AS 'consultation_description',consultation_no,
		sector.name AS 'sector_name'
		 FROM consultation 
		 JOIN client ON consultation.client_id = client.id
		 JOIN sector ON consultation.sector_id = sector.id
		 WHERE client.active = ?
		 ORDER BY company_name ASC";
		$query = $this->db->query($sql, array(1));
		return $query->result_array();

	}

	


	public function getClientDocument($id, $type)
	{
		If ($type == 'all') {
			$sql = "SELECT document.*,name,directory,consultation_no
			FROM document
			 	 LEFT JOIN document_type ON document.document_type_id = document_type.id
			 	 LEFT JOIN consultation ON document.consultation_id = consultation.id
			 	 JOIN client ON document.client_id = client.id
			WHERE document.client_id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->result_array();
		}
		else {  //for a specific type of document
			$sql = "SELECT document.*,name,directory,consultation_no
			FROM document
			     LEFT JOIN document_type ON document.document_type_id = document_type.id
			     LEFT JOIN consultation ON document.consultation_id = consultation.id
			     JOIN client ON document.client_id = client.id
			WHERE document.client_id = ? AND document.document_type_id = ?";
			$query = $this->db->query($sql, array($id, $type));
			return $query->result_array();
		}

	}


	public function create($data)
	{
		//---> The id is returned to the controller so that the update form
		//     of client can be opened to continue encoding the datas
		if($data) {
			$insert = $this->db->insert('client', $data);
			$insert_id = $this->db->insert_id();
			return ($insert == true) ? $insert_id : false;
		}
	}

	public function update($data, $id)
	{
		if($data && $id) {
			$this->db->where('id', $id);
			$update = $this->db->update('client', $data);
			return ($update == true) ? true : false;
		}
	}

	public function remove($id)
	{
		//--> All the information attached to the client must be deleted

		if($id) {
			// Get the directory of the documents from the client table
			$sql = "SELECT directory FROM client where id = ?";
			$query = $this->db->query($sql, array($id));
			$row = $query->row();

			if (isset($row)) {$directory = $row->directory;}
			$path = "./upload/documents/".$directory;

			// Delete all the documents inside the directory
			// We can delete a directory with rmdir only if it's empty
			$dir = opendir($path);
		    while(false !== ( $file = readdir($dir)) ) {
		        if (( $file != '.' ) && ( $file != '..' )) {
		            $full = $path . '/' . $file;
		            if ( is_dir($full) ) {rrmdir($full);}
		            else {unlink($full);}
		        }
		    }
		    closedir($dir);
		    rmdir($path);

			// Remove the tables attached to client
			// consultation - performance - document - inquiry

			$this->db->where('client_id', $id);
			$delete = $this->db->delete('consultation');
			$this->db->where('client_id', $id);
			$delete = $this->db->delete('document');
			$this->db->where('client_id', $id);
			$delete = $this->db->delete('inquiry');

			// delete the client
			$this->db->where('id', $id);
			$delete = $this->db->delete('client');
		    return ($delete == true) ? true : false;

		}
	}


	public function countTotalClient()
	{
		$sql = "SELECT * FROM client WHERE active = ?";
		$query = $this->db->query($sql, array(1));
		return $query->num_rows();
	}
	

	public function createDocument($data)
	{
		if($data) {
			$insert = $this->db->insert('document', $data);
			return ($insert == true) ? true : false;
		}
	}


	public function removeDocument($id)
	{
		if($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('document');
			return ($delete == true) ? true : false;
		}
	}


	public function getDocument($id = null)
	{
		$sql = "SELECT document.*,directory
		FROM document
		     JOIN client ON document.client_id = client.id
		WHERE document.id = ?";
		$query = $this->db->query($sql, array($id));
		return $query->row_array();

	}


}