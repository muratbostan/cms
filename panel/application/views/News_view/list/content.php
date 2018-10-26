<div class="row">
  <div class="col-md-12">
    <h4 class="m-b-lg">Ürün Listesi
      <a href="<?php echo base_url("news/add_news") ?>
        "class="btn pull-right btn-outline btn-primary btn-xs "><i class="fa fa-plus"></i>Yeni Ekle</a>
      </h4>
    </div>
    <div class="col-md-12">
      <div class="widget p-lg">
        <?php if(empty($items)) { ?>
          <div class="alert alert-info text-center" role="alert">
            <span>Kayıt Bulunamadı.Eklemek için lütfen</span>
            <a href="<?php echo base_url("news/add_news") ?>" class="alert-link">Tıklayın</a>
          </div>
        <?php } else { ?>
          <table class="table table-hover table-striped table-bordered content-container">
            <thead>
              <th><i class="fa fa-reorder"></i></th>
              <th>id</th>
              <th>Başlık</th>
              <th>url</th>
              <th>Açıklama</th>
              <th>Haber Türü</th>
              <th>Görsel</th>
              <th>Durumu</th>
              <th>İşlem</th>
            </thead>
            <tbody class="sortable" data-url="<?php echo base_url("news/rankSet")?>">
              <?php foreach ($items as $items) { ?>
                <tr id="tr-<?php echo $items->id; ?>">
                  <td><i class="fa fa-reorder"></i></td>
                  <td>
                    <?php echo $items->id ?>
                  </td>
                  <td>
                    <?php echo $items->title ?>
                  </td>
                  <td>
                    <?php echo $items->url?>
                  </td>
                  <td>
                    <?php echo $items->description ?>
                  </td>
                  <td>
                    <?php echo $items->news_type ?>
                  </td>
                  <td>
                    <?php if($items->news_type == "image"){ ?>

                      <img width="100" src="<?php echo base_url("uploads/$viewFolder/$items->img_url"); ?>" alt="" class="img-rounded" >

                    <?php }else if($items->news_type =="video"){?>
                      <iframe width="100" height="130" src="<?php echo $items->video_url?>"
                      frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                      <?php }?>
                    </td>
                    <td>
                      <input data-url="<?php echo base_url("news/isActiveSet/$items->id")?>"
                      type="checkbox" class="isActive" data-switchery data-color="#10c469"
                      <?php echo ($items->isActive) ? "checked" : "" ; ?>
                      />
                    </td>
                    <td>
                      <button data-url="<?php echo base_url("news/delete_news/$items->id")?>"
                        class="btn btn-sm btn-danger remove-btn">
                        <i class="fa fa-trash">Sil</i>
                      </button>
                      <a href="<?php echo base_url("news/update_news/$items->id") ?>"
                        class="btn btn-sm btn-info "><i class="fa fa-pencil-square-o">Düzenle</i></a>

                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            <?php } ?>
          </div><!-- .widget -->
        </div>
      </div>
