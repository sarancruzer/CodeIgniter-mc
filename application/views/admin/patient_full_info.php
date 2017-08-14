
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Patient View</h3>
              </div>
               
            </div>

           


              <div class="clearfix"></div>

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><?php if(!empty($personal)) { echo ucfirst(@$personal[0]['title']).' '.ucfirst(@$personal[0]['initials']).' '.ucfirst(@$personal[0]['first_name']).' '.ucfirst(@$personal[0]['last_name']); } else { echo "Patient Details"; }?></h2>
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
                    <a class="btn btn-sm btn-success pull-right" href="<?php echo $downloadurl; ?>" >Download</a>
                    </div></div>
                    <?php  if(!empty($personal)) { ?>
                    <div class="x_content">
                    <div class="table-responsive">
                    <table class="table table-striped">
                      <tbody>
                        <tr>
                          <th>Title</th><th>:</th><td><?php echo ucfirst(@$personal[0]['title']);?></td>
                          <th>District</th><th>:</th><td><?php echo @$personal[0]['district_name'];?></td>
                        </tr>  
                        <tr>
                          <th>Initials</th><th>:</th><td><?php echo ucfirst(@$personal[0]['initials']);?></td>
                          <th>State</th><th>:</th><td><?php echo @$personal[0]['state_name'];?></td>
                        </tr> 
                        <tr>
                          <th>First Name</th><th>:</th><td><?php echo ucfirst(@$personal[0]['first_name']);?></td>
                          <th>Mobile </th><th>:</th><td><?php echo @$personal[0]['mobile'];?></td>
                        </tr> 
                        <tr>
                          <th>Last Name</th><th>:</th><td><?php echo ucfirst(@$personal[0]['last_name']);?></td>
                          <th>Email </th><th>:</th><td><?php echo @$personal[0]['email'];?></td>
                        </tr> 
                        <tr>
                          <th>Date of Birth</th><th>:</th><td><?php echo date('d-m-Y',strtotime(@$personal[0]['dob']));?></td>
                          <th>Occupation</th><th>:</th><td><?php echo @$personal[0]['occupation'];?></td>
                        </tr>                          
                        <tr>
                          <th>Gender</th><th>:</th><td><?php echo @$personal[0]['gender'];?></td>
                          <th>Marital Status</th><th>:</th><td><?php echo @$personal[0]['marital_status'];?></td>
                        </tr> 
                        <tr>
                          <th>Address</th><th>:</th><td><?php echo @$personal[0]['address'];?></td>
                         <th>Husband / Father Name</th><th>:</th><td><?php echo @$personal[0]['husband_or_father_name'];?></td>
                        </tr> 
                        <tr>
                          <th>Slum / Village</th><th>:</th><td><?php echo @$personal[0]['village_name'];?></td>
                          <th>Monthly Income</th><th>:</th><td><?php echo @$personal[0]['monthly_income'];?></td>
                        </tr>       
                        <tr>
                          <th>Ward or Panchayat</th><th>:</th><td><?php echo @$personal[0]['panchayat_name'];?></td>
                          <th>Registration By</th><th>:</th><td><?php echo @$personal[0]['register_name'];?></td>
                        </tr>     
                        <tr>
                          <th>City or Block</th><th>:</th><td><?php echo @$personal[0]['city_name'];?></td>
                          <th>Diagnosis Date</th><th>:</th><td><?php if($personal[0]['date_of_registration'] !='0000-00-00') { echo date('d-m-Y',strtotime(@$personal[0]['date_of_registration'])); }?></td>
                        </tr> 
                        <?php if(!empty($patient_child)) {?>
                        <tr>
                        <div class="table-responsive">
                        <table class="table table-striped jambo_table bulk_action">
                        <thead>
                            <tr class="headings">
                            <th class="column-title" nowrap="">Child Name</th>
                            <th class="column-title" nowrap="">Child Date of Birth</th>
                            <th class="column-title" nowrap="">Child Gender</th>
                            </tr>
                          </thead>
                          <tbody>
                           <?php foreach($patient_child as $child)
                           {
                            ?>
                            <tr class="even pointer">
                            <td><?php echo $child['child_name'];?></td>
                            <td><?php echo date('d-m-Y',strtotime(@$child['child_dob']));?></td>
                            <td><?php echo $child['child_gender'];?></td>
                            </tr>
                            <?php } ?>
                          </tbody>
                        </table>
                        </div>
                        </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                    </div>
                  </div>
                  <?php } ?>
                    <div class="title_left"><h2>Diagnosis</h2></div>
                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">                            
                            <th class="column-title" nowrap>Circulatory and respiratory </th>
                            <th class="column-title" nowrap>Digestive system and abdomen </th>
                            <th class="column-title" nowrap>Skin and subcutaneous tissue </th>
                            <th class="column-title" nowrap>Nervous and musculoskeletal systems </th>
                            <th class="column-title" nowrap>Urinary system </th>
                            <th class="column-title" nowrap>Cognition, perception, emotional </th>
                            <th class="column-title" nowrap>Speech and voice </th>
                            <th class="column-title" nowrap>General symptoms and signs </th>
                            <th class="column-title" nowrap>Blood </th>
                            <th class="column-title" nowrap>Urine </th>
                            <th class="column-title" nowrap>Body fluids, substances and tissues </th>
                            <th class="column-title" nowrap>Imaging and in function studies </th>
                            <th class="column-title" nowrap>Ill-defined and unknown causes of mortality </th>
                            <th class="column-title" nowrap>Preliminary diagnosis </th>
                            <th class="column-title" nowrap>Final diagnosis </th>
                            <th class="column-title" nowrap>Diagnosis By </th>
                            <th class="column-title" nowrap>Diagnosis Date </th>
                            </tr>
                        </thead>

                        <tbody>
                          <?php if(!empty($diagnosis_info)) {
                            foreach ($diagnosis_info as $diagnosis) {
                             
                            ?>
                          <tr class="even pointer">
                          <td class=" "><?php echo $diagnosis['circulatory_name'];?></td>
                          <td class=" "><?php echo $diagnosis['digestive_name'];?></td>
                          <td class=" "><?php echo $diagnosis['skin_name'];?></td>
                          <td class=" "><?php echo $diagnosis['nervous_name'];?></td>
                          <td class=" "><?php echo $diagnosis['urinary_name'];?></td>
                          <td class=" "><?php echo $diagnosis['cognition_name'];?></td>
                          <td class=" "><?php echo $diagnosis['speech_name'];?></td>
                          <td class=" "><?php echo $diagnosis['general_name'];?></td>
                          <td class=" "><?php echo $diagnosis['blood'];?></td>
                          <td class=" "><?php echo $diagnosis['urine'];?></td>
                          <td class=" "><?php echo $diagnosis['body_fluids'];?></td>
                          <td class=" "><?php echo $diagnosis['imaging'];?></td>
                          <td class=" "><?php echo $diagnosis['mortality'];?></td>
                          <td class=" "><?php echo $diagnosis['preliminary_diagnosis'];?></td>
                          <td class=" "><?php echo $diagnosis['final_diagnosis'];?></td>
                          <td class=" "><?php echo $diagnosis['diagnosis_name'];?></td>
                          <td class=" "><?php echo date('d-m-Y',strtotime($diagnosis['date_of_diagnosis']));?></td>                         
                          </tr>
                          <?php } } else {?>
                           <tr class="even pointer"><td colspan="18">No diagnosis details</td> </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                    </div>
                     <?php echo @$dgnlinks;?>
                    <br><br>
                    <div class="title_left"><h2>Prescription</h2></div>
                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings"> 
                            <th class="column-title" nowrap>Tab / cap / syrup </th>
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
                            <th class="column-title" nowrap>Prescription Date </th>
                            </tr>
                        </thead>

                        <tbody>
                          <?php if(!empty($prescription_info)) {
                            foreach ($prescription_info as $prescription) {
                             
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
                          <?php } } else {?>
                           <tr class="even pointer"><td colspan="12">No prescription details</td> </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                    </div>
                     <?php echo @$psclinks;?>
                     <br><br>
                      <div class="title_left"><h2>Referrals</h2></div>
                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings"> 
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
                            <td class=" "><?php echo $referral['referred_to'];?></td>
                            <td class=" "><?php echo $referral['hospital_name'];?></td>
                            <td class=" "><?php echo $referral['preliminary_diagnosis'];?></td>
                            <td class=" "><?php echo $referral['final_diagnosis'];?></td>
                            <td class=" "><?php echo $referral['referral_name'];?></td>
                            <td class=" "><?php echo date('d-m-Y',strtotime($referral['referred_date']));?></td>
                            </td>
                          </tr>
                          <?php } } else {?>
                           <tr class="even pointer"><td colspan="11">No referrals details</td> </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                    </div>
                     <?php echo @$reflinks;?>

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