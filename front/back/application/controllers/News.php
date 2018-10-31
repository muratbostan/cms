<?php

class News extends CI_Controller
{
  public $viewFolder="";
  public function __construct(){
    parent::__construct();
    $this->viewFolder="news_view";
    $this->load->model("News_model");
    if(!get_active_user()){
      redirect(base_url("login"));
    }

  }
  public function index(){
    $viewData = new stdClass();
    //Tablodan veri getirilmesi
    $items=$this->News_model->get_all(array(),"rank ASC");

    //View'e yollanacak veriler
    $viewData->viewFolder = $this->viewFolder;
    $viewData->subViewFolder="list";
    $viewData->items=$items;
    $this->load->view("{$this->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
  }
  public function add_news(){
    $viewData = new stdClass();
    $viewData->viewFolder=$this->viewFolder;
    $viewData->subViewFolder="add";
    $this->load->view("{$this->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
  }
  public function saved(){
      $this->load->library("form_validation");

      $news_type = $this->input->post("news_type");

      if($news_type == "image"){

        if($_FILES["img_url"]["name"] == ""){

          $alert = array(
            "title" => "İşlem Başarısız",
            "text" => "Lütfen bir görsel seçiniz",
            "type"  => "error"
          );
          $this->session->set_flashdata("alert", $alert);
          redirect(base_url("news/add_news"));

        }
      }else if($news_type == "video"){
        $this->form_validation->set_rules("video_url","Video URL","required|trim");
      }


      $this->form_validation->set_rules("title","Başlık","required|trim");
      $validation=$this->form_validation->run();

      if($validation)
        {

        //Upload proces

        if($news_type=="image"){

          $file_name = convertToSEO(pathinfo($_FILES["img_url"]["name"], PATHINFO_FILENAME)) . "." . pathinfo($_FILES["img_url"]["name"], PATHINFO_EXTENSION);

          $image_513x289 = upload_picture($_FILES["img_url"]["tmp_name"], "uploads/$this->viewFolder",513,289, $file_name);
          $image_730x411 = upload_picture($_FILES["img_url"]["tmp_name"], "uploads/$this->viewFolder",730,411, $file_name);

          if($image_513x289 && $image_730x411){

            $data = array(
              "title"         => $this->input->post("title"),
              "description"   => $this->input->post("description"),
              "url"           => convertToSEO($this->input->post("title")),
              "news_type"     => $news_type,
              "img_url"       => $file_name,
              "video_url"     => "#",
              "rank"          => 0,
              "isActive"      => 1,
              "createdAt"     => date("Y-m-d H:i:s")
            );

          }else{
            $alert =array(
              "title" => "İşlem Başarısız..",
              "text"  => "Görsel Yüklenirken Bir Problem Oluştu...",
              "type"  => "error"
            );
            $this->session->set_flashdata("alert",$alert);
            redirect(base_url("news/add_news"));
          }

        }else if ($news_type=="video")
        {
          $data=array(
            "title"      =>$this->input->post("title"),
            "description"=>$this->input->post("description"),
            "url"        =>convertToSEO($this->input->post("title")),
            "news_type"  =>$news_type,
            "img_url"    =>"#",
            "video_url"  => $this->input->post("video_url"),
            "rank"       =>0,
            "isActive"   => 1,
            "createdAt"  =>date("Y-m-d H:i:s"));
          }

          $insert=$this->News_model->add($data);
          if($insert)
          {
            $alert =array(
              "title" => "İşlem Başarılı..",
              "text" => "İşlem Başarılı Bir Şekilde Gerçekleşti..",
              "type" => "success"
            );

          }
          else
          {
            $alert =array(
              "title" => "İşlem Başarısız..",
              "text" => "İşlem Sırasında Bir Hata Oluştu...",
              "type" => "error"
            );
          }
          $this->session->set_flashdata("alert",$alert);
          redirect(base_url("news"));

        }
        else
        {
          $viewData= new stdClass();
          $viewData->viewFolder=$this->viewFolder;
          $viewData->subViewFolder="add";
          $viewData->form_error= true;
          $viewData->news_type=$news_type;
          $this->load->view("{$this->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
        }
      }
  public function update_news($id){
        $viewData = new stdClass();
        $item=$this->News_model->
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
  public function update($id){

        $this->load->library("form_validation");
        $news_type = $this->input->post("news_type");

        if($news_type == "video"){
          $this->form_validation->set_rules("video_url", "Video URL", "required|trim");
        }
        $this->form_validation->set_rules("title", "Başlık", "required|trim");
        $this->form_validation->set_message(
          array(
            "required"  => "<b>{field}</b> alanı doldurulmalıdır"
          )
        );
        $validate = $this->form_validation->run();
        if($validate){
          if($news_type == "image"){
            if($_FILES["img_url"]["name"] !== "") {
              $file_name = convertToSEO(pathinfo($_FILES["img_url"]["name"], PATHINFO_FILENAME)) . "." . pathinfo($_FILES["img_url"]["name"], PATHINFO_EXTENSION);

              $image_513x289 = upload_picture($_FILES["img_url"]["tmp_name"], "uploads/$this->viewFolder",513,289, $file_name);
              $image_730x411 = upload_picture($_FILES["img_url"]["tmp_name"], "uploads/$this->viewFolder",730,411, $file_name);

              if($image_513x289 && $image_730x411){

                $data = array(
                  "title" => $this->input->post("title"),
                  "description" => $this->input->post("description"),
                  "url" => convertToSEO($this->input->post("title")),
                  "news_type" => $news_type,
                  "img_url" => $file_name,
                  "video_url" => "#",
                );

              } else {
                $alert = array(
                  "title" => "İşlem Başarısız",
                  "text" => "Görsel yüklenirken bir problem oluştu",
                  "type" => "error"
                );

                $this->session->set_flashdata("alert", $alert);
                redirect(base_url("news/update_news/$id"));
              }
            } else {

              $data = array(
                "title" => $this->input->post("title"),
                "description" => $this->input->post("description"),
                "url" => convertToSEO($this->input->post("title")),
              );
            }
          } else if($news_type == "video"){

            $data = array(
              "title"         => $this->input->post("title"),
              "description"   => $this->input->post("description"),
              "url"           => convertToSEO($this->input->post("title")),
              "news_type"     => $news_type,
              "img_url"       => "#",
              "video_url"     => $this->input->post("video_url")
            );
          }
          $update = $this->News_model->update(array("id" => $id), $data);


          if($update){

            $alert = array(
              "title" => "İşlem Başarılı",
              "text" => "Kayıt başarılı bir şekilde güncellendi",
              "type"  => "success"
            );

          } else {

            $alert = array(
              "title" => "İşlem Başarısız",
              "text" => "Kayıt Güncelleme sırasında bir problem oluştu",
              "type"  => "error"
            );
          }

          // İşlemin Sonucunu Session'a yazma işlemi...
          $this->session->set_flashdata("alert", $alert);

          redirect(base_url("news"));

        } else {

          $viewData = new stdClass();

          /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
          $viewData->viewFolder = $this->viewFolder;
          $viewData->subViewFolder = "update";
          $viewData->form_error = true;
          $viewData->news_type = $news_type;

          /** Tablodan Verilerin Getirilmesi.. */
          $viewData->item = $this->news_model->get(
            array(
              "id"    => $id,
            )
          );
          $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }
      }
  public function delete_news($id){
    $delete=$this->News_model->delete(
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
      redirect(base_url("news"));
    }
  public function isActiveSet($id){
          if($id){
            $isActive=($this->input->post("data")==="true") ? 1 : 0;

            $this->News_model->update(
              array(
                "id" => $id
              ),
              array(
                "isActive" =>$isActive
              )
            );
          }
        }
  public function rankSet(){
          $data=$this->input->post("data");
          parse_str($data,$order);
          $items=$order["tr"];
          foreach ($items as $rank => $id) {
            $this->News_model->update(
              array(
                "id"      =>$id,
                "rank !=" => $rank
              ),
              array(
                "rank" =>$rank
              )
            );
          }
        }

    }?>
