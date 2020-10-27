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
    <div class="modal fade" id="add_member" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
              <form role="form" method="POST" enctype="multipart/form-data" action="<?php echo base_url() ?>member/add_ajax" id="add_member_form">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Add Member</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group ">
                      <label>Name</label><input class="form-control " name="member_name" placeholder="Name"  required  maxlength=50>
                  </div>
                  <div class="form-group">
                      <label>Gender</label><br>
                      <select class="form-control" name="member_gender" data-placeholder="Pilih..." style="width: 100%;">
                        <option value="1">Male</option>
                        <option value="0">Female</option>
                      </select>
                  </div>
                  <div class="form-group">
                      <label>Address</label><textarea class="form-control" name="member_address" ></textarea>
                  </div>
                  <div class="form-group">
                      <label>Contact</label><input class="form-control " name="member_contact" placeholder="Contact"  maxlength=12>
                  </div>
                  <div class="form-group <?php echo (form_error('member_bbm') != "") ? "has-error" : "" ?>">
                      <label>Bbm</label><input class="form-control " name="member_bbm" placeholder="Bbm"  maxlength=10>
                  </div>
                  
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
              </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="add_distributor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
              <form role="form" method="POST" enctype="multipart/form-data" action="<?php echo base_url() ?>distributor/add_ajax" id="add_distributor_form">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Add Distributor</h4>
                </div>
                <div class="modal-body">
                   <div class="form-group">
                      <label class="control-label">Nama</label><div class=""><input class="form-control " name="distributor_name" placeholder="Nama Distributor"  maxlength=50></div>
                  </div>
                  <div class="form-group">
                      <label class="control-label">Alamat</label><div class=""><textarea class="form-control" name="distributor_address" ></textarea></div>
                  </div>
                  <div class="form-group">
                      <label class="control-label">Kontak</label><div class=""><input class="form-control " name="distributor_contact" placeholder="Kontak Distributor"  maxlength=12></div>
                  </div>
                  <div class="form-group">
                      <label class="control-label">Perusahaan</label><div class=""><input class="form-control " name="distributor_company" placeholder="Perusahaan Distributor"  maxlength=255></div>
                  </div>
                  
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
              </form>
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