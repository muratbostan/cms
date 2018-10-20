<?php if(empty($item_images)) { ?>
  <div class="alert alert-info text-center" role="alert">
    <span>Ürüne Ait Resim Bulunamadı.</span>

  </div>
<?php } else { ?>
  <table class="table table-bordered table-striped table-hover  ">
    <thread>
      <th><i class="fa fa-reorder"></i></th>
      <th>id</th>
      <th>Görsel</th>
      <th>Resim adı</th>
      <th>Durumu</th>
      <th>Kapak</th>
      <th>İşlem</th>
    </thread>
    <tbody class="sortable"data-url="<?php echo base_url("Product/imageRankSet")?>">
      <?php foreach ($item_images as $image) { ?>
        <tr id="tr-<?php echo $image->id; ?>">
          <td><i class="fa fa-reorder"></i></td>
          <td class="w100"><?php echo $image->id?></td>
          <td class="w100">
            <img width="50" src="<?php echo base_url("uploads/{$viewFolder}/$image->img_url")?> " alt="" class="img-responsive" >
          </td>
          <td><?php echo $image->img_url?></td>
          <td class="w100">
            <input
            data-url="<?php echo base_url("Product/imagaIsActiveSet/$image->id")?>"
            type="checkbox"
            class="isActive"
            data-switchery
            data-color="#10c469"
            <?php echo ($image->isActive) ? "checked" : "" ; ?>
            />
          </td>
          <td class="w100">
            <input
            data-url="<?php echo base_url("Product/isCoverSet/$image->id/$image->product_id")?>"
            type="checkbox"
            class="isCover"
            data-switchery
            data-color="#ff5b5b"
            <?php echo ($image->isCover) ? "checked" : "" ; ?>
            />
          </td>
          <td class="w100">
            <button
            data-url="<?php echo base_url("Product/image_delete/$image->id/$image->product_id")?>"
            class="btn btn-sm btn-danger remove-btn">
            <i class="fa fa-trash">Sil</i>
          </button></td>
        </tr>
      <?php  } ?>

    </tbody>

  </table>
<?php }?>
