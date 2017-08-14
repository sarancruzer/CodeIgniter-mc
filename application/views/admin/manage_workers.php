
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Manage Workers</h3>
              </div>
               <form method="GET" action="<?php echo base_url('admin/manage_workers');?>" >
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
                    <h2>Workers List</h2>
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

                    <p>Workers details are order by id wise. We can search workers information only email, user name, name, device id.</p>
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
                    <a href="#" class="btn btn-sm btn-success  pull-right add-form" data-toggle="modal" data-target="#add-workers" >Add</a>
                    </div></div>
                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">
                            <th class="column-title" nowrap>User Name </th>
                            <th class="column-title" nowrap>Name </th>
                            <th class="column-title" nowrap>Email </th>
                            <th class="column-title" nowrap>Device Id </th>
                            <th class="column-title" nowrap>Status </th>
                            <th class="column-title" nowrap>Action </th>
                          </tr>
                        </thead>

                        <tbody>
                          <?php if(!empty($total_workers)) {
                            foreach ($total_workers as $totworker) {
                             
                            ?>
                          <tr class="even pointer">
                           <!-- <td class="a-center ">
                              <input type="checkbox" class="flat" name="table_records">
                            </td>-->
                            
                            <td class=" "><?php echo $totworker['username'];?></td>
                            <td class=" "><?php echo $totworker['name'];?></td>
                            <td class=" "><?php echo $totworker['email'];?></td>
                            <td class=" "><?php echo $totworker['device_id'];?></td>
                            <td class=" "><?php if($totworker['is_active']=='1'){ echo "Active";} else { echo "Inactive"; }?></td>
                            <td class=" "><a href="#" class="edit edit-form" data-toggle="modal" data-target="#edit-workers" 
                                    data-row-id='<?php echo $totworker["id"]; ?>'
                                    data-row-username='<?php echo $totworker["username"]; ?>'
                                    data-row-name='<?php echo $totworker["name"]; ?>'
                                    data-row-email='<?php echo $totworker["email"]; ?>'
                                    data-row-device_id='<?php echo $totworker["device_id"]; ?>'
                                    data-row-is_active='<?php echo $totworker["is_active"]; ?>'
                                    title="Edit Health Workers"><i class="fa fa-edit"></i>Edit</a> | <a href="#" class="delete" data-toggle="modal" data-target=".deleting" 
                                    data-row-id='<?php echo $totworker["id"]; ?>'          
                                    title="Delete Health Workers"><i class="fa fa-trash"></i>Delete</a></td>
                          </tr>
                          <?php } } else {?>
                           <tr class="even pointer"><td colspan="6">No workers details</td> </tr>
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
       

  <div class="modal fade" id="add-workers" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Add Health Worker <span class="mant pull-right" >* Mandatory</span></h4>
      </div>
       <form role="form" method="post" id="add-form" action="<?php echo base_url('admin/addworkers');?>">
      <div class="modal-body">
      
              <input type="hidden" name="id" id="id" value=""/>
                               
              
              <div class="row">
              <div class="col-xs-1 col-sm-3 col-md-3">
               </div>
               
               <div class="col-xs-10 col-sm-6 col-md-6">
               <div class="form-group">
                 <label>User Name</label> <span class="mant">*</span>
                   <input type="text" name="username" id="username" class="form-control" autocomplete="off" tabindex="1"/>
                   <label for="username" class="error" id="error" style="display:none"></label>
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
                 <label>Password</label> <span class="mant">*</span>
                   <input type="text" name="password" id="password" class="form-control" autocomplete="off" tabindex="1"/>
                   <label for="password" class="error" id="error" style="display:none"></label>
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
                 <label>Name</label> <span class="mant">*</span>
                   <input type="text" name="name" id="name" class="form-control" autocomplete="off" tabindex="1"/>
                   <label for="name" class="error" id="error" style="display:none"></label>
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
                 <label>Email</label> <span class="mant">*</span>
                   <input type="text" name="email" id="email" class="form-control" autocomplete="off" tabindex="1"/>
                   <input type="hidden" name="old_emailad" id="old_emailad" class="form-control"/>
                   <label for="email" class="error" id="error" style="display:none"></label>
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
                 <label>Status</label> 
                   <select name="isactive" id="isactive" class="form-control" placeholder="">
                    <option value="1" >Active</option>                 
                    <option value="0">Inactive</option>                 
                                   
                   </select>
                  
                   </div>
               </div>
                  
                <div class="col-xs-1 col-sm-3 col-md-3">
                </div>             
              </div>
              
                 
        </div>
        <div class="modal-footer">
         <input type="submit" class="btn btn-primary" value="Submit" name="addworker" id="addworker" tabindex="11">
         <button type="button" class="btn btn-default" data-dismiss="modal" tabindex="12">Cancel</button>
        </div>
        </form>
      </div>
    </div>
   </div>

<div class="modal fade" id="edit-workers" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Edit Health Worker <span class="mant pull-right" >* Mandatory</span></h4>
      </div>
       <form role="form" method="post" id="edit-form" name="edit-form" action="<?php echo base_url('admin/editworker');?>">
      <div class="modal-body">
      
              <input type="hidden" name="editid" id="editid" value=""/>
                               
              
              <div class="row">
              <div class="col-xs-1 col-sm-3 col-md-3">
               </div>
               
               <div class="col-xs-10 col-sm-6 col-md-6">
               <div class="form-group">
                 <label>User Name</label> <span class="mant">*</span>
                   <input type="hidden" name="old_username" id="old_username">
                   <input type="text" name="editusername" id="editusername" class="form-control" autocomplete="off" tabindex="1"/>
                   <label for="editusername" class="error" id="error" style="display:none"></label>
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
                 <label>Name</label> <span class="mant">*</span>
                   <input type="text" name="editname" id="editname" class="form-control" autocomplete="off" tabindex="1"/>
                   <label for="editname" class="error" id="error" style="display:none"></label>
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
                 <label>Email</label> <span class="mant">*</span>
                   <input type="text" name="editemail" id="editemail" class="form-control" autocomplete="off" tabindex="1"/>
                   <label for="editemail" class="error" id="error" style="display:none"></label>
                   </div>
               </div>
                  
                <div class="col-xs-1 col-sm-3 col-md-3">
                </div>             
              </div>

              <div class="row" style="display: none" id="device">
              <div class="col-xs-1 col-sm-3 col-md-3">
               </div>
               
               <div class="col-xs-10 col-sm-6 col-md-6">
                <div class="form-group">
                 <label>Device Id</label> 
                 <div style="border:1px solid #ccc;padding: 5px;">
                 <div class="checkbox">
                            <label>
                              <input value="reset" type="checkbox" name="reset"> Reset Device Id
                            </label>
                          </div>
                   <div id="editdevice_id" name="editdevice_id"></div>
                   </div>
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
                 <label>Status</label> 
                   <select name="editstatus" id="editstatus" class="form-control" placeholder="">
                    <option value="1" >Active</option>                 
                    <option value="0">Inactive</option> 
                   </select>
                  
                   </div>
               </div>
                  
                <div class="col-xs-1 col-sm-3 col-md-3">
                </div>             
              </div>
              
                 
        </div>
        <div class="modal-footer">
         <input type="submit" class="btn btn-primary" value="Submit" name="editworker" id="editworker" tabindex="11">
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
            <h4 class="modal-title" id="myModalLabel2">Delete Health Worker</h4>
        </div>
        <form method="POST" action="<?php echo base_url();?>admin/deleteworker?q=<?php echo @$q?>&stat=<?php echo @$stat;?>&paginate=<?php echo @$paginate?>">
        <div class="modal-body">
            <h5>Do you want to delete in this health worker</h5>
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
         $.validator.addMethod( //override email with django email validator regex - fringe cases: "user@admin.state.in..us" or "name@website.a"
        'emailid',
        function(value, element){
            return this.optional(element) || /(^[-!#$%&'*+/=?^_`{}|~0-9A-Z]+(\.[-!#$%&'*+/=?^_`{}|~0-9A-Z]+)*|^"([\001-\010\013\014\016-\037!#-\[\]-\177]|\\[\001-\011\013\014\016-\177])*")@((?:[A-Z0-9](?:[A-Z0-9-]{0,61}[A-Z0-9])?\.)+(?:[A-Z]{2,6}\.?|[A-Z0-9-]{2,}\.?)$)|\[(25[0-5]|2[0-4]\d|[0-1]?\d?\d)(\.(25[0-5]|2[0-4]\d|[0-1]?\d?\d)){3}\]$/i.test(value);
        },
        'Please enter valid Email'
    );
      $('#add-form').validate({
      rules: {
         username: {
          required:true,
          remote: {
              url: "<?php echo base_url('admin/username');?>",
              type: "post",
              data: {
                       username: function() {
            return $( "#username" ).val();
          },

              },
         },
         },
         password: "required",
         name: "required",
         email: {
                  required: true,
                  email: true,
                  emailid:true ,                     
              },
          
           },
      messages: {
        username: {
          required:"Please enter username",
          remote:"User name already used",
        },
        password: "Please enter password",
        name: "Please enter name",
       email:{
                  required: "Please enter email",
                  email: "Please enter valid email",
                  remote:"Email already exist"
                 
              },
        
           }
       });

      $('#edit-form').validate({
      rules: {
         editusername: {
          required:true,
          remote: {
          param: {
            url: "<?php echo base_url('admin/username');?>",
            type: "post",
            data: {
                   insustrial: $( "#editusername" ).val()
                  },
               },
     
              depends: function() {
                return $("#editusername").val() !== $('#old_username').val();
              }
          },
         },
         editname: "required",
         editemail: {
                  required: true,
                  email: true,
                  emailid:true ,                     
              },
          
           },
      messages: {
        editusername: {
          required:"Please enter username",
          remote:"User name already used",
        },
       editname: "Please enter name",
       editemail:{
                  required: "Please enter email",
                  email: "Please enter valid email",
                  remote:"Email already exist"
                 
              },
        
           }
       });
       
       
       $(".edit").on('click', function(){
    
        //or do your operations here instead of on show of modal to populate values to modal.
         //$('#orderModal').data('orderid',$(this).data('id'));
         $('#editid').val('');
         $('#editusername').val('');
         $('#old_username').val('');
         $('#editname').val('');
         $('#editemail').val('');
         $('#editdevice_id').text('');
         $('#device').hide();
         var id = $(this).data('row-id');
         var username = $(this).data('row-username');
         var name = $(this).data('row-name');
         var email = $(this).data('row-email');
         var device_id = $(this).data('row-device_id');
         var is_active = $(this).data('row-is_active');
         
         $('#editid').val(id);
         $('#editusername').val(username);
         $('#old_username').val(username);
         $('#editname').val(name);
         $('#editemail').val(email);
         if(device_id!='')
         {
         $('#device').show();
         $('#editdevice_id').text(device_id);
         }
        // $('#status').attr('value',status1).html(status1);
         $('[name=editstatus] option').filter(function() {
         /* alert($(this).val()); 
          alert(status1);*/
        return ($(this).val() == is_active); //To select Blue
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
        $("label.error").hide();
        $(".error").removeClass("error");
        });

        $(".edit-form").click(function() {
        $("label.error").hide();
        $(".error").removeClass("error");
        });

      });
    </script>
    