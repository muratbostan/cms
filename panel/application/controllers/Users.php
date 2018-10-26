<?php

class Users extends CI_Controller
{
  public $viewFolder="";
  public function __construct()
  {
    parent::__construct();

    $this->viewFolder="Users_view";
    $this->load->model("User_model");

  }
  public function index()
  {
    $viewData = new stdClass();
    //Tablodan veri getirilmesi
    $items=$this->User_model->get_all(array());

    //View'e yollanacak veriler
    $viewData->viewFolder = $this->viewFolder;
    $viewData->subViewFolder="list";
    $viewData->items=$items;
    $this->load->view("{$this->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
  }
  public function add_Users()
  {
    $viewData = new stdClass();
    $viewData->viewFolder=$this->viewFolder;
    $viewData->subViewFolder="add";
    $this->load->view("{$this->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
  }
  public function saved()
  {

    $this->load->library("form_validation");
    $this->form_validation->set_rules("user_name", "Kullanıcı Adı", "required|trim|is_unique[users.user_name]");
    $this->form_validation->set_rules("full_name", "Ad Soyad", "required|trim");
    $this->form_validation->set_rules("email", "E-posta", "required|trim|valid_email|is_unique[users.email]");
    $this->form_validation->set_rules("password", "Şifre", "required|trim|min_length[6]|max_length[8]");
    $this->form_validation->set_rules("re_password", "Şifre Tekrar", "required|trim|min_length[6]|max_length[8]|matches[password]");

    $this->form_validation->set_message(
      array(
        "required" => "<b>{field}</b> alanı doldurulmalıdır",
        "valid_email" => "Lütfen Geçerli Bir E-posta Giriniz.",
        "is_unique"  => "<b>{field}</b> alanı daha önceden kullanılmış",
        "matches" =>"Şifreler birbirlerini tutmuyor",
        "max_length"=>"Şifre çok kısa,lütfen 6-8 karakter arası şifre oluşturun.",
        "max_length" =>"Şifre çok uzun,lütfen 6-8 karakter arası şifre oluşturun."
      )
    );
    $validation=$this->form_validation->run();

    if($validation)
    {
         $insert = $this->User_model->add(
        array(
          "user_name"     => $this->input->post("user_name"),
          "full_name"     => $this->input->post("full_name"),
          "email"         => $this->input->post("email"),
          "password"      => md5($this->input->post("password")),
          "isActive"      => 1,
          "createdAt"     => date("Y-m-d H:i:s")
        )
      );
      if($insert)
      {
        $alert =array(
          "title" => "İşlem Başarılı..",
          "text"  => "Kayıt İşlemi Gerçekleşti..",
          "type"  => "success"
        );
        }
      else
      {
        $alert =array(
          "title" => "İşlem Başarısız..",
          "text"  => "Kayıt İşlemi Sırasında Bir Hata Oluştu...",
          "type"  => "error"
        );
      }
      $this->session->set_flashdata("alert",$alert);
      redirect(base_url("Users"));

    }
    else
    {
      $viewData= new stdClass();
      $viewData->viewFolder=$this->viewFolder;
      $viewData->subViewFolder="add";
      $viewData->form_error= true;
      $this->load->view("{$this->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
    }
  }
  public function update_Users($id)
  {
    $viewData = new stdClass();
    $item=$this->User_model->
    get(
      array(
        "id"  =>  $id
      )
    );
    $viewData->viewFolder=$this->viewFolder;
    $viewData->subViewFolder="update";
    $viewData->item=$item;
    $this->load->view("{$this->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
  }
  public function update_password_form($id)
  {
    $viewData = new stdClass();
    $item=$this->User_model->
    get(
      array(
        "id"  =>  $id
      )
    );
    $viewData->viewFolder=$this->viewFolder;
    $viewData->subViewFolder="password";
    $viewData->item=$item;
    $this->load->view("{$this->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
  }
  public function update($id)
  {
    $this->load->library("form_validation");

    $oldUser= $this->User_model->get(
      array(
        "id" => $id ,
      )
    );
    if($oldUser->user_name != $this->input->post("user_name")){
      $this->form_validation->set_rules("user_name", "Kullanıcı Adı", "required|trim|is_unique[users.user_name]");
    }
    if($oldUser->full_name != $this->input->post("full_name")){
      $this->form_validation->set_rules("full_name", "Ad Soyad", "required|trim");
    }
    if($oldUser->email != $this->input->post("email")){
      $this->form_validation->set_rules("email", "E-posta", "required|trim|valid_email|is_unique[users.email]");
    }

    $this->form_validation->set_message(
      array(
        "required" => "<b>{field}</b> alanı doldurulmalıdır",
        "valid_email" => "Lütfen Geçerli Bir E-posta Giriniz.",
        "is_unique"  => "<b>{field}</b> alanı daha önceden kullanılmış",

      )
    );
    $validation=$this->form_validation->run();
    if($validation)
      {

        $update = $this->User_model->update(
        array( "id" => $id),
         array(
           "user_name"     => $this->input->post("user_name"),
           "full_name"     => $this->input->post("full_name"),
           "email"         => $this->input->post("email"),
           "isActive"      => 1,
           "createdAt"     => date("Y-m-d H:i:s")
         ));
        if($update){

            $alert = array(
                "title" => "İşlem Başarılı",
                "text" =>  "Kayıt Güncelleme başarılı bir şekilde güncellendi",
                "type"  => "success"
            );
        } else {
            $alert = array(
                "title" => "İşlem Başarısız",
                "text" =>  "Kayıt Güncelleme sırasında bir problem oluştu",
                "type"  => "error"
            );
        }

        // İşlemin Sonucunu Session'a yazma işlemi...
        $this->session->set_flashdata("alert", $alert);

        redirect(base_url("Users"));

       }else {

      $viewData = new stdClass();

      /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
      $viewData->viewFolder = $this->viewFolder;
      $viewData->subViewFolder = "update";
      $viewData->form_error = true;

      $viewData->item = $this->User_model->get(

        array(
          "id"    => $id,
        )
      );
      $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }
  }
  public function update_password($id)
  {
    $this->load->library("form_validation");

    $this->form_validation->set_rules("password", "Şifre", "required|trim|min_length[6]|max_length[8]");
    $this->form_validation->set_rules("re_password", "Şifre Tekrar", "required|trim|min_length[6]|max_length[8]|matches[password]");
    $this->form_validation->set_message(
      array(
        "matches" =>"Şifreler birbirlerini tutmuyor",
        "min_length"=>"Şifre çok kısa,lütfen 6-8 karakter arası şifre oluşturun.",
        "max_length" =>"Şifre çok uzun,lütfen 6-8 karakter arası şifre oluşturun."
      )
    );
    $validation=$this->form_validation->run();
    if($validation)
      {

        $update = $this->User_model->update(
        array( "id" => $id),
         array(

           "password"      => md5($this->input->post("password")),
         ));
        if($update){

            $alert = array(
                "title" => "İşlem Başarılı",
                "text" =>  "Şifreniz  başarılı bir şekilde güncellendi",
                "type"  => "success"
            );
        } else {
            $alert = array(
                "title" => "İşlem Başarısız",
                "text" =>  "Şifre Güncelleme sırasında bir problem oluştu",
                "type"  => "error"
            );
        }

        // İşlemin Sonucunu Session'a yazma işlemi...
        $this->session->set_flashdata("alert", $alert);

        redirect(base_url("Users"));

       }else {

      $viewData = new stdClass();

      /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
      $viewData->viewFolder = $this->viewFolder;
      $viewData->subViewFolder = "password";
      $viewData->form_error = true;

      $viewData->item = $this->User_model->get(

        array(
          "id"    => $id,
        )
      );
      $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
    }
  }
  public function delete_Users($id)
  {
    $delete=$this->User_model->delete(
      array(
        "id" => $id
      ));

      if($delete)
      {
        $alert =array(
          "title" => "İşlem Başarılı..",
          "text" => "Kayıt Başarılı Bir Şekilde Silindi..",
          "type" => "success"
        );

      }
      else
      {
        $alert =array(
          "title" => "İşlem Başarısız..",
          "text" => "Kayıt Silme Sırasında Bir Hata Oluştu...",
          "type" => "error"
        );
      }
      $this->session->set_flashdata("alert",$alert);
      redirect(base_url("Users"));
  }
  public function isActiveSet($id)
  {
    if($id){
      $isActive = ($this->input->post("data") === "true") ? 1 : 0;
      $this->User_model->update(
        array(
          "id"    => $id
        ),
        array(
          "isActive"  => $isActive
        )
      );
      }
  }
  
  }?>
