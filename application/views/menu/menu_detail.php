<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Menu
    <small>Detail</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="<?php echo $current_context; ?>">Menu</a></li>
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
          <h3 class="box-title">Menu</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
            
			<div class="form-group">
					<label>Men Menu Id:</label>
					<p><?php echo $menu->men_menu_id; ?></p>
			</div>
			<div class="form-group">
					<label>Menu Name:</label>
					<p><?php echo $menu->menu_name; ?></p>
			</div>
			<div class="form-group">
					<label>Menu Link:</label>
					<p><?php echo $menu->menu_link; ?></p>
			</div>
			<div class="form-group">
					<label>Menu Status:</label>
					<p><?php echo $menu->menu_status; ?></p>
			</div>
			<div class="form-group">
					<label>Menu Ismaster:</label>
					<p><?php echo $menu->menu_ismaster; ?></p>
			</div>
			<div class="form-group">
					<label>Menu Order:</label>
					<p><?php echo $menu->menu_order; ?></p>
			</div>
			<div class="form-group">
					<label>Created At:</label>
					<p><?php echo $menu->created_at; ?></p>
			</div>
			<div class="form-group">
					<label>Updated At:</label>
					<p><?php echo $menu->updated_at; ?></p>
			</div>
            <div class="box-footer">
               <a href="<?php echo $current_context; ?>" class="btn btn-default">Back</a>
               <!-- <a href="<?php echo $current_context .'edit' ; ?>" class="btn btn-primary pull-right">Edit</a> -->
            </div><!-- /.box-footer -->
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!--/.col (right) -->
  </div>   <!-- /.row -->
</section><!-- /.content