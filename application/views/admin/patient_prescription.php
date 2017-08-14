
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Patient Prescription</h3>
              </div>
               
            </div>

           


              <div class="clearfix"></div>

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><?php if($prescription_info) { echo ucfirst(@$prescription_info[0]['patient_title']).' '.ucfirst(@$prescription_info[0]['patient_initials']).' '.ucfirst(@$prescription_info[0]['patientfname']).' '.ucfirst(@$prescription_info[0]['patientlname']); } else { echo "Prescription"; }?></h2>
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
                    <div class="row">
                    <div style="padding-right: 5px;">
                    <a class="btn btn-sm btn-info pull-right" href="<?php echo base_url('admin/manage_patient');?>" >Back</a>
                    </div></div>
                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">
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
                            <th class="column-title" nowrap>Prescription Date</th>
                            </tr>
                        </thead>

                        <tbody>
                          <?php if(!empty($prescription_info)) {
                            $prescript='';
                            foreach ($prescription_info as $prescription) {
                            /* if(($prescription['date_of_prescription']!=$prescript)&&($prescript!=''))
                              {?>
                            <tr class="even pointer"><td colspan="12">xdfd</td></tr>
                            <?php} else {
                              $prescript=$prescription['date_of_prescription'];*/
                            ?>
                          <tr class="even pointer">
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
                            <td class=" "><?php echo date('d-m-Y',strtotime($prescription['date_of_prescription']));?></td>
                            </td>
                          </tr>
                          <?php //}
                           } } else {?>
                           <tr class="even pointer"><td colspan="12">No prescription details</td> </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->
       

  

<style type="text/css">
     .table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {
    border-top: 0px none !important;
    line-height: 1.42857;
    padding: 8px;
    vertical-align: top;
}
   </style>