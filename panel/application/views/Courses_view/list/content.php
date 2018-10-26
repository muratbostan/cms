<div class="row">
  <div class="col-md-12">
    <h4 class="m-b-lg">Eğitim Listesi
      <a href="<?php echo base_url("Courses/add_Courses") ?>
        "class="btn pull-right btn-outline btn-primary btn-xs "><i class="fa fa-plus"></i>Yeni Ekle</a>
      </h4>
    </div>
    <div class="col-md-12">
      <div class="widget p-lg">
        <?php if(empty($items)) { ?>
          <div class="alert alert-info text-center" role="alert">
            <span>Kayıt Bulunamadı.Eklemek için lütfen</span>
            <a href="<?php echo base_url("Courses/add_Courses") ?>" class="alert-link">Tıklayın</a>
          </div>
        <?php } else { ?>
          <table class="table table-hover table-striped table-bordered content-container">
            <thead>
              <th class="text-center w50"><i class="fa fa-reorder"></i></th>
              <th class="text-center">id</th>
              <th>Başlık</th>
              <th>Tarih</th>
              <th>Görsel</th>
              <th>Durumu</th>
              <th>İşlem</th>
            </thead>
            <tbody class="sortable" data-url="<?php echo base_url("Courses/rankSet")?>">
              <?php foreach ($items as $items) { ?>
                <tr id="tr-<?php echo $items->id; ?>" class="text-center">
                  <td><i class="fa fa-reorder"></i></td>
                  <td class="w50">
                    <?php echo $items->id ?>
                  </td>
                  <td>
                    <?php echo $items->title ?>
                  </td>
                  <td class="w200">
                    <?php echo getReadebleDate($items->event_date )?>
                  </td>
                  <td class="w100">
                      <img width="100" src="<?php echo base_url("uploads/$viewFolder/$items->img_url"); ?>"
                      alt="" class="img-rounded" >
                    </td>
                    <td class="w50">
                      <input data-url="<?php echo base_url("Courses/isActiveSet/$items->id")?>"
                      type="checkbox" class="isActive" data-switchery data-color="#10c469"
                      <?php echo ($items->isActive) ? "checked" : "" ; ?>
                      />
                    </td>
                    <td class="w200">
                      <button data-url="<?php echo base_url("Courses/delete_Courses/$items->id")?>"
                        class="btn btn-sm btn-danger remove-btn">
                        <i class="fa fa-trash">Sil</i>
                      </button>
                      <a href="<?php echo base_url("Courses/update_Courses/$items->id") ?>"
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
