<div class="row">
  <div class="col-md-12">
    <h4 class="m-b-lg">
      Ürün Listesi
      <a href="<?php echo base_url("product/add_product"); ?>"
      class="btn btn-outline btn-primary btn-xs pull-right"> <i class="fa fa-plus"></i> Yeni Ekle</a>
    </h4>
  </div><!-- END column -->
  <div class="col-md-12">
    <div class="widget p-lg">

      <?php if(empty($items)) { ?>

        <div class="alert alert-info text-center">
          <p>Burada herhangi bir veri bulunmamaktadır. Eklemek için lütfen <a href="<?php echo base_url("product/add_product"); ?>">tıklayınız</a></p>
        </div>

      <?php } else { ?>

        <table class="table table-hover table-striped table-bordered content-container">
          <thead>
            <th class="order"><i class="fa fa-reorder"></i></th>
            <th class="w50">#id</th>
            <th>Başlık</th>
            <th>url</th>
            <th>Açıklama</th>
            <th>Durumu</th>
            <th>İşlem</th>
          </thead>
          <tbody class="sortable" data-url="<?php echo base_url("product/rankSet"); ?>">

            <?php foreach($items as $items) { ?>
              <tr id="tr-<?php echo $items->id; ?>">
                <td class="order"><i class="fa fa-reorder"></i></td>
                <td class="w50 text-center">#<?php echo $items->id; ?></td>
                <td><?php echo $items->title; ?></td>
                <td><?php echo $items->url; ?></td>
                <td><?php echo $items->description; ?></td>
                <td>
                  <input
                  data-url="<?php echo base_url("product/isActiveSet/$items->id"); ?>"
                  class="isActive"
                  type="checkbox"
                  data-switchery
                  data-color="#10c469"
                  <?php echo ($items->isActive) ? "checked" : ""; ?>
                  />
                </td>
                <td>
                  <button
                  data-url="<?php echo base_url("product/delete_product/$items->id"); ?>"
                  class="btn btn-sm btn-danger btn-outline remove-btn">
                  <i class="fa fa-trash"></i> Sil
                </button>
                <a href="<?php echo base_url("product/update_product/$items->id"); ?>" class="btn btn-sm btn-info btn-outline"><i class="fa fa-pencil-square-o"></i> Düzenle</a>
                <a href="<?php echo base_url("product/image_form/$items->id"); ?>" class="btn btn-sm btn-dark btn-outline"><i class="fa fa-image"></i> Resimler</a>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    <?php } ?>
  </div><!-- .widget -->
</div><!-- END column -->
</div>
