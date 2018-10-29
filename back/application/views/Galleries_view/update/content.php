<div class="row">
  <div class="col-md-12">
    <h4><?php echo "<b> $item->title </b> Ürününü düzenliyorsunuz." ?> </h4>
  </div>
  <div class="col-md-12">
    <div class="widget">
      <hr class="widget-separator">
      <div class="widget-body">
        <form action="<?php echo base_url("galleries/update/$item->id/$item->gallery_type/$item->folder_name") ?>" method="POST">
          <div class="form-group">
            <label>Galeri Adı</label>
            <input class="form-control" placeholder="Galerinizin adını giriniz.." name="title" value="<?php echo $item->title;?>">
          </div>
          <?php if(isset($form_error)) { ?>
            <div class="alert alert-danger text-center" role="alert">
              <span class="pull-right input-form-error"><?php echo $form_error("title") ?> </span>
            </div>
          <?php }?>
        <button type="submit" class="btn btn-primary btn-md">Kaydet</button>
        <a href="<?php echo base_url("galleries") ?>" class="btn btn-danger">İptal</a>
      </form>
    </div><!-- .widget-body -->
  </div><!-- .widget -->
</div>
</div>
