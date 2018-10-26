<div class="row">
  <div class="col-md-12">
    <h4>Yeni Galeri Ekleme Menüsü </h4>
  </div>
  <div class="col-md-12">
    <div class="widget">
      <hr class="widget-separator">
      <div class="widget-body">
        <form action="<?php echo base_url("galleries/saved") ?>" method="POST">
          <div class="form-group">
            <label>Galeri Adı</label>
            <input class="form-control" placeholder="Galeri Adını Giriniz" name="title">
          </div>
          <?php if(isset($form_error)) { ?>
            <div class="alert alert-danger text-center" role="alert">
              <span class="pull-right input-form-error"><?php echo $form_error("title") ?> </span>
            </div>
          <?php }?>
          <div class="form-group">
            <label for="control-demo-6" class="col-sm-3">Haberin Türü</label>
            <div id="control-demo-6" class="col-sm-9">
              <select class="form-control " name="gallery_type">
                <option <?php echo (isset($gallery_type) && $gallery_type=="image") ? "selected":"" ; ?> value="image">Resim</option>
                <option <?php echo (isset($gallery_type) && $gallery_type=="video") ? "selected":"" ; ?> value="video">video</option>
                <option <?php echo (isset($gallery_type) && $gallery_type=="file") ? "selected":"" ; ?> value="file">Dosya</option>
              </select>
            </div>
          </div>

          <button type="submit" class="btn btn-primary btn-md">Kaydet</button>
          <a href="<?php echo base_url("galleries") ?>" class="btn btn-danger">İptal</a>
        </form>
      </div><!-- .widget-body -->
    </div><!-- .widget -->
  </div>
</div>
