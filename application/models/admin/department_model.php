<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Department_model extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "departments";
        $this->pk = "department_id";
        $this->status = "status";
        $this->order = "order";
    } 
	
 public function validate_form_data(){
	 $validation_config = array(
            
                        array(
                            "field"  =>  "department_name",
                            "label"  =>  "Department Name",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "address",
                            "label"  =>  "Address",
                            "rules"  =>  "required"
                        ),
                        
            );
	 //set and run the validation
        $this->form_validation->set_rules($validation_config);
	 return $this->form_validation->run();
	 
	 }	

public function save_data($image_field= NULL){
	$inputs = array();
            
                    $inputs["department_name"]  =  $this->input->post("department_name");
                    
                    $inputs["address"]  =  $this->input->post("address");
                    
	return $this->department_model->save($inputs);
	}	 	

public function update_data($department_id, $image_field= NULL){
	$inputs = array();
            
                    $inputs["department_name"]  =  $this->input->post("department_name");
                    
                    $inputs["address"]  =  $this->input->post("address");
                    
	return $this->department_model->save($inputs, $department_id);
	}	
	
    //----------------------------------------------------------------
 public function get_department_list($where_condition=NULL, $pagination=TRUE, $public = FALSE){
		$data = (object) array();
		$fields = array("departments.*");
		$join_table = array();
		if(!is_null($where_condition)){ $where = $where_condition; }else{ $where = ""; }
		
		if($pagination){
				//configure the pagination
	        $this->load->library("pagination");
			
			if($public){
					$config['per_page'] = 10;
					$config['uri_segment'] = 3;
					$this->department_model->uri_segment = $this->uri->segment(3);
					$config["base_url"]  = base_url($this->uri->segment(1)."/".$this->uri->segment(2));
				}else{
					$this->department_model->uri_segment = $this->uri->segment(4);
					$config["base_url"]  = base_url(ADMIN_DIR.$this->uri->segment(2)."/".$this->uri->segment(3));
					}
			$config["total_rows"] = $this->department_model->joinGet($fields, "departments", $join_table, $where, true);
	        $this->pagination->initialize($config);
	        $data->pagination = $this->pagination->create_links();
			$data->departments = $this->department_model->joinGet($fields, "departments", $join_table, $where);
			return $data;
		}else{
			return $this->department_model->joinGet($fields, "departments", $join_table, $where, FALSE, TRUE);
		}
		
	}

public function get_department($department_id){
	
		$fields = array("departments.*");
		$join_table = array();
		$where = "departments.department_id = $department_id";
		
		return $this->department_model->joinGet($fields, "departments", $join_table, $where, FALSE, TRUE);
		
	}
	
	


}


	

