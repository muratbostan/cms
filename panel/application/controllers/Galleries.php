<?php

class Galleries extends CI_Controller
{
  public $viewFolder="";
  public function __construct()
    {
      parent::__construct();
      $this->viewFolder="Galleries_view";
      $this->load->model("Gallery_model");
      $this->load->model("image_model");
      $this->load->model("file_model");
      $this->load->model("video_model");
    }
  public function index()
    {
      $viewData = new stdClass();
      //Tablodan veri getirilmesi
      $items=$this->Gallery_model->get_all(array(),"rank ASC");

      //View'e yollanacak veriler
      $viewData->viewFolder = $this->viewFolder;
      $viewData->subViewFolder="list";
      $viewData->items=$items;
      $this->load->view("{$this->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
    }
  public function add_Galleries()
    {
      $viewData = new stdClass();
      $viewData->viewFolder=$this->viewFolder;
      $viewData->subViewFolder="add";
      $this->load->view("{$this->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
    }
  public function saved()
    {
      $this->load->library("form_validation");
      $this->form_validation->set_rules("title","Galeri Adı","required|trim");
      $this->form_validation->set_message(
        array(
          "required" => "<b>{field}</b> alanı doldurulmalıdır."
        ));
        $validation=$this->form_validation->run();

        if($validation)
        {
          //Gallery file creation
          $gallery_type= $this->input->post("gallery_type");
          if($gallery_type != "video")
          {
            $folder_name=convertToSEO($this->input->post("title"));
            $path="uploads/$this->viewFolder/$gallery_type/$folder_name";
            $create_folder= mkdir($path,0775);
            if(!($create_folder))
            {
              $alert =array(
                "title"    => "İşlem Başarısız..",
                "text"     => "Klasör Oluştururken Bir Hata Oluştu...",
                "type"     =>  "error"
              );
              $this->session->set_flashdata("alert",$alert);
              redirect(base_url("Galleries"));
            }
          }

          $insert=$this->Gallery_model->
          add(
            array(
              "title"       =>$this->input->post("title"),
              "gallery_type"=>$gallery_type,
              "url"         =>convertToSEO($this->input->post("title")),
              "folder_name" =>$folder_name,
              "isActive"    => 1,
              "createdAt"  =>date("Y-m-d H:i:s")
            )
          );
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
          redirect(base_url("Galleries"));
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
  public function update_Galleries($id)
    {
        $viewData = new stdClass();
        $item=$this->Gallery_model->
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
  public function update($id,$gallery_type,$oldFolderName="")
    {
      $this->load->library("form_validation");
      $this->form_validation->set_rules("title","Galeri Adı","required|trim");
      $this->form_validation->set_message(
          array(
            "required" => "<b>{field}</b> alanı doldurulmalıdır."
          ));

          $validation=$this->form_validation->run();
          if($validation)
          {
            //Gallery file creation
            if($gallery_type != "video")
            {
              $folder_name=convertToSEO($this->input->post("title"));
              $path="uploads/$this->viewFolder/$gallery_type/";
              $rename=rename("$path/$oldFolderName","$path/$folder_name");
              if(!($rename))
              {
                $alert =array(
                  "title"    => "İşlem Başarısız..",
                  "text"     => "Klasör Düzenlenirken Bir Hata Oluştu...",
                  "type"     =>  "error"
                );
                $this->session->set_flashdata("alert",$alert);
                redirect(base_url("Galleries"));
              }
            }

            $update=$this->Gallery_model->
            update(
              array(
                "id" => $id
              ),
              array(
                "title"       =>$this->input->post("title"),
                "folder_name" =>$folder_name,
                "url"         =>convertToSEO($this->input->post("title")),
              )
            );

            if($update)
            {
              $alert =array(
                "title" => "İşlem Başarılı..",
                "text" => "Güncelleme Başarılı Bir Şekilde Gerçekleşti..",
                "type" => "success"
              );

            }
            else
            {
              $alert =array(
                "title" => "İşlem Başarısız..",
                "text" => "Güncelleme Sırasında Bir Hata Oluştu...",
                "type" => "error"
              );
            }
            $this->session->set_flashdata("alert",$alert);
            redirect(base_url("Galleries"));
          }
          else
          {
            $viewData= new stdClass();
            $item=$this->Gallery_model->
            get(
              array(
                "id"  =>  $id,
              )
            );
            $viewData->viewFolder=$this->viewFolder;
            $viewData->subViewFolder="update";
            $viewData->form_error= true;
            $viewData->item=$item;
            $this->load->view("{$this->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
          }
        }
  public function delete_Galleries($id)
    {
      $gallery = $this->Gallery_model->get(
            array(
              "id" => $id,
            )
          );
      if($gallery->gallery_type != "video"){

            $path ="uploads/$this->viewFolder/$gallery->gallery_type/$gallery->folder_name" ;
            $delete_folder=rmdir($path);
            if(!$delete_folder){
              $alert =array(
                "title" => "İşlem Başarısız..",
                "text"  => "Dosya Silme Sırasında Bir Hata Oluştu...",
                "type"  => "error"
              );
              $this->session->set_flashdata("alert",$alert);
              redirect(base_url("Galleries"));
            }
          }
      $delete=$this->Gallery_model->delete(
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
            redirect(base_url("Galleries"));
          }
  public function fileDelete($id, $parent_id, $gallery_type){
    $modelName = ($gallery_type == "image") ? "image_model" : "file_model";
    $fileName = $this->$modelName->get(
      array(
        "id"    => $id
      )
    );
    $delete = $this->$modelName->delete(
      array(
        "id"    => $id
      )
    );
    if($delete){
      unlink($fileName->url);
      redirect(base_url("galleries/upload_form/$parent_id"));
    } else {
      redirect(base_url("galleries/upload_form/$parent_id"));
    }
  }
  public function isActiveSet($id)
              {
                if($id){
                  $isActive=($this->input->post("data")==="true") ? 1 : 0;

                  $this->Gallery_model->update(
                    array(
                      "id" => $id
                    ),
                    array(
                      "isActive" =>$isActive
                    )
                  );
                }
              }
  public function fileIsActiveSetter($id, $gallery_type){

    if($id && $gallery_type){

      $modelName = ($gallery_type == "image") ? "image_model" : "file_model";

      $isActive = ($this->input->post("data") === "true") ? 1 : 0;

      $this->$modelName->update(
        array(
          "id"    => $id
        ),
        array(
          "isActive"  => $isActive
        )
      );
    }
  }
  public function rankSet(){
                $data=$this->input->post("data");
                parse_str($data,$order);
                $items=$order["tr"];
                foreach ($items as $rank => $id) {
                  $this->Gallery_model->update(
                    array(
                      "id"      =>$id,
                      "rank !=" =>$rank
                    ),
                    array(
                      "rank"    =>$rank
                    )
                  );
                }
              }
  public function fileRankSetter($gallery_type){
    $data = $this->input->post("data");
    parse_str($data, $order);
    $items = $order["ord"];
    $modelName = ($gallery_type == "image") ? "image_model" : "file_model";
    foreach ($items as $rank => $id){
      $this->$modelName->update(
        array(
          "id"        => $id,
          "rank !="   => $rank
        ),
        array(
          "rank"      => $rank
        )
      );
    }
  }
  public function upload_form($id){
          $viewData = new stdClass();
          /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
          $viewData->viewFolder = $this->viewFolder;
          $viewData->subViewFolder = "image";
          $item = $this->Gallery_model->get(
              array(
                  "id"    => $id
              )
          );
          $viewData->item = $item;
          if($item->gallery_type == "image"){
              $viewData->items = $this->image_model->get_all(
                  array(
                      "gallery_id"    => $id
                  ), "rank ASC"
              );
          } else if($item->gallery_type == "file"){

              $viewData->items = $this->file_model->get_all(
                  array(
                      "gallery_id"    => $id
                  ), "rank ASC"
              );
          } else {
              $viewData->items = $this->video_model->get_all(
                  array(
                      "gallery_id"    => $id
                  ), "rank ASC"
              );
          }
          $viewData->gallery_type = $item->gallery_type;
          $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
      }
  public function file_upload($gallery_id,$gallery_type,$folder_name)
              {
                $file_name=convertToSEO(pathinfo($_FILES["file"]["name"],PATHINFO_FILENAME)). "." .pathinfo($_FILES["file"]["name"],PATHINFO_EXTENSION);
                $config["allowed_types"]="jpg||jpeg||png||pdf||doc||docx";
                $config["upload_path"]="uploads/$this->viewFolder/$gallery_type/$folder_name/";
                $config["file_name"]= $file_name;

                $this->load->library("upload",$config);
                $upload=$this->upload->do_upload("file");
                if($upload)
                {
                  $uploaded_file = $this->upload->data("file_name");

                  $modelName =($gallery_type=="image") ? "image_model" : "file_model";

                  $this->$modelName->add(
                    array(
                      "url" =>"{$config["upload_path"]}$file_name",
                      "rank" => 0,
                      "isActive" =>1,
                      "createdAt" => date("Y-m-d H:i:s"),
                      "gallery_id" => $gallery_id
                    )
                  );
                }else{
                  echo "fail";
                }
              }
  public function refresh_file_list($gallery_id, $gallery_type){

    $viewData = new stdClass();

    /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
    $viewData->viewFolder = $this->viewFolder;
    $viewData->subViewFolder = "image";

    $modelName = ($gallery_type == "image") ? "image_model" : "file_model";

    $viewData->items = $this->$modelName->get_all(
      array(
        "gallery_id"    => $gallery_id
      )
    );

    $viewData->gallery_type = $gallery_type;

    $render_html = $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/render_elements/file_list_v", $viewData, true);

    echo $render_html;

  }
      /************* Video Galeri için Kullanılan Metotlar *************/
  public function gallery_video_list($id){

            $viewData = new stdClass();

            $gallery = $this->Gallery_model->get(
                array(
                    "id"    => $id
                )
            );

            /** Tablodan Verilerin Getirilmesi.. */
            $items = $this->video_model->get_all(
                array(
                    "gallery_id"    => $id
                ), "rank ASC"
            );

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "video/list";
            $viewData->items = $items;
            $viewData->gallery = $gallery;

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
        }
  public function new_gallery_video_form($id){

            $viewData = new stdClass();

            $viewData->gallery_id = $id;
            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "video/add";

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);

        }
  public function gallery_video_save($id){

            $this->load->library("form_validation");

            // Kurallar yazilir..
            $this->form_validation->set_rules("url", "Video URL", "required|trim");

            $this->form_validation->set_message(
                array(
                    "required"  => "<b>{field}</b> alanı doldurulmalıdır"
                )
            );
            $validate = $this->form_validation->run();

            if($validate){

                $insert = $this->video_model->add(
                    array(
                        "url"           => $this->input->post("url"),
                        "gallery_id"    => $id,
                        "rank"          => 0,
                        "isActive"      => 1,
                        "createdAt"     => date("Y-m-d H:i:s")
                    )
                );

                // TODO Alert sistemi eklenecek...
                if($insert){

                    $alert = array(
                        "title" => "İşlem Başarılı",
                        "text" => "Kayıt başarılı bir şekilde eklendi",
                        "type"  => "success"
                    );

                } else {

                    $alert = array(
                        "title" => "İşlem Başarısız",
                        "text" => "Kayıt Ekleme sırasında bir problem oluştu",
                        "type"  => "error"
                    );
                }

                // İşlemin Sonucunu Session'a yazma işlemi...
                $this->session->set_flashdata("alert", $alert);

                redirect(base_url("galleries/gallery_video_list/$id"));

            } else {

                $viewData = new stdClass();

                /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
                $viewData->viewFolder = $this->viewFolder;
                $viewData->subViewFolder = "video/add";
                $viewData->form_error = true;
                $viewData->gallery_id = $id;

                $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
            }

        }
  public function update_gallery_video_form($id){

            $viewData = new stdClass();

            /** Tablodan Verilerin Getirilmesi.. */
            $item = $this->video_model->get(
                array(
                    "id"    => $id,
                )
            );

            /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
            $viewData->viewFolder = $this->viewFolder;
            $viewData->subViewFolder = "video/update";
            $viewData->item = $item;

            $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);


        }
  public function gallery_video_update($id, $gallery_id){

            $this->load->library("form_validation");

            // Kurallar yazilir..
            $this->form_validation->set_rules("url", "Video URL", "required|trim");

            $this->form_validation->set_message(
                array(
                    "required"  => "<b>{field}</b> alanı doldurulmalıdır"
                )
            );

            $validate = $this->form_validation->run();

            if($validate){

                $update = $this->video_model->update(
                    array(
                        "id"    => $id
                    ),
                    array(
                        "url"   => $this->input->post("url"),
                    )
                );

                // TODO Alert sistemi eklenecek...
                if($update){

                    $alert = array(
                        "title" => "İşlem Başarılı",
                        "text" => "Kayıt başarılı bir şekilde güncellendi",
                        "type"  => "success"
                    );

                } else {

                    $alert = array(
                        "title" => "İşlem Başarısız",
                        "text" => "Güncelleme sırasında bir problem oluştu",
                        "type"  => "error"
                    );

                }

                $this->session->set_flashdata("alert", $alert);

                redirect(base_url("galleries/gallery_video_list/$gallery_id"));

            } else {

                $viewData = new stdClass();

                /** Tablodan Verilerin Getirilmesi.. */
                $item = $this->video_model->get(
                    array(
                        "id"    => $id,
                    )
                );

                /** View'e gönderilecek Değişkenlerin Set Edilmesi.. */
                $viewData->viewFolder = $this->viewFolder;
                $viewData->subViewFolder = "video/update";
                $viewData->form_error = true;
                $viewData->item = $item;

                $this->load->view("{$viewData->viewFolder}/{$viewData->subViewFolder}/index", $viewData);
            }

        }
  public function rankGalleryVideoSetter(){


            $data = $this->input->post("data");

            parse_str($data, $order);

            $items = $order["ord"];

            foreach ($items as $rank => $id){

                $this->video_model->update(
                    array(
                        "id"        => $id,
                        "rank !="   => $rank
                    ),
                    array(
                        "rank"      => $rank
                    )
                );

            }

        }
  public function galleryVideoIsActiveSetter($id){

            if($id){

                $isActive = ($this->input->post("data") === "true") ? 1 : 0;

                $this->video_model->update(
                    array(
                        "id"    => $id
                    ),
                    array(
                        "isActive"  => $isActive
                    )
                );
            }
        }
  public function galleryVideoDelete($id, $gallery_id){

            $delete = $this->video_model->delete(
                array(
                    "id"    => $id
                )
            );

            // TODO Alert Sistemi Eklenecek...
            if($delete){

                $alert = array(
                    "title" => "İşlem Başarılı",
                    "text" => "Kayıt başarılı bir şekilde silindi",
                    "type"  => "success"
                );

            } else {

                $alert = array(
                    "title" => "İşlem Başarısız",
                    "text" => "Kayıt silme sırasında bir problem oluştu",
                    "type"  => "error"
                );


            }

            $this->session->set_flashdata("alert", $alert);
            redirect(base_url("galleries/gallery_video_list/$gallery_id"));

        }
}
?>
