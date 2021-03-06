<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

        <section id="content">   <!-- Start: Content -->
	        <div class="container" style="padding-top: 20px;">
                
            <?php if ($this->session->flashdata('update')=="success"){ ?>
                <div class="col-md-12">
                        <div class="col-md-6">
                            <div class="alert alert-success">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                Successfully updated the member details
                            </div>
                        </div>
                </div>
            <?php } ?>
                

                <div class="col-md-8">
                    <div class="panel panel-success" style="margin-top:20px;">
                        <div class="panel-heading reg-main-panel">
                            <h3 class="panel-title"> Special Cadre Subject List </h3>
                        </div><!--End of panel-heading-->
                        <div class="panel-body">
                            
                        <table  class="table table-striped table-hover DynamicTable" border="0" id="dataTable">
                            <thead>
                                <tr>
                                    <th> Subject </th>
                                    <th style="width:80px;"> Action </th>
                                </tr>
                            </thead>
                            <tbody id="tablebody">
                            </tbody>
                        </table>
                        <table  class="table table-striped table-hover DynamicTable" border="0" >
                            <tr>
                                <td> <button class="delete_workplace btn btn-large btn-success " id="addNew" ><i class="fa fa-plus"></i></button> Add New Special Cadre Subject </td>
                                <td> </td>
                                <td> </td>
                            </tr>
                        </table>
                            
                  
                    <!-- Modal to update Work Places dates-->
                        <div id="UpdateModal" class="modal fade" role="dialog">
                          <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  <h4 id="modal_title">  </h4>

                              </div>

                            <?php echo form_open() ?> 
                              <div class="modal-body">
                                <div class="col-md-12">
                                        <input type="text" class="form-control hidden" name="spsubject_id" id="spsubject_id" >
                                        <input type="text" class="form-control hidden" name="action" id="action" >
                                    <div class="form-group">
                                        <label class="modal_q"> Special Cadre Subject </label>
                                        <input type="text" class="form-control" name="spsubject_name" id="spsubject_name">
                                    </div>
                                </div>
                              </div>
                              <div class="modal-footer" style="border-top:0;">
                                <button type="button" class="btn btn-success" data-dismiss="modal" id="modal_submit">Save</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              </div>
                            <?php echo form_close() ?>
                            </div>

                          </div>
                        </div>
                            
                        </div>
                    </div>
                </div>

            </div>
    </section>

    <script src="<?php echo base_url()."assets/plugins/select2/select2.min.js"?>"></script>
    <script src="<?php echo base_url()."assets/plugins/datatables/js/jquery.dataTables.min.js"?>"></script>
    <script src="<?php echo base_url()."assets/plugins/datatables/js/DT_bootstrap.js"?>"></script>
    <script src="<?php echo base_url()."assets/plugins/validation/jquery.validate.min.js"?>"></script>
    <script src="<?php echo base_url()."assets/plugins/bootstrap-toggle/js/bootstrap-toggle.min.js"?>"></script>
            
<script>
    $(document).ready(function(){
        
        $('#mnuThree').addClass('menu-open');
        $('#mnu_service-spsubjects').addClass('active');
        getSpSubjects();
        
        $(document).on('click', '.edit', function(){
            var spsubject_id = $(this).data("id");
            var spsubject_name = $(this).data("name");
            
            $('#spsubject_id').val(spsubject_id);
            $('#spsubject_name').data("ID", spsubject_id);
            $('#spsubject_name').val(spsubject_name);
            $('#action').val('edit');
            $('#modal_title').text("Edit Special Cadre Subject");
            $('#modal_submit').text("Save");
            $('#UpdateModal').modal('toggle');
        });
        
        $(document).on('click', '.delete', function(){
            var post_url = "index.php/Main/deleteSpSubject/2";
            var form_data = new FormData();
            var spsubject_id = $(this).data("id");
            
            form_data.append('<?php echo $this->security->get_csrf_token_name(); ?>','<?php echo $this->security->get_csrf_hash(); ?>');
            form_data.append('spsubject_id', spsubject_id);
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>" + post_url,
                dataType :'text',
                data: form_data,
                contentType: false,
                processData: false,
                success: function(response){
                    getSpSubjects();
                    },
                error: function (response) {
                    alert("Error Delete! Please try again.");
                }
            });
        });
        
        $('#addNew').click(function(){
            
            $('#modal_title').text("Add New Special Cadre Subject");
            $('#modal_submit').text("Add");
            $('#action').val('add');
            $('#UpdateModal').modal('toggle');
        });
        
        $('#modal_submit').click(function(){
            var form_data = new FormData();
            var spsubject_id = $('#spsubject_id').val();
            var spsubject_name = $('#spsubject_name').val();
            var action = $('#action').val();
            
            if(action == 'edit'){
                var post_url = "index.php/Main/updateSpSubject/2";
                form_data.append('<?php echo $this->security->get_csrf_token_name(); ?>','<?php echo $this->security->get_csrf_hash(); ?>');
                form_data.append('spsubject_id', spsubject_id);
                form_data.append('spsubject_name', spsubject_name);
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>" + post_url,
                    dataType :'text',
                    data: form_data,
                    contentType: false,
                    processData: false,
                    success: function(response){
                        
                        getSpSubjects()

                        },
                    error: function (response) {
                        alert("Error Updating! Please try again.");
                    }
                });
            }else if(action == 'add'){
                var post_url = "index.php/Main/addSpSubject/2";
                form_data.append('<?php echo $this->security->get_csrf_token_name(); ?>','<?php echo $this->security->get_csrf_hash(); ?>');
                form_data.append('spsubject_name', spsubject_name);
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>" + post_url,
                    dataType :'text',
                    data: form_data,
                    contentType: false,
                    processData: false,
                    success: function(response){
                        
                        getSpSubjects();
                        
                        },
                    error: function (response) {
                        alert("Error Updating! Please try again.");
                    }
                });
            }
            
        });
        
        function getSpSubjects(){
            
            var dataarray = {'<?php echo $this->security->get_csrf_token_name(); ?>':'<?php echo $this->security->get_csrf_hash(); ?>'};
            var post_url = "index.php/FormControl/getSpSubject/2";
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>" + post_url,
                dataType :'json',
                data: dataarray,
                success: function(res){
                    $('#tablebody').empty();
                    $.each(res, function(ID,province_office){
                        $('#dataTable tbody').append('<tr><td>'+res[ID].sub_name+'</td>'+
                                                       '<td> <button class="edit btn btn-xs btn-success " data-ID="'+res[ID].ID+'" data-name="'+res[ID].sub_name+'" ><i class="fa fa-edit"></i></button> ' +
                                                       ' <button class="delete btn btn-xs btn-danger " data-ID="'+res[ID].ID+'" ><i class="fa fs-remove"></i></button> </td>'+
                                                       '</tr>');
                    });
                }
            });
            
        }
                      
    });

</script>