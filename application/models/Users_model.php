<?php
class Users_model extends CI_Model {
    public function __construct() {
        $this->load->database();
    }
    /*public function login($username, $password) {
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
    }*/

    public function login($username, $password) 
    {
      $this->db->select('*');
      $this->db->from('users');
      $this->db->where('username', $username);
      $this->db->where('password', $password);
      $query = $this->db->get();
        if ($query->num_rows() == 1) {
            $result = $query->result_array();
            return $result;
        }
        return false;
    }

    public function updateDevice($id,$deviceId){
        
     @$update['device_id']=$deviceId;
     
     $this->db->where('id',$id)->update('users', $update);
      
     return  $this->db->affected_rows();
     
  }

    public function registration($data)
    {
    	$this->db->insert('registration', $data); 
    	return $this->db->insert_id();
    }	
    public function child_registration($child)
    {
     $this->db->insert_batch('patient_child', $child);
      return $this->db->insert_id();
    } 
    public function existpatient($email) 
    {
        $this->db->select('*');
        $this->db->from('registration');
        $this->db->where('email', $email);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            $result = $query->result();
            return $result[0]->id;
        }
        return false;
    }
    public function getRegister($table,$where='',$orderby='') {
        $query = 'select * from '.$table;
        if(!empty($where))
        {
          $query .= ' where '.$where;
        }
        if(!empty($orderby))
        {
        $query.=" order by $orderby asc";
        }
        //echo $query; exit;
        $response = $this->db->query($query);
        if($response->num_rows() > 0)
          {
            
                return $response->result_array();
             
         
            }
          else 
          {
            return false;
          }
    }
    public function get_patient_details($options  = array(),$count=NULL) {
     
      $query = 'select reg.*,sl.state_name,dl.district_name,cb.city_name,wp.panchayat_name,sv.village_name from registration reg left join state_list sl on reg.state=sl.id left join district_list dl on reg.district=dl.id left join city_or_block cb on reg.city_block=cb.id left join ward_or_panchayat wp on reg.ward_or_panchayat=wp.id left join slum_or_village sv on reg.slum_or_village=sv.id';
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
              
              if(isset($options['patientid']))
              {
                $output1=array();
                $output1=$response->result_array();
                $sql="select * from patient_child where patient_id=".$options['patientid'];
                $output2= $this->db->query($sql)->result_array();
                $output1[0]["child_list"] = $output2;
                //$v=array_merge($output1, $output2);
                return $output1;
              }
              else
              {
              return $response->result_array();  
              }
              
            }
       
          }
        else 
        {
          return false;
        }
    }

    public function get_patient_details_list($options  = array(),$count=NULL) {
     
      $query = 'select reg.*,sl.state_name,dl.district_name,cb.city_name,wp.panchayat_name,sv.village_name from registration reg left join state_list sl on reg.state=sl.id left join district_list dl on reg.district=dl.id left join city_or_block cb on reg.city_block=cb.id left join ward_or_panchayat wp on reg.ward_or_panchayat=wp.id left join slum_or_village sv on reg.slum_or_village=sv.id';
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
                $output1=array();
                $output1=$response->result_array();
                for($i=0;$i<$response->num_rows();$i++)
                {
                  $sql="select * from patient_child where patient_id=".$output1[$i]['id'];
                  $output2= $this->db->query($sql)->result_array();
                  $output1[$i]["child_list"] = $output2;
                }
                //$v=array_merge($output1, $output2);
                return $output1;
              
              
            }
       
          }
        else 
        {
          return false;
        }
    }

    public function diagnosis($data)
    {
      $this->db->insert('diagnosis', $data); 
      return $this->db->affected_rows();
    } 
    public function getPatient_list($options  = array(),$count=NULL) 
    {
        $query = 'select id,CONCAT(first_name," ",last_name) as name from registration';
        if(isset($options['key']))
        {
          $query .= $options['key'].' ';
        }
        
        $query.=" order by first_name asc";
       
        //echo $query; exit;
        $response = $this->db->query($query);
        if($response->num_rows() > 0)
          {
            
                return $response->result_array();
             
         
            }
          else 
          {
            return false;
          }
    }
    public function prescription($data)
    {
      $this->db->insert('prescription', $data); 
      return $this->db->affected_rows();
    }
    public function get_masters($options  = array(),$count=NULL) 
    {
        $query = 'select * from masters';
        if(isset($options['key']))
        {
          $query .= $options['key'].' ';
        }
        
        $query.=" order by master_value asc";
       
        //echo $query; exit;
        $response = $this->db->query($query);
        if($response->num_rows() > 0)
          {
            
                return $response->result_array();
             
         
            }
          else 
          {
            return false;
          }
    }
  public function get_prescription($options  = array(),$count=NULL) 
  {     
      $query = 'select pc.*,reg.initials as patient_initials, reg.first_name as patient_fname, reg.last_name as patient_lname,users.name as prescript_name from prescription pc left join registration reg on pc.patient_id=reg.id left join users on pc.prescribed_by=users.id';
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
    public function referral($data)
    {
      $this->db->insert('referrals', $data); 
      return $this->db->affected_rows();
    } 
    public function gethospital($options  = array(),$count=NULL) 
    {
        $query = 'select * from hospitals_list';
        if(isset($options['key']))
        {
          $query .= $options['key'].' ';
        }
        
        $query.=" order by hospital_name asc";
       
        //echo $query; exit;
        $response = $this->db->query($query);
        if($response->num_rows() > 0)
          {
            
                return $response->result_array();
             
         
            }
          else 
          {
            return false;
          }
    }
    public function getAwarenessTypes($options  = array(),$count=NULL) 
    {
        $query = 'select * from awareness_type';
        if(isset($options['key']))
        {
          $query .= $options['key'].' ';
        }
        
        $query.=" order by awareness_type asc";
       
        //echo $query; exit;
        $response = $this->db->query($query);
        if($response->num_rows() > 0)
          {
            
                return $response->result_array();
             
         
            }
          else 
          {
            return false;
          }
    }
    public function awareness($data)
    {
      $this->db->insert('awareness', $data); 
      return $this->db->affected_rows();
    } 

    public function getAwarenessList($options  = array(),$count=NULL) 
    {
        $query = 'select awr.*,at.awareness_type from awareness awr left join awareness_type at on  awr.awareness_type=at.id';
        if(isset($options['key']))
        {
          $query .= $options['key'].' ';
        }
        
        //echo $query; exit;
        $response = $this->db->query($query);
        if($response->num_rows() > 0)
          {
            
                return $response->result_array();
             
         
            }
          else 
          {
            return false;
          }
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

}
?>
