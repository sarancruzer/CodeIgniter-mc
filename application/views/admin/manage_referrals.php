
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Manage Referrals</h3>
              </div>
               <form method="GET" action="<?php echo base_url('admin/manage_referrals');?>" >
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
                    <h2>Referrals List</h2>
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

                    <p>We can search patient name, referred to, hospital name / pharmacy, preliminary diagnosis, final diagnosis, referred by.</p>

                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">                            
                            <th class="column-title" nowrap>Patient Name </th>
                            <th class="column-title" nowrap>Referred To </th>
                            <th class="column-title" nowrap>Hospital Name / Pharmacy </th>
                            <th class="column-title" nowrap>Preliminary Diagnosis </th>
                            <th class="column-title" nowrap>Final Diagnosis </th>
                            <th class="column-title" nowrap>Referred By </th>
                            <th class="column-title" nowrap>Referred Date </th>
                            </tr>
                        </thead>

                        <tbody>
                          <?php if(!empty($referrals_info)) {
                            foreach ($referrals_info as $referral) {
                             
                            ?>
                          <tr class="even pointer">
                           <!-- <td class="a-center ">
                              <input type="checkbox" class="flat" name="table_records">
                            </td>-->                            
                            <td class=" "><?php echo $referral['patient_title'].' '.$referral['patient_initials'].' '.$referral['patientfname'].' '.$referral['patientlname'] ;?> </td>
                            <td class=" "><?php echo $referral['referred_to'];?></td>
                            <td class=" "><?php echo $referral['hospital_name'];?></td>
                            <td class=" "><?php echo $referral['preliminary_diagnosis'];?></td>
                            <td class=" "><?php echo $referral['final_diagnosis'];?></td>
                            <td class=" "><?php echo $referral['referral_name'];?></td>
                            <td class=" "><?php echo date('d-m-Y',strtotime($referral['referred_date']));?></td>
                            </td>
                          </tr>
                          <?php } } else {?>
                           <tr class="even pointer"><td colspan="12">No referrals details</td> </tr>
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