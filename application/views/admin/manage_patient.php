
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Manage Patient</h3>
              </div>
               <form method="GET" action="<?php echo base_url('admin/manage_patient');?>" >
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
                    <h2>Patient List</h2>
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

                    <p>Patient details are order by Date wise. We can search patient information only email, first name, last name, mobile number.</p>

                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">
                            <!--<th>
                              <input type="checkbox" id="check-all" class="flat">
                            </th>-->
                            <th class="column-title" nowrap>Registration Date </th>
                            <th class="column-title" nowrap>Title / Initial / Name </th>
                            <th class="column-title" nowrap>Mobile Number </th>
                            <th class="column-title" nowrap>Email </th>
                            <th class="column-title" nowrap>Gender </th>
                            <th class="column-title" nowrap>Date of Birth </th>                            
                            <th class="column-title" nowrap>Action </th>
                           <!-- <th class="column-title no-link last"><span class="nobr">Action</span>
                            </th>
                            <th class="bulk-actions" colspan="7">
                              <a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                            </th>-->
                          </tr>
                        </thead>

                        <tbody>
                          <?php if(!empty($patient_info)) {
                            foreach ($patient_info as $patient) {
                             
                            ?>
                          <tr class="even pointer">
                           <!-- <td class="a-center ">
                              <input type="checkbox" class="flat" name="table_records">
                            </td>-->
                            <td class=" " nowrap><?php echo date('d-m-Y',strtotime($patient['date_of_registration']));?></td>
                            <td class=" "><?php echo $patient['title'].' '.$patient['initials'].' '.$patient['first_name'].' '.$patient['last_name'] ;?> </td>
                            <td class=" "><?php echo $patient['mobile'];?></td>
                            <td class=" "><?php echo $patient['email'];?></td>
                            <td class=" "><?php echo $patient['gender'];?></td>
                            <td class=" "><?php echo date('d-m-Y',strtotime($patient['dob']));?></td>
                            <td class=" "><a href="<?php echo base_url();?>admin/patient_view/<?php echo $patient['id'];?>">View</a> </td>
                            <!--<td class=" last"><a href="#">View</a>-->
                            </td>
                          </tr>
                          <?php } } else {?>
                           <tr class="even pointer"><td colspan="7">No patient details</td> </tr>
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
       /* $('#single_cal4').daterangepicker({
          singleDatePicker: true,
          dateFormat: 'dd/mm/yyyy',
          singleClasses: "picker_4"
        }, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
        });

        $('#single_cal5').daterangepicker({
          singleDatePicker: true,
          dateFormat: 'dd/mm/yyyy',
          singleClasses: "picker_4"
        }, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
        });*/

        $("#single_cal4").on("dp.change", function (e) {
            $('#single_cal5').data("DateTimePicker").minDate(e.date);
        });
        $("#single_cal5").on("dp.change", function (e) {
            $('#single_cal4').data("DateTimePicker").maxDate(e.date);
        });
      });
    </script>