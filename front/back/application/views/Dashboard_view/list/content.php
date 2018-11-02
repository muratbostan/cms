<style>
.table tr {
  cursor: pointer;
}
.hiddenRow {
  padding: 0 4px !important;
  background-color: #eeeeee;
  font-size: 13px;
}
</style>


<script>
$('.accordian-body').on('show.bs.collapse', function () {
  $(this).closest("table")
  .find(".collapse.in")
  .not(this)
  .collapse('toggle')
})
</script>


<div class="row">
  <div class="col-md-12"> ,
    <div class="widget p-lg">
    <h3>Projenin Amacı </h3>
    <p> İçerik yönetim sistemi oluşturma,Önyüzde bulunan içerikleri ve ayarları yönetim sistemi ile dinamik olarak değiştirmek.  </p>
  </div>
      <div class="widget p-lg">
      <table class="table table-hover table-striped table-bordered" style="border-collapse:collapse;">
        <thead>
          <th>Panel Adı</th>
          <th>Bitirilme Oranı</th>
        </thead>
        <tbody>
          <?php foreach ($items as $item) { ?>
            <tr data-toggle="collapse" data-target="#demo<?php echo $item->id;?>" >
                <td><?php echo $item->panel_name ;?></td>
                <td>
                  <div class="progress progress-striped">
                      <div class="progress-bar progress-bar-danger"
                      role="progressbar" aria-valuenow="80"
                      aria-valuemin="0" aria-valuemax="100"
                      style="width: <?php echo $item->rate?>%">
                      <span><?php echo $item->rate?>% Complete </span>
                      </div>
                 </div>
                </td>
            </tr>
            <tr>
                <td colspan="6"  class="hiddenRow"><div id="demo<?php echo $item->id;?>"
                    class="accordian-body collapse"><?php echo $item->description;?></div>
                </td>
            </tr>
            <?php } ?>
        </tbody>
      </table>
    </div><!-- .widget -->
  </div><!-- END column -->
</div>
