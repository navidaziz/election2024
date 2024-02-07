<?php if (!defined('BASEPATH')) exit('Direct access not allowed!');

class Training_model extends MY_Model
{

    public function __construct()
    {

        parent::__construct();
        $this->table = "trainings";
        $this->pk = "training_id";
        $this->status = "status";
        $this->order = "order";
    }

    public function validate_form_data()
    {
        $validation_config = array(



            array(
                "field"  =>  "title",
                "label"  =>  "Title",
                "rules"  =>  "required"
            ),

            array(
                "field"  =>  "department_id",
                "label"  =>  "Department",
                "rules"  =>  "required"
            ),
            array(
                "field"  =>  "level",
                "label"  =>  "Level",
                "rules"  =>  "required"
            ),

            array(
                "field"  =>  "category",
                "label"  =>  "Category",
                "rules"  =>  "required"
            ),

            array(
                "field"  =>  "sub_category",
                "label"  =>  "Sub Category",
                "rules"  =>  "required"
            ),

            array(
                "field"  =>  "type",
                "label"  =>  "Type",
                "rules"  =>  "required"
            ),

            array(
                "field"  =>  "training_for",
                "label"  =>  "Training For",
                "rules"  =>  "required"
            ),

            array(
                "field"  =>  "location",
                "label"  =>  "Location",
                "rules"  =>  "required"
            ),

            array(
                "field"  =>  "start_date",
                "label"  =>  "Start Date",
                "rules"  =>  "required"
            ),

            array(
                "field"  =>  "end_date",
                "label"  =>  "End Date",
                "rules"  =>  "required"
            ),

            array(
                "field"  =>  "detail",
                "label"  =>  "Detail",
                "rules"  =>  "required"
            ),

        );
        //set and run the validation
        $this->form_validation->set_rules($validation_config);
        return $this->form_validation->run();
    }

    public function save_data($image_field = NULL)
    {
        $inputs = array();


        $query = "SELECT COUNT(*) as total FROM trainings";
        $training_total = $this->db->query($query)->row()->total;

        $inputs["code"]  =  date('Y') . "-" . ($training_total + 1);
        $inputs["department_id"]  =  $this->input->post("department_id");

        $inputs["title"]  =  $this->input->post("title");

        $inputs["level"]  =  $this->input->post("level");

        $inputs["category"]  =  $this->input->post("category");

        $inputs["sub_category"]  =  $this->input->post("sub_category");

        $inputs["type"]  =  $this->input->post("type");

        $inputs["training_for"]  =  $this->input->post("training_for");

        $inputs["location"]  =  $this->input->post("location");

        $inputs["start_date"]  =  $this->input->post("start_date");

        $inputs["end_date"]  =  $this->input->post("end_date");

        $inputs["detail"]  =  $this->input->post("detail");

        return $this->training_model->save($inputs);
    }

    public function update_data($training_id, $image_field = NULL)
    {
        $inputs = array();
        $inputs["department_id"]  =  $this->input->post("department_id");

        $inputs["code"]  =  $this->input->post("code");

        $inputs["title"]  =  $this->input->post("title");

        $inputs["level"]  =  $this->input->post("level");

        $inputs["category"]  =  $this->input->post("category");

        $inputs["sub_category"]  =  $this->input->post("sub_category");

        $inputs["type"]  =  $this->input->post("type");

        $inputs["training_for"]  =  $this->input->post("training_for");

        $inputs["location"]  =  $this->input->post("location");

        $inputs["start_date"]  =  $this->input->post("start_date");

        $inputs["end_date"]  =  $this->input->post("end_date");

        $inputs["detail"]  =  $this->input->post("detail");

        return $this->training_model->save($inputs, $training_id);
    }

    //----------------------------------------------------------------
    public function get_training_list($where_condition = NULL, $pagination = TRUE, $public = FALSE)
    {
        $data = (object) array();
        $fields = array("trainings.*");
        $join_table = array();
        if (!is_null($where_condition)) {
            $where = $where_condition;
        } else {
            $where = "";
        }

        if ($pagination) {
            //configure the pagination
            $this->load->library("pagination");

            if ($public) {
                $config['per_page'] = 10;
                $config['uri_segment'] = 3;
                $this->training_model->uri_segment = $this->uri->segment(3);
                $config["base_url"]  = base_url($this->uri->segment(1) . "/" . $this->uri->segment(2));
            } else {
                $this->training_model->uri_segment = $this->uri->segment(4);
                $config["base_url"]  = base_url(ADMIN_DIR . $this->uri->segment(2) . "/" . $this->uri->segment(3));
            }
            $config["total_rows"] = $this->training_model->joinGet($fields, "trainings", $join_table, $where, true);
            $this->pagination->initialize($config);
            $data->pagination = $this->pagination->create_links();
            $data->trainings = $this->training_model->joinGet($fields, "trainings", $join_table, $where);
            return $data;
        } else {
            return $this->training_model->joinGet($fields, "trainings", $join_table, $where, FALSE, TRUE);
        }
    }

    public function get_training($training_id)
    {

        $fields = array("trainings.*");
        $join_table = array();
        $where = "trainings.training_id = $training_id";

        return $this->training_model->joinGet($fields, "trainings", $join_table, $where, FALSE, TRUE);
    }
}
