<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class City extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'City';
	}


	public function index()
	{
		if(!in_array('viewCity', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$this->render_template('city/index', $this->data);
	}


	//--> It retrieve the specific city information via a city id
	//    and returns the data in json format

	public function fetchCityDataById($id)
	{
		if($id) {
			$data = $this->model_city->getCityData($id);
			echo json_encode($data);
		}
	}


	//--> It retrieves all the city data from the database
	//    This function is called from the datatable ajax function
	//    The data is return based on the json format.

	public function fetchCityData()
	{
		$result = array('data' => array());

		$data = $this->model_city->getCityData();

		foreach ($data as $key => $value) {

			$buttons = '';

			if(in_array('updateCity', $this->permission)) {
				$buttons = '<button type="button" class="btn btn-default" onclick="editFunc('.$value['id'].')" data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil"></i></button>';
			}

			if(in_array('deleteCity', $this->permission)) {
				$buttons .= ' <button type="button" class="btn btn-default" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
			}

			$active = ($value['active'] == 1) ? '<span class="label label-success">Active</span>' : '<span class="label label-warning">Inactive</span>';

			$result['data'][$key] = array(
				$value['name'],
				$value['code'],
				$active,
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}


	//--> If the validation is not true (not valid), then it provides the validation error on the json format
    //    If the validation for each input is valid then it creates the data into the database and
    //    returns an appropriate message in the json format.

	public function create()
	{
		if(!in_array('createCity', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = array();

		$this->form_validation->set_rules('city_name', 'Name', 'trim|required');
		$this->form_validation->set_rules('city_code', 'Code', 'trim|required');
		$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

        if ($this->form_validation->run() == TRUE) {
        	$data = array(
        		'code' => $this->input->post('city_code'),
        		'name' => $this->input->post('city_name'),
        		'active' => $this->input->post('active'),
        	);

        	$create = $this->model_city->create($data);
        	if($create == true) {
        		$response['success'] = true;
        		$response['messages'] = 'Successfully created';
        	}
        	else {
        		$response['success'] = false;
        		$response['messages'] = 'Error in the database while creating the information';
        	}
        }
        else {
        	$response['success'] = false;
        	foreach ($_POST as $key => $value) {
        		$response['messages'][$key] = form_error($key);
        	}
        }

        echo json_encode($response);
	}


	//--> If the validation is not true (not valid), then it provides the validation error on the json format
    //    If the validation for each input is valid then it updates the data into the database and
    //    returns an appropriate message in the json format.

	public function update($id)
	{
		if(!in_array('updateCity', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$response = array();

		if($id) {
			$this->form_validation->set_rules('edit_city_name', 'Name', 'trim|required');
			$this->form_validation->set_rules('edit_city_code', 'Code', 'trim|required');
			$this->form_validation->set_error_delimiters('<p class="text-danger">','</p>');

	        if ($this->form_validation->run() == TRUE) {
	        	$data = array(
	        		'code' => $this->input->post('edit_city_code'),
	        		'name' => $this->input->post('edit_city_name'),
	        		'active' => $this->input->post('edit_active'),
	        	);

	        	$update = $this->model_city->update($data, $id);
	        	if($update == true) {
	        		$response['success'] = true;
	        		$response['messages'] = 'Successfully updated';
	        	}
	        	else {
	        		$response['success'] = false;
	        		$response['messages'] = 'Error in the database while updating the information';
	        	}
	        }
	        else {
	        	$response['success'] = false;
	        	foreach ($_POST as $key => $value) {
	        		$response['messages'][$key] = form_error($key);
	        	}
	        }
		}
		else {
			$response['success'] = false;
    		$response['messages'] = 'Error please refresh the page again';
		}

		echo json_encode($response);
	}


	//--> If checks if the city id is provided on the function, if not then an appropriate message
	//    is return on the json format
    //    If the validation is true (valid) then it removes the data into the database and returns an appropriate
    //    message in the json format.

	public function remove()
	{
		if(!in_array('deleteCity', $this->permission)) {
			redirect('dashboard', 'refresh');
		}

		$city_id = $this->input->post('city_id');

		$response = '';
		$response = array();

		if($city_id) {
			//---> Validate if the information is used in client table
			$total_client = $this->model_city->checkIntegrity($city_id);
			//---> If no client have this information, we can delete
            if ($total_client == 0) {
				$delete = $this->model_city->remove($city_id);
				if($delete == true) {
					$response['success'] = true;
					$response['messages'] = 'Successfully deleted';}
				else {
					$response['success'] = false;
					$response['messages'] = 'Error in the database while deleting the information';}
				}

			else {
				//---> There is at least one client having this information
				$response['success'] = false;
				$response['messages'] = 'At least one client uses this information.  You cannot delete.';}

		}
		else {
			$response['success'] = false;
			$response['messages'] = 'Refresh the page again';}

		echo json_encode($response);
	}

}