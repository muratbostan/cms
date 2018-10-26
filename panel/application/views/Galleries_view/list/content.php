<div class="row">
  <div class="col-md-12">
    <h4 class="m-b-lg">
      Galeri Listesi
      <a href="<?php echo base_url("Galleries/add_Galleries"); ?>"
        class="btn btn-outline btn-primary btn-xs pull-right"> <i class="fa fa-plus"></i> Yeni Ekle</a>
      </h4>
    </div><!-- END column -->
    <div class="col-md-12">
      <div class="widget p-lg">

        <?php if(empty($items)) { ?>

          <div class="alert alert-info text-center">
            <p>Burada herhangi bir veri bulunmamaktadır. Eklemek için lütfen
              <a href="<?php echo base_url("Galleries/add_Galleries"); ?>">tıklayınız</a></p>
            </div>

          <?php } else { ?>

            <table class="table table-hover table-striped table-bordered content-container">
              <thead>
                <th class="order text-center w50"><i class="fa fa-reorder"></i></th>
                <th class="w50">id</th>
                <th>Galeri Adı </th>
                <th>Galeri Türü</th>
                <th class="w50">Durumu</th>
                <th>İşlem</th>
              </thead>
              <tbody class="sortable" data-url="<?php echo base_url("Galleries/rankSet"); ?>">

                <?php foreach($items as $items) { ?>

                  <tr id="tr-<?php echo $items->id; ?>" class="text-center">
                    <td class="order text-center"><i class="fa fa-reorder"></i></td>
                    <td>#<?php echo $items->id; ?></td>
                    <td><?php echo $items->title; ?></td>
                    <td><?php echo $items->gallery_type; ?></td>
                    <td class="w50">
                      <input
                      data-url="<?php echo base_url("Galleries/isActiveSet/$items->id"); ?>"
                      class="isActive"
                      type="checkbox"
                      data-switchery
                      data-color="#10c469"
                      <?php echo ($items->isActive) ? "checked" : ""; ?>
                      />
                    </td>
                    <td class="w300">
                      <button
                      data-url="<?php echo base_url("Galleries/delete_Galleries/$items->id"); ?>"
                      class="btn btn-sm btn-danger btn-outline remove-btn">
                      <i class="fa fa-trash"></i> Sil
                    </button>
                    <?php

                    if($items->gallery_type == "image"){
                      $button_icon = "fa fa-image";
                      $name = "Resim Galerisi";
                      $button_url = "galleries/upload_form/$items->id";
                    } else if($items->gallery_type == "video") {
                      $button_icon = "fa fa-play";
                      $name = "Video Galerisi";
                      $button_url = "galleries/gallery_video_list/$items->id";
                    } else {
                      $button_icon = "fa fa-folder";
                      $name = "Dosya Galerisi";
                      $button_url = "galleries/upload_form/$items->id";
                    }
                    ?>
                    <a href="<?php echo base_url("Galleries/update_Galleries/$items->id"); ?>"
                      class="btn btn-sm btn-info btn-outline"><i class="fa fa-pencil-square-o"></i> Düzenle</a>
                      <a href="<?php echo base_url($button_url); ?>"
                        class="btn btn-sm btn-dark btn-outline"><i class="<?php echo $button_icon ?>"></i>
                        <?php echo $name ?></a>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            <?php } ?>
          </div><!-- .widget -->
        </div><!-- END column -->
      </div>
