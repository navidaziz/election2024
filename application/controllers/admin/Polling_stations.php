<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Polling_stations extends Admin_Controller
{
   public function __construct()
   {
      parent::__construct();
      $this->load->helper('project_helper');
   }

   public function index()
   {

      $this->data['title'] = 'Polling Stations List';
      $this->data['description'] = 'list of all polling stations';
      $this->data['view'] = 'admin/polling_stations/index';
      $this->load->view('admin/layout', $this->data);
   }

   public function add_result_form()
   {
      $data['polling_station_id'] = (int) $this->input->post('polling_station_id');
      $this->load->view('admin/polling_stations/add_result_form', $data);
   }

   public function add_election_result()
   {
      $polling_station_id  = (int) $this->input->post("polling_station_id");

      $this->db->where('polling_station_id', $polling_station_id);
      $this->db->delete('election_results');

      $candidates = $this->input->post("candidates");

      foreach ($candidates as $candidate_id => $vote) {

         $data = array(
            'polling_station_id' => $polling_station_id,
            'candidate_id' => $candidate_id,
            'votes' => $vote
         );

         $this->db->insert('election_results', $data);
      }
      redirect($_SERVER['HTTP_REFERER']);
   }
}
