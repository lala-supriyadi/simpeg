<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Jabatan
    <small>Detail</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="<?php echo $current_context; ?>">Jabatan</a></li>
    <li class="active">Detail</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <!-- right column -->
    <div class="col-md-12">
      <!-- general form elements disabled -->
      <div class="box box-warning">
        <div class="box-header with-border">
          <h3 class="box-title">Jabatan</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
            
			<div class="form-group">
					<label>Nama:</label>
					<p><?php echo $role->role_name; ?></p>
			</div>
			<div class="form-group">
					<label>Status:</label>
					<p><?php echo ($role->role_status == '1')?"Aktif":"Tidak Aktif"; ?></p>
			</div>
			<div class="form-group">
					<label>Dapat Login:</label>
					<p><?php echo ($role->role_canlogin == '1')?"Ya":"Tidak"; ?></p>
			</div>
      <div class="form-group">
          <label>Menu yang dapat diakses:</label>
          <div class="table-responsive">
              <table class="table table-hover table-bordered">
                <thead>
                <th class="table-number">No</th>
                <th>Nama Menu</th>
                <th>Nama Sub Menu</th>
                <th>Nama Sub Sub Menu</th>
                </thead>
                <tbody>
                  <?php
                  if (empty($menu)) {
                    ?>
                    <tr><td colspan="4">Tidak Ada Menu</td></tr>
                    <?php
                  } else {
                    $i = 1;
                    foreach ($menu as $parent) {
                      ?>
                      <tr>
                        <td><?php echo $i ?></td>
                        <td><?php echo $parent->menu_name; ?></td>
                        <?php
                        if (!empty($parent->submenu)) {
                          $j = 0;
                          foreach ($parent->submenu as $child) {
                            if ($j > 0) {
                              $i++;
                              echo "</tr><tr>" .
                              "<td>" . $i . "</td>" .
                              "<td>" . $parent->menu_name . "</td>";
                            }
                            ?>
                            <td><?php echo $child->menu_name; ?></td>
                            <?php
                            if (!empty($child->subsubmenu)) {
                              $k = 0;
                              foreach ($child->subsubmenu as $grandchild) {
//                                                                            print_r($grandchild);
                                if ($k > 0) {
                                  $i++;
                                  echo "</tr><tr>" .
                                  "<td>" . $i . "</td>" .
                                  "<td>" . $parent->menu_name . "</td>" .
                                  "<td>" . $child->menu_name . "</td>";
                                }
                                ?>
                                <td><?php echo $grandchild->menu_name; ?></td>
                                <?php
                                $k++;
                              }
                            } else {
                              echo "<td></td>";
                            }
                            $j++;
                          }
                        } else {
                          echo "<td></td><td></td>";
                        }
                        ?>
                      </tr>
                      <?php
                      $i++;
                    }
                  }
                  ?>
                </tbody>
              </table>
            </div>
      </div>
            <div class="box-footer">
               <a href="<?php echo $current_context; ?>" class="btn btn-default">Back</a>
               <!-- <a href="<?php echo $current_context .'edit/'.$role->role_id ; ?>" class="btn btn-primary pull-right">Edit</a> -->
            </div><!-- /.box-footer -->
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!--/.col (right) -->
  </div>   <!-- /.row -->
</section><!-- /.content