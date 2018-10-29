<?php

class Product extends CI_Controller
{
  public $viewFolder="";
  public function __construct()
  {
    parent::__construct();
    $this->viewFolder="Product_view";
    $this->load->model("Product_model");
    $this->load->model("Product_image_model");
    if(!get_active_user()){
        redirect(base_url("login"));
    }
  }
  public function index()
  {
    $viewData = new stdClass();
    //Tablodan veri getirilmesi
    $items=$this->Product_model->get_all(array(),"rank ASC");

    //View'e yollanacak veriler
    $viewData->viewFolder = $this->viewFolder;
    $viewData->subViewFolder="list";
    $viewData->items=$items;
    $this->load->view("{$this->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
  }
  public function add_product()
  {
    $viewData = new stdClass();
    $viewData->viewFolder=$this->viewFolder;
    $viewData->subViewFolder="add";
    $this->load->view("{$this->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
  }
  public function saved()
  {
    $this->load->library("form_validation");
    $this->form_validation->set_rules("title","Başlık","required|trim");
    $validation=$this->form_validation->run();
    if($validation)
    {
      $insert=$this->Product_model->
      add(
        array(
        "title"      =>$this->input->post("title"),
        "description"=>$this->input->post("description"),
        "url"        =>convertToSEO($this->input->post("title")),
        "isActive"   => 1,
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
    redirect(base_url(product));

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
public function update_product($id)
{
  $viewData = new stdClass();
  $item=$this->Product_model->
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
    $this->form_validation->set_rules("title","Başlık","required|trim");
    $validation=$this->form_validation->run();
    if($validation)
    {
      $update=$this->Product_model->
      update(
        array(
          "id" => $id
        ),
        array(
        "title"      =>$this->input->post("title"),
        "description"=>$this->input->post("description"),
        "url"        =>convertToSEO($this->input->post("title")),
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
    redirect(base_url(product));
    }
    else
    {
    $viewData= new stdClass();
    $item=$this->Product_model->
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
public function delete_product($id){
    $delete=$this->Product_model->delete(
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
    redirect(base_url(product));
  }
public function image_delete($id,$parent_id)
  {
        $file_name=$this->Product_image_model->get(
        array(
        "id" => $id
        ));
      $delete=$this->Product_image_model->delete(
        array(
          "id" => $id
        ));

        if($delete)
        {
          unlink("uploads/{$this->viewFolder}/$file_name->img_url");
          redirect (base_url("product/image_form/$parent_id"));
        }
        else {
          redirect (base_url("product/image_form/$parent_id"));
        }
      }
public function isActiveSet($id){
        if($id){
          $isActive=($this->input->post("data")==="true") ? 1 : 0;

          $this->Product_model->update(
            array(
              "id" => $id
            ),
            array(
              "isActive" =>$isActive
            )
          );
        }
      }
public function imagaIsActiveSet($id){
        if($id){
          $isActive=($this->input->post("data")==="true") ? 1 : 0;

          $this->Product_image_model->update(
            array(
              "id" => $id
            ),
            array(
              "isActive" =>$isActive
            )
          );
        }
      }
public function isCoverSet($id,$parent_id){
        if($id && $parent_id){
          $isCover=($this->input->post("data")==="true") ? 1 : 0;

          $this->Product_image_model->update(
            array(
              "id"          => $id,
              "product_id"  => $parent_id
            ),
            array(
              "isCover"     =>$isCover
            )
          );
          $this->Product_image_model->update(
            array(
              "id !="       => $id,
              "product_id"  => $parent_id
            ),
            array(
              "isCover" => 0
            )
          );
          $viewData = new stdClass();
          $viewData->viewFolder=$this->viewFolder;
          $viewData->subViewFolder="image";

          $viewData->item_images=$this->Product_image_model->get_all(
            array(
              "product_id"=> $parent_id
            ),"rank ASC "
          );
          $render_html = $this->load->view("{$this->viewFolder}/{$viewData->subViewFolder}/render_elements/images_list_v",$viewData,true);
          echo $render_html;

        }
      }
public function rankSet(){
        $data=$this->input->post("data");
        parse_str($data,$order);
        $items=$order["tr"];
        foreach ($items as $rank => $id) {
          $this->Product_model->update(
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
public function imageRankSet(){
        $data=$this->input->post("data");
        parse_str($data,$order);
        $items=$order["tr"];
        foreach ($items as $rank => $id) {
          $this->Product_image_model->update(
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
public function image_form($id){
        $viewData = new stdClass();
        $viewData->viewFolder=$this->viewFolder;
        $viewData->subViewFolder="image";
        $viewData->item=$this->Product_model->
        get(
          array(
            "id" => $id
          )
        );
        $viewData->item_images=$this->Product_image_model->get_all(
          array(
            "product_id"=> $id
          ),"rank ASC"
        );
        $this->load->view("{$this->viewFolder}/{$viewData->subViewFolder}/index",$viewData);
      }
public function image_upload($id)
      {
        $file_name = convertToSEO(pathinfo($_FILES["file"]["name"], PATHINFO_FILENAME)) . "." . pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);

       $image_348x215 = upload_picture($_FILES["file"]["tmp_name"], "uploads/$this->viewFolder",348,215, $file_name);
       $image_1080x426 = upload_picture($_FILES["file"]["tmp_name"], "uploads/$this->viewFolder",1080,426, $file_name);

       if($image_348x215 && $image_1080x426){

           $this->Product_image_model->add(
               array(
                   "img_url"       => $file_name,
                   "rank"          => 0,
                   "isActive"      => 1,
                   "isCover"       => 0,
                   "createdAt"     => date("Y-m-d H:i:s"),
                   "product_id"    => $id
               )
           );


       } else {
           echo "islem basarisiz";
       }
      }
public function reflesh_image_list($id){

        $viewData = new stdClass();
        $viewData->viewFolder=$this->viewFolder;
        $viewData->subViewFolder="image";

        $viewData->item_images=$this->Product_image_model->get_all(
          array(
            "product_id"=> $id
          )
        );
        $render_html = $this->load->view("{$this->viewFolder}/{$viewData->subViewFolder}/render_elements/images_list_v",$viewData,true);
        echo $render_html;
      }
    }
?>
