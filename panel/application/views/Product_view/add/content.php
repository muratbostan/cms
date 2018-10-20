<div class="row">
  <div class="col-md-12">
    <h4>Yeni Ürün Eklem Menüsü </h4>
  </div>
  <div class="col-md-12">
    <div class="widget">
      <header class="widget-header">
        <h4 class="widget-title">Basic Example</h4>
      </header><!-- .widget-header -->
      <hr class="widget-separator">
      <div class="widget-body">
        <form action="<?php echo base_url("product/saved") ?>" method="POST">
          <div class="form-group">
            <label>Başlık</label>
            <input class="form-control" placeholder="Başlık" name="title">
          </div>
          <?php if(isset($form_error)) { ?>
          <div class="alert alert-danger text-center" role="alert">
           <span>Başık Alanını Doldurunuz.</span>
          </div>
        <?php } else { }?>
          <div class="form-group">
            <label>Açıklama</label>
            <textarea  name="description" class="m-0" data-plugin="summernote" data-options="{height: 250}" style="display: none;"></textarea>
          </div>
          <button type="submit" class="btn btn-primary btn-md">Kaydet</button>
          <a href="<?php echo base_url("product") ?>" class="btn btn-danger">İptal</a>
        </form>
      </div><!-- .widget-body -->
    </div><!-- .widget -->
  </div>
</div>
