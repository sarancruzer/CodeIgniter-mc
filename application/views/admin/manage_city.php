
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Manage City or Block</h3>
              </div>
               <form method="GET" action="<?php echo base_url('admin/manage_city');?>" >
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
                    <h2>City or Block List</h2>
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

                    <p>We can search city or block name, district name, state name wise.</p>
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
                    <a href="#" class="btn btn-sm btn-success  pull-right add-form" data-toggle="modal" data-target="#add-district" >Add</a>
                    </div></div>
                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">
                            <th class="column-title" nowrap>City or Block Name </th>
                            <th class="column-title" nowrap>District Name </th>
                            <th class="column-title" nowrap>State Name </th>
                            <th class="column-title" nowrap>Action </th>
                          </tr>
                        </thead>

                        <tbody>
                          <?php if(!empty($city_info)) {
                            foreach ($city_info as $city) {
                             
                            ?>
                          <tr class="even pointer">
                           <td class=" "><?php echo $city['city_name'];?></td>
                           <td class=" "><?php echo $city['district_name'];?></td>
                            <td class=" "><?php echo $city['state_name'];?></td>
                            <td class=" "><a href="#" class="edit edit-form" data-toggle="modal" data-target="#edit-city" 
                                    data-row-id='<?php echo $city["id"]; ?>'
                                    data-row-state_id='<?php echo $city["state_id"]; ?>'
                                    data-row-district_id='<?php echo $city["district_id"]; ?>'
                                    data-row-city_name='<?php echo $city["city_name"]; ?>'
                                    title="Edit City or Block"><i class="fa fa-edit"></i>Edit</a> | <a href="#" class="delete" data-toggle="modal" data-target=".deleting" 
                                    data-row-id='<?php echo $city["id"]; ?>'          
                                    title="Delete City or Block"><i class="fa fa-trash"></i>Delete</a></td>
                          </tr>
                          <?php } } else {?>
                           <tr class="even pointer"><td colspan="6">No city or block found.</td> </tr>
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
       

  <div class="modal fade" id="add-district" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Add City or Block <span class="mant pull-right" >* Mandatory</span></h4>
      </div>
      <form role="form" method="post" id="add-form" action="<?php echo base_url('admin/add_city');?>">
      <div class="modal-body">
      
              <input type="hidden" name="id" id="id" value=""/>
              
              
              <div class="row">
              <div class="col-xs-1 col-sm-3 col-md-3">
               </div>
               
               <div class="col-xs-10 col-sm-6 col-md-6">
                <div class="form-group">
                 <label>State</label> <span class="mant">*</span>
                  <select name="state_id" id="state_id" class="form-control">
                  <option value="">Select</option>
                  <?php
                  if(!empty($state_info)) {
                   foreach($state_info as $state){?>
                  <option value="<?php echo $state['id'];?>" ><?php echo $state['state_name'];?></option>
                  <?php } }?>
                  </select>
                   <label for="state_id" class="error" id="error" style="display:none"></label>
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
                 <label>District</label> <span class="mant">*</span>
                 <div id="onloaddistrict">
                  <select name="district_id" id="district_id" class="form-control">
                  <option value="">Select</option>                  
                  </select>
                  </div>
                   <label for="district_id" class="error" id="error" style="display:none"></label>
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
                 <label>City or Block Name</label> <span class="mant">*</span>
                   <input type="text" name="city_name" id="city_name" class="form-control" autocomplete="off" tabindex="1"/>
                   <label for="city_name" class="error" id="error" style="display:none"></label>
                   </div>
               </div>
                  
                <div class="col-xs-1 col-sm-3 col-md-3">
                </div>             
              </div>              
                 
        </div>
        <div class="modal-footer">
         <input type="submit" class="btn btn-primary" value="Submit" name="addcity" id="addcity" tabindex="11">
         <button type="button" class="btn btn-default" data-dismiss="modal" tabindex="12">Cancel</button>
        </div>
        </form>
      </div>
    </div>
   </div>

<div class="modal fade" id="edit-city" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Edit City or Blog <span class="mant pull-right" >* Mandatory</span></h4>
      </div>
       <form role="form" method="post" id="edit-form" name="edit-form" action="<?php echo base_url('admin/editcity');?>">
      <div class="modal-body">
      
              <input type="hidden" name="editid" id="editid" value=""/>
                               
              <div class="row">
              <div class="col-xs-1 col-sm-3 col-md-3">
               </div>
               
               <div class="col-xs-10 col-sm-6 col-md-6">
                <div class="form-group">
                 <label>State</label> <span class="mant">*</span>
                  <select name="editstate_id" id="editstate_id" class="form-control">
                  <option value="">Select</option>
                  <?php
                  if(!empty($state_info)) {
                   foreach($state_info as $state){?>
                  <option value="<?php echo $state['id'];?>" ><?php echo $state['state_name'];?></option>
                  <?php } }?>
                  </select>
                   <label for="editstate_id" class="error" id="error" style="display:none"></label>
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
                 <label>District</label> <span class="mant">*</span>
                 <div id="editdistrict">
                  <select name="editdistrict_id" id="editdistrict_id" class="form-control">
                  <option value="">Select</option>                 
                  </select>
                  </div>
                   <label for="editdistrict_id" class="error" id="error" style="display:none"></label>
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
                 <label>City or Block Name</label> <span class="mant">*</span>
                   <input type="hidden" name="old_cityname" id="old_cityname">
                   <input type="text" name="editcityname" id="editcityname" class="form-control" autocomplete="off" tabindex="1"/>
                   <label for="editcityname" class="error" id="error" style="display:none"></label>
                   </div>
               </div>
                  
                <div class="col-xs-1 col-sm-3 col-md-3">
                </div>             
              </div> 
                 
        </div>
        <div class="modal-footer">
         <input type="submit" class="btn btn-primary" value="Submit" name="editcity" id="editcity" tabindex="11">
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
            <h4 class="modal-title" id="myModalLabel2">Delete City or Block</h4>
        </div>
        <form method="POST" action="<?php echo base_url();?>admin/deletecity?q=<?php echo @$q?>&paginate=<?php echo @$paginate?>">
        <div class="modal-body">
            <h5>Do you want to delete in this city or block</h5>
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

    $("#state_id").change(function(){
      $('#error').hide();
    //  $("#afflist").mask("Please Wait...");

      var state_id=$('#state_id').val();
      var name='district_id';
      $.ajax({
      type: "POST",
      url: "<?php echo base_url();?>admin/onloaddistrict",
        data: {state_id:state_id,name:name},
        success: function(msg)
          {
          //  $("#afflist").unmask();
            $("#onloaddistrict").html(msg);
           }  
       });
       
  });

  $("#editstate_id").change(function(){
      $('#error').hide();
    //  $("#afflist").mask("Please Wait...");

      var state_id=$('#editstate_id').val();
      var name='editdistrict_id';
      $.ajax({
      type: "POST",
      url: "<?php echo base_url();?>admin/onloaddistrict",
        data: {state_id:state_id,name:name},
        success: function(msg)
          {
          //  $("#afflist").unmask();
            $("#editdistrict").html(msg);
           }  
       });
       
  });
      $('#add-form').validate({
      rules: {
         state_id:{required:true,},
         district_id:{required:true,},
         city_name: {
          required:true,
          remote: {
              url: "<?php echo base_url('admin/cityname');?>",
              type: "post",
              data: {
                       city_name: function() {
            return $( "#city_name" ).val();
          },

              },
         },
         },       
        
           },
      messages: {
        state_id:{required:"Please select state", },
        district_id:{required:"Please select district", },
        city_name: {
          required:"Please enter city or block name",
          remote:"City or block name already used",
        },
        
           }
       });

      $('#edit-form').validate({
      rules: {
         editstate_id:{required:true,},
         editdistrict_id:{required:true},
         editcityname: {
          required:true,
          remote: {
          param: {
            url: "<?php echo base_url('admin/cityname');?>",
            type: "post",
            data: {
                   insustrial: $( "#editcityname" ).val()
                  },
               },
     
              depends: function() {
                return $("#editcityname").val() !== $('#old_cityname').val();
              }
          },
         },                   
           },
      messages: {
        editstate_id:{required:"Please select state", },
        editdistrict_id:{required:"Please select district", },
        editcityname: {
          required:"Please enter city or block name",
          remote:"City or block name already used",
        },              
           }
       });
       
       
       $(".edit").on('click', function(){
    
        //or do your operations here instead of on show of modal to populate values to modal.
         //$('#orderModal').data('orderid',$(this).data('id'));
         $('#edit-form')[0].reset();
         var id = $(this).data('row-id');
         var city_name = $(this).data('row-city_name');
         var district_id = $(this).data('row-district_id');
         var state_id = $(this).data('row-state_id');
         
         var name='editdistrict_id';
        var eselect=district_id;
        $.ajax({
        type: "POST",
        url: "<?php echo base_url();?>admin/onloaddistrict",
          data: {state_id:state_id,name:name,eselect:eselect},
          success: function(msg)
            {
            //  $("#afflist").unmask();
              $("#editdistrict").html(msg);
             }  
         });
         $('#editid').val(id);
         $('#editcityname').val(city_name);
         $('#old_cityname').val(city_name);
         $('[name=editstate_id] option').filter(function() {
          return ($(this).val() == state_id); //To select Blue
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
    