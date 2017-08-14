
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Manage Prescription</h3>
              </div>
               <form method="GET" action="<?php echo base_url('admin/manage_prescription');?>" >
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
                    <h2>Prescription List</h2>
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

                    <p>We can search patient name, prescribed by.</p>

                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">                            
                            <th class="column-title" nowrap>Patient Name </th>
                            <th class="column-title" nowrap>Tab/cap/syrup </th>
                            <th class="column-title" nowrap>Description </th>
                            <th class="column-title" nowrap>BB </th>
                            <th class="column-title" nowrap>AB </th>
                            <th class="column-title" nowrap>BL </th>
                            <th class="column-title" nowrap>AL </th>
                            <th class="column-title" nowrap>Evening </th>
                            <th class="column-title" nowrap>BM </th>
                            <th class="column-title" nowrap>AM </th>
                            <th class="column-title" nowrap>No.Of Days </th>
                            <th class="column-title" nowrap>Prescribed By</th>
                            </tr>
                        </thead>

                        <tbody>
                          <?php if(!empty($prescription_info)) {
                            foreach ($prescription_info as $prescription) {
                             
                            ?>
                          <tr class="even pointer">
                           <!-- <td class="a-center ">
                              <input type="checkbox" class="flat" name="table_records">
                            </td>-->                            
                            <td class=" "><?php echo $prescription['patient_initials'].' '.$prescription['patientfname'].' '.$prescription['patientlname'] ;?> </td>
                            <td class=" "><?php echo $prescription['tab_cap_syrup'];?></td>
                            <td class=" "><?php echo $prescription['description'];?></td>
                            <td class=" "><?php echo $prescription['bb']?'Yes':'No';?></td>
                            <td class=" "><?php echo $prescription['ab']?'Yes':'No';?></td>
                            <td class=" "><?php echo $prescription['bl']?'Yes':'No';?></td>
                            <td class=" "><?php echo $prescription['al']?'Yes':'No';?></td>
                            <td class=" "><?php echo $prescription['eve']?'Yes':'No';?></td>
                            <td class=" "><?php echo $prescription['bm']?'Yes':'No';?></td>
                            <td class=" "><?php echo $prescription['am']?'Yes':'No';?></td>
                            <td class=" "><?php echo $prescription['days'];?></td>
                            <td class=" "><?php echo $prescription['prescript_name'];?></td>
                            </td>
                          </tr>
                          <?php } } else {?>
                           <tr class="even pointer"><td colspan="12">No prescription details</td> </tr>
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