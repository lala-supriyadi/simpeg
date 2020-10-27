<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Menu Role
    <small>Detail</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="<?php echo $current_context; ?>">Menu Role</a></li>
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
          <h3 class="box-title">Menu Role</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
            
			<div class="form-group">
					<label>Role Id:</label>
					<p><?php echo $menu_role->role_id; ?></p>
			</div>
			<div class="form-group">
					<label>Menu Id:</label>
					<p><?php echo $menu_role->menu_id; ?></p>
			</div>
            <div class="box-footer">
               <a href="<?php echo $current_context; ?>" class="btn btn-default">Back</a>
               <!-- <a href="<?php echo $current_context .'edit'  .'/'. $menu_role->role_id .'/'. $menu_role->menu_id; ?>" class="btn btn-primary pull-right">Edit</a> -->
            </div><!-- /.box-footer -->
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!--/.col (right) -->
  </div>   <!-- /.row -->
</section><!-- /.content -->