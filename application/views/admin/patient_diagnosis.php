
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Patient Diagnosis</h3>
              </div>
               
            </div>

           


              <div class="clearfix"></div>

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><?php if($diagnosis_info) { echo ucfirst(@$diagnosis_info[0]['patient_title']).' '.ucfirst(@$diagnosis_info[0]['patient_initials']).' '.ucfirst(@$diagnosis_info[0]['patient_fname']).' '.ucfirst(@$diagnosis_info[0]['patient_lname']); } else { echo "Diagnosis"; }?></h2>
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
                    <?php if($diagnosis_info) { foreach($diagnosis_info as $diagnosis) {?>
                    <div class="table-responsive">
                      <table class="table table-striped">   
                      <tr class="headings" style="background-color: #73879c;color: #fff;">
                       <th class="column-title" nowrap>Diagnosis Date </th><th>:</th><td><?php if($diagnosis['date_of_diagnosis'] !='0000-00-00') { echo date('d-m-Y',strtotime(@$diagnosis['date_of_diagnosis'])); }?></td>
                        <th></th><th></th><td></td>
                      </tr>                  
                      <tbody>
                        <tr>
                          <th>Circulatory and respiratory</th><th>:</th><td><?php echo @$diagnosis['circulatory_name'];?></td>
                          <th>Blood</th><th>:</th><td><?php echo @$diagnosis['blood'];?></td>
                        </tr> 
                        <tr>
                          <th>Digestive system and abdomen</th><th>:</th><td><?php echo @$diagnosis['digestive_name'];?></td>
                          <th>Urine</th><th>:</th><td><?php echo @$diagnosis['urine'];?></td>
                        </tr> 
                        <tr>
                          <th>Skin and subcutaneous tissue</th><th>:</th><td><?php echo @$diagnosis['skin_name'];?></td>
                          <th>Body fluids, substances and tissues </th><th>:</th><td><?php echo @$diagnosis['body_fluids'];?></td>
                        </tr> 
                        <tr>
                          <th>Nervous and musculoskeletal systems</th><th>:</th><td><?php echo @$diagnosis['nervous_name'];?></td>
                          <th>Imaging and in function studies </th><th>:</th><td><?php echo @$diagnosis['imaging'];?></td>
                        </tr> 
                        <tr>
                          <th>Urinary system</th><th>:</th><td><?php echo @$diagnosis['urinary_name'];?></td>
                          <th>Ill-defined and unknown causes of mortality</th><th>:</th><td><?php echo @$diagnosis['mortality'];?></td>
                        </tr> 
                        <tr>
                          <th>Cognition, perception, emotional</th><th>:</th><td><?php echo @$diagnosis['cognition_name'];?></td>
                          <th>Preliminary diagnosis</th><th>:</th><td><?php echo @$diagnosis['preliminary_diagnosis'];?></td>
                        </tr>        
                        <tr>
                          <th>Speech and voice</th><th>:</th><td><?php echo @$diagnosis['speech_name'];?></td>
                          <th>Final diagnosis</th><th>:</th><td><?php echo ucfirst(@$diagnosis['final_diagnosis']);?></td>
                        </tr>     
                        <tr>
                          <th>General symptoms and signs</th><th>:</th><td><?php echo @$diagnosis['general_name'];?></td>
                           <th>Diagnosis By</th><th>:</th><td><?php echo ucfirst(@$diagnosis['diagnosis_name']);?></td>
                        </tr>      
                      </tbody>
                    </table>
                    </div>
                    <br>
                    <br>
                    <?php } } else { echo "No diagnosis found.";} ?>
                     
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