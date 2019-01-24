<?php

 class Pages extends Controller {
  public function __construct() {
  }

  public function index() {

    if(isLoggedIn()) {
      redirect('goals/index');
    }

    $data = [
      'title' => "SMARTrack",
      'description' => 'Setup and track the progress of your SMART goals (Specific, Measurable, Achievable, Relevant, Time-based)'
    ];
    $this->view('pages/index', $data);
  }

  public function about() {
    $data = [
      'title' => "About Us"
    ];
    $this->view('pages/about', $data);
  }

 }

?>