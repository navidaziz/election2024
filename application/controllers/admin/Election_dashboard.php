<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Election_dashboard extends Admin_Controller
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
      $this->data['view'] = 'admin/polling_stations/election_dashboard';
      $this->load->view('admin/layout', $this->data);
   }
}
