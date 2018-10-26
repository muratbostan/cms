<div class="row">
  <div class="col-md-12">
    <h4> Yeni Eğitim Ekle </h4>
  </div>
  <div class="col-md-12">
    <div class="widget">
      <hr class="widget-separator">
      <div class="widget-body">
        <form action="<?php echo base_url("Courses/saved") ?>" method="POST" enctype="multipart/form-data">
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
          <div class="row" >
            <div class="col-md-4">
              <label for="datetimepicker1">Eğitim Tarihi</label>
              <input type="hidden" name="event_date" id="datetimepicker1" data-plugin="datetimepicker"
              data-options="{ inline: true, viewMode: 'days',format: 'YYYY-MM-DD HH:mm:ss' }"/>

            </div><!-- END column -->
            <div class="form-group image_upload_con col-md-8">
              <label>Görsel Seçiniz</label>
              <input type="file" name="img_url" class="form-control">
            </div>
          </div>

          <button type="submit" class="btn btn-primary btn-md">Kaydet</button>
          <a href="<?php echo base_url("Courses") ?>" class="btn btn-danger">İptal</a>
        </form>
      </div><!-- .widget-body -->
    </div><!-- .widget -->
  </div>
</div>
