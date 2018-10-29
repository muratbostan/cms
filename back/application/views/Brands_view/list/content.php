<div class="row">
  <div class="col-md-12">
    <h4 class="m-b-lg">Marka Listesi
      <a href="<?php echo base_url("Brands/add_Brands") ?>
        "class="btn pull-right btn-outline btn-primary btn-xs "><i class="fa fa-plus"></i>Yeni Ekle</a>
      </h4>
    </div>
    <div class="col-md-12">
      <div class="widget p-lg">
        <?php if(empty($items)) { ?>
          <div class="alert alert-info text-center" role="alert">
            <span>Kayıt Bulunamadı.Eklemek için lütfen</span>
            <a href="<?php echo base_url("Brands/add_Brands") ?>" class="alert-link">Tıklayın</a>
          </div>
        <?php } else { ?>
          <table class="table table-hover table-striped table-bordered content-container">
            <thead>
              <th class="text-center  w50"><i class="fa fa-reorder"></i></th>
              <th class="text-center  w50">id</th>
              <th>Başlık</th>
              <th class="text-center">Görsel</th>
              <th class="text-center">Durumu</th>
              <th>İşlem</th>
            </thead>
            <tbody class="sortable" data-url="<?php echo base_url("Brands/rankSet")?>">
              <?php foreach ($items as $items) { ?>
                <tr id="tr-<?php echo $items->id; ?>" class="text-center">
                  <td><i class="fa fa-reorder"></i></td>
                  <td class="text-center">
                    <?php echo $items->id ?>
                  </td>
                  <td class="text-center">
                    <?php echo $items->title ?>
                  </td>
                  <td class="text-center w100">
                    <img width="75"
                    src="<?php echo get_picture($viewFolder, $items->img_url, "350x216"); ?>"
                    alt="" class="img-rounded">
                  </td>
                  <td class="text-center w50">
                    <input data-url="<?php echo base_url("Brands/isActiveSet/$items->id")?>"
                    type="checkbox" class="isActive" data-switchery data-color="#10c469"
                    <?php echo ($items->isActive) ? "checked" : "" ; ?>
                    />
                  </td>
                  <td class="text-center w200">
                    <button data-url="<?php echo base_url("Brands/delete_Brands/$items->id")?>"
                      class="btn btn-sm btn-danger remove-btn">
                      <i class="fa fa-trash">Sil</i>
                    </button>
                    <a href="<?php echo base_url("Brands/update_Brands/$items->id") ?>"
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
