<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/admin
	 *	- or -
	 * 		http://example.com/index.php/admin/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/admin/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Main_data_model'); //load database model.
        $this->load->model('Form_data_model'); //load database model.
        
    }

	public function check_sess($user_logged)
	{
		if ($user_logged != "in") {
			$this->logout();
		}//Redirect to login page if session not initiated.
	}

    public $response = array("result"=>"none", "data"=>"none");

    //work_places
	public function Places($place)
	{
		$this->check_sess($this->session->user_logged);
        if($this->session->user_level != '0') {$this->logout();}
        
        
		$this->load->view('head');
		$this->load->view('admin_sidebar');
        
        $this->response['workPlaces'] = $this->Form_data_model->select('workplace');
        
		$this->load->view('master/' . $place, $this->response);
        
		$this->load->view('footer');
	}
    
    public function updateWorkplace()
    {
		$this->check_sess($this->session->user_logged);
        if($this->session->user_level != '0') {$this->logout();}
        
        
        header('Content-Type: application/x-json; charset=utf-8');
        $workplace_id = $this->input->post('workplace_id');
        $workplace_name = $this->input->post('workplace_name');
        
        $user_array = array('ID' => $workplace_id, 'work_place' => $workplace_name);
        $res = $this->Main_data_model->update('Work_Place', 'ID', $workplace_id, $user_array);
        
        if(res == '1'){
            echo "Success";
        }
        
    }
    
    public function addWorkplace()
    {
		$this->check_sess($this->session->user_logged);
        if($this->session->user_level != '0') {$this->logout();}
        
        
        header('Content-Type: application/x-json; charset=utf-8');
        
        $workplace_id_array = $this->Main_data_model->get_recent_id('Work_Place');
        $workplace_id = $workplace_id_array['0']['ID'] + 1;
        
        $workplace_name = $this->input->post('workplace_name');
        $workplace_code = $this->input->post('workplace_code');
        
        $user_array = array('ID' => $workplace_id, 'work_place' => $workplace_name, 'work_place_code' => $workplace_code);
        $res = $this->Main_data_model->insert('Work_Place', $user_array);
        
        if(res == '1'){
            //echo strval($workplace_id);
            echo "success";
        }else {
            echo strval($workplace_id);
        }
    }
    
    public function deleteWorkplace()
    {
		$this->check_sess($this->session->user_logged);
        if($this->session->user_level != '0') {$this->logout();}
        
        header('Content-Type: application/x-json; charset=utf-8');
        $workplace_id = $this->input->post('workplace_id');
        
        $res = $this->Main_data_model->delete('Work_Place', 'ID', $workplace_id);
        
        if(res == '1'){
            echo "Success";
        }
        
    }
    
    public function addBranch()
    {
        $this->check_sess($this->session->user_logged);
        if($this->session->user_level != '0') {$this->logout();}
        
        header('Content-Type: application/x-json; charset=utf-8');
        
        $branch_id_array = $this->Main_data_model->get_recent_id('Main_Office_Branches');
        $branch_id = $branch_id_array['0']['ID'] + 1;
        
        $branch_name = $this->input->post('branch_name');
        $work_place_id = $this->input->post('work_place_id');
        
        $user_array = array('ID' => $branch_id, 'work_place_id' => $work_place_id, 'office_branch' => $branch_name);
        $res = $this->Main_data_model->insert('Main_Office_Branches', $user_array);
        
        if(res == '1'){
            //echo strval($workplace_id);
            echo "success";
        }else {
            echo strval($branch_id);
        }
    }
    
    public function updateBranch()
    {
		$this->check_sess($this->session->user_logged);
        if($this->session->user_level != '0') {$this->logout();}
        
        
        header('Content-Type: application/x-json; charset=utf-8');
        $branch_id = $this->input->post('branch_id');
        $branch_name = $this->input->post('branch_name');
        
        $user_array = array('office_branch' => $branch_name);
        $res = $this->Main_data_model->update('Main_Office_Branches', 'ID', $branch_id, $user_array);
        
        if(res == '1'){
            echo "Success";
        }
        
    }
    
    public function deleteBranch()
    {
		$this->check_sess($this->session->user_logged);
        if($this->session->user_level != '0') {$this->logout();}
        
        header('Content-Type: application/x-json; charset=utf-8');
        $branch_id = $this->input->post('branch_id');
        
        $res = $this->Main_data_model->delete('Main_Office_Branches', 'ID', $branch_id);
        
        if(res == '1'){
            echo "Success";
        }
        
    }
    
    
}
?>