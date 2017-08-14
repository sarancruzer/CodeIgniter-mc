
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Manage Masters Diagnosis</h3>
              </div>
               <form method="GET" action="<?php echo base_url('admin/manage_masters');?>" >
               <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                  <div class="input-group">
                    <input class="form-control" placeholder="Search for..." name="q" value="<?php echo @$q;?>" type="text">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="submit">Go!</button>
                    </span>
                  </div>
                </div>
              </div>
              </form>
            </div>

           


              <div class="clearfix"></div>

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Diagnosis Types List</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                     <!-- <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li>-->
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">

                    <p>We can search diagnosis type, diagnosis type value wise.</p>
                    <?php if(@$this->session->flashdata('success')) { ?>
                     <div class="col-lg-12"> 
                       <div class="alert alert-success">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <?php echo $this->session->flashdata('success'); ?>
                      </div>
                      <?php } if(@$this->session->flashdata('failure')) { ?>
                      <div class="alert alert-danger">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <?php echo $this->session->flashdata('failure'); ?>
                      </div> 
                      <?php } ?>
                      </div>
                    <div class="row">
                    <div style="padding-right: 5px;">
                    <a href="#" class="btn btn-sm btn-success  pull-right add-form" data-toggle="modal" data-target="#add-diagnosis" >Add</a>
                    </div></div>
                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">
                            <th class="column-title" nowrap>Diagnosis Type </th>
                            <th class="column-title" nowrap>Diagnosis Type Value </th>
                            <th class="column-title" nowrap>Action </th>
                          </tr>
                        </thead>

                        <tbody>
                          <?php if(!empty($masters_info)) {
                            foreach ($masters_info as $master) {
                             
                            ?>
                          <tr class="even pointer">
                           <!-- <td class="a-center ">
                              <input type="checkbox" class="flat" name="table_records">
                            </td>-->
                             <td class=" "><?php echo $master['master_name'];?></td>
                            <td class=" "><?php echo $master['master_value'];?></td>
                            <td class=" "><a href="#" class="edit edit-form" data-toggle="modal" data-target="#edit-diagnosis" 
                                    data-row-id='<?php echo $master["id"]; ?>'
                                    data-row-master_type='<?php echo $master["master_type"]; ?>'
                                    data-row-master_name='<?php echo $master["master_value"]; ?>'
                                    title="Edit Masters Type"><i class="fa fa-edit"></i>Edit</a> | <a href="#" class="delete" data-toggle="modal" data-target=".deleting" 
                                    data-row-id='<?php echo $master["id"]; ?>'          
                                    title="Delete Masters Type"><i class="fa fa-trash"></i>Delete</a></td>
                          </tr>
                          <?php } } else {?>
                           <tr class="even pointer"><td colspan="6">No district details found.</td> </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                    </div>
                     <?php echo $links;?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->
       

  <div class="modal fade" id="add-diagnosis" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Add Diagnosis Types <span class="mant pull-right" >* Mandatory</span></h4>
      </div>
      <form role="form" method="post" id="add-form" action="<?php echo base_url('admin/add_diagnosisTypes');?>">
      <div class="modal-body">
      
              <input type="hidden" name="id" id="id" value=""/>
              
              
              <div class="row">
              <div class="col-xs-1 col-sm-3 col-md-3">
               </div>
               
               <div class="col-xs-10 col-sm-6 col-md-6">
                <div class="form-group">
                 <label>Diagnosis Type</label> <span class="mant">*</span>
                  <select name="diagnosisType" id="diagnosisType" class="form-control">
                  <option value="">Select</option>
                  <?php
                  if(!empty($masterstype_info)) {
                   foreach($masterstype_info as $masterstype){?>
                  <option value="<?php echo $masterstype['master_key'];?>" ><?php echo $masterstype['master_name'];?></option>
                  <?php } }?>
                  </select>
                   <label for="diagnosisType" class="error" id="error" style="display:none"></label>
                   </div>
               </div>
                  
                <div class="col-xs-1 col-sm-3 col-md-3">
                </div>             
              </div>                  
              
              <div class="row">
              <div class="col-xs-1 col-sm-3 col-md-3">
               </div>
               
               <div class="col-xs-10 col-sm-6 col-md-6">
               <div class="form-group">
                 <label>Diagnosis Type Value</label> <span class="mant">*</span>
                   <input type="text" name="diagnosisTypeValue" id="diagnosisTypeValue" class="form-control" autocomplete="off" tabindex="1"/>
                   <label for="diagnosisTypeValue" class="error" id="error" style="display:none"></label>
                   </div>
               </div>
                  
                <div class="col-xs-1 col-sm-3 col-md-3">
                </div>             
              </div>              
                 
        </div>
        <div class="modal-footer">
         <input type="submit" class="btn btn-primary" value="Submit" name="addDiagnosisType" id="addDiagnosisType" tabindex="11">
         <button type="button" class="btn btn-default" data-dismiss="modal" tabindex="12">Cancel</button>
        </div>
        </form>
      </div>
    </div>
   </div>

<div class="modal fade" id="edit-diagnosis" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Edit Diagnosis Types <span class="mant pull-right" >* Mandatory</span></h4>
      </div>
       <form role="form" method="post" id="edit-form" name="edit-form" action="<?php echo base_url('admin/editdiagnosisTypes');?>">
      <div class="modal-body">
      
              <input type="hidden" name="editid" id="editid" value=""/>
                               
              <div class="row">
              <div class="col-xs-1 col-sm-3 col-md-3">
               </div>
               
               <div class="col-xs-10 col-sm-6 col-md-6">
                <div class="form-group">
                 <label>Diagnosis Type</label> <span class="mant">*</span>
                  <select name="editdiagnosisType" id="editdiagnosisType" class="form-control">
                  <option value="">Select</option>
                  <?php
                  if(!empty($masterstype_info)) {
                   foreach($masterstype_info as $masterstype){?>
                  <option value="<?php echo $masterstype['master_key'];?>" ><?php echo $masterstype['master_name'];?></option>
                  <?php } }?>
                  </select>
                   <label for="editdiagnosisType" class="error" id="error" style="display:none"></label>
                   </div>
               </div>
                  
                <div class="col-xs-1 col-sm-3 col-md-3">
                </div>             
              </div>

              <div class="row">
              <div class="col-xs-1 col-sm-3 col-md-3">
               </div>
               
               <div class="col-xs-10 col-sm-6 col-md-6">
               <div class="form-group">
                 <label>Diagnosis Type Value</label> <span class="mant">*</span>
                   <input type="hidden" name="old_diagnosisType" id="old_diagnosisType">
                   <input type="text" name="editdiagnosisTypeValue" id="editdiagnosisTypeValue" class="form-control" autocomplete="off" tabindex="1"/>
                   <label for="editdiagnosisTypeValue" class="error" id="error" style="display:none"></label>
                   </div>
               </div>
                  
                <div class="col-xs-1 col-sm-3 col-md-3">
                </div>             
              </div> 
                 
        </div>
        <div class="modal-footer">
         <input type="submit" class="btn btn-primary" value="Submit" name="editdistrict" id="editdistrict" tabindex="11">
         <button type="button" class="btn btn-default" data-dismiss="modal" tabindex="12">Cancel</button>
        </div>
        </form>
      </div>
    </div>
   </div>

<div class="modal fade deleting" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog modal-sm">
    <div class="modal-content">

        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
            </button>
            <h4 class="modal-title" id="myModalLabel2">Delete Diagnosis Type Value</h4>
        </div>
        <form method="POST" action="<?php echo base_url();?>admin/deletediagnosisType?q=<?php echo @$q?>&paginate=<?php echo @$paginate?>">
        <div class="modal-body">
            <h5>Do you want to delete in this diagnosis type value</h5>
            <input type="hidden" name="deleteid" id="deleteid" class="form-control" />  
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success" style="margin-top:-4px;">Ok</button>
        </div>

    </div>
</div>
</div>

<style type="text/css">
  
</style>
      <script>
      $(document).ready(function() {
      $('#add-form').validate({
      rules: {
         diagnosisType:{required:true,},
         diagnosisTypeValue: {
          required:true,
          remote: {
              url: "<?php echo base_url('admin/diagnosisType');?>",
              type: "post",
              data: {
                       district_name: function() {
            return $( "#diagnosisTypeValue" ).val();
          },

              },
         },
         },       
        
           },
      messages: {
        diagnosisType:{required:"Please select diagnosis type", },
        
        diagnosisTypeValue: {
          required:"Please enter diagnosis type Value",
          remote:"Diagnosis type Value already used",
        },
        
           }
       });

      $('#edit-form').validate({
      rules: {
         editdiagnosisType:{required:true,},
         editdiagnosisTypeValue: {
          required:true,
          remote: {
          param: {
            url: "<?php echo base_url('admin/diagnosisType');?>",
            type: "post",
            data: {
                   insustrial: $( "#editdiagnosisTypeValue" ).val()
                  },
               },
     
              depends: function() {
                return $("#editdiagnosisTypeValue").val() !== $('#old_diagnosisType').val();
              }
          },
         },                   
           },
      messages: {
        editdiagnosisType:{required:"Please select diagnosis type", },
        editdiagnosisTypeValue: {
          required:"Please enter diagnosis type Value",
          remote:"Diagnosis type Value already used",
        },              
           }
       });
       
       
       $(".edit").on('click', function(){
    
        //or do your operations here instead of on show of modal to populate values to modal.
         //$('#orderModal').data('orderid',$(this).data('id'));
         $('#edit-form')[0].reset();
         var id = $(this).data('row-id');
         var master_type = $(this).data('row-master_type');
         var master_name = $(this).data('row-master_name');
         
         $('#editid').val(id);
         $('#editdiagnosisTypeValue').val(master_name);
         $('#old_diagnosisType').val(master_name);
         $('[name=editdiagnosisType] option').filter(function() {
          return ($(this).val() == master_type); //To select Blue
    }).prop('selected', true);
     });

    $(".delete").on('click', function(){
      var id = $(this).data('row-id');
         $('#deleteid').val(id);
     });

    $('.deleting').on('hidden.bs.modal', function () {
        $('#deleteid').val('');
    });
        $(".add-form").click(function() {
        $('#add-form')[0].reset();
        $("label.error").hide();
        $(".error").removeClass("error");
        });

        $(".edit-form").click(function() {
        $("label.error").hide();
        $(".error").removeClass("error");
        });

      });
    </script>
    