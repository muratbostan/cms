<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

  public $viewFolder = "";
  public function __construct()
  {
    parent::__construct();
    $this->viewFolder="Dashboard_view";
    $this->load->model("Dashboard_model");
    if(!get_active_user()){
        redirect(base_url("login"));
    }
  }
	public function index()
	{
    $viewData = new stdClass();
    $items =$this->Dashboard_model->get_all(
      array(), "id ASC");
    $viewData->items=$items;
    $viewData->viewFolder =$this->viewFolder;
    $viewData->subViewFolder="list";
    $this->load->view("{$this->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
	}
}
