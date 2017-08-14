
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Manage Diagnosis</h3>
              </div>
               <form method="GET" action="<?php echo base_url('admin/manage_diagnosis');?>" >
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
                    <h2>Diagnosis List</h2>
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

                  <p>We can search Diagnosis information only patient name, diagnosis by.</p>

                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">                            
                            <th class="column-title" nowrap>Patient Name </th>
                            <th class="column-title" nowrap>Gender </th>
                            <th class="column-title" nowrap>Mobile </th>
                            <th class="column-title" nowrap>Diagnosis By </th>
                            <th class="column-title" nowrap>Action </th>
                            </tr>
                        </thead>

                        <tbody>
                          <?php if(!empty($diagnosis_info)) {
                            foreach ($diagnosis_info as $diagnosis) {
                             
                            ?>
                          <tr class="even pointer">
                           <!-- <td class="a-center ">
                              <input type="checkbox" class="flat" name="table_records">
                            </td>-->                            
                            <td class=" "><?php echo $diagnosis['patient_title'].' '.$diagnosis['patient_initials'].' '.$diagnosis['patient_fname'].' '.$diagnosis['patient_lname'] ;?> </td>
                            <td class=" "><?php echo $diagnosis['gender'];?></td>
                            <td class=" "><?php echo $diagnosis['mobile'];?></td>
                            <td class=" "><?php echo $diagnosis['diagnosis_name'];?></td>
                            <td class=" ">
                            <a href="#" class="view edit-form" data-toggle="modal" data-target="#edit-doctor" 
                                    data-row-id='<?php echo $diagnosis["diagnosis_id"]; ?>'
                                    title="View Diagnosis">View</a> 
                            </td>
                          </tr>
                          <?php } } else {?>
                           <tr class="even pointer"><td colspan="3">No diagnosis details</td> </tr>
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

      <script>
      $(document).ready(function() {
        $(".view").on('click', function(){
         var id = $(this).data('row-id');  
         $.ajax({
          type: "POST",
          url: "<?php echo base_url();?>admin/viewDiagnosis",
            data: {id:id},
            success: function(msg)
              {
                //  $("#afflist").unmask();
                $("#viewDiagnosis").html(msg);
                        }  
           });
         
         
     });
      
      });
    </script>
    <div class="modal fade" id="edit-doctor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">View Diagnosis </h4>
      </div>
       <form role="form">
      <div class="modal-body">
                               
              <div id="viewDiagnosis"></div>                          
              <div class="row">
              <div class="col-xs-1 col-sm-3 col-md-3">
               </div>           
              </div>              
                 
        </div>
        <div class="modal-footer">
         <button type="button" class="btn btn-default" data-dismiss="modal" tabindex="12">Cancel</button>
        </div>
        </form>
      </div>
    </div>
   
   </div>
   <style type="text/css">
     .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
    border-top: 0px none !important;
    line-height: 1.42857;
    padding: 8px;
    vertical-align: top;
}
   </style>