<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Candidate_model extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "candidates";
        $this->pk = "candidate_id";
        $this->status = "status";
        $this->order = "order";
    }
	
 public function validate_form_data(){
	 $validation_config = array(
            
                        array(
                            "field"  =>  "name",
                            "label"  =>  "Name",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "political_party",
                            "label"  =>  "Political Party",
                            "rules"  =>  "required"
                        ),
                        
            );
	 //set and run the validation
        $this->form_validation->set_rules($validation_config);
	 return $this->form_validation->run();
	 
	 }	

public function save_data($image_field= NULL){
	$inputs = array();
            
                    $inputs["name"]  =  $this->input->post("name");
                    
                    $inputs["political_party"]  =  $this->input->post("political_party");
                    
                    if($_FILES["symbol"]["size"] > 0){
                        $inputs["symbol"]  =  $this->router->fetch_class()."/".$this->input->post("symbol");
                    }
                    
                    if($_FILES["image"]["size"] > 0){
                        $inputs["image"]  =  $this->router->fetch_class()."/".$this->input->post("image");
                    }
                    
	return $this->candidate_model->save($inputs);
	}	 	

public function update_data($candidate_id, $image_field= NULL){
	$inputs = array();
            
                    $inputs["name"]  =  $this->input->post("name");
                    
                    $inputs["political_party"]  =  $this->input->post("political_party");
                    
                    if($_FILES["symbol"]["size"] > 0){
						//remove previous file....
						$candidates = $this->get_candidate($candidate_id);
						$file_path = $candidates[0]->symbol;
						$this->delete_file($file_path);
                        $inputs["symbol"]  =  $this->router->fetch_class()."/".$this->input->post("symbol");
                    }
                    
                    if($_FILES["image"]["size"] > 0){
						//remove previous file....
						$candidates = $this->get_candidate($candidate_id);
						$file_path = $candidates[0]->image;
						$this->delete_file($file_path);
                        $inputs["image"]  =  $this->router->fetch_class()."/".$this->input->post("image");
                    }
                    
	return $this->candidate_model->save($inputs, $candidate_id);
	}	
	
    //----------------------------------------------------------------
 public function get_candidate_list($where_condition=NULL, $pagination=TRUE, $public = FALSE){
		$data = (object) array();
		$fields = array("candidates.*");
		$join_table = array();
		if(!is_null($where_condition)){ $where = $where_condition; }else{ $where = ""; }
		
		if($pagination){
				//configure the pagination
	        $this->load->library("pagination");
			
			if($public){
					$config['per_page'] = 10;
					$config['uri_segment'] = 3;
					$this->candidate_model->uri_segment = $this->uri->segment(3);
					$config["base_url"]  = base_url($this->uri->segment(1)."/".$this->uri->segment(2));
				}else{
					$this->candidate_model->uri_segment = $this->uri->segment(4);
					$config["base_url"]  = base_url(ADMIN_DIR.$this->uri->segment(2)."/".$this->uri->segment(3));
					}
			$config["total_rows"] = $this->candidate_model->joinGet($fields, "candidates", $join_table, $where, true);
	        $this->pagination->initialize($config);
	        $data->pagination = $this->pagination->create_links();
			$data->candidates = $this->candidate_model->joinGet($fields, "candidates", $join_table, $where);
			return $data;
		}else{
			return $this->candidate_model->joinGet($fields, "candidates", $join_table, $where, FALSE, TRUE);
		}
		
	}

public function get_candidate($candidate_id){
	
		$fields = array("candidates.*");
		$join_table = array();
		$where = "candidates.candidate_id = $candidate_id";
		
		return $this->candidate_model->joinGet($fields, "candidates", $join_table, $where, FALSE, TRUE);
		
	}
	
	


}


	

