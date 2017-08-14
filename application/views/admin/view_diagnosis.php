<div class="x_content">

  <table class="table table-striped">
    <!--<thead>
      <tr>
        <th>#</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Username</th>
      </tr>
    </thead>-->
    <tbody>
      <tr>
        <th>Patient Name</th><th>:</th><td><?php echo ucfirst(@$diagnosis[0]['patient_title']).' '.ucfirst(@$diagnosis[0]['patient_initials']).' '.ucfirst(@$diagnosis[0]['patient_fname']).' '.ucfirst(@$diagnosis[0]['patient_lname']);?></td>
        <th>Blood</th><th>:</th><td><?php echo @$diagnosis[0]['blood'];?></td>
      </tr>  
      <tr>
        <th>Circulatory and respiratory</th><th>:</th><td><?php echo @$diagnosis[0]['circulatory_name'];?></td>
        <th>Urine</th><th>:</th><td><?php echo @$diagnosis[0]['urine'];?></td>
      </tr> 
      <tr>
        <th>Digestive system and abdomen</th><th>:</th><td><?php echo @$diagnosis[0]['digestive_name'];?></td>
        <th>Body fluids, substances and tissues </th><th>:</th><td><?php echo @$diagnosis[0]['body_fluids'];?></td>
      </tr> 
      <tr>
        <th>Skin and subcutaneous tissue</th><th>:</th><td><?php echo @$diagnosis[0]['skin_name'];?></td>
        <th>Imaging and in function studies </th><th>:</th><td><?php echo @$diagnosis[0]['imaging'];?></td>
      </tr> 
      <tr>
        <th>Nervous and musculoskeletal systems</th><th>:</th><td><?php echo @$diagnosis[0]['nervous_name'];?></td>
        <th>Ill-defined and unknown causes of mortality</th><th>:</th><td><?php echo @$diagnosis[0]['mortality'];?></td>
      </tr> 
      <tr>
        <th>Urinary system</th><th>:</th><td><?php echo @$diagnosis[0]['urinary_name'];?></td>
        <th>Preliminary diagnosis</th><th>:</th><td><?php echo @$diagnosis[0]['preliminary_diagnosis'];?></td>
      </tr> 
      <tr>
        <th>Cognition, perception, emotional</th><th>:</th><td><?php echo @$diagnosis[0]['cognition_name'];?></td>
       <th>Final diagnosis</th><th>:</th><td><?php echo ucfirst(@$diagnosis[0]['final_diagnosis']);?></td>
      </tr>        
      <tr>
        <th>Speech and voice</th><th>:</th><td><?php echo @$diagnosis[0]['speech_name'];?></td>
        <th>Diagnosis By</th><th>:</th><td><?php echo ucfirst(@$diagnosis[0]['diagnosis_name']);?></td>
      </tr>     
      <tr>
        <th>General symptoms and signs</th><th>:</th><td><?php echo @$diagnosis[0]['general_name'];?></td>
        <th>Diagnosis Date</th><th>:</th><td><?php if($diagnosis[0]['date_of_diagnosis'] !='0000-00-00') { echo date('d-m-Y',strtotime(@$diagnosis[0]['date_of_diagnosis'])); }?></td>
      </tr>      
    </tbody>
  </table>

</div>
