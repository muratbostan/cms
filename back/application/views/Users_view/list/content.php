<div class="row">
  <div class="col-md-12">
    <h4 class="m-b-lg">
      Kullanıcı Listesi
      <a href="<?php echo base_url("Users/add_Users"); ?>"
        class="btn btn-outline btn-primary btn-xs pull-right"> <i class="fa fa-plus"></i> Yeni Ekle</a>
    </h4>
  </div><!-- END column -->
  <div class="col-md-12">
    <div class="widget p-lg">
      <?php if(empty($items)) { ?>
        <div class="alert alert-info text-center">
          <p>Burada herhangi bir veri bulunmamaktadır. Eklemek için lütfen
            <a href="<?php echo base_url("Users/add_Users"); ?>">tıklayınız</a></p>
        </div>

      <?php } else { ?>

        <table class="table table-hover table-striped table-bordered content-container">
          <thead>
            <th class="order"><i class="fa fa-reorder"></i></th>
            <th class="w50">#id</th>
            <th>Kullanıcı Adı</th>
            <th>Ad Soyıad</th>
            <th>E-posta</th>
            <th>Durumu</th>
            <th>İşlem</th>
          </thead>
          <tbody>

            <?php foreach($items as $item) { ?>

              <tr>
                <td class="order"><i class="fa fa-reorder"></i></td>
                <td class="w50 text-center">#<?php echo $item->id; ?></td>
                <td><?php echo $item->user_name; ?></td>
                <td><?php echo $item->full_name; ?></td>
                <td class=" w100"><?php echo $item->email; ?> </td>
                <td class="text-center w100">
                  <input
                  data-url="<?php echo base_url("Users/isActiveSet/$item->id"); ?>"
                  class="isActive"
                  type="checkbox"
                  data-switchery
                  data-color="#10c469"
                  <?php echo ($item->isActive) ? "checked" : ""; ?>
                  />
                </td>
                <td class="text-center w300">
                  <button
                      data-url="<?php echo base_url("users/delete_Users/$item->id"); ?>"
                      class="btn btn-sm btn-danger btn-outline remove-btn">
                      <i class="fa fa-trash"></i> Sil
                  </button>
                <a href="<?php echo base_url("Users/update_Users/$item->id"); ?>"
                  class="btn btn-sm btn-info btn-outline"><i class="fa fa-pencil-square-o"></i> Düzenle</a>
                  <a href="<?php echo base_url("Users/update_password_form/$item->id"); ?>"
                    class="btn btn-sm btn-purple btn-outline"><i class="fa fa-key"></i>Şifre Değiş</a>
                  </td>
                </tr>

              <?php } ?>

            </tbody>

          </table>

        <?php } ?>

      </div><!-- .widget -->
    </div><!-- END column -->
  </div>
