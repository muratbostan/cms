<div class="row">
  <div class="col-md-12">
    <h4>Ürün Fotoğrafları
      <a href="<?php echo base_url("Product") ?>"
        class="btn pull-right btn-outline btn-primary btn-xs "><i class="fa fa-plus"></i>Ürün Listesi</a>
      </h4>
    </div>
    <div class="col-md-12">
      <div class="widget">
        <header class="widget-header">
          <h4 class="widget-title">Dropzone</h4>
        </header><!-- .widget-header -->
        <hr class="widget-separator">
        <div class="widget-body ">
          <form data-url="<?php echo base_url("product/reflesh_image_list/$item->id")?>"  action="<?php echo base_url("Product/image_upload/$item->id") ?>"
           id="dropzone"  class="dropzone"  data-plugin="dropzone"
            data-options="{ url: '<?php echo base_url("Product/image_upload/$item->id") ?>'}">
            <div class="dz-message">
              <h3 class="m-h-lg">Drop files here or click to upload.</h3>
              <p class="m-b-lg text-muted">Yüklemek için dosyalarınızı sürükleyin ya da bu alana tıklayın.</p>
            </div>
          </form>
        </div><!-- .widget-body -->
      </div><!-- .widget -->
    </div><!-- END column -->
  </div>

  <div class="row">
    <div class="col-md-12">
      <h4><strong><?php echo $item->title; ?></strong> Kaydına Ait Resimler
      </h4>
    </div>
    <div class="col-md-12">
      <div class="widget">
        <hr class="widget-separator">
        <div class="widget-body image-list-container">
          <?php $this->load->view("{$viewFolder}/{$subViewFolder}/render_elements/images_list_v");?>
    </div><!-- .widget -->
  </div><!-- END column -->
</div>
