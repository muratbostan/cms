<div class="row">
  <div class="col-md-12">
    <h4><?php echo "<b> $item->title </b> Ürününü düzenliyorsunuz." ?> </h4>
  </div>
  <div class="col-md-12">
    <div class="widget">
      <hr class="widget-separator">
      <div class="widget-body">
        <form action="<?php echo base_url("References/update/$item->id") ?>" method="POST" enctype="multipart/form-data">
          <div class="form-group">
            <label>Başlık</label>
            <input class="form-control" placeholder="Başlık" name="title" value="<?php echo $item->title;?>">
            <?php if(isset($form_error)){ ?>
              <small class="pull-right input-form-error"> <?php echo form_error("title"); ?></small>
            <?php } ?>
          </div>

          <div class="form-group">
            <label>Açıklama</label>
            <textarea  name="description" class="m-0"
            data-plugin="summernote"
            data-options="{height: 250}"
            style="display: none;">
            <?php echo $item->description ?>
          </textarea>
        </div>

          <div class="row">
            <div class="col-md-1 image_upload_con">
              <img src="<?php echo base_url("uploads/$viewFolder/$item->img_url") ?>" alt="" class="img-responsive">
            </div>
            <div class="col-md-9">
              <div class="form-group image_upload_con" >
                <label>Görsel Seçiniz</label>
                <input type="file" name="img_url" class="form-control">
              </div>
            </div>
          </div>
        <button type="submit" class="btn btn-primary btn-md">Güncelle</button>
        <a href="<?php echo base_url("References") ?>" class="btn btn-danger">İptal</a>
      </form>
    </div><!-- .widget-body -->
  </div><!-- .widget -->
</div>
</div>
