
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Manage Slum or Village</h3>
              </div>
               <form method="GET" action="<?php echo base_url('admin/manage_village');?>" >
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
                    <h2>Slum or Village List</h2>
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

                    <p>We can search slum or village, ward or panchayat, city or block name, district name, state name wise.</p>
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
                    <a href="#" class="btn btn-sm btn-success  pull-right add-form" data-toggle="modal" data-target="#add-village" >Add</a>
                    </div></div>
                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">
                            <th class="column-title" nowrap>Slum or Village Name </th>
                            <th class="column-title" nowrap>Ward or Panchayat Name </th>
                            <th class="column-title" nowrap>City or Block Name </th>
                            <th class="column-title" nowrap>District Name </th>
                            <th class="column-title" nowrap>State Name </th>
                            <th class="column-title" nowrap>Action </th>
                          </tr>
                        </thead>

                        <tbody>
                          <?php if(!empty($village_info)) {
                            foreach ($village_info as $village) {
                             
                            ?>
                          <tr class="even pointer">
                          <td class=" "><?php echo $village['village_name'];?></td>
                          <td class=" "><?php echo $village['panchayat_name'];?></td>
                           <td class=" "><?php echo $village['city_name'];?></td>
                           <td class=" "><?php echo $village['district_name'];?></td>
                            <td class=" "><?php echo $village['state_name'];?></td>
                            <td class=" "><a href="#" class="edit edit-form" data-toggle="modal" data-target="#edit-village" 
                                    data-row-id='<?php echo $village["id"]; ?>'
                                    data-row-state_id='<?php echo $village["state_id"]; ?>'
                                    data-row-district_id='<?php echo $village["district_id"]; ?>'
                                    data-row-city_id='<?php echo $village["city_id"]; ?>'
                                    data-row-panchayat_id='<?php echo $village["panchayat_id"]; ?>'
                                    data-row-village_name='<?php echo $village["village_name"]; ?>'
                                    title="Edit Slum or Village"><i class="fa fa-edit"></i>Edit</a> | <a href="#" class="delete" data-toggle="modal" data-target=".deleting" 
                                    data-row-id='<?php echo $village["id"]; ?>'          
                                    title="Delete Slum or Village"><i class="fa fa-trash"></i>Delete</a></td>
                          </tr>
                          <?php } } else {?>
                           <tr class="even pointer"><td colspan="6">No slum or village found.</td> </tr>
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
       

  <div class="modal fade" id="add-village" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Add Slum or Village <span class="mant pull-right" >* Mandatory</span></h4>
      </div>
      <form role="form" method="post" id="add-form" action="<?php echo base_url('admin/add_village');?>">
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
                 <label>City or Block</label> <span class="mant">*</span>
                 <div id="onloadcity">
                  <select name="city_id" id="city_id" class="form-control">
                  <option value="">Select</option>                  
                  </select>
                  </div>
                   <label for="city_id" class="error" id="error" style="display:none"></label>
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
                 <label>Ward or Panchayat </label> <span class="mant">*</span>
                 <div id="onloadpanchayat">
                  <select name="panchayat_id" id="panchayat_id" class="form-control">
                  <option value="">Select</option>                  
                  </select>
                  </div>
                   <label for="panchayat_id" class="error" id="error" style="display:none"></label>
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
                 <label>Slum or Village Name</label> <span class="mant">*</span>
                   <input type="text" name="village_name" id="village_name" class="form-control" autocomplete="off" tabindex="1"/>
                   <label for="village_name" class="error" id="error" style="display:none"></label>
                   </div>
               </div>
                  
                <div class="col-xs-1 col-sm-3 col-md-3">
                </div>             
              </div>              
                 
        </div>
        <div class="modal-footer">
         <input type="submit" class="btn btn-primary" value="Submit" name="addvillage" id="addvillage" tabindex="11">
         <button type="button" class="btn btn-default" data-dismiss="modal" tabindex="12">Cancel</button>
        </div>
        </form>
      </div>
    </div>
   </div>

<div class="modal fade" id="edit-village" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Edit Slum or village <span class="mant pull-right" >* Mandatory</span></h4>
      </div>
       <form role="form" method="post" id="edit-form" name="edit-form" action="<?php echo base_url('admin/editvillage');?>">
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
                 <label>City or Block</label> <span class="mant">*</span>
                 <div id="editcity">
                  <select name="editcity_id" id="editcity_id" class="form-control">
                  <option value="">Select</option>                 
                  </select>
                  </div>
                   <label for="editcity_id" class="error" id="error" style="display:none"></label>
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
                 <label>Ward or Panchayat</label> <span class="mant">*</span>
                 <div id="editpanchayat">
                  <select name="editpanchayat_id" id="editpanchayat_id" class="form-control">
                  <option value="">Select</option>                 
                  </select>
                  </div>
                   <label for="editpanchayat_id" class="error" id="error" style="display:none"></label>
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
                 <label>Slum or Village Name</label> <span class="mant">*</span>
                   <input type="hidden" name="old_villagename" id="old_villagename">
                   <input type="text" name="editvillagename" id="editvillagename" class="form-control" autocomplete="off" tabindex="1"/>
                   <label for="editvillagename" class="error" id="error" style="display:none"></label>
                   </div>
               </div>
                  
                <div class="col-xs-1 col-sm-3 col-md-3">
                </div>             
              </div> 
                 
        </div>
        <div class="modal-footer">
         <input type="submit" class="btn btn-primary" value="Submit" name="editvillage" id="editvillage" tabindex="11">
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
            <h4 class="modal-title" id="myModalLabel2">Delete Slum or Village</h4>
        </div>
        <form method="POST" action="<?php echo base_url();?>admin/deletevillage?q=<?php echo @$q?>&paginate=<?php echo @$paginate?>">
        <div class="modal-body">
            <h5>Do you want to delete in this slum or village</h5>
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

       $(document).on('change','#district_id',function(){
     $('#error').hide();
    //  $("#afflist").mask("Please Wait...");

      var state_id=$('#state_id').val();
      var district_id=$('#district_id').val();
      var name='city_id';
      $.ajax({
      type: "POST",
      url: "<?php echo base_url();?>admin/onloadcity",
        data: {state_id:state_id,name:name,district_id:district_id},
        success: function(msg)
          {
          //  $("#afflist").unmask();
            $("#onloadcity").html(msg);
            var msg2='<select class="form-control" name="panchayat_id" id="panchayat_id"><option value="">--Select--</option></select>'
            $("#onloadpanchayat").html(msg2);

           }  
       });
});
       $(document).on('change','#city_id',function(){
     $('#error').hide();
    //  $("#afflist").mask("Please Wait...");

      var state_id=$('#state_id').val();
      var district_id=$('#district_id').val();
      var city_id=$('#city_id').val();
      var name='panchayat_id';
      $.ajax({
      type: "POST",
      url: "<?php echo base_url();?>admin/onloadpanchayat",
        data: {state_id:state_id,name:name,district_id:district_id,city_id:city_id},
        success: function(msg)
          {
          //  $("#afflist").unmask();
            $("#onloadpanchayat").html(msg);
            
           }  
       });
});
       $(document).on('change','#editcity_id',function(){
     $('#error').hide();
    //  $("#afflist").mask("Please Wait...");

      var state_id=$('#editstate_id').val();
      var district_id=$('#editdistrict_id').val();
      var city_id=$('#editcity_id').val();
      var name='editpanchayat_id';
      $.ajax({
      type: "POST",
      url: "<?php echo base_url();?>admin/onloadpanchayat",
        data: {state_id:state_id,name:name,district_id:district_id,city_id:city_id},
        success: function(msg)
          {
          //  $("#afflist").unmask();
            $("#editpanchayat").html(msg);
            
           }  
       });
});
  $(document).on('change','#editdistrict_id',function(){
     $('#error').hide();
    //  $("#afflist").mask("Please Wait...");

      var state_id=$('#editstate_id').val();
      var district_id=$('#editdistrict_id').val();
      var name='editcity_id';
      $.ajax({
      type: "POST",
      url: "<?php echo base_url();?>admin/onloadcity",
        data: {state_id:state_id,name:name,district_id:district_id},
        success: function(msg)
          {
          //  $("#afflist").unmask();
            $("#editcity").html(msg);
            var msg2='<select class="form-control" name="editpanchayat_id" id="editpanchayat_id"><option value="">--Select--</option></select>'
            $("#editpanchayat").html(msg2);
           }  
       });
});
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
            var msg2='<select class="form-control" name="city_id" id="city_id"><option value="">--Select--</option></select>'
            $("#onloadcity").html(msg2);
             var msg3='<select class="form-control" name="panchayat_id" id="panchayat_id"><option value="">--Select--</option></select>'
            $("#onloadpanchayat").html(msg3);
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
            var msg2='<select class="form-control" name="editcity_id" id="editcity_id"><option value="">--Select--</option></select>'
            $("#editcity").html(msg2);
            var msg3='<select class="form-control" name="editpanchayat_id" id="editpanchayat_id"><option value="">--Select--</option></select>'
            $("#editpanchayat").html(msg3);
           }  
       });
       
  });
      $('#add-form').validate({
      rules: {
         state_id:{required:true,},
         district_id:{required:true,},
         city_id:{required:true,},
         panchayat_id:{required:true,},
         village_name: {
          required:true,
          remote: {
              url: "<?php echo base_url('admin/villagename');?>",
              type: "post",
              data: {
                       city_name: function() {
            return $( "#village_name" ).val();
          },

              },
         },
         },       
        
           },
      messages: {
        state_id:{required:"Please select state", },
        district_id:{required:"Please select district", },
        city_id:{required:"Please select city or block", },
        panchayat_id:{required:"Please select ward or panchayat", },
        village_name: {
          required:"Please enter slum or village name",
          remote:"Slum or village name already used",
        },
        
           }
       });

      $('#edit-form').validate({
      rules: {
         editstate_id:{required:true,},
         editdistrict_id:{required:true},
         editcity_id:{required:true},
         editpanchayat_id:{required:true},
         editvillagename: {
          required:true,
          remote: {
          param: {
            url: "<?php echo base_url('admin/villagename');?>",
            type: "post",
            data: {
                   insustrial: $( "#editvillagename" ).val()
                  },
               },
     
              depends: function() {
                return $("#editvillagename").val() !== $('#old_villagename').val();
              }
          },
         },                   
           },
      messages: {
        editstate_id:{required:"Please select state", },
        editdistrict_id:{required:"Please select district", },
        editcity_id:{required:"Please select city or block", },
        editpanchayat_id:{required:"Please select ward or panchayat", },
        editvillagename: {
          required:"Please enter slum or village name",
          remote:"Slum or village name already used",
        },              
           }
       });
       
       
       $(".edit").on('click', function(){
    
        //or do your operations here instead of on show of modal to populate values to modal.
         //$('#orderModal').data('orderid',$(this).data('id'));
         $('#edit-form')[0].reset();
         var id = $(this).data('row-id');
         var village_name = $(this).data('row-village_name');
         var panchayat_id = $(this).data('row-panchayat_id');
         var city_id = $(this).data('row-city_id');
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

         var name2='editcity_id';
        var eselect2=city_id;
        $.ajax({
        type: "POST",
        url: "<?php echo base_url();?>admin/onloadcity",
          data: {state_id:state_id,district_id:district_id,name:name2,eselect:eselect2},
          success: function(msg)
            {
            //  $("#afflist").unmask();
              $("#editcity").html(msg);
             }  
         });

        var name3='editpanchayat_id';
        var eselect3=city_id;
        $.ajax({
        type: "POST",
        url: "<?php echo base_url();?>admin/onloadpanchayat",
          data: {state_id:state_id,district_id:district_id,city_id:city_id,name:name3,eselect:eselect3},
          success: function(msg)
            {
            //  $("#afflist").unmask();
              $("#editpanchayat").html(msg);
             }  
         });
         $('#editid').val(id);
         $('#editvillagename').val(village_name);
         $('#old_villagename').val(village_name);
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
    