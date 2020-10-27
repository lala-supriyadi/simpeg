<?php
    error_reporting(0);
    $query=$this->db->query("SELECT * FROM karyawan WHERE updated_status='1' AND DAY(updated_at) = DAY(NOW())");
    $jum_notif=$query->num_rows();
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SIMPEG</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- <link rel="shortcut icon" href="<?php echo base_url() ?>assets/images/prima.png" /> -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datepicker/datepicker3.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/timepicker/bootstrap-timepicker.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datetimepicker/bootstrap-datetimepicker.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/toastr/build/toastr.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables/jquery.dataTables.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/select2/dist/css/select2.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/AdminLTE.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/app.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/skins/_all-skins.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/ionicons/css/ionicons.css">
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/uniform/css/uniform.default.min.css"> -->
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

      <header class="main-header">
  <a href="<?php echo base_url(); ?>" class="logo">
    <span class="logo-lg"><b>SIMPEG</b></span>
  </a>

  <nav class="navbar navbar-static-top" role="navigation">
  <!-- Sidebar toggle button-->
  <a href="<?php echo base_url(); ?>assets/#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
    <span class="sr-only">Toggle navigation</span>
  </a>
  <!-- Navbar Right Menu -->
  <div class="navbar-custom-menu">
    <ul class="nav navbar-nav">

      <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-success"><?php echo $jum_notif;?></span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">Anda memiliki <?php echo $jum_notif;?> pemberitahuan</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                <?php
                    $notif=$this->db->query("SELECT karyawan.*,DATE_FORMAT(updated_at,'%d %M %Y') AS tanggal, updated_by AS orang FROM karyawan WHERE updated_status = '1' AND DAY(updated_at) = DAY(NOW()) ORDER BY id_karyawan DESC LIMIT 10");
                    foreach ($notif->result_array() as $not) :
                        $id_karyawan=$not['id_karyawan'];
                        $nip=$not['nip'];
                        $nama_karyawan=$not['nama_karyawan'];
                        $updated_at=$not['updated_at'];
                        $updated_by=$not['updated_by'];
                        $foto=$not['foto'];
                ?>
                  <li><!-- start notif -->
                      <a href="<?php echo base_url() . 'karyawan' . '/' . 'detail' . '/' . $id_karyawan ?>">
                      <div class="pull-left">
                        <img src="<?php echo base_url() ?>./upload/karyawan_foto/<?php echo $foto ?>" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        <small><i class="fa fa-clock-o"></i> <?php echo $updated_at;?></small>
                      </h4>
                      <p>Data karyawan <b><?php echo $nama_karyawan;?></b></p>
                      
                      <p> telah di ubah oleh <?php echo $updated_by;?></b></p>
                      <p>pada <?php echo $updated_at;?></p>
                    </a>
                  </li>
                  <!-- end notif -->
                  <?php endforeach;?>
                </ul>
              </li>
              <li class="footer"><a href="<?php echo base_url().'karyawan/'?>">Lihat Pemberitahuan</a></li>
            </ul>
          </li>

      <!-- <li class="dropdown notifications-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-bell-o"></i>
                  <span class="label label-warning"></span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header"><?php echo $notif_user->jumlah_update; ?></li>
                  <li>
                    <ul class="menu">
                      <li>
                        <a href="#">
                          <i class="fa fa-users text-aqua"></i> 5 new members joined today
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the page and may cause design problems
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <i class="fa fa-users text-red"></i> 5 new members joined
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <i class="fa fa-user text-red"></i> You changed your username
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li class="footer"><a href="#">View all</a></li>
                </ul>
              </li> -->
      
      <!-- User Account Menu -->
      <li class="dropdown user user-menu">
        <!-- Menu Toggle Button -->
        <a href="<?php echo base_url(); ?>assets/#" class="dropdown-toggle" data-toggle="dropdown">
          <!-- The user image in the navbar-->
          <!-- <img src="<?php echo base_url(); ?>assets/images/SIMPEG.jpg" class="user-image" alt="User Image"> -->
          <!-- hidden-xs hides the username on small devices so only the image appears. -->
          <span class="hidden-xs"><?php echo $login_user->username; ?></span>
        </a>
        <ul class="dropdown-menu">
          <!-- The user image in the menu -->
          <li class="user-header">
            <img src="<?php echo base_url() ?>./upload/user_photo/<?php echo $login_user->gambar ?>" class="img-circle" alt="User Image">

            <p>
              <?php echo $login_user->username; ?> - <?php echo $login_user->role_name; ?>
              <!-- <small>Member since Sep. 2020</small> -->
            </p>
          </li>
          <!-- Menu Footer-->
          <li class="user-footer">
            <div class="pull-left">

                <a href="<?php echo base_url('user/update'); ?>" class="btn btn-default btn-flat">Setting</a>
              
            </div>
            <div class="pull-right">
              <a href="<?php echo base_url('auth/logout'); ?>" class="btn btn-default btn-flat">Sign out</a>
            </div>
          </li>
        </ul>
      </li>
    </ul>
  </div>
</nav>
        <!-- Header Navbar: style can be found in header.less -->
        <!-- nav --> 
</header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar" style="margin-top: -50px">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

    <a href="<?php echo base_url(); ?>dashboard" class="logo" style="height:100px" >
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini">
          </span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg">
            <center><img src="<?php echo base_url() ?>./upload/user_photo/<?php echo $login_user->gambar ?>" width="700px" class="img-responsive"></center>
            <h5><?php echo $login_user->username; ?></h5>
            <h6>Level : <?php echo $login_user->role_name; ?></h6>
          </span>
        </a>

          <!-- Sidebar user panel -->
          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <?php if (!empty($menu_trans)): ?>
              <li class="header">MAIN NAVIGATION</li>
            <?php endif ?>
            <?php
                foreach ($menu_trans as $menu) {
                  $fa = '';
                        switch ($menu->menu_name) {
                            case 'Dashboard':
                                $fa = 'fa-home';
                                break;        
                            default:
                                $fa = 'fa-th';
                                break;
                        }
                    ?>
                    <li class="treeview <?php echo ($current_menu == $menu->menu_link)?"active":""; ?>">
                      <a href="<?php echo base_url() . $menu->menu_link ?>">
                        <i class="fa <?php echo $fa; ?>"></i> <span><?php echo $menu->menu_name ?></span> <?php echo (!empty($menu->submenu))?'<i class="fa fa-angle-left pull-right"></i>':''; ?>
                      </a>
                    <?php
                    if(!empty($menu->submenu)){
                      ?>
                      <ul class="treeview-menu">
                        <?php
                        foreach ($menu->submenu as $submenu) {
                            ?>
                            <li class="<?php echo ($submenu->menu_link == $current_menu)?"active":"";?>">
                                <a href="<?php echo base_url() . $submenu->menu_link ?>"><i class="fa fa-circle-o"></i><?php echo $submenu->menu_name ?></a>
                            </li>
                            <?php
                        }
                        ?>
                      </ul>
                      <?php
                    }
                    ?>
                    </li>
                    <?php
                }
            ?>
            <?php if (!empty($menu_master)): ?>
              <li class="header">DATA MASTER</li>  
            <?php endif ?>
            
            <?php
                foreach ($menu_master as $menu) {
                  $fa = '';
                        switch ($menu->menu_name) {
                            case 'Data Karyawan':
                                $fa = 'fa fa-users';
                                break;
                            case 'Gaji Karyawan':
                                $fa = 'fa fa-usd';
                                break;    
                            case 'Penempatan':
                                $fa = 'fa fa-user';
                                break;
                            case 'Divisi':
                                $fa = 'fa fa-book';
                                break;
                            case 'Data Referensi':
                                $fa = 'fa fa-sticky-note';
                                break;          
                            case 'Logout':
                                $fa = 'fa-sign-out';
                                break;                   
                            default:
                                $fa = 'fa-th';
                                break;
                        }
                    ?>
                    <li class="treeview <?php echo ($current_menu == $menu->menu_link)?"active":""; ?>">
                      <a href="<?php echo base_url() . $menu->menu_link ?>">
                        <i class="fa <?php echo $fa; ?>"></i> <span><?php echo $menu->menu_name ?></span> <?php echo (!empty($menu->submenu))?'<i class="fa fa-angle-left pull-right"></i>':''; ?>
                      </a>
                    <?php
                    if(!empty($menu->submenu)){
                      ?>
                      <ul class="treeview-menu">
                        <?php
                        foreach ($menu->submenu as $submenu) {
                            ?>
                            <li class="<?php echo ($submenu->menu_link == $current_menu)?"active":"";?>">
                                <a href="<?php echo base_url() . $submenu->menu_link ?>"><i class="fa fa-circle-o"></i><?php echo $submenu->menu_name ?></a>
                            </li>
                            <?php
                        }
                        ?>
                      </ul>
                      <?php
                    }
                    ?>
                    </li>
                    <?php
                }
            ?>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <?php echo $_content; ?>
      </div><!-- /.content-wrapper -->
      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b></b> 
        </div>
        <strong>Copyright &copy; 2020. SIMPEG.</strong> All rights reserved.
      </footer>
    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url(); ?>assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/select2/dist/js/select2.min.js"></script>
    <!-- Slimscroll -->
    <script src="<?php echo base_url(); ?>assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo base_url(); ?>assets/plugins/fastclick/fastclick.min.js"></script>
    <!-- Datepicker -->
    <script src="<?php echo base_url(); ?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/datetimepicker/moment.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/datetimepicker/bootstrap-datetimepicker.min.js"></script>
    <!-- Timepicker -->
    <script src="<?php echo base_url(); ?>assets/plugins/timepicker/bootstrap-timepicker.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url(); ?>assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/toastr/toastr.js"></script>
    <script src="<?php echo base_url(); ?>assets/dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <!-- <script src="<?php echo base_url(); ?>assets/dist/js/demo.js"></script> -->
    <!-- <script src="<?php echo base_url(); ?>assets/plugins/uniform/jquery.uniform.min.js"></script> -->
    <!-- <script src="<?php echo base_url(); ?>assets/dist/js/template.js"></script> -->
    <?php
    if($page_title == "Dashboard"){
        ?>
        <!-- Sparkline -->
        <script src="<?php echo base_url(); ?>assets/plugins/sparkline/jquery.sparkline.min.js"></script>
        <!-- jvectormap -->
        <script src="<?php echo base_url(); ?>assets/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
        <!-- ChartJS 1.0.1 -->
        <script src="<?php echo base_url(); ?>assets/plugins/chartjs/Chart.min.js"></script>
        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <script src="<?php echo base_url(); ?>assets/dist/js/pages/dashboard2.js"></script>
        <?php
    }
    ?>
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Delete Data?</h4>
                </div>
                <div class="modal-body">
                    Do you want to delete this data?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-danger danger">Yes</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteAll" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Delete Data?</h4>
                </div>
                <div class="modal-body">
                    Do you want to delete selected data?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-danger danger2">Yes</button>
                </div>
            </div>
        </div>
    </div>
    
    <script>
      jQuery(document).ready(function() {    
         // initiate layout and plugins
        $('#deleteModal').on('show.bs.modal', function(e) {
            $(this).find('.danger').attr('onclick', 'location.href=\"' + $(e.relatedTarget).data('href') + '\"');
        });
        $('#deleteAll').on('show.bs.modal', function (e) {
            $(this).find('.danger2').attr('onclick', 'go_delete(\"' + $(e.relatedTarget).data('href') + '\")');
        });
         $(".timepicker").timepicker({
          showInputs: false
        });
         $(".datepicker").datepicker({
          showInputs: false,
          format:'yyyy-mm-dd'
        });
         $(".datetimepicker").datetimepicker({
          format:'YYYY-MM-DD LT',
        });
        $(".select2me").select2({
        });
        $(".select-nosearch").select2({
            minimumResultsForSearch: -1
        });
        $('select:not(.select2me)').select2({
          minimumResultsForSearch: -1
        });

        $('#add_member_form').validate({
            rules: {
                "member_name": {
                    required: true
                },
                "member_gender": {
                    required: true
                },
                "member_address": {
                    required: true
                },
                "member_contact": {
                    required: true,
                    digits: true
                }
            },
            highlight: function (e) {
                $(e).closest('.form-group').addClass('has-error');
            },
            unhighlight: function (e) {
                $(e).closest('.form-group').removeClass('has-error');
            },
            errorClass: "help-block",
            errorElement: "p",
            submitHandler: function (form) {
                var formd = form;
                $('.overlay').show();
                $.ajax({
                    url: $(form).attr('action'),
                    type: $(form).attr('method'),
                    data: $(form).serialize(),
                    dataType: 'json'
                }).done(function (result) {
                    if (result) {
                        $('#add_member').modal('hide');
                        toastr.options = {
                            "preventDuplicates": true,
                            "positionClass": "toast-bottom-right"
                        }
                        $('.overlay').hide();
                        toastr["success"]("Data has been inserted");
                    } else {
                        toastr.options = {
                            "preventDuplicates": true,
                            "positionClass": "toast-bottom-right"
                        }
                        toastr["error"]("Something wrong with the server. Please Try Again Later.");
                    }
                });
                formd.reset();
                return false;
            }
        });

        $('#add_distributor_form').validate({
            rules: {
                "distributor_name": {
                    required: true
                },
                "distributor_address": {
                    required: true
                },
                "distributor_contact": {
                    required: true,
                    digits: true
                },
                "distributor_company": {
                    required: true
                }
            },
            highlight: function (e) {
                $(e).closest('.form-group').addClass('has-error');
            },
            unhighlight: function (e) {
                $(e).closest('.form-group').removeClass('has-error');
            },
            errorClass: "help-block",
            errorElement: "p",
            submitHandler: function (form) {
                var formd = form;
                $('.overlay').show();
                $.ajax({
                    url: $(form).attr('action'),
                    type: $(form).attr('method'),
                    data: $(form).serialize(),
                    dataType: 'json'
                }).done(function (result) {
                    if (result) {
                        $('#add_distributor').modal('hide');
                        toastr.options = {
                            "preventDuplicates": true,
                            "positionClass": "toast-bottom-right"
                        }
                        $('.overlay').hide();
                        toastr["success"]("Data has been inserted");
                    } else {
                        toastr.options = {
                            "preventDuplicates": true,
                            "positionClass": "toast-bottom-right"
                        }
                        toastr["error"]("Something wrong with the server. Please Try Again Later.");
                    }
                });
                formd.reset();
                return false;
            }
        });

      });
      function go_delete(p_url) {
            id_obj = [];
            $('.checkboxes:checked').each(function ()
            {
                ids = $(this).data();
                var id_array = {};
                $.each(ids,function(index, value){
                    if(index !== 'uniformed'){
                        id_array[index] = value;
                    }
                });
                id_obj.push(id_array);
            }).get();
            var post = {ids: id_obj, updated_by: '<?php echo $login_user->username ?>', updated_on:'<?php echo  date("Y-m-d H:i:s") ?> "'};
            $.ajax({
                url: p_url,
                type: 'post',
                dataType: 'json',
                data: JSON.stringify(post),
                success: function (data) {
                    // console.log(data);
                    location.reload();
                }
            });
            $('#del_All').modal('hide');
        }
   </script>

   
  </body>
</html>
