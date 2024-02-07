<?php if(!defined('BASEPATH')) exit('Direct access not allowed!');

class Training_batche_model extends MY_Model{
    
    public function __construct(){
        
        parent::__construct();
        $this->table = "training_batches";
        $this->pk = "batch_id";
        $this->status = "status";
        $this->order = "order";
    }
	
 public function validate_form_data(){
	 $validation_config = array(
            
                        array(
                            "field"  =>  "training_id",
                            "label"  =>  "Training Id",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "batch_title",
                            "label"  =>  "Batch Title",
                            "rules"  =>  "required"
                        ),
                        
                        array(
                            "field"  =>  "batch_detail",
                            "label"  =>  "Batch Detail",
                            "rules"  =>  "required"
                        ),
                        
            );
	 //set and run the validation
        $this->form_validation->set_rules($validation_config);
	 return $this->form_validation->run();
	 
	 }	

public function save_data($image_field= NULL){
	$inputs = array();
            
                    $inputs["training_id"]  =  $this->input->post("training_id");
                    
                    $inputs["batch_title"]  =  $this->input->post("batch_title");
                    
                    $inputs["batch_detail"]  =  $this->input->post("batch_detail");
                    
	return $this->training_batche_model->save($inputs);
	}	 	

public function update_data($batch_id, $image_field= NULL){
	$inputs = array();
            
                    $inputs["training_id"]  =  $this->input->post("training_id");
                    
                    $inputs["batch_title"]  =  $this->input->post("batch_title");
                    
                    $inputs["batch_detail"]  =  $this->input->post("batch_detail");
                    
	return $this->training_batche_model->save($inputs, $batch_id);
	}	
	
    //----------------------------------------------------------------
 public function get_training_batche_list($where_condition=NULL, $pagination=TRUE, $public = FALSE){
		$data = (object) array();
		$fields = array("training_batches.*"
                , "trainings.title"
            );
		$join_table = array(
            "trainings" => "trainings.training_id = training_batches.training_id",
        );
		if(!is_null($where_condition)){ $where = $where_condition; }else{ $where = ""; }
		
		if($pagination){
				//configure the pagination
	        $this->load->library("pagination");
			
			if($public){
					$config['per_page'] = 10;
					$config['uri_segment'] = 3;
					$this->training_batche_model->uri_segment = $this->uri->segment(3);
					$config["base_url"]  = base_url($this->uri->segment(1)."/".$this->uri->segment(2));
				}else{
					$this->training_batche_model->uri_segment = $this->uri->segment(4);
					$config["base_url"]  = base_url(ADMIN_DIR.$this->uri->segment(2)."/".$this->uri->segment(3));
					}
			$config["total_rows"] = $this->training_batche_model->joinGet($fields, "training_batches", $join_table, $where, true);
	        $this->pagination->initialize($config);
	        $data->pagination = $this->pagination->create_links();
			$data->training_batches = $this->training_batche_model->joinGet($fields, "training_batches", $join_table, $where);
			return $data;
		}else{
			return $this->training_batche_model->joinGet($fields, "training_batches", $join_table, $where, FALSE, TRUE);
		}
		
	}

public function get_training_batche($batch_id){
	
		$fields = array("training_batches.*"
                , "trainings.title"
            );
		$join_table = array(
            "trainings" => "trainings.training_id = training_batches.training_id",
        );
		$where = "training_batches.batch_id = $batch_id";
		
		return $this->training_batche_model->joinGet($fields, "training_batches", $join_table, $where, FALSE, TRUE);
		
	}
	
	


}


	

