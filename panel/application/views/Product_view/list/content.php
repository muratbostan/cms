<div class="row">
    <div class="col-md-12">
        <h4>Ürün Listesi
        <a href="#" class="btn pull-right btn-outline btn-primary btn-xs "><i class="fa fa-plus"></i>Yeni Ekle</a>
      </h4>
    </div>
  <div class="col-md-12">
  				<div class="widget p-lg">
            <?php if(empty($items)) { ?>
            <div class="alert alert-info text-center" role="alert">
             <span>Kayıt Bulunamadı.Eklemek için lütfen</span>
             <a href="#" class="alert-link">Tıklayın</a>
            </div>
          <?php } else { ?>
   					<table class="table table-hover table-striped">
            <thead>
              <th>#id</th>
              <th>url</th>
              <th>Başlık</th>
              <th>Açıklama</th>
              <th>Durumu</th>
              <th>İşlem</th>
            </thead>
            <tbody>
            <?php foreach ($items as $items) { ?>
              <tr>
                  <td><?php echo $items->id ?></td>
                  <td><?php echo $items->url?></td>
                  <td><?php echo $items->title ?></td>
                  <td><?php echo $items->description ?></td>
                  <td>
                  <input  type="checkbox"
                          data-switchery
                          data-color="#10c469"
                          <?php echo ($items->isActive) ? "checked" : "" ; ?>
                  />
                </td>
                  <td>
                    <a href="#" class="btn btn-sm btn-danger  "><i class="fa fa-trash">Sil</i></a>
                    <a href="#" class="btn btn-sm btn-info "><i class="fa fa-pencil-square-o">Düzenle</i></a>
                  </td>
              </tr>
            <?php } ?>
            </tbody>
           </table>
         <?php } ?>
  				</div><!-- .widget -->
  </div>
</div>
