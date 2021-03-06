<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Requirement extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Requirement';   
	}


	public function index()
	{
        if(!in_array('viewRequirement', $this->permission)) {redirect('dashboard', 'refresh');}

		$this->render_template('requirement/index', $this->data);	
	}


	public function fetchRequirementData()
	{
		$result = array('data' => array());

		$data = $this->model_requirement->getRequirementData();

		foreach ($data as $key => $value) {

			$buttons = '';

			if(in_array('updateRequirement', $this->permission)) {
                $buttons .= '<a href="'.base_url('requirement/update/'.$value['id']).'" class="btn btn-default"><i class="fa fa-pencil"></i></a>';
            }

            if(in_array('deleteRequirement', $this->permission)) { 
                $buttons .= '<button type="button" class="btn btn-default" onclick="removeFunc('.$value['id'].')" data-toggle="modal" data-target="#removeModal"><i class="fa fa-trash"></i></button>';
            }

			$result['data'][$key] = array(			
				$value['question'],
				$value['remark'],
				$value['question_type_name'],
				$buttons
			);
		} // /foreach

		echo json_encode($result);
	}


	public function create()
	{
		if(!in_array('createRequirement', $this->permission)) {redirect('dashboard', 'refresh');}
        $this->form_validation->set_rules('question', 'Question', 'trim|required');//question is required
        $this->form_validation->set_rules('question_type', 'Question Type', 'trim|required');//question type is required
        $this->form_validation->set_error_delimiters('<p class="alert alert-warning">','</p>');


        if ($this->form_validation->run() == TRUE) 
        { 
            if (!empty($this->input->post('option'))) 
            {
                $count_option = count($this->input->post('option'));
                $option = array();
                for($x = 0; $x < $count_option; $x++) 
                {
                    array_push($option,$this->input->post('option')[$x]);
                }  
            }
            else
            {
                $option=null; 
            }
            $data = array(
                'question' => $this->input->post('question'),
                'question_type_id' => $this->input->post('question_type'),
                'remark' => $this->input->post('remark'),
                'question_option' => json_encode($option));  
            $success = $this->model_requirement->create($data);
            if($success)
            {
                $this->session->set_flashdata('success', 'Successfully created');
                redirect('requirement/', 'refresh');
            }
            else
            {
                $this->session->set_flashdata('errors', 'Error occurred!!');
                redirect('requirement/', 'refresh');
            }
        }
        else 
        {
            // false casee  	
			$this->data['question_type'] = $this->model_question->getActiveQuestionType();  
            $this->render_template('requirement/create', $this->data);
        }	
    }

    public function update($requirement_id)
	{      
        if(!in_array('updateRequirement', $this->permission)) {redirect('dashboard', 'refresh');}

        if(!$requirement_id) {redirect('dashboard', 'refresh');}

        $this->form_validation->set_rules('question', 'Question', 'trim|required'); 
        $this->form_validation->set_rules('question_type', 'Question', 'trim|required');
        $this->form_validation->set_error_delimiters('<p class="alert alert-warning">','</p>');

        if ($this->form_validation->run() == TRUE) 
        {
            if (!empty($this->input->post('option'))) 
            {
                $count_option = count($this->input->post('option'));
                $option = array();
                for($x = 0; $x < $count_option; $x++) 
                {
                    array_push($option,$this->input->post('option')[$x]);
                }
            }
            else
            {
                $option=null; 
            }
            $data = array(
                'question' => $this->input->post('question'),
                'question_type_id' => $this->input->post('question_type'),
                'remark' => $this->input->post('remark'),
                'question_option' => json_encode($option)
            );
            $update = $this->model_requirement->update($data,$requirement_id);
            if($update == true)
            {
                $this->session->set_flashdata('success', 'Successfully Updated!');
                redirect('requirement/', 'refresh');
            }
            else
            {
                $this->session->set_flashdata('errors', 'Error occurred!!');
                redirect('requirement/', 'refresh');
            }
        }
        else 
        {       
            $this->data['question_type'] = $this->model_question->getActiveQuestionType();  
            $result = array();
            $data_requirement = $this->model_requirement->getRequirementData($requirement_id);
            $result['requirement'] = $data_requirement;
            $question_option=json_decode($data_requirement['question_option'],true);
            if($question_option!=null){
                foreach($question_option as $k => $v) 
                {
                    $result['question_option'][] = $v;
                }
            }
            $this->data['data_requirement'] = $result;
            $this->render_template('requirement/edit', $this->data); 

            }   
	}


    
    public function remove()
	{
        if(!in_array('deleteRequirement', $this->permission)) {redirect('dashboard', 'refresh');}
        
        $requirement_id = $this->input->post('requirement_id');

        $response = array();

        if($requirement_id) {
            $delete = $this->model_requirement->remove($requirement_id);
            if($delete == true) {
                $response['success'] = true;
                $response['messages'] = "Successfully removed"; 
            }
            else {
                $response['success'] = false;
                $response['messages'] = "Error in the database while removing the requirement information";
            }
        }
        else {
            $response['success'] = false;
            $response['messages'] = "Refresh the page again!!";
        }

        echo json_encode($response);
	}

}