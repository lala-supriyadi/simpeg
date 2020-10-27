<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Menu
    <small>Insert</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="<?php echo $current_context; ?>">Menu</a></li>
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
          <h3 class="box-title">Menu</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <form role="form" method="POST" enctype="multipart/form-data" class="form-horizontal">
            
			<div class="form-group <?php echo (form_error('parent_menu_id') != "") ? "has-error" : "" ?>">
					<label class="control-label col-md-2">Parent Menu</label>
					<div class="col-md-10">
					<select class="form-control select2me" name="parent_menu_id" data-placeholder="Pilih..." >
						<option>--Select--</option>
						<?php
						foreach($menu_list as $me){
							if($me->menu_id == set_value('parent_menu_id',$menu->parent_menu_id)){
								echo "<option value='$me->menu_id' selected>$me->menu_name</option>";
							} else {
								echo "<option value='$me->menu_id'>$me->menu_name</option>";
							}
						}
						?>
					</select>
					</div>
					<!--<input class="form-control mask_number" name="parent_menu_id" value="<?php echo set_value('parent_menu_id', $menu->parent_menu_id); ?>" placeholder="Men Menu Id"  maxlength=10>-->
				<?php echo form_error('parent_menu_id'); ?>
			</div>
			<div class="form-group <?php echo (form_error('menu_name') != "") ? "has-error" : "" ?>">
					<label class="control-label col-md-2">Nama Menu</label><div class="col-md-10"><input class="form-control " name="menu_name" value="<?php echo set_value('menu_name', $menu->menu_name); ?>" placeholder="Nama Menu"  required  maxlength=50></div>
				<?php echo form_error('menu_name'); ?>
			</div>
			<div class="form-group <?php echo (form_error('menu_link') != "") ? "has-error" : "" ?>">
					<label class="control-label col-md-2">Menu Link</label><div class="col-md-10"><input class="form-control " name="menu_link" value="<?php echo set_value('menu_link', $menu->menu_link); ?>" placeholder="Menu Link"  required  maxlength=100></div>
				<?php echo form_error('menu_link'); ?>
			</div>
			<div class="form-group <?php echo (form_error('menu_status') != "") ? "has-error" : "" ?>">
					<label class="control-label col-md-2">Status</label>
					<div class="col-md-10">
					<div class="radio">
			            <label>
			              <input type="radio" name="menu_status" value="1" <?php echo set_value('menu_status', ($menu->menu_status == '1') ? "checked" : ""); ?>> Aktif
			            </label>
			            <label>
			              <input type="radio" name="menu_status" value="0" <?php echo set_value('menu_status', ($menu->menu_status === '0') ? "checked" : ""); ?>> Tidak Aktif
			            </label>
			          </div>
			          </div>
					<!--<input class="form-control mask_number" name="menu_status" value="<?php //echo set_value('menu_status', ($menu->menu_status))?"Active":"Not Active"; ?>" placeholder="Menu Status"  required  maxlength=3>-->
				<?php echo form_error('menu_status'); ?>
			</div>
			<div class="form-group <?php echo (form_error('menu_ismaster') != "") ? "has-error" : "" ?>">
					<label class="control-label col-md-2">Menu Master</label><div class="col-md-10">
					<div class="radio">
			            <label>
			              <input type="radio" name="menu_ismaster" value="1" <?php echo set_value('menu_ismaster', ($menu->menu_ismaster == '1') ? "checked" : ""); ?>> Ya
			            </label>
			            <label>
			              <input type="radio" name="menu_ismaster" value="0" <?php echo set_value('menu_ismaster', ($menu->menu_ismaster === '0') ? "checked" : ""); ?>> Tidak
			            </label>
			          </div>
					<!--<input class="form-control mask_number" name="menu_ismaster" value="<?php echo set_value('menu_ismaster', $menu->menu_ismaster); ?>" placeholder="Menu Ismaster"  required  maxlength=3>-->
					</div>
				<?php echo form_error('menu_ismaster'); ?>
			</div>
			<!--<div class="form-group <?php echo (form_error('menu_order') != "") ? "has-error" : "" ?>">
					<label>Menu Order</label><input class="form-control mask_number" name="menu_order" value="<?php echo set_value('menu_order', $menu->menu_order); ?>" placeholder="Menu Order"  maxlength=10>
				<?php echo form_error('menu_order'); ?>
			</div>-->
            <div class="box-footer">
               <a href="<?php echo $current_context; ?>" class="btn btn-default">Batal</a>
               <button type="submit" class="btn btn-primary pull-right">Simpan</button>
            </div><!-- /.box-footer -->
          </form>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!--/.col (right) -->
  </div>   <!-- /.row -->
</section><!-- /.content -->