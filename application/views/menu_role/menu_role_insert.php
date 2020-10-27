<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Menu Role
    <small>Insert</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="<?php echo $current_context; ?>">Menu Role</a></li>
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
          <h3 class="box-title">Menu Role</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <form role="form" method="POST" enctype="multipart/form-data">
            
			<div class="form-group <?php echo (form_error('role_id') != "") ? "has-error" : "" ?>">
					<label>Role Id</label><input class="form-control mask_number" name="role_id" value="<?php echo set_value('role_id', $menu_role->role_id); ?>" placeholder="Role Id"  required  maxlength=10>
				<?php echo form_error('role_id'); ?>
			</div>
			<div class="form-group <?php echo (form_error('menu_id') != "") ? "has-error" : "" ?>">
					<label>Menu Id</label><input class="form-control mask_number" name="menu_id" value="<?php echo set_value('menu_id', $menu_role->menu_id); ?>" placeholder="Menu Id"  required  maxlength=10>
				<?php echo form_error('menu_id'); ?>
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