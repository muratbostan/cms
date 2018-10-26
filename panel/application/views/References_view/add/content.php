<div class="row">
  <div class="col-md-12">
    <h4>Referans Ekle </h4>
  </div>
  <div class="col-md-12">
    <div class="widget">
      <hr class="widget-separator">
      <div class="widget-body">
        <form action="<?php echo base_url("References/saved") ?>" method="POST" enctype="multipart/form-data">
          <div class="form-group">
            <label>Başlık</label>
            <input class="form-control" placeholder="Başlık" name="title">
            <?php if(isset($form_error)){ ?>
              <small class="pull-right input-form-error"> <?php echo form_error("title"); ?></small>
            <?php } ?>
          </div>
          <div class="form-group">
            <label>Açıklama</label>
            <textarea  name="description" class="m-0" data-plugin="summernote"
            data-options="{height: 250}" style="display: none;"></textarea>
          </div>
            <div class="form-group image_upload_con">
              <label>Görsel Seçiniz</label>
              <input type="file" name="img_url" class="form-control">
            </div>
          <button type="submit" class="btn btn-primary btn-md">Kaydet</button>
          <a href="<?php echo base_url("References") ?>" class="btn btn-danger">İptal</a>
        </form>
      </div><!-- .widget-body -->
    </div><!-- .widget -->
  </div>
</div>
