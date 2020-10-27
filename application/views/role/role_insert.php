<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Jabatan
    <small>Insert</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="<?php echo $current_context; ?>">Jabatan</a></li>
    <li class="active">Insert</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <?php
        $message = $this->session->flashdata('message');
        $type_message = $this->session->flashdata('type_message');
        echo (!empty($message) && $type_message=="success") ? ' <div class="col-md-12" id="data-alert-box"><div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times</button><strong>Berhasil! </strong>'.$message.'</div></div>': '';
        echo (!empty($message) && $type_message=="error") ? '   <div class="col-md-12" id="data-alert-box"><div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times</button><strong>Error! </strong>'.$message.'</div></div>': '';
    ?>
    <!-- right column -->
    <div class="col-md-12">
      <!-- general form elements disabled -->
      <div class="box box-warning">
        <div class="box-header with-border">
          <h3 class="box-title">Jabatan</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <form role="form" method="POST" enctype="multipart/form-data" class="form-horizontal">
            
			<div class="form-group <?php echo (form_error('role_name') != "") ? "has-error" : "" ?>">
					<label class="control-label col-md-2">Jabatan</label>
          <div class="col-md-10">
            <input class="form-control " name="role_name" value="<?php echo set_value('role_name', $role->role_name); ?>" placeholder="Jabatan"  required  maxlength=50>
          </div>
				<?php echo form_error('role_name'); ?>
			</div>
			<div class="form-group <?php echo (form_error('role_status') != "") ? "has-error" : "" ?>">
					<label class="control-label col-md-2">Status</label>
          <div class="col-md-10">
            <div class="radio">
              <label>
                <input type="radio" name="role_status" value="1" <?php echo set_value('role_status', ($role->role_status == '1') ? "checked" : ""); ?>> Aktif
              </label>
              <label>
                <input type="radio" name="role_status" value="0" <?php echo set_value('role_status', ($role->role_status === '0') ? "checked" : ""); ?>> Tidak Aktif
              </label>
            </div>
          </div>
          <!--<input class="form-control mask_number" name="role_status" value="<?php echo set_value('role_status', $role->role_status); ?>" placeholder="Role Status"  required  maxlength=3>-->
				<?php echo form_error('role_status'); ?>
			</div>
			<div class="form-group <?php echo (form_error('role_canlogin') != "") ? "has-error" : "" ?>">
					<label class="control-label col-md-2">Dapat Login</label>
          <div class="col-md-10">
          <div class="radio">
            <label>
              <input type="radio" name="role_canlogin" value="1" <?php echo set_value('role_canlogin', ($role->role_canlogin == '1') ? "checked" : ""); ?>> Ya
            </label>
            <label>
              <input type="radio" name="role_canlogin" value="0" <?php echo set_value('role_canlogin', ($role->role_canlogin === '0') ? "checked" : ""); ?>> Tidak
            </label>
          </div>
          </div>
          <!--<input class="form-control mask_number" name="role_canlogin" value="<?php echo set_value('role_canlogin', $role->role_canlogin); ?>" placeholder="Role Canlogin"  required  maxlength=3>-->
				<?php echo form_error('role_canlogin'); ?>
			</div>
			<div class="form-group">
      <table>
        <tr>
          <td valign="top" width="200px"><label class="control-label col-md-2">Menu Yang dapat diakses : </label></td>
          <td><div class="checkbox-list">
          <?php
            if (!empty($menu)) {
              foreach ($menu as $parent) {
                $ac_menu = array_search($parent->menu_id, $active_menu);
                ?>
                <ul class="list-unstyled parent-menu">
                  <li><label>
                    <input type="checkbox" class="group-check" name="parent[]" value="<?php echo $parent->menu_id; ?>" <?php echo (($edit) ? ((!empty($ac_menu) || $ac_menu === 0) ? "checked" : "") : ""); ?>>
                    <b><?php echo $parent->menu_name; ?></b></label>
                <?php
                if (!empty($parent->submenu)) {
                  echo "<ul class='list-unstyled child-menu'>";
                  foreach ($parent->submenu as $child) {
                    $ac_child = array_search($child->menu_id, $active_menu);
                    ?>
                    <li>
                      <input type="checkbox" class="group-check-sec" name="child[]" value="<?php echo $child->menu_id; ?>" <?php echo (($edit) ? ((!empty($ac_child) || $ac_child === 0) ? "checked" : "") : "") ?>>
                      <?php echo $child->menu_name; ?>
                    <?php
                    if (!empty($child->subsubmenu)) {
                      echo "<ul class='list-unstyled grand-menu'>";
                      foreach ($child->subsubmenu as $grandchild) {
                        $ac_grandchild = array_search($grandchild->menu_id, $active_menu);
                        ?>
                      <li><input type="checkbox" class="check-menu" name="grandchild[]" value="<?php echo $grandchild->menu_id; ?>" <?php echo (($edit) ? ((!empty($ac_grandchild) || $ac_grandchild === 0) ? "checked" : "") : "") ?>><?php echo $grandchild->menu_name; ?></li>
                        <?php
                      } echo "</ul>";
                    } echo "</li>";
                  } echo "</ul>";
                } echo "</li></ul>";
              }
            }
            ?>
          
          <?php //echo form_error('role_canlogin'); ?>
          </div></td>

        </tr>
      </table> 
      </div>
            <div class="box-footer">
               <a href="<?php echo $current_context; ?>" class="btn btn-default">Cancel</a>
               <button type="submit" class="btn btn-primary pull-right">Save</button>
            </div><!-- /.box-footer -->
          </form>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!--/.col (right) -->
  </div>   <!-- /.row -->
</section><!-- /.content -->