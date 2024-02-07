<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
        
class Candidates extends Admin_Controller{
    
    /**
     * constructor method
     */
    public function __construct(){
        
        parent::__construct();
        $this->load->model("admin/candidate_model");
		$this->lang->load("candidates", 'english');
		$this->lang->load("system", 'english');
        //$this->output->enable_profiler(TRUE);
    }
    //---------------------------------------------------------------
    
    
    /**
     * Default action to be called
     */ 
    public function index(){
        $main_page=base_url().ADMIN_DIR.$this->router->fetch_class()."/view";
  		redirect($main_page); 
    }
    //---------------------------------------------------------------


	
    /**
     * get a list of all items that are not trashed
     */
    public function view(){
		
        $where = "`candidates`.`status` IN (0, 1) ";
		$data = $this->candidate_model->get_candidate_list($where);
		 $this->data["candidates"] = $data->candidates;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Candidates');
		$this->data["view"] = ADMIN_DIR."candidates/candidates";
		$this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get single record by id
     */
    public function view_candidate($candidate_id){
        
        $candidate_id = (int) $candidate_id;
        
        $this->data["candidates"] = $this->candidate_model->get_candidate($candidate_id);
        $this->data["title"] = $this->lang->line('Candidate Details');
		$this->data["view"] = ADMIN_DIR."candidates/view_candidate";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * get a list of all trashed items
     */
    public function trashed(){
	
        $where = "`candidates`.`status` IN (2) ";
		$data = $this->candidate_model->get_candidate_list($where);
		 $this->data["candidates"] = $data->candidates;
		 $this->data["pagination"] = $data->pagination;
		 $this->data["title"] = $this->lang->line('Trashed Candidates');
		$this->data["view"] = ADMIN_DIR."candidates/trashed_candidates";
        $this->load->view(ADMIN_DIR."layout", $this->data);
    }
    //-----------------------------------------------------
    
    /**
     * function to send a user to trash
     */
    public function trash($candidate_id, $page_id = NULL){
        
        $candidate_id = (int) $candidate_id;
        
        
        $this->candidate_model->changeStatus($candidate_id, "2");
        $this->session->set_flashdata("msg_success", $this->lang->line("trash_msg_success"));
        redirect(ADMIN_DIR."candidates/view/".$page_id);
    }
    
    /**
      * function to restor candidate from trash
      * @param $candidate_id integer
      */
     public function restore($candidate_id, $page_id = NULL){
        
        $candidate_id = (int) $candidate_id;
        
        
        $this->candidate_model->changeStatus($candidate_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("restore_msg_success"));
        redirect(ADMIN_DIR."candidates/trashed/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to draft candidate from trash
      * @param $candidate_id integer
      */
     public function draft($candidate_id, $page_id = NULL){
        
        $candidate_id = (int) $candidate_id;
        
        
        $this->candidate_model->changeStatus($candidate_id, "0");
        $this->session->set_flashdata("msg_success", $this->lang->line("draft_msg_success"));
        redirect(ADMIN_DIR."candidates/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to publish candidate from trash
      * @param $candidate_id integer
      */
     public function publish($candidate_id, $page_id = NULL){
        
        $candidate_id = (int) $candidate_id;
        
        
        $this->candidate_model->changeStatus($candidate_id, "1");
        $this->session->set_flashdata("msg_success", $this->lang->line("publish_msg_success"));
        redirect(ADMIN_DIR."candidates/view/".$page_id);
     }
     //---------------------------------------------------------------------------
    
    /**
      * function to permanently delete a Candidate
      * @param $candidate_id integer
      */
     public function delete($candidate_id, $page_id = NULL){
        
        $candidate_id = (int) $candidate_id;
        //$this->candidate_model->changeStatus($candidate_id, "3");
        //Remove file....
						$candidates = $this->candidate_model->get_candidate($candidate_id);
						$file_path = $candidates[0]->image;
						$this->candidate_model->delete_file($file_path);
		$this->candidate_model->delete(array( 'candidate_id' => $candidate_id));
        $this->session->set_flashdata("msg_success", $this->lang->line("delete_msg_success"));
        redirect(ADMIN_DIR."candidates/trashed/".$page_id);
     }
     //----------------------------------------------------
    
	 
	 
     /**
      * function to add new Candidate
      */
     public function add(){
		
        $this->data["title"] = $this->lang->line('Add New Candidate');$this->data["view"] = ADMIN_DIR."candidates/add_candidate";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
     public function save_data(){
	  if($this->candidate_model->validate_form_data() === TRUE){
		  
                    if($this->upload_file("symbol")){
                       $_POST['symbol'] = $this->data["upload_data"]["file_name"];
                    }
                    
                    if($this->upload_file("image")){
                       $_POST['image'] = $this->data["upload_data"]["file_name"];
                    }
                    
		  $candidate_id = $this->candidate_model->save_data();
          if($candidate_id){
				$this->session->set_flashdata("msg_success", $this->lang->line("add_msg_success"));
                redirect(ADMIN_DIR."candidates/edit/$candidate_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."candidates/add");
            }
        }else{
			$this->add();
			}
	 }


     /**
      * function to edit a Candidate
      */
     public function edit($candidate_id){
		 $candidate_id = (int) $candidate_id;
        $this->data["candidate"] = $this->candidate_model->get($candidate_id);
		  
        $this->data["title"] = $this->lang->line('Edit Candidate');$this->data["view"] = ADMIN_DIR."candidates/edit_candidate";
        $this->load->view(ADMIN_DIR."layout", $this->data);
     }
     //--------------------------------------------------------------------
	 
	 public function update_data($candidate_id){
		 
		 $candidate_id = (int) $candidate_id;
       
	   if($this->candidate_model->validate_form_data() === TRUE){
		  
                    if($this->upload_file("symbol")){
                         $_POST["symbol"] = $this->data["upload_data"]["file_name"];
                    }
                    
                    if($this->upload_file("image")){
                         $_POST["image"] = $this->data["upload_data"]["file_name"];
                    }
                    
		  $candidate_id = $this->candidate_model->update_data($candidate_id);
          if($candidate_id){
                
                $this->session->set_flashdata("msg_success", $this->lang->line("update_msg_success"));
                redirect(ADMIN_DIR."candidates/edit/$candidate_id");
            }else{
                
                $this->session->set_flashdata("msg_error", $this->lang->line("msg_error"));
                redirect(ADMIN_DIR."candidates/edit/$candidate_id");
            }
        }else{
			$this->edit($candidate_id);
			}
		 
		 }
	 
     
    /**
     * get data as a json array 
     */
    public function get_json(){
				$where = array("status" =>1);
				$where[$this->uri->segment(3)]= $this->uri->segment(4);
				$data["candidates"] = $this->candidate_model->getBy($where, false, "candidate_id" );
				$j_array[]=array("id" => "", "value" => "candidate");
				foreach($data["candidates"] as $candidate ){
					$j_array[]=array("id" => $candidate->candidate_id, "value" => "");
					}
					echo json_encode($j_array);
			
       
    }
    //-----------------------------------------------------
    
}        
