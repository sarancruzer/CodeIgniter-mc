<?php
require_once APPPATH . '/libraries/REST_Controller.php';
require_once APPPATH . '/libraries/JWT.php';
use \Firebase\JWT\JWT;
class User extends REST_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Users_model');
        date_default_timezone_set('Asia/Kolkata');
    }
    /*public function login_post() {
        $username = $this->post('username');
        $password = $this->post('password');
        $invalidLogin = ['invalid' => $username];
        if(!$username || !$password) $this->response($invalidLogin, REST_Controller::HTTP_NOT_FOUND);
        $id = $this->Users_model->login($username,$password);
        if($id) {
            $token['id'] = $id;
            $token['username'] = $username;
            $date = new DateTime();
            $token['iat'] = $date->getTimestamp();
            $token['exp'] = $date->getTimestamp() + 60*60*5;
            $output['token'] = JWT::encode($token, "my Secret key!");
            $output['username']=$username;
           // $output['id'] = $id;
            
            $this->set_response($output, REST_Controller::HTTP_OK);
        }
        else {
            $this->set_response($invalidLogin, REST_Controller::HTTP_NOT_FOUND);
        }
    }*/

    public function login_post() {
        $username = $this->post('username');
        $password = $this->post('password');
       	$device_id = @$this->post('device_id');
       	$invalid = ['invalid' => 'Missing some field'];
        if(!$username || !$password || !$device_id) $this->response($invalid, REST_Controller::HTTP_NOT_FOUND);
        $crediential = $this->Users_model->login($username,$password);
        if($crediential) 
        {
        	if($crediential[0]['is_active']='1')
        	{
        		if(empty($crediential[0]['device_id']))
        		{
        			$this->Users_model->updateDevice($crediential[0]['id'],$device_id);
        			$token['id'] = $crediential[0]['id'];
		            $token['username'] = $username;
		            $date = new DateTime();
		            $token['iat'] = $date->getTimestamp();
		            $token['exp'] = $date->getTimestamp() + 60*60*5;
		            $output['token'] = JWT::encode($token, "my Secret key!");
		            $output['username']=$username;
		            $output['statuscode']=200;
		            $this->set_response($output, REST_Controller::HTTP_OK);
        		}
                else if($crediential[0]['device_id']==$device_id)
                {
		            $token['id'] = $crediential[0]['id'];
		            $token['username'] = $username;
		            $date = new DateTime();
		            $token['iat'] = $date->getTimestamp();
		            $token['exp'] = $date->getTimestamp() + 60*60*5;
		            $output['token'] = JWT::encode($token, "my Secret key!");
		            $output['username']=$username;
		            $output['statuscode']=200;
		            $this->set_response($output, REST_Controller::HTTP_OK);
	            }
	            else
	            {
	            	$invalidDevice = ['invalid' => 'Your mobile is not authorized. Please contact admin','statuscode' => 404];
	            	$this->set_response($invalidDevice, REST_Controller::HTTP_NOT_FOUND);
	            }
         	}
         	else 
         	{
	        	$invalidStatus = ['invalid' => 'You are inactive status. Please contact admin','statuscode' => 404];
	            $this->set_response($invalidStatus, REST_Controller::HTTP_NOT_FOUND);
        	}
        }
        else {
        	$invalidLogin = ['invalid' => 'Invalid username password','statuscode' => 404];
            $this->set_response($invalidLogin, REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function register_post()
    {
       if($this->post('email')==' ' || empty($this->post('email')))
        {
          $invalidLogin['message'] = "Email id mandatory";
          $this->set_response($invalidLogin, REST_Controller::HTTP_NOT_FOUND);
        }
       else
       { 
         $id = $this->Users_model->existpatient($this->post('email'));
         if(!($id))
         {
           $jwt=$this->post('token');
           $output= tocken_auth($jwt);
           if(empty($output['id']))
           {
              $this->set_response($output, REST_Controller::HTTP_NOT_FOUND);
           }
           else
           {
             $registration_by=$output['id']; 
             $data = array(
            'title' => $this->post('title'),
            'initials' => $this->post('initials'),
            'first_name' => $this->post('firstname'),
            'last_name' => $this->post('lastname'),
           // 'dob' => date('Y-m-d',strtotime($this->post('dob'))),
            'title' => $this->post('title'),
            'gender' => $this->post('gender'),
            'address' => $this->post('address'),
            'slum_or_village' => $this->post('slum_or_village'),
            'ward_or_panchayat' => $this->post('ward_or_panchayat'),
            'city_block' => $this->post('city_block'),
            'district' => $this->post('district'),
            'state' => $this->post('state'),
            'mobile' => $this->post('mobile'),
            'email' => $this->post('email'),
            'occupation' => @$this->post('occupation'),
            'marital_status' => @$this->post('martial_status'),
            'husband_or_father_name' => $this->post('husband_or_father_name'),
            'child_one' => $this->post('child_one'),
            'monthly_income' => $this->post('monthly_income'),
            'registration_by' => $registration_by,
            'date_of_registration' => date('Y-m-d h:i:s')
            );
             if(!empty($this->post('dob')))
             {
              $data['dob']=date('Y-m-d',strtotime($this->post('dob')));
             }
             else
             {
              $data['dob']=null;
             }

             $id = $this->Users_model->registration($data);
            
            if(!empty($this->post('child_details')))
            {
              $child_details=$this->post('child_details');

              $child =array();
              foreach($child_details as $details)
              {  
              if(!empty($details['child_dob']))
              {
                $childdate=date('Y-m-d',strtotime(@$details['child_dob'])); 
              }
              else              
              {
                $childdate=null;
              }              
              $child[] = array(
                         'child_name' => @$details['child_name'], 
                         'child_dob' => $childdate,
                         'child_gender' => @$details['child_gender'],
                         'patient_id'=>$id
                         );
              } 
                          
              $this->Users_model->child_registration($child);
            }
    
            if($id) 
            { 
               $output1['lastInsertedId']=$id;
               $output1['statuscode']='200';
               $output1['message'] = "Patient details inserted successfully";
               $this->set_response($output1, REST_Controller::HTTP_OK); 
            }
            else
            {
              $invalidLogin['statuscode']='404';
              $invalidLogin['message'] = "Can not insert patient details";
              $this->set_response($invalidLogin, REST_Controller::HTTP_NOT_FOUND);
            }
          }
        }
        else
        {
             $invalidLogin['statuscode']='404';
             $invalidLogin['message'] = "Email id already exist";
           $this->set_response($invalidLogin, REST_Controller::HTTP_NOT_FOUND);
         }
      }
    }
    
    public function getRegister_post()
    {
      $jwt=$this->post('token');
       $output= tocken_auth($jwt);
      // var_dump($output);
       if(empty($output['id']))
       {
          $this->set_response($output, REST_Controller::HTTP_NOT_FOUND);
       }
       else
       {
	      if($this->post('state')!='')
	      {
	        $where="state_id=".$this->post('state');
	        $output['district_list']=$this->Users_model->getRegister('district_list',$where,'district_name');
	      }
	      else if($this->post('district')!='')
	      {
	        $where="district_id=".$this->post('district');
	        $output['city_list']=$this->Users_model->getRegister('city_or_block',$where,'city_name');
	      }
	      else if($this->post('city')!='')
	      {
	        $where="city_id=".$this->post('city');
	        $output['panchayat_list']=$this->Users_model->getRegister('ward_or_panchayat',$where,'panchayat_name');
	      }
	      else if($this->post('panchayat')!='')
	      {
	        $where="panchayat_id=".$this->post('panchayat');
	        $output['village_list']=$this->Users_model->getRegister('slum_or_village',$where,'village_name');
	      }
	      else
	      {
	        $where="";
	        $output['state_list']=$this->Users_model->getRegister('state_list',$where,'state_name');
	      }
	      $this->set_response($output, REST_Controller::HTTP_OK); 
	  }
    }

    
    public function getPatient_post()
    {
      $jwt=$this->post('token');
       $output= tocken_auth($jwt);
      // var_dump($output);
       if(empty($output['id']))
       {
          $this->set_response($output, REST_Controller::HTTP_NOT_FOUND);
       }
       else{
         $id=$output['id'];
         $options=array(); 
         @$options['key'] =" where reg.registration_by=$id";
         $optionsets=array();
         if(!empty($this->post('state'))){
         $state = $this->post('state');
         $optionsets[] = "reg.state=$state"; 
         } 
         if(!empty($this->post('district'))){
         $district = $this->post('district');
         $optionsets[] = "reg.district=$district"; 
         }  
         if(!empty($this->post('city_block'))){
         $city_block = $this->post('city_block');
         $optionsets[] = "reg.city_block=$city_block"; 
         } 
         if(!empty($this->post('ward_or_panchayat'))){
         $ward_or_panchayat = $this->post('ward_or_panchayat');
         $optionsets[] = "reg.ward_or_panchayat=$ward_or_panchayat"; 
         } 
         if(!empty($this->post('slum_or_village'))){
         $slum_or_village = $this->post('slum_or_village');
         $optionsets[] = "reg.slum_or_village=$slum_or_village"; 
         }
         if(!empty($this->post('patient_id'))){
         $patient_id = $this->post('patient_id');
         $optionsets[] = "reg.id=$patient_id"; 
         @$options['patientid']=$this->post('patient_id');
         }
            
         if(!empty($optionsets))
         {
            $options['key'].=' and '.implode(' and ',$optionsets);
         }
         @$options['key'] .=" order by reg.date_of_registration desc";
         $output['patient_info']=$this->Users_model->get_patient_details($options);
         $output['statuscode']='200';
         $this->set_response($output, REST_Controller::HTTP_OK); 
       }
    }

    public function getPatientList_post()
    {
      $jwt=$this->post('token');
       $output= tocken_auth($jwt);
      // var_dump($output);
       if(empty($output['id']))
       {
          $this->set_response($output, REST_Controller::HTTP_NOT_FOUND);
       }
       else{
         $id=$output['id'];
         $options=array(); 
         @$options['key'] =" where reg.registration_by=$id and reg.date_of_registration BETWEEN CURDATE() - INTERVAL 90 DAY AND CURDATE()";
         $optionsets=array();
         if(!empty($this->post('state'))){
         $state = $this->post('state');
         $optionsets[] = "reg.state=$state"; 
         } 
         if(!empty($this->post('district'))){
         $district = $this->post('district');
         $optionsets[] = "reg.district=$district"; 
         }  
         if(!empty($this->post('city_block'))){
         $city_block = $this->post('city_block');
         $optionsets[] = "reg.city_block=$city_block"; 
         } 
         if(!empty($this->post('ward_or_panchayat'))){
         $ward_or_panchayat = $this->post('ward_or_panchayat');
         $optionsets[] = "reg.ward_or_panchayat=$ward_or_panchayat"; 
         } 
         if(!empty($this->post('slum_or_village'))){
         $slum_or_village = $this->post('slum_or_village');
         $optionsets[] = "reg.slum_or_village=$slum_or_village"; 
         }
         if(!empty($this->post('patient_id'))){
         $patient_id = $this->post('patient_id');
         $optionsets[] = "reg.id=$patient_id"; 
         @$options['patientid']=$this->post('patient_id');
         }
            
         if(!empty($optionsets))
         {
            $options['key'].=' and '.implode(' and ',$optionsets);
         }
         @$options['key'] .=" order by reg.date_of_registration desc";
         $output['patient_info']=$this->Users_model->get_patient_details_list($options);
         $output['statuscode']='200';
         $this->set_response($output, REST_Controller::HTTP_OK); 
       }
    }

    public function diagnosis_post()
    {
       $jwt=$this->post('token');
       $output= tocken_auth($jwt);
       if(empty($output['id']))
       {
          $this->set_response($output, REST_Controller::HTTP_NOT_FOUND);
       }
       else
       {
         $id=$output['id']; 
         if(empty($this->post('patient_id')))
         {
          $invalid['statuscode']='404';
          $invalid['message'] = "Patient id is mandatory";
          $this->set_response($invalid, REST_Controller::HTTP_NOT_FOUND);

         }
         else
         {
         $options = array(
        //'diagnosis_id' => $id."-".time(),
        'patient_id' => trim($this->post('patient_id')),
        'blood_group' => trim($this->post('blood_group')),
        'height' => trim($this->post('height')),
        'weight' => trim($this->post('weight')),
        'temperature' => trim($this->post('temperature')),
        'body_pain' => trim($this->post('body_pain')),
        'heart_rate' => trim($this->post('heart_rate')),
        'sugar_level' => trim($this->post('sugar_level')),
        'bp' => trim($this->post('bp')),
        'paleness_face_nail' => trim($this->post('paleness_face_nail')),
        'haemoglobin' => trim($this->post('haemoglobin')),
        'urine_albumin' => trim($this->post('urine_albumin')),
        'urine_sugar' => trim($this->post('urine_sugar')),
        'blood_sugar' => trim($this->post('blood_sugar')),
        'anaemia' => trim($this->post('anaemia')),
        'observation_i' => trim($this->post('observation_i')),
        'recommendation' => trim($this->post('recommendation')),
        'referrals' => trim($this->post('referrals')),
        'treatment' => trim($this->post('treatment')),
        'de_worming' => trim($this->post('de_worming')),
        'vaccination' => trim($this->post('vaccination')),
        'vitamin_a' => trim($this->post('vitamin_a')),
        'ifa' => trim($this->post('ifa')),
        'blood' => trim($this->post('blood')),
        'urine' => trim($this->post('urine')),
        'body_fluids' => trim($this->post('body_fluids')),
        'imaging' => trim($this->post('imaging')),
        'mortality' => trim($this->post('mortality')),
        'preliminary_diagnosis' => trim($this->post('preliminary_diagnosis')),
        'final_diagnosis' => trim($this->post('final_diagnosis')),
        'circulatory_id' => trim($this->post('circulatory_id')),
        'digestive_id' => trim($this->post('digestive_id')),
        'skin_id' => trim($this->post('skin_id')),
        'nervous_id' => trim($this->post('nervous_id')),
        'urinary_id' => trim($this->post('urinary_id')),
        'speech_id' => trim($this->post('speech_id')),
        'general_id' => trim($this->post('general_id')),
        'cognition_id' => trim($this->post('cognition_id')),
        'next_follow_up' => date('Y-m-d',strtotime($this->post('next_follow_up'))),
        'diagnosis_by' => $id
        );
         $affectedRow=$this->Users_model->diagnosis($options);
         if($affectedRow>0)
         {
         $data['statuscode']='200';
         $data['message']='Patient diagnosis details is inserted.';
         }
         $this->set_response($data , REST_Controller::HTTP_OK); 
       }
      }
    }
    public function getAutoList_post()    
    {
      echo $this->post('search'); exit;
    }
    public function getDiagnosis_post()    
    {
       $jwt=$this->post('token');
       $output= tocken_auth($jwt);
       if(empty($output['id']))
       {
          $this->set_response($output, REST_Controller::HTTP_NOT_FOUND);
       }
       else
       {
         $options=array();
         if(!empty($this->post('search'))){
         $search = '%'.$this->post('search').'%';
         $options['key']= " where first_name like '$search' or last_name like '$search' or CONCAT( first_name,  ' ', last_name ) LIKE '$search'"; 
         } 
        //var_dump($options);*/
       $output['statuscode']='200';
       $output['patient_list']=$this->Users_model->getPatient_list($options);
       $this->set_response($output , REST_Controller::HTTP_OK); 
     }
    }
    public function prescription_post()
    {
       $jwt=$this->post('token');
       $output= tocken_auth($jwt);
       if(empty($output['id']))
       {
          $this->set_response($output, REST_Controller::HTTP_NOT_FOUND);
       }
       else
       {
        if(empty($this->post('patient_id')))
         {
          $invalid['statuscode']='404';
          $invalid['message'] = "Patient id is mandatory";
          $this->set_response($invalid, REST_Controller::HTTP_NOT_FOUND);

         }
         else
         {
         $id=$output['id']; 
         $options = array( 
        'patient_id' => $this->post('patient_id'),
        'tab_cap_syrup' => $this->post('tab_cap_syrup'),
        'description' => $this->post('description'),
        'bb' => $this->post('bb'),
        'ab' => $this->post('ab'),
        'bl' => $this->post('bl'),
        'al' => $this->post('al'),
        'eve' => $this->post('eve'),
        'bm' => $this->post('bm'),
        'am' => $this->post('am'),
        'days' => $this->post('days'),
        'prescribed_by' => $id
        );
         $affectedRow=$this->Users_model->prescription($options);
         if($affectedRow>0)
         {
         $data['statuscode']='200';
         $data['message']='Prescription details is inserted.';
         }
         $this->set_response($data , REST_Controller::HTTP_OK); 
         }
       }

    }

    public function get_masters_post()
    {
       $jwt=$this->post('token');
       $output= tocken_auth($jwt);
       if(empty($output['id']))
       {
          $this->set_response($output, REST_Controller::HTTP_NOT_FOUND);
       }
       else
       {
         $options=array();
         if(!empty($this->post('master_type'))){
         $master_type = $this->post('master_type');
         $options['key']= " where master_type like '$master_type'"; 
         } 
         $output2['statuscode']='200';
         $output2['masters']=$this->Users_model->get_masters($options);
         $this->set_response($output2 , REST_Controller::HTTP_OK); 
       }
    }
    public function getprescription_list_post()
    {
       $jwt=$this->post('token');
       $output= tocken_auth($jwt);
       if(empty($output['id']))
       {
          $this->set_response($output, REST_Controller::HTTP_NOT_FOUND);
       }
       else
       {
         if(empty($this->post('patient_id')))
         {
          $invalid['statuscode']='404';
          $invalid['message'] = "Patient id is mandatory";
          $this->set_response($invalid, REST_Controller::HTTP_NOT_FOUND);

         }
         else
         {
         $options=array();
         if(!empty($this->post('patient_id'))){
         $patient_id = $this->post('patient_id');
         $options['key']= " where reg.id =$patient_id";
         } 
         if(!empty($this->post('name'))){
         $name = '%'.$this->post('name').'%';
         $options['key']= " where users.name LIKE '$name' or reg.first_name LIKE '$name' or reg.last_name LIKE '$name' or CONCAT( reg.initials, ' ',reg.first_name,  ' ', reg.last_name ) LIKE '$name'";
         } 
         $output2['statuscode']='200';
         $output2['masters']=$this->Users_model->get_prescription($options);
         $this->set_response($output2 , REST_Controller::HTTP_OK); 
         }
       }
    }
    public function referral_post()
    {
       $jwt=$this->post('token');
       $output= tocken_auth($jwt);
       if(empty($output['id']))
       {
          $this->set_response($output, REST_Controller::HTTP_NOT_FOUND);
       }
       else
       {
         $id=$output['id']; 
         if(empty($this->post('patient_id')))
         {
          $invalid['statuscode']='404';
          $invalid['message'] = "Patient id is mandatory";
          $this->set_response($invalid, REST_Controller::HTTP_NOT_FOUND);

         }
         else
         {
           $options = array( 
          'patient_id' => $this->post('patient_id'),
          'referred_to' => trim($this->post('referred_to')),
          'hospital_id' => $this->post('hospital_id'),
          'preliminary_diagnosis' => $this->post('preliminary_diagnosis'),
          'final_diagnosis' => $this->post('final_diagnosis'),
          'referred_by' => $id
          );
           $affectedRow=$this->Users_model->referral($options);
           if($affectedRow>0)
           {
             $data['statuscode']='200';
             $data['message']='Referral details is inserted.';
           }
           $this->set_response($data , REST_Controller::HTTP_OK); 
         }
       }

    }
    public function gethospital_post()
    {
       $jwt=$this->post('token');
       $output= tocken_auth($jwt);
       if(empty($output['id']))
       {
          $this->set_response($output, REST_Controller::HTTP_NOT_FOUND);
       }
       else
       {
         $options=array();
         $output2['statuscode']='200';
         $output2['hospital']=$this->Users_model->gethospital($options);
         $this->set_response($output2 , REST_Controller::HTTP_OK); 
       }
    }
    public function getAwarenessTypes_post()    
    {
       $jwt=$this->post('token');
       $output= tocken_auth($jwt);
       if(empty($output['id']))
       {
          $this->set_response($output, REST_Controller::HTTP_NOT_FOUND);
       }
       else
       {
         $options=array();
          
        //var_dump($options);*/
       $output['statuscode']='200';
       @$options['key']=" where status='1'";
       $output['awareness_list']=$this->Users_model->getAwarenessTypes($options);
       $this->set_response($output , REST_Controller::HTTP_OK); 
     }
    }

    public function awareness_post()
    {
       $jwt=$this->post('token');
       $output= tocken_auth($jwt);
       if(empty($output['id']))
       {
          $this->set_response($output, REST_Controller::HTTP_NOT_FOUND);
       }
       else
       {
         $id=$output['id'];          
           $options = array( 
          'state' => $this->post('state'),
          'distirct_or_city' => trim($this->post('distirct_or_city')),
          'block_or_zone' => $this->post('block_or_zone'),
          'panchyat_or_ward' => $this->post('panchyat_or_ward'),
          'village_or_slum' => $this->post('village_or_slum'),
          'awareness_type' => $this->post('awareness_type'),
          'attendees' => $this->post('attendees'),
          'boys_above_18' => $this->post('boys_above_18'),
          'girls_above_18' => $this->post('girls_above_18'),
          'male_above_30' => $this->post('male_above_30'),
          'female_above_30' => $this->post('female_above_30'),
          'male_below_30' => $this->post('male_below_30'),
          'female_below_30' => $this->post('female_below_30'),
          'reported_by' => $id
          );
           $affectedRow=$this->Users_model->awareness($options);
           if($affectedRow>0)
           {
             $data['statuscode']='200';
             $data['message']='Awareness details is inserted.';
           }
           $this->set_response($data , REST_Controller::HTTP_OK); 
         
       }

    }

    public function getAwarenessList_post()    
    {
       $jwt=$this->post('token');
       $output= tocken_auth($jwt);
       if(empty($output['id']))
       {
          $this->set_response($output, REST_Controller::HTTP_NOT_FOUND);
       }
       else
       {
         $reported_by=$this->post('reported_by');
         if(!empty($reported_by))
         {
         $options=array();
         @$options['key']=" where awr.reported_by=$reported_by";
        //var_dump($options);*/
       $output['statuscode']='200';
       $output['awareness_list']=$this->Users_model->getAwarenessList($options);
       $this->set_response($output , REST_Controller::HTTP_OK); 
       }
       else
       {
          @$invalid['message']="reported_by id is mandatory";
          $this->set_response($invalid, REST_Controller::HTTP_NOT_FOUND);
       }
     }
    }

    public function offLineMasters_post()    
    {
       $jwt=$this->post('token');
       $output= tocken_auth($jwt);
       if(empty($output['id']))
       {
          $this->set_response($output, REST_Controller::HTTP_NOT_FOUND);
       }
       else
       {
       $state=array('table'=>'state_list','key'=>' order by state_name asc');
       $data['state_list']=$this->Users_model->get_details($state); 

       $district=array('table'=>'district_list','key'=>' order by district_name asc');
       $data['district_list']=$this->Users_model->get_details($district);

       $city=array('table'=>'city_or_block','key'=>' order by city_name asc');
       $data['city_list']=$this->Users_model->get_details($city);

       $panchayat=array('table'=>'ward_or_panchayat','key'=>' order by panchayat_name asc');
       $data['panchayat_list']=$this->Users_model->get_details($panchayat);

       $village=array('table'=>'slum_or_village','key'=>' order by village_name asc');
       $data['village_list']=$this->Users_model->get_details($village);

       $masters=array('table'=>'masters','key'=>' order by master_type asc');
       $data['masters_list']=$this->Users_model->get_details($masters);

       $data['statuscode']='200';
       $this->set_response($data , REST_Controller::HTTP_OK); 
      
     }
    }
}
?>
