<?php
class Admin_model extends CI_Model {
    public function __construct() {
        $this->load->database();
    }
    public function login($username, $password) {
        $this->db->select('*');
  $this->db->from('users');
  $this->db->where('username', $username);
  $this->db->where('password', $password);
  $query = $this->db->get();
        if ($query->num_rows() == 1) {
            $result = $query->result();
            return $result[0]->id;
        }
        return false;
    }

    public function registration($data){
	    $this->db->insert('registration', $data); 
	    return $this->db->insert_id();
    }	
    public function get_patient_details($options  = array(),$count=NULL) 
    {     
      $query = "select reg.*,sl.state_name,dl.district_name,cb.city_name,wp.panchayat_name,sv.village_name , users.name as register_name from registration reg left join state_list sl on reg.state=sl.id left join district_list dl on reg.district=dl.id left join city_or_block cb on reg.city_block=cb.id left join ward_or_panchayat wp on reg.ward_or_panchayat=wp.id left join slum_or_village sv on reg.slum_or_village=sv.id left join users on reg.registration_by=users.id";
  		if(isset($options['key']))
  		{
  			$query .= $options['key'].' ';
  		}
  		if(isset($options['offset']))
  		{
  			$options['offset'] = !empty($options['offset']) ? $options['offset'] : 0;
  			$query .= " limit ".$options['offset'].",".$options['limit'];
  		}
      //$query.=" order by date_of_registration desc";
  		//echo $query; exit;
  		$response = $this->db->query($query);
  		if($response->num_rows() > 0)
     		{
  	   		if($count == 'counts')
  	   		{
  	   			return $response->num_rows();
  	   		}
  	       	else
  	      	{
  	      		return $response->result_array();
  	      	}
  	   
        	}
  	    else 
  	    {
  	    	return false;
  	    }
    }

    public function get_doctors_list($options  = array(),$count=NULL) {
     
      $query = 'select * from users';
      if(isset($options['key']))
      {
        $query .= $options['key'].' ';
      }
      if(isset($options['offset']))
      {
        $options['offset'] = !empty($options['offset']) ? $options['offset'] : 0;
        $query .= " limit ".$options['offset'].",".$options['limit'];
      }
      //$query.=" order by date_of_registration desc";
      //echo $query; exit;
      $response = $this->db->query($query);
      if($response->num_rows() > 0)
        {
          if($count == 'counts')
          {
            return $response->num_rows();
          }
            else
            {
              return $response->result_array();
            }
       
          }
        else 
        {
          return false;
        }
    }

    function login_authenticate($username,$password)
    {     
    //$this->db->select('id,username,password');
   // $where = array('username'=>$username,'password'=>$password,);
    //$this->db->where($where);
   // $query = $this->db->get_where('users',$where);
    $query=$this->db->query("select users.*,ul.user_role from users left join user_role ul on users.user_role=ul.id where users.username like '$username' and users.password like '$password' and ul.user_role like 'Admin'");
      $count = $query->num_rows();
      $result = $query->result_array();       
      if($count>0)
      {
         $user_details = array('username'=>$result[0]['username'],'user_role'=>$result[0]['user_role'],'userid'=>@$result[0]['id'],'is_active'=>$result[0]['is_active'],'name'=>$result[0]['name'],'email'=>$result[0]['email']);
        $this->session->set_userdata($user_details);
        return $result;
      }
      else 
      {
        return false;
      }
    }

   public function get_workers_details($options  = array(),$count=NULL) {
     
      $query = 'select users.* from users left join user_role UR on users.user_role=UR.id';
      if(isset($options['key']))
      {
        $query .= $options['key'].' ';
      }
      if(isset($options['offset']))
      {
        $options['offset'] = !empty($options['offset']) ? $options['offset'] : 0;
        $query .= " limit ".$options['offset'].",".$options['limit'];
      }
      //$query.=" order by date_of_registration desc";
      //echo $query; exit;
      $response = $this->db->query($query);
      if($response->num_rows() > 0)
        {
          if($count == 'counts')
          {
            return $response->num_rows();
          }
            else
            {
              return $response->result_array();
            }
       
          }
        else 
        {
          return false;
        }
    }

  public function get_doctors_details($options  = array(),$count=NULL) 
  {     
      $query = 'select users.* from users left join user_role UR on users.user_role=UR.id';
      if(isset($options['key']))
      {
        $query .= $options['key'].' ';
      }
      if(isset($options['offset']))
      {
        $options['offset'] = !empty($options['offset']) ? $options['offset'] : 0;
        $query .= " limit ".$options['offset'].",".$options['limit'];
      }
      //$query.=" order by date_of_registration desc";
      //echo $query; exit;
      $response = $this->db->query($query);
      if($response->num_rows() > 0)
        {
          if($count == 'counts')
          {
            return $response->num_rows();
          }
            else
            {
              return $response->result_array();
            }
       
          }
        else 
        {
          return false;
        }
  }

  public function adddoctor($params = array(),$response=array())
  {
     $data = array(
            'username' => trim($params['username']),
            'password' => trim($params['password']),
            'name' => trim($params['name']),
            'email' => trim($params['email']),
            'user_role' => trim($params['user_role']),
            'is_active'=>trim($params['isactive']),
        );
        
     $this->db->insert('users', $data);

     if($this->db->insert_id()){
      $response = $this->db->insert_id();
     }else{
      $response =false;
     }
     return  $response;
  }
  
  public function editdoctor($params = array(),$response = array()){
    $update = array(
        'username' => trim($params['username']),
        'name' => trim($params['name']),
        'email' => trim($params['email']),
        'is_active' => trim($params['is_active']),
         );
    if(@$params['device_id']=='reset')
     {
      $update['device_id']='';
     }
     $responseval = $this->db->where('id',trim($params['id']))->update('users', $update);
    // echo $this->db->last_query();exit;
      if($responseval){
      $response = array('status'=>'success');
     }else{
      $response = array('status'=>'failure');
     }
     return  $response;
     
  }
  
   public function deletedoctor($id = NULL){
    /*$query1 = $this->db->get_where('affiliates',array('default_banker'=>$id));
       $query2 = $this->db->get_where('client_details',array('banker_id'=>$id));
    if(($query1->num_rows()==0)&&($query2->num_rows()==0))
    {*/
    if($this->db->delete('users',array('id' => $id)))
    {
      return true;
    }
    else 
    {
      return false;
    }
    /*}
    else
    {
      return false;
    }*/
    
   }

  public function get_details($options  = array(),$count=NULL) 
  {
      $query = 'select * from '.$options['table'];
      if(isset($options['key']))
      {
        $query .= $options['key'].' ';
      }
      if(isset($options['offset']))
      {
        $options['offset'] = !empty($options['offset']) ? $options['offset'] : 0;
        $query .= " limit ".$options['offset'].",".$options['limit'];
      }
      //$query.=" order by date_of_registration desc";
      //echo $query; exit;
      $response = $this->db->query($query);
      if($response->num_rows() > 0)
        {
          if($count == 'counts')
          {
            return $response->num_rows();
          }
            else
            {
              return $response->result_array();
            }
       
          }
        else 
        {
          return false;
        }
    }

  public function addworkers($params = array(),$response=array())
  {
     $data = array(
            'username' => trim($params['username']),
            'password' => trim($params['password']),
            'name' => trim($params['name']),
            'email' => trim($params['email']),
            'user_role' => trim($params['user_role']),
            'is_active'=>trim($params['isactive']),
        );
        
     $this->db->insert('users', $data);

     if($this->db->insert_id()){
      $response = $this->db->insert_id();
     }else{
      $response =false;
     }
     return  $response;
  }

  public function deleteworker($id = NULL){
    /*$query1 = $this->db->get_where('affiliates',array('default_banker'=>$id));
       $query2 = $this->db->get_where('client_details',array('banker_id'=>$id));
    if(($query1->num_rows()==0)&&($query2->num_rows()==0))
    {*/
    if($this->db->delete('users',array('id' => $id)))
    {
      return true;
    }
    else 
    {
      return false;
    }
    /*}
    else
    {
      return false;
    }*/
    
   }

   public function editworker($params = array(),$response = array()){
    $update = array(
        'username' => trim($params['username']),
        'name' => trim($params['name']),
        'email' => trim($params['email']),
        'is_active' => trim($params['is_active']),
         );
    if(@$params['device_id']=='reset')
     {
      $update['device_id']='';
     }
     $responseval = $this->db->where('id',trim($params['id']))->update('users', $update);
    // echo $this->db->last_query();exit;
      if($responseval){
      $response = array('status'=>'success');
     }else{
      $response = array('status'=>'failure');
     }
     return  $response;
     
  }
  public function manage_prescription($options  = array(),$count=NULL) 
  {     
      $query = 'select pc.*,reg.title as patient_title,reg.initials as patient_initials, reg.first_name as patientfname, reg.last_name as patientlname,users.name as prescript_name from prescription pc left join registration reg on pc.patient_id=reg.id left join users on pc.prescribed_by=users.id';
      if(isset($options['key']))
      {
        $query .= $options['key'].' ';
      }
      if(isset($options['offset']))
      {
        $options['offset'] = !empty($options['offset']) ? $options['offset'] : 0;
        $query .= " limit ".$options['offset'].",".$options['limit'];
      }
      //$query.=" order by date_of_registration desc";
      //echo $query; 
      $response = $this->db->query($query);
      if($response->num_rows() > 0)
        {
          if($count == 'counts')
          {
            return $response->num_rows();
          }
            else
            {
              return $response->result_array();
            }
       
          }
        else 
        {
          return false;
        }
    }

  public function manage_diagnosis($options  = array(),$count=NULL) 
  {     
      $query = 'select dg.*,reg.title as patient_title,reg.initials as patient_initials, reg.first_name as patient_fname, reg.last_name as patient_lname,reg.gender as gender,reg.mobile as mobile,users.name as diagnosis_name, ms1.master_value as circulatory_name,ms2.master_value as digestive_name,ms3.master_value as skin_name,ms4.master_value as nervous_name,ms5.master_value as urinary_name,ms6.master_value as speech_name,ms7.master_value as general_name,ms8.master_value as cognition_name from diagnosis dg left join registration reg on dg.patient_id=reg.id left join users on dg.diagnosis_by=users.id left join masters ms1 on dg.circulatory_id=ms1.id left join masters ms2 on dg.digestive_id=ms2.id left join masters ms3 on dg.skin_id=ms3.id left join masters ms4 on dg.nervous_id=ms4.id left join masters ms5 on dg.urinary_id=ms5.id left join masters ms6 on dg.speech_id=ms6.id left join masters ms7 on dg.general_id=ms7.id left join masters ms8 on dg.cognition_id=ms8.id';
      if(isset($options['key']))
      {
        $query .= $options['key'].' ';
      }
      if(isset($options['offset']))
      {
        $options['offset'] = !empty($options['offset']) ? $options['offset'] : 0;
        $query .= " limit ".$options['offset'].",".$options['limit'];
      }
      //$query.=" order by date_of_registration desc";
      //echo $query; 
      $response = $this->db->query($query);
      if($response->num_rows() > 0)
        {
          if($count == 'counts')
          {
            return $response->num_rows();
          }
            else
            {
              return $response->result_array();
            }
       
          }
        else 
        {
          return false;
        }
    }
  public function manage_referrals($options  = array(),$count=NULL) 
  {     
      $query = 'select rf.*,reg.title as patient_title,reg.initials as patient_initials, reg.first_name as patientfname, reg.last_name as patientlname,users.name as referral_name,hl.hospital_name as hospital_name from referrals rf left join registration reg on rf.patient_id=reg.id left join users on rf.referred_by=users.id left join hospitals_list hl on rf.hospital_id=hl.id';
      if(isset($options['key']))
      {
        $query .= $options['key'].' ';
      }
      if(isset($options['offset']))
      {
        $options['offset'] = !empty($options['offset']) ? $options['offset'] : 0;
        $query .= " limit ".$options['offset'].",".$options['limit'];
      }
      //$query.=" order by date_of_registration desc";
      //echo $query; 
      $response = $this->db->query($query);
      if($response->num_rows() > 0)
        {
          if($count == 'counts')
          {
            return $response->num_rows();
          }
            else
            {
              return $response->result_array();
            }
       
          }
        else 
        {
          return false;
        }
    }

  public function manage_state($options  = array(),$count=NULL) 
  {     
      $query = 'select * from state_list';
      if(isset($options['key']))
      {
        $query .= $options['key'].' ';
      }
      if(isset($options['offset']))
      {
        $options['offset'] = !empty($options['offset']) ? $options['offset'] : 0;
        $query .= " limit ".$options['offset'].",".$options['limit'];
      }
      //$query.=" order by date_of_registration desc";
      //echo $query; exit;
      $response = $this->db->query($query);
      if($response->num_rows() > 0)
        {
          if($count == 'counts')
          {
            return $response->num_rows();
          }
            else
            {
              return $response->result_array();
            }
       
          }
        else 
        {
          return false;
        }
    }

  public function add_state($params = array(),$response=array())
  {
     $data = array(
            'state_name' => trim($params['state_name'])
        );
        
     $this->db->insert('state_list', $data);

     if($this->db->insert_id()){
      $response = $this->db->insert_id();
     }else{
      $response =false;
     }
     return  $response;
  }
  public function editstate($params = array(),$response = array()){
    $update = array(
        'state_name' => trim($params['state_name'])
         );    
     $responseval = $this->db->where('id',trim($params['id']))->update('state_list', $update);
    // echo $this->db->last_query();exit;
      if($responseval){
      $response = array('status'=>'success');
     }else{
      $response = array('status'=>'failure');
     }
     return  $response;
     
  }
  public function deletestate($id = NULL){
    /*$query1 = $this->db->get_where('affiliates',array('default_banker'=>$id));
       $query2 = $this->db->get_where('client_details',array('banker_id'=>$id));
    if(($query1->num_rows()==0)&&($query2->num_rows()==0))
    {*/
    if($this->db->delete('state_list',array('id' => $id)))
    {
      return true;
    }
    else 
    {
      return false;
    }
    /*}
    else
    {
      return false;
    }*/
    
   }
  public function manage_hospitals($options  = array(),$count=NULL) 
  {     
      $query = 'select * from hospitals_list';
      if(isset($options['key']))
      {
        $query .= $options['key'].' ';
      }
      if(isset($options['offset']))
      {
        $options['offset'] = !empty($options['offset']) ? $options['offset'] : 0;
        $query .= " limit ".$options['offset'].",".$options['limit'];
      }
      //$query.=" order by date_of_registration desc";
      //echo $query; exit;
      $response = $this->db->query($query);
      if($response->num_rows() > 0)
        {
          if($count == 'counts')
          {
            return $response->num_rows();
          }
            else
            {
              return $response->result_array();
            }
       
          }
        else 
        {
          return false;
        }
    }

  public function add_hospital($params = array(),$response=array())
  {
     $data = array(
            'hospital_name' => trim($params['hospital_name'])
        );
        
     $this->db->insert('hospitals_list', $data);

     if($this->db->insert_id()){
      $response = $this->db->insert_id();
     }else{
      $response =false;
     }
     return  $response;
  }
  public function edithospital($params = array(),$response = array()){
    $update = array(
        'hospital_name' => trim($params['hospital_name'])
         );    
     $responseval = $this->db->where('id',trim($params['id']))->update('hospitals_list', $update);
    // echo $this->db->last_query();exit;
      if($responseval){
      $response = array('status'=>'success');
     }else{
      $response = array('status'=>'failure');
     }
     return  $response;
     
  }

  public function deletehospital($id = NULL){
    /*$query1 = $this->db->get_where('affiliates',array('default_banker'=>$id));
       $query2 = $this->db->get_where('client_details',array('banker_id'=>$id));
    if(($query1->num_rows()==0)&&($query2->num_rows()==0))
    {*/
    if($this->db->delete('hospitals_list',array('id' => $id)))
    {
      return true;
    }
    else 
    {
      return false;
    }
    /*}
    else
    {
      return false;
    }*/
    
   }

  public function manage_district($options  = array(),$count=NULL) 
  {     
      $query = 'select dl.*, sl.state_name from district_list dl left join state_list sl on dl.state_id=sl.id';
      if(isset($options['key']))
      {
        $query .= $options['key'].' ';
      }
      if(isset($options['offset']))
      {
        $options['offset'] = !empty($options['offset']) ? $options['offset'] : 0;
        $query .= " limit ".$options['offset'].",".$options['limit'];
      }
      //$query.=" order by date_of_registration desc";
      //echo $query; exit;
      $response = $this->db->query($query);
      if($response->num_rows() > 0)
        {
          if($count == 'counts')
          {
            return $response->num_rows();
          }
            else
            {
              return $response->result_array();
            }
       
          }
        else 
        {
          return false;
        }
    }
  public function add_district($params = array(),$response=array())
  {
     $data = array(
            'state_id' => trim($params['state_id']),
            'district_name' => trim($params['district_name'])
        );
        
     $this->db->insert('district_list', $data);

     if($this->db->insert_id()){
      $response = $this->db->insert_id();
     }else{
      $response =false;
     }
     return  $response;
  }

  public function editdistrict($params = array(),$response = array()){
    $update = array(
        'state_id' => trim($params['state_id']),
        'district_name' => trim($params['district_name'])
         );    
     $responseval = $this->db->where('id',trim($params['id']))->update('district_list', $update);
    // echo $this->db->last_query();exit;
      if($responseval){
      $response = array('status'=>'success');
     }else{
      $response = array('status'=>'failure');
     }
     return  $response;
     
  }

  public function deletedistrict($id = NULL){
    /*$query1 = $this->db->get_where('affiliates',array('default_banker'=>$id));
       $query2 = $this->db->get_where('client_details',array('banker_id'=>$id));
    if(($query1->num_rows()==0)&&($query2->num_rows()==0))
    {*/
    if($this->db->delete('district_list',array('id' => $id)))
    {
      return true;
    }
    else 
    {
      return false;
    }
    /*}
    else
    {
      return false;
    }*/
    
   }
  public function manage_city($options  = array(),$count=NULL) 
  {     
      $query = 'select cb.*, sl.state_name,dl.district_name from city_or_block cb left join state_list sl on cb.state_id=sl.id left join district_list dl on cb.district_id=dl.id';
      if(isset($options['key']))
      {
        $query .= $options['key'].' ';
      }
      if(isset($options['offset']))
      {
        $options['offset'] = !empty($options['offset']) ? $options['offset'] : 0;
        $query .= " limit ".$options['offset'].",".$options['limit'];
      }
      //$query.=" order by date_of_registration desc";
      //echo $query; exit;
      $response = $this->db->query($query);
      if($response->num_rows() > 0)
        {
          if($count == 'counts')
          {
            return $response->num_rows();
          }
            else
            {
              return $response->result_array();
            }
       
          }
        else 
        {
          return false;
        }
    }
  public function add_city($params = array(),$response=array())
  {
     $data = array(
            'state_id' => trim($params['state_id']),
            'district_id' => trim($params['district_id']),
            'city_name' => trim($params['city_name'])
        );
        
     $this->db->insert('city_or_block', $data);

     if($this->db->insert_id()){
      $response = $this->db->insert_id();
     }else{
      $response =false;
     }
     return  $response;
  }

  public function editcity($params = array(),$response = array()){
    $update = array(
        'state_id' => trim($params['state_id']),
        'district_id' => trim($params['district_id']),
        'city_name' => trim($params['city_name'])
         );    
     $responseval = $this->db->where('id',trim($params['id']))->update('city_or_block', $update);
    // echo $this->db->last_query();exit;
      if($responseval){
      $response = array('status'=>'success');
     }else{
      $response = array('status'=>'failure');
     }
     return  $response;
     
  }

  public function deletecity($id = NULL){
    /*$query1 = $this->db->get_where('affiliates',array('default_banker'=>$id));
       $query2 = $this->db->get_where('client_details',array('banker_id'=>$id));
    if(($query1->num_rows()==0)&&($query2->num_rows()==0))
    {*/
    if($this->db->delete('city_or_block',array('id' => $id)))
    {
      return true;
    }
    else 
    {
      return false;
    }
    /*}
    else
    {
      return false;
    }*/
    
   }

  public function manage_panchayat($options  = array(),$count=NULL) 
  {     
      $query = 'select wp.*, sl.state_name,dl.district_name,cb.city_name from ward_or_panchayat wp left join state_list sl on wp.state_id=sl.id left join district_list dl on wp.district_id=dl.id left join city_or_block cb on wp.city_id=cb.id';
      if(isset($options['key']))
      {
        $query .= $options['key'].' ';
      }
      if(isset($options['offset']))
      {
        $options['offset'] = !empty($options['offset']) ? $options['offset'] : 0;
        $query .= " limit ".$options['offset'].",".$options['limit'];
      }
      //$query.=" order by date_of_registration desc";
      //echo $query; exit;
      $response = $this->db->query($query);
      if($response->num_rows() > 0)
        {
          if($count == 'counts')
          {
            return $response->num_rows();
          }
            else
            {
              return $response->result_array();
            }
       
          }
        else 
        {
          return false;
        }
    }

  public function add_panchayat($params = array(),$response=array())
  {
     $data = array(
            'state_id' => trim($params['state_id']),
            'district_id' => trim($params['district_id']),
            'city_id' => trim($params['city_id']),
            'panchayat_name' => trim($params['panchayat_name'])
        );
        
     $this->db->insert('ward_or_panchayat', $data);

     if($this->db->insert_id()){
      $response = $this->db->insert_id();
     }else{
      $response =false;
     }
     return  $response;
  }
  public function editpanchayat($params = array(),$response = array()){
    $update = array(
        'state_id' => trim($params['state_id']),
        'district_id' => trim($params['district_id']),
        'city_id' => trim($params['city_id']),
        'panchayat_name' => trim($params['panchayat_name'])
         );    
     $responseval = $this->db->where('id',trim($params['id']))->update('ward_or_panchayat', $update);
    // echo $this->db->last_query();exit;
      if($responseval){
      $response = array('status'=>'success');
     }else{
      $response = array('status'=>'failure');
     }
     return  $response;
     
  }
  public function deletepanchayat($id = NULL){
    /*$query1 = $this->db->get_where('affiliates',array('default_banker'=>$id));
       $query2 = $this->db->get_where('client_details',array('banker_id'=>$id));
    if(($query1->num_rows()==0)&&($query2->num_rows()==0))
    {*/
    if($this->db->delete('ward_or_panchayat',array('id' => $id)))
    {
      return true;
    }
    else 
    {
      return false;
    }
    /*}
    else
    {
      return false;
    }*/
    
   }

  public function manage_village($options  = array(),$count=NULL) 
  {     
      $query = 'select sv.*, wp.panchayat_name, sl.state_name,dl.district_name,cb.city_name from slum_or_village sv left join state_list sl on sv.state_id=sl.id left join district_list dl on sv.district_id=dl.id left join city_or_block cb on sv.city_id=cb.id left join ward_or_panchayat wp on sv.panchayat_id=wp.id';
      if(isset($options['key']))
      {
        $query .= $options['key'].' ';
      }
      if(isset($options['offset']))
      {
        $options['offset'] = !empty($options['offset']) ? $options['offset'] : 0;
        $query .= " limit ".$options['offset'].",".$options['limit'];
      }
      //$query.=" order by date_of_registration desc";
      //echo $query; exit;
      $response = $this->db->query($query);
      if($response->num_rows() > 0)
        {
          if($count == 'counts')
          {
            return $response->num_rows();
          }
            else
            {
              return $response->result_array();
            }
       
          }
        else 
        {
          return false;
        }
    }
  public function add_village($params = array(),$response=array())
  {
     $data = array(
            'state_id' => trim($params['state_id']),
            'district_id' => trim($params['district_id']),
            'city_id' => trim($params['city_id']),
            'panchayat_id' => trim($params['panchayat_id']),
            'village_name' => trim($params['village_name'])
        );
        
     $this->db->insert('slum_or_village', $data);

     if($this->db->insert_id()){
      $response = $this->db->insert_id();
     }else{
      $response =false;
     }
     return  $response;
  }
  public function editvillage($params = array(),$response = array()){
    $update = array(
        'state_id' => trim($params['state_id']),
        'district_id' => trim($params['district_id']),
        'city_id' => trim($params['city_id']),
        'panchayat_id' => trim($params['panchayat_id']),
        'village_name' => trim($params['village_name'])
         );    
     $responseval = $this->db->where('id',trim($params['id']))->update('slum_or_village', $update);
    // echo $this->db->last_query();exit;
      if($responseval){
      $response = array('status'=>'success');
     }else{
      $response = array('status'=>'failure');
     }
     return  $response;
     
  }
  public function deletevillage($id = NULL){
    /*$query1 = $this->db->get_where('affiliates',array('default_banker'=>$id));
       $query2 = $this->db->get_where('client_details',array('banker_id'=>$id));
    if(($query1->num_rows()==0)&&($query2->num_rows()==0))
    {*/
    if($this->db->delete('slum_or_village',array('id' => $id)))
    {
      return true;
    }
    else 
    {
      return false;
    }
    /*}
    else
    {
      return false;
    }*/
    
   }

  public function manage_awareness_type($options  = array(),$count=NULL) 
  {     
      $query = 'select * from awareness_type';
      if(isset($options['key']))
      {
        $query .= $options['key'].' ';
      }
      if(isset($options['offset']))
      {
        $options['offset'] = !empty($options['offset']) ? $options['offset'] : 0;
        $query .= " limit ".$options['offset'].",".$options['limit'];
      }
      //$query.=" order by date_of_registration desc";
      //echo $query; exit;
      $response = $this->db->query($query);
      if($response->num_rows() > 0)
        {
          if($count == 'counts')
          {
            return $response->num_rows();
          }
            else
            {
              return $response->result_array();
            }
       
          }
        else 
        {
          return false;
        }
    }

  public function add_awarenessType($params = array(),$response=array())
  {
     $data = array(
            'awareness_type' => trim($params['awareness_type'])
        );
        
     $this->db->insert('awareness_type', $data);

     if($this->db->insert_id()){
      $response = $this->db->insert_id();
     }else{
      $response =false;
     }
     return  $response;
  }
  public function editAwarnessType($params = array(),$response = array()){
    $update = array(
        'awareness_type' => trim($params['awareness_type']),
        'status' => trim($params['status'])
         );    
     $responseval = $this->db->where('id',trim($params['id']))->update('awareness_type', $update);
    // echo $this->db->last_query();exit;
      if($responseval){
      $response = array('status'=>'success');
     }else{
      $response = array('status'=>'failure');
     }
     return  $response;
     
  }
  public function deleteAwarenessType($id = NULL){
    /*$query1 = $this->db->get_where('affiliates',array('default_banker'=>$id));
       $query2 = $this->db->get_where('client_details',array('banker_id'=>$id));
    if(($query1->num_rows()==0)&&($query2->num_rows()==0))
    {*/
    if($this->db->delete('awareness_type',array('id' => $id)))
    {
      return true;
    }
    else 
    {
      return false;
    }
    /*}
    else
    {
      return false;
    }*/
    
   }
   public function manage_awareness($options  = array(),$count=NULL) 
  {     
      $query = 'select aw.*,sl.state_name,dl.district_name,cb.city_name,wp.panchayat_name,sv.village_name,at.awareness_type,users.name from awareness aw left join state_list sl on aw.state=sl.id left join district_list dl on aw.distirct_or_city=dl.id left join city_or_block cb on aw.block_or_zone=cb.id left join ward_or_panchayat wp on aw.panchyat_or_ward=wp.id left join slum_or_village sv on aw.village_or_slum=sv.id left join awareness_type at on aw.awareness_type=at.id left join users on aw.reported_by=users.id';
      if(isset($options['key']))
      {
        $query .= $options['key'].' ';
      }
      if(isset($options['offset']))
      {
        $options['offset'] = !empty($options['offset']) ? $options['offset'] : 0;
        $query .= " limit ".$options['offset'].",".$options['limit'];
      }
      //$query.=" order by date_of_registration desc";
      //echo $query; exit;
      $response = $this->db->query($query);
      if($response->num_rows() > 0)
        {
          if($count == 'counts')
          {
            return $response->num_rows();
          }
            else
            {
              return $response->result_array();
            }
       
          }
        else 
        {
          return false;
        }
    }

    public function chartcount($options  = array(),$count=NULL) {
     
      $query = 'select count(*) as chartcount from registration';
      if(isset($options['key']))
      {
        $query .= $options['key'].' ';
      }
      if(isset($options['offset']))
      {
        $options['offset'] = !empty($options['offset']) ? $options['offset'] : 0;
        $query .= " limit ".$options['offset'].",".$options['limit'];
      }
      //$query.=" order by date_of_registration desc";
      //echo $query; 
      $response = $this->db->query($query);
      
      return $response->result_array();
          
    }

    public function manage_masterTypes($options  = array(),$count=NULL) {
     
      $query = 'select * from masters_types';
      if(isset($options['key']))
      {
        $query .= $options['key'].' ';
      }
      if(isset($options['offset']))
      {
        $options['offset'] = !empty($options['offset']) ? $options['offset'] : 0;
        $query .= " limit ".$options['offset'].",".$options['limit'];
      }
      //$query.=" order by date_of_registration desc";
      //echo $query; exit;
      $response = $this->db->query($query);
      if($response->num_rows() > 0)
        {
          if($count == 'counts')
          {
            return $response->num_rows();
          }
            else
            {
              return $response->result_array();
            }
       
          }
        else 
        {
          return false;
        }
    }

    public function manage_masters($options  = array(),$count=NULL) {
     
      $query = 'select ms.*,mt.master_name from masters ms left join masters_types mt on ms.master_type=mt.master_key';
      if(isset($options['key']))
      {
        $query .= $options['key'].' ';
      }
      if(isset($options['offset']))
      {
        $options['offset'] = !empty($options['offset']) ? $options['offset'] : 0;
        $query .= " limit ".$options['offset'].",".$options['limit'];
      }
      //$query.=" order by date_of_registration desc";
      //echo $query; exit;
      $response = $this->db->query($query);
      if($response->num_rows() > 0)
        {
          if($count == 'counts')
          {
            return $response->num_rows();
          }
            else
            {
              return $response->result_array();
            }
       
          }
        else 
        {
          return false;
        }
    }

  public function add_diagnosisTypes($params = array(),$response=array())
  {
     $data = array(
            'master_type' => trim($params['master_type']),
            'master_value' => trim($params['master_value'])
        );
        
     $this->db->insert('masters', $data);

     if($this->db->insert_id()){
      $response = $this->db->insert_id();
     }else{
      $response =false;
     }
     return  $response;
  }

  public function editdiagnosisTypes($params = array(),$response = array()){
    $update = array(
        'master_type' => trim($params['master_type']),
        'master_value' => trim($params['master_value'])
         );    
     $responseval = $this->db->where('id',trim($params['id']))->update('masters', $update);
    // echo $this->db->last_query();exit;
      if($responseval){
      $response = array('status'=>'success');
     }else{
      $response = array('status'=>'failure');
     }
     return  $response;
     
  }

   public function deletediagnosisType($id = NULL){
    /*$query1 = $this->db->get_where('affiliates',array('default_banker'=>$id));
       $query2 = $this->db->get_where('client_details',array('banker_id'=>$id));
    if(($query1->num_rows()==0)&&($query2->num_rows()==0))
    {*/
    if($this->db->delete('masters',array('id' => $id)))
    {
      return true;
    }
    else 
    {
      return false;
    }
    /*}
    else
    {
      return false;
    }*/
    
   }

   public function diagnosiscount($options  = array(),$count=NULL) {
      $table='diagnosis';
      if(isset($options['filter']))
      {
      $where=$options['filter'];
      $table="(select * from diagnosis $where) dgn";
      }
      
      $query = "select masters.*,counttable.mastercount from masters left join (SELECT count(circulatory_id) as mastercount,circulatory_id FROM $table group by circulatory_id) counttable on masters.id=counttable.circulatory_id left join masters_types mt on masters.master_type=mt.master_key";
      if(isset($options['key']))
      {
        $query .= $options['key'].' ';
      }
      if(isset($options['offset']))
      {
        $options['offset'] = !empty($options['offset']) ? $options['offset'] : 0;
        $query .= " limit ".$options['offset'].",".$options['limit'];
      }
      //$query.=" order by date_of_registration desc";
      //echo $query; 
      $response = $this->db->query($query);
      
      return $response->result_array();
          
    }

    public function digestive($options  = array(),$count=NULL) {
      $table='diagnosis';
      if(isset($options['filter']))
      {
      $where=$options['filter'];
      $table="(select * from diagnosis $where) dgn";
      }
      $query = "select masters.*,counttable.mastercount from masters left join (SELECT count(digestive_id) as mastercount,digestive_id FROM $table group by digestive_id) counttable on masters.id=counttable.digestive_id left join masters_types mt on masters.master_type=mt.master_key";
      if(isset($options['key']))
      {
        $query .= $options['key'].' ';
      }
      if(isset($options['offset']))
      {
        $options['offset'] = !empty($options['offset']) ? $options['offset'] : 0;
        $query .= " limit ".$options['offset'].",".$options['limit'];
      }
      //$query.=" order by date_of_registration desc";
      //echo $query; 
      $response = $this->db->query($query);
      
      return $response->result_array();
          
    }
    public function skin($options  = array(),$count=NULL) {
      $table='diagnosis';
      if(isset($options['filter']))
      {
      $where=$options['filter'];
      $table="(select * from diagnosis $where) dgn";
      }
      $query = "select masters.*,counttable.mastercount from masters left join (SELECT count(skin_id) as mastercount,skin_id FROM $table group by skin_id) counttable on masters.id=counttable.skin_id left join masters_types mt on masters.master_type=mt.master_key";
      if(isset($options['key']))
      {
        $query .= $options['key'].' ';
      }
      if(isset($options['offset']))
      {
        $options['offset'] = !empty($options['offset']) ? $options['offset'] : 0;
        $query .= " limit ".$options['offset'].",".$options['limit'];
      }
      //$query.=" order by date_of_registration desc";
      //echo $query; 
      $response = $this->db->query($query);
      
      return $response->result_array();
          
    }

    public function nervous($options  = array(),$count=NULL) {
      $table='diagnosis';
      if(isset($options['filter']))
      {
      $where=$options['filter'];
      $table="(select * from diagnosis $where) dgn";
      }
      $query = "select masters.*,counttable.mastercount from masters left join (SELECT count(nervous_id) as mastercount,nervous_id FROM $table group by nervous_id) counttable on masters.id=counttable.nervous_id left join masters_types mt on masters.master_type=mt.master_key";
      if(isset($options['key']))
      {
        $query .= $options['key'].' ';
      }
      if(isset($options['offset']))
      {
        $options['offset'] = !empty($options['offset']) ? $options['offset'] : 0;
        $query .= " limit ".$options['offset'].",".$options['limit'];
      }
      //$query.=" order by date_of_registration desc";
      //echo $query; 
      $response = $this->db->query($query);
      
      return $response->result_array();          
    }
    public function urinary($options  = array(),$count=NULL) {
      $table='diagnosis';
      if(isset($options['filter']))
      {
      $where=$options['filter'];
      $table="(select * from diagnosis $where) dgn";
      }
      $query = "select masters.*,counttable.mastercount from masters left join (SELECT count(urinary_id) as mastercount,urinary_id FROM $table group by urinary_id) counttable on masters.id=counttable.urinary_id left join masters_types mt on masters.master_type=mt.master_key";
      if(isset($options['key']))
      {
        $query .= $options['key'].' ';
      }
      if(isset($options['offset']))
      {
        $options['offset'] = !empty($options['offset']) ? $options['offset'] : 0;
        $query .= " limit ".$options['offset'].",".$options['limit'];
      }
      //$query.=" order by date_of_registration desc";
      //echo $query; 
      $response = $this->db->query($query);
      
      return $response->result_array();          
    }
    public function cognition($options  = array(),$count=NULL) {
      $table='diagnosis';
      if(isset($options['filter']))
      {
      $where=$options['filter'];
      $table="(select * from diagnosis $where) dgn";
      }
      $query = "select masters.*,counttable.mastercount from masters left join (SELECT count(cognition_id) as mastercount,cognition_id FROM $table group by cognition_id) counttable on masters.id=counttable.cognition_id left join masters_types mt on masters.master_type=mt.master_key";
      if(isset($options['key']))
      {
        $query .= $options['key'].' ';
      }
      if(isset($options['offset']))
      {
        $options['offset'] = !empty($options['offset']) ? $options['offset'] : 0;
        $query .= " limit ".$options['offset'].",".$options['limit'];
      }
      //$query.=" order by date_of_registration desc";
      //echo $query; 
      $response = $this->db->query($query);
      
      return $response->result_array();          
    }
    public function speech($options  = array(),$count=NULL) {
      $table='diagnosis';
      if(isset($options['filter']))
      {
      $where=$options['filter'];
      $table="(select * from diagnosis $where) dgn";
      }
      $query = "select masters.*,counttable.mastercount from masters left join (SELECT count(speech_id) as mastercount,speech_id FROM $table group by speech_id) counttable on masters.id=counttable.speech_id left join masters_types mt on masters.master_type=mt.master_key";
      if(isset($options['key']))
      {
        $query .= $options['key'].' ';
      }
      if(isset($options['offset']))
      {
        $options['offset'] = !empty($options['offset']) ? $options['offset'] : 0;
        $query .= " limit ".$options['offset'].",".$options['limit'];
      }
      //$query.=" order by date_of_registration desc";
      //echo $query; 
      $response = $this->db->query($query);
      
      return $response->result_array();          
    }
    public function general($options  = array(),$count=NULL) {
      $table='diagnosis';
      if(isset($options['filter']))
      {
      $where=$options['filter'];
      $table="(select * from diagnosis $where) dgn";
      }
      $query = "select masters.*,counttable.mastercount from masters left join (SELECT count(general_id) as mastercount,general_id FROM $table group by general_id) counttable on masters.id=counttable.general_id left join masters_types mt on masters.master_type=mt.master_key";
      if(isset($options['key']))
      {
        $query .= $options['key'].' ';
      }
      if(isset($options['offset']))
      {
        $options['offset'] = !empty($options['offset']) ? $options['offset'] : 0;
        $query .= " limit ".$options['offset'].",".$options['limit'];
      }
      //$query.=" order by date_of_registration desc";
      //echo $query; 
      $response = $this->db->query($query);
      
      return $response->result_array();          
    }
}
?>
