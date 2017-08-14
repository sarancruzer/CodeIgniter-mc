<?php
class Admin extends CI_Controller {
    public function __construct() 
    {
        parent::__construct();
        $this->load->model('admin_model');
        $this->load->helper('url');
        $this->data = array(
            'template' => 'admin/common/template',
            'access' => isset($this->session->userdata['userid']) ? $this->session->userdata['userid']: 0
            );
    }
    
    public function manage_patient()
    {
        if($this->data['access'] == 0)
        {
            redirect('admin/login');
        }
        else
        {
            $data = array('title' => 'Mobile Clinic | Manage Patient', 'page' => 'admin/manage_patient',  'errorCls' => NULL,'page_params' => NULL);
         
            $optionsets=array();
            if(isset($_GET['q']) && $_GET['q']!='')
            {
               $q = '%'.$_GET['q'].'%';
               $optionsets[] = "reg.email LIKE '$q' or reg.first_name LIKE '$q' or reg.last_name LIKE '$q' or CONCAT( reg.first_name,  ' ', reg.last_name ) LIKE '$q' or reg.mobile ='".$_GET['q']."'"; 
            } 
            if(isset($_GET['stat']) && ($_GET['stat']!=''))
            {
                $stat = $_GET['stat'];
                $optionsets[] = "reg.is_active='$stat'"; 
            } 
            if(isset($_GET['from_date']) && ($_GET['from_date']!='0000-00-00'))
            {
                $from_date = date('Y-m-d',strtotime($_GET['from_date']))."%";
                $optionsets[] = "reg.date_of_registration>='$from_date'"; 
            } 
            if(!empty($optionsets))
            {
                $options['key']=' where '.implode(' and ',$optionsets);
            }
            @$options['key'] .=' order by reg.id desc';
            $config = array();
            $config["base_url"] = base_url()."admin/manage_patient";
            $config['first_url'] = base_url()."admin/manage_patient?q=".@$_GET['q']."&stat=".@$_GET['stat']."&from_date=".@$_GET['from_date']."";
            $config["suffix"] ="?q=".@$_GET['q']."&stat=".@$_GET['stat']."&from_date=".@$_GET['from_date']."";
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $config["per_page"] = 30;
            $config["uri_segment"] = 3;
            $config["total_rows"] = $this->admin_model->get_patient_details($options,'counts');
            $options['limit'] = $config["per_page"]; 

            $options['offset'] = $page; 
            $data['offset'] = $page; 

            $data['paginate'] = @$page; 
            $data['q']=@$_GET['q'];
            $data['stat']=@$_GET['stat'];
            $data['from_date']=@$_GET['from_date'];
            $data['patient_info']=$this->admin_model->get_patient_details($options);
            $doct=array();
            $doct['key']=" order by name asc";
            $data['doctors']=$this->admin_model->get_doctors_list($doct);

            if(empty($data['patient_info']) && !empty($page))
            {
                $paginate=$page-$config["per_page"];
                redirect('admin/manage_patient/'.@$paginate.'?q='.@$_GET['q'].'&stat='.@$_GET['stat']);
            }
            $this->pagination->initialize($config);
            $data["links"] = $this->pagination->create_links(); 

            $data = $data + $this->data;
            $this->load->view($data['template'],$data);
        }
    }

    public function index()
    {
        $data = array('title' => 'Mobile Clinic | Login', 'page' => 'admin/login',  'errorCls' => NULL,'page_params' => NULL);
        if((isset($this->session->userdata['userid']))&&(isset($this->session->userdata['userid'])))
        {
            redirect('admin/dashboard');
        }
        $data = $data + $this->data;
        $this->load->view('admin/login');
    }

   /* public function dashboard()
    {
        $data = array('title' => 'Mobile Clinic | Dashboard', 'page' => 'admin/dashboard',  'errorCls' => NULL,'page_params' => NULL);
        $malearray=array();
        $femalearr=array();
        $nullarray=array();
        $datearray=array();
        $day=date('Y-m-d');
        if(isset($_GET['dgndate']) && ($_GET['dgndate']!=''))
        {
            $day=date('Y-m-d',strtotime($_GET['dgndate']));
        }
        for($i=4;$i>=0;$i--)
        {
        $current_day = date('Y-m-d', strtotime("-$i days", strtotime($day)));

        @$maleDiagnosis['key']=" where reg.gender like 'Male' and date(date_of_diagnosis)='$current_day'";
        $maleDiagnosisCount=$this->admin_model->diagnosiscount($maleDiagnosis);

        @$femaleDiagnosis['key']=" where reg.gender like 'Female' and date(date_of_diagnosis)='$current_day'";
        $femaleDiagnosisCount=$this->admin_model->diagnosiscount($femaleDiagnosis); 

        @$undefineDiagnosis['key']=" where reg.gender IS NULL and date(date_of_diagnosis)='$current_day'";
        $nullDiagnosisCount=$this->admin_model->diagnosiscount($undefineDiagnosis);

        $malearray[]=@$maleDiagnosisCount[0]['diagnosiscount'];
        $femalearray[]=@$femaleDiagnosisCount[0]['diagnosiscount'];
        $nullarray[]=@$nullDiagnosisCount[0]['diagnosiscount'];
        $datearray[]="'".date('d/m/Y',strtotime($current_day))."'";
        }
        $data['maleDiagnosisList']=implode(",", $malearray);
        $data['femaleDiagnosisList']=implode(",", $femalearray);
        $data['nullDiagnosisList']=implode(",", $nullarray);
        $data['dateDiagnosisList']=implode(",", $datearray);
        $data['diagnosisDate']=date('d-m-Y',strtotime($day));

        @$maledgnpie['key']=" where reg.gender like 'Male'";
        @$femaledgnpie['key']=" where reg.gender like 'Female'";
        @$undefinedgnpie['key']=" where reg.gender IS NULL";
        $optionsets2=array();
        if(isset($_GET['status2']) && ($_GET['status2']!=''))
        {
            $status2 = $_GET['status2'];
            $optionsets2[] = "marital_status like '$status2'"; 
        } 
        if(isset($_GET['agegroup2']) && ($_GET['agegroup2']!=''))
        {
            $agegroup2 = $_GET['agegroup2'];
            if($agegroup2=='below_18')
            {
            $optionsets2[] = "TIMESTAMPDIFF(YEAR,dob,CURDATE())<18"; 
            }
            if($agegroup2=='below_30')
            {
            $optionsets2[] = "TIMESTAMPDIFF(YEAR,dob,CURDATE())<30"; 
            }
            if($agegroup2=='above_30')
            {
            $optionsets2[] = "TIMESTAMPDIFF(YEAR,dob,CURDATE())>30"; 
            }
        } 
        if(isset($_GET['from2']) && ($_GET['from2']!=''))
        {
            //echo strtotime($_GET['from']);
            $from2 = date("Y-m-d",strtotime($_GET['from2']));
            $optionsets2[] = "DATE(dgn.date_of_diagnosis)>='$from2'"; 
        } 
        if(isset($_GET['to2']) && ($_GET['to2']!=''))
        {
            $to2 = date("Y-m-d",strtotime($_GET['to2']));
            $optionsets2[] = "DATE(dgn.date_of_diagnosis)<='$to2'"; 
        }
        if(!empty($optionsets2))
        {
            $optionskey2=' and '.implode(' and ',$optionsets2);
            $maledgnpie['key'].=$optionskey2;
            $femaledgnpie['key'].=$optionskey2;
            $undefinedgnpie['key'].=$optionskey2;
        }

        $maledgncount=$this->admin_model->diagnosiscount($maledgnpie);
        $femaledgncount=$this->admin_model->diagnosiscount($femaledgnpie);
        $nulldgncount=$this->admin_model->diagnosiscount($undefinedgnpie);

        $data['maledgncount']=$maledgncount[0]['diagnosiscount'];
        $data['femaledgncount']=$femaledgncount[0]['diagnosiscount'];
        $data['nulldgncount']=$nulldgncount[0]['diagnosiscount'];

        @$male['key']=" where gender like 'Male'";
        @$female['key']=" where gender like 'Female'";
        @$undefine['key']=" where gender IS NULL";
        $optionsets=array();
        if(isset($_GET['status']) && ($_GET['status']!=''))
        {
            $status = $_GET['status'];
            $optionsets[] = "marital_status like '$status'"; 
        } 
        if(isset($_GET['agegroup']) && ($_GET['agegroup']!=''))
        {
            $agegroup = $_GET['agegroup'];
            if($agegroup=='below_18')
            {
            $optionsets[] = "TIMESTAMPDIFF(YEAR,dob,CURDATE())<18"; 
            }
            if($agegroup=='below_30')
            {
            $optionsets[] = "TIMESTAMPDIFF(YEAR,dob,CURDATE())<30"; 
            }
            if($agegroup=='above_30')
            {
            $optionsets[] = "TIMESTAMPDIFF(YEAR,dob,CURDATE())>30"; 
            }
        } 
        if(isset($_GET['from']) && ($_GET['from']!=''))
        {
            //echo strtotime($_GET['from']);
            $from = date("Y-m-d",strtotime($_GET['from']));
            $optionsets[] = "DATE(date_of_registration)>='$from'"; 
        } 
        if(isset($_GET['to']) && ($_GET['to']!=''))
        {
            $to = date("Y-m-d",strtotime($_GET['to']));
            $optionsets[] = "DATE(date_of_registration)<='$to'"; 
        }
        if(!empty($optionsets))
        {
            $optionskey=' and '.implode(' and ',$optionsets);
            $male['key'].=$optionskey;
            $female['key'].=$optionskey;
            $undefine['key'].=$optionskey;
        }

        
        $malecount=$this->admin_model->chartcount($male);        
        $femalecount=$this->admin_model->chartcount($female);
        $nullcount=$this->admin_model->chartcount($undefine);
        $data['male']=$malecount[0]['chartcount'];
        $data['female']=$femalecount[0]['chartcount'];
        $data['nullvalue']=$nullcount[0]['chartcount'];
        $data['status']=@$_GET['status'];
        $data['agegroup']=@$_GET['agegroup'];
        $data['from']=@$_GET['from'];
        $data['to']=@$_GET['to'];
        $data['status2']=@$_GET['status2'];
        $data['agegroup2']=@$_GET['agegroup2'];
        $data['from2']=@$_GET['from2'];
        $data['to2']=@$_GET['to2'];

       // @$maledgn['key']=" where "
       // $maledgn=$this->admin_model->diagnosiscount($maledgn); 
        $data = $data + $this->data;
        $this->load->view($data['template'],$data);
    }*/

    public function dashboard()
    {
    	if($this->data['access'] == 0)
        {
            redirect('admin/login');
        }
        else
        {
	        $data = array('title' => 'Mobile Clinic | Dashboard', 'page' => 'admin/dashboard',  'errorCls' => NULL,'page_params' => NULL);        
	        $data['male']=0;
	        $data['female']=0;
	        $data['nullvalue']=0;
	        @$male['key']=" where gender like 'Male'";
	        @$female['key']=" where gender like 'Female'";
	        @$undefine['key']=" where gender IS NULL";

	        $optionsets=array();
	        if(isset($_GET['from']) && ($_GET['from']!=''))
	        {
	            //echo strtotime($_GET['from']);
	            $from = date("Y-m-d",strtotime($_GET['from']));
	            $optionsets[] = "DATE(date_of_registration)>='$from'"; 
	        } 
	        if(isset($_GET['to']) && ($_GET['to']!=''))
	        {
	            $to = date("Y-m-d",strtotime($_GET['to']));
	            $optionsets[] = "DATE(date_of_registration)<='$to'"; 
	        }
	        if(!empty($optionsets))
	        {
	            $optionskey=' and '.implode(' and ',$optionsets);
	            $male['key'].=$optionskey;
	            $female['key'].=$optionskey;
	            $undefine['key'].=$optionskey;
	        }

	        
	        $malecount=$this->admin_model->chartcount($male);        
	        $femalecount=$this->admin_model->chartcount($female);
	        $nullcount=$this->admin_model->chartcount($undefine);
	        $data['male']=$malecount[0]['chartcount'];
	        $data['female']=$femalecount[0]['chartcount'];
	        $data['nullvalue']=$nullcount[0]['chartcount'];

	        $data['below_18']=0;
	        $data['below_30']=0;
	        $data['above_30']=0;
	        @$below_18['key']=" where TIMESTAMPDIFF(YEAR,dob,CURDATE())<18";
	        @$below_30['key']=" where (TIMESTAMPDIFF(YEAR,dob,CURDATE())>=18 and TIMESTAMPDIFF(YEAR,dob,CURDATE())<=30)";
	        @$above_30['key']=" where TIMESTAMPDIFF(YEAR,dob,CURDATE())>30";
	        
	        $optionsets=array();
	        if(isset($_GET['from']) && ($_GET['from']!=''))
	        {
	            //echo strtotime($_GET['from']);
	            $from = date("Y-m-d",strtotime($_GET['from']));
	            $optionsets[] = "DATE(date_of_registration)>='$from'"; 
	        } 
	        if(isset($_GET['to']) && ($_GET['to']!=''))
	        {
	            $to = date("Y-m-d",strtotime($_GET['to']));
	            $optionsets[] = "DATE(date_of_registration)<='$to'"; 
	        }
	        if(!empty($optionsets))
	        {
	            $optionskey=' and '.implode(' and ',$optionsets);
	            $below_18['key'].=$optionskey;
	            $below_30['key'].=$optionskey;
	            $above_30['key'].=$optionskey;
	        }

	        
	        $below_18count=$this->admin_model->chartcount($below_18); 
	        $below_30count=$this->admin_model->chartcount($below_30);
	        $above_30count=$this->admin_model->chartcount($above_30);

	        $data['below_18']=$below_18count[0]['chartcount'];
	        $data['below_30']=$below_30count[0]['chartcount'];
	        $data['above_30']=$above_30count[0]['chartcount'];

	        $data['circulatory_name']='';
	        $data['circulatory_data']='';
	        @$circulatory_id['key']=" where mt.master_name like 'Circulatory and respiratory'";
	        $optionsets=array();
	        if(isset($_GET['from']) && ($_GET['from']!=''))
	        {
	            //echo strtotime($_GET['from']);
	            $from = date("Y-m-d",strtotime($_GET['from']));
	            $optionsets[] = "DATE(date_of_diagnosis)>='$from'"; 
	        } 
	        if(isset($_GET['to']) && ($_GET['to']!=''))
	        {
	            $to = date("Y-m-d",strtotime($_GET['to']));
	            $optionsets[] = "DATE(date_of_diagnosis)<='$to'"; 
	        }
	        if(!empty($optionsets))
	        {
	            $optionskey='where '.implode(' and ',$optionsets);
	            $circulatory_id['filter']=$optionskey;
	        }
	        $circulatorycount=$this->admin_model->diagnosiscount($circulatory_id); 
	        $master_value=array();
	        $master_count=array();
	        $master_series=array();
	        if(!empty($circulatorycount))
	        {
	            foreach($circulatorycount as $circulatory)
	            {
	                
	                $master_count[].=$circulatory['mastercount'];
	                if(!empty($circulatory['mastercount']))
	                {
	                    $value=$circulatory['mastercount'];
	                }
	                else
	                {
	                    $value=0;
	                }
	                $master_value[].="'".$circulatory['master_value']." (".$value.")'";
	                $master_series[]="{value: ".$value.",name: '".$circulatory['master_value']." (".$value.")'}";      
	        
	            }
	        }   
	        if(!empty($master_value))
	        {
	            $data['circulatory_name']=implode(',',$master_value);
	        } 
	       
	        if(!empty($master_series))
	        {
	            $data['circulatory_data']=implode(',',$master_series);
	        } 
	        /*******  Digestive system and abdomen *******/
	        $data['digestive_name']='';
	        $data['digestive_data']='';
	        @$digestive_id['key']=" where mt.master_name like 'Digestive system and abdomen'";
	        $optionsets=array();
	        if(isset($_GET['from']) && ($_GET['from']!=''))
	        {
	            //echo strtotime($_GET['from']);
	            $from = date("Y-m-d",strtotime($_GET['from']));
	            $optionsets[] = "DATE(date_of_diagnosis)>='$from'"; 
	        } 
	        if(isset($_GET['to']) && ($_GET['to']!=''))
	        {
	            $to = date("Y-m-d",strtotime($_GET['to']));
	            $optionsets[] = "DATE(date_of_diagnosis)<='$to'"; 
	        }
	        if(!empty($optionsets))
	        {
	            $optionskey='where '.implode(' and ',$optionsets);
	            $digestive_id['filter']=$optionskey;
	        }
	        $digestivecount=$this->admin_model->digestive($digestive_id);        
	        $master_value=array();
	        $master_count=array();
	        $master_series=array();
	        if(!empty($digestivecount))
	        {
	            foreach($digestivecount as $digestive)
	            {
	                
	                $master_count[].=$digestive['mastercount'];
	                if(!empty($digestive['mastercount']))
	                {
	                    $value=$digestive['mastercount'];
	                }
	                else
	                {
	                    $value=0;
	                }
	                $master_value[].="'".$digestive['master_value']." (".$value.")'";
	                $master_series[]="{value: ".$value.",name: '".$digestive['master_value']." (".$value.")'}";      
	        
	            }
	        }   
	        if(!empty($master_value))
	        {
	            $data['digestive_name']=implode(',',$master_value);
	        } 
	       
	        if(!empty($master_series))
	        {
	            $data['digestive_data']=implode(',',$master_series);
	        }
	        /****** Digestive system and abdomen end ****/

	        /*******    Skin and subcutaneous tissue *******/
	        $data['skin_name']='';
	        $data['skin_data']='';
	        @$skin_id['key']=" where mt.master_name like 'Skin and subcutaneous tissue'";
	        $optionsets=array();
	        if(isset($_GET['from']) && ($_GET['from']!=''))
	        {
	            //echo strtotime($_GET['from']);
	            $from = date("Y-m-d",strtotime($_GET['from']));
	            $optionsets[] = "DATE(date_of_diagnosis)>='$from'"; 
	        } 
	        if(isset($_GET['to']) && ($_GET['to']!=''))
	        {
	            $to = date("Y-m-d",strtotime($_GET['to']));
	            $optionsets[] = "DATE(date_of_diagnosis)<='$to'"; 
	        }
	        if(!empty($optionsets))
	        {
	            $optionskey='where '.implode(' and ',$optionsets);
	            $skin_id['filter']=$optionskey;
	        }
	        $skincount=$this->admin_model->skin($skin_id); 
	        $master_value=array();
	        $master_count=array();
	        $master_series=array();
	        if(!empty($skincount))
	        {
	            foreach($skincount as $skin)
	            {
	                
	                $master_count[].=$skin['mastercount'];
	                if(!empty($skin['mastercount']))
	                {
	                    $value=$skin['mastercount'];
	                }
	                else
	                {
	                    $value=0;
	                }
	                $master_value[].="'".$skin['master_value']." (".$value.")'";
	                $master_series[]="{value: ".$value.",name: '".$skin['master_value']." (".$value.")'}";      
	        
	            }
	        }   
	        if(!empty($master_value))
	        {
	            $data['skin_name']=implode(',',$master_value);
	        } 
	       
	        if(!empty($master_series))
	        {
	            $data['skin_data']=implode(',',$master_series);
	        }
	        /******     Skin and subcutaneous tissue end****/

	        /*******    Nervous and musculoskeletal systems *******/
	        $data['nervous_name']='';
	        $data['nervous_data']='';
	        @$nervous_id['key']=" where mt.master_name like 'Nervous and musculoskeletal systems'";
	        $optionsets=array();
	        if(isset($_GET['from']) && ($_GET['from']!=''))
	        {
	            //echo strtotime($_GET['from']);
	            $from = date("Y-m-d",strtotime($_GET['from']));
	            $optionsets[] = "DATE(date_of_diagnosis)>='$from'"; 
	        } 
	        if(isset($_GET['to']) && ($_GET['to']!=''))
	        {
	            $to = date("Y-m-d",strtotime($_GET['to']));
	            $optionsets[] = "DATE(date_of_diagnosis)<='$to'"; 
	        }
	        if(!empty($optionsets))
	        {
	            $optionskey='where '.implode(' and ',$optionsets);
	            $nervous_id['filter']=$optionskey;
	        }
	        $nervouscount=$this->admin_model->nervous($nervous_id); 
	        $master_value=array();
	        $master_count=array();
	        $master_series=array();
	        if(!empty($nervouscount))
	        {
	            foreach($nervouscount as $nervous)
	            {
	                
	                $master_count[].=$nervous['mastercount'];
	                if(!empty($nervous['mastercount']))
	                {
	                    $value=$nervous['mastercount'];
	                }
	                else
	                {
	                    $value=0;
	                }
	                $master_value[].="'".$nervous['master_value']." (".$value.")'";
	                $master_series[]="{value: ".$value.",name: '".$nervous['master_value']." (".$value.")'}";      
	        
	            }
	        }   
	        if(!empty($master_value))
	        {
	            $data['nervous_name']=implode(',',$master_value);
	        } 
	       
	        if(!empty($master_series))
	        {
	            $data['nervous_data']=implode(',',$master_series);
	        }
	        /******     Nervous and musculoskeletal systems end****/

	        /*******    Urinary system *******/
	        $data['urinary_name']='';
	        $data['urinary_data']='';
	        @$urinary_id['key']=" where mt.master_name like 'Urinary system'";
	        $optionsets=array();
	        if(isset($_GET['from']) && ($_GET['from']!=''))
	        {
	            //echo strtotime($_GET['from']);
	            $from = date("Y-m-d",strtotime($_GET['from']));
	            $optionsets[] = "DATE(date_of_diagnosis)>='$from'"; 
	        } 
	        if(isset($_GET['to']) && ($_GET['to']!=''))
	        {
	            $to = date("Y-m-d",strtotime($_GET['to']));
	            $optionsets[] = "DATE(date_of_diagnosis)<='$to'"; 
	        }
	        if(!empty($optionsets))
	        {
	            $optionskey='where '.implode(' and ',$optionsets);
	            $urinary_id['filter']=$optionskey;
	        }
	        $urinarycount=$this->admin_model->urinary($urinary_id); 
	        $master_value=array();
	        $master_count=array();
	        $master_series=array();
	        if(!empty($urinarycount))
	        {
	            foreach($urinarycount as $urinary)
	            {
	                
	                $master_count[].=$urinary['mastercount'];
	                if(!empty($urinary['mastercount']))
	                {
	                    $value=$urinary['mastercount'];
	                }
	                else
	                {
	                    $value=0;
	                }
	                $master_value[].="'".$urinary['master_value']." (".$value.")'";
	                $master_series[]="{value: ".$value.",name: '".$urinary['master_value']." (".$value.")'}";      
	        
	            }
	        }   
	        if(!empty($master_value))
	        {
	            $data['urinary_name']=implode(',',$master_value);
	        } 
	       
	        if(!empty($master_series))
	        {
	            $data['urinary_data']=implode(',',$master_series);
	        }
	        /******     Urinary system end****/

	        /*******    Cognition, perception, emotional *******/
	        $data['cognition_name']='';
	        $data['cognition_data']='';
	        @$cognition_id['key']=" where mt.master_name like 'Cognition, perception, emotional'";
	        $optionsets=array();
	        if(isset($_GET['from']) && ($_GET['from']!=''))
	        {
	            //echo strtotime($_GET['from']);
	            $from = date("Y-m-d",strtotime($_GET['from']));
	            $optionsets[] = "DATE(date_of_diagnosis)>='$from'"; 
	        } 
	        if(isset($_GET['to']) && ($_GET['to']!=''))
	        {
	            $to = date("Y-m-d",strtotime($_GET['to']));
	            $optionsets[] = "DATE(date_of_diagnosis)<='$to'"; 
	        }
	        if(!empty($optionsets))
	        {
	            $optionskey='where '.implode(' and ',$optionsets);
	            $cognition_id['filter']=$optionskey;
	        }
	        $cognitioncount=$this->admin_model->cognition($cognition_id); 
	        $master_value=array();
	        $master_count=array();
	        $master_series=array();
	        if(!empty($cognitioncount))
	        {
	            foreach($cognitioncount as $cognition)
	            {
	                
	                $master_count[].=$cognition['mastercount'];
	                if(!empty($cognition['mastercount']))
	                {
	                    $value=$cognition['mastercount'];
	                }
	                else
	                {
	                    $value=0;
	                }
	                $master_value[].="'".$cognition['master_value']." (".$value.")'";
	                $master_series[]="{value: ".$value.",name: '".$cognition['master_value']." (".$value.")'}";      
	        
	            }
	        }   
	        if(!empty($master_value))
	        {
	            $data['cognition_name']=implode(',',$master_value);
	        } 
	       
	        if(!empty($master_series))
	        {
	            $data['cognition_data']=implode(',',$master_series);
	        }
	        /******     Cognition, perception, emotional end****/

	        /*******    Speech and voice *******/
	        $data['speech_name']='';
	        $data['speech_data']='';
	        @$speech_id['key']=" where mt.master_name like 'Speech and voice'";
	        $optionsets=array();
	        if(isset($_GET['from']) && ($_GET['from']!=''))
	        {
	            //echo strtotime($_GET['from']);
	            $from = date("Y-m-d",strtotime($_GET['from']));
	            $optionsets[] = "DATE(date_of_diagnosis)>='$from'"; 
	        } 
	        if(isset($_GET['to']) && ($_GET['to']!=''))
	        {
	            $to = date("Y-m-d",strtotime($_GET['to']));
	            $optionsets[] = "DATE(date_of_diagnosis)<='$to'"; 
	        }
	        if(!empty($optionsets))
	        {
	            $optionskey='where '.implode(' and ',$optionsets);
	            $speech_id['filter']=$optionskey;
	        }
	        $speechcount=$this->admin_model->speech($speech_id); 
	        $master_value=array();
	        $master_count=array();
	        $master_series=array();
	        if(!empty($speechcount))
	        {
	            foreach($speechcount as $speech)
	            {   
	                $master_count[].=$speech['mastercount'];
	                if(!empty($speech['mastercount']))
	                {
	                    $value=$speech['mastercount'];
	                }
	                else
	                {
	                    $value=0;
	                }
	                $master_value[].="'".$speech['master_value']." (".$value.")'";
	                $master_series[]="{value: ".$value.",name: '".$speech['master_value']." (".$value.")'}";
	            }
	        }   
	        if(!empty($master_value))
	        {
	            $data['speech_name']=implode(',',$master_value);
	        } 
	       
	        if(!empty($master_series))
	        {
	            $data['speech_data']=implode(',',$master_series);
	        }
	        /******     Speech and voice end****/

	        /*******    General symptoms and signs *******/
	        $data['general_name']='';
	        $data['general_data']='';
	        @$general_id['key']=" where mt.master_name like 'General symptoms and signs'";
	        $optionsets=array();
	        if(isset($_GET['from']) && ($_GET['from']!=''))
	        {
	            //echo strtotime($_GET['from']);
	            $from = date("Y-m-d",strtotime($_GET['from']));
	            $optionsets[] = "DATE(date_of_diagnosis)>='$from'"; 
	        } 
	        if(isset($_GET['to']) && ($_GET['to']!=''))
	        {
	            $to = date("Y-m-d",strtotime($_GET['to']));
	            $optionsets[] = "DATE(date_of_diagnosis)<='$to'"; 
	        }
	        if(!empty($optionsets))
	        {
	            $optionskey='where '.implode(' and ',$optionsets);
	            $general_id['filter']=$optionskey;
	        }
	        $generalcount=$this->admin_model->general($general_id); 
	        $master_value=array();
	        $master_count=array();
	        $master_series=array();
	        if(!empty($generalcount))
	        {
	            foreach($generalcount as $general)
	            {   
	                $master_count[].=$general['mastercount'];
	                if(!empty($general['mastercount']))
	                {
	                    $value=$general['mastercount'];
	                }
	                else
	                {
	                    $value=0;
	                }
	                $master_value[].="'".$general['master_value']." (".$value.")'";
	                $master_series[]="{value: ".$value.",name: '".$general['master_value']." (".$value.")'}";
	            }
	        }   
	        if(!empty($master_value))
	        {
	            $data['general_name']=implode(',',$master_value);
	        } 
	       
	        if(!empty($master_series))
	        {
	            $data['general_data']=implode(',',$master_series);
	        }
	        /******     General symptoms and signs end****/

	        $data['status']=@$_GET['status'];
	        $data['agegroup']=@$_GET['agegroup'];
	        $data['from']=@$_GET['from'];
	        $data['to']=@$_GET['to'];
	        $data['from2']=@$_GET['from2'];
	        $data['to2']=@$_GET['to2'];

	       // @$maledgn['key']=" where "
	       // $maledgn=$this->admin_model->diagnosiscount($maledgn); 
	        $data = $data + $this->data;
	        $this->load->view($data['template'],$data);
	    }
    }

    public function login()
    {

        $username = $this->input->post('username');
        $password = $this->input->post('password');
            
        $result = $this->admin_model->login_authenticate($username,$password);
        //var_dump($result);exit;
        if(!empty($result))
        {
            if($result[0]['is_active']=='1')
            {
                $this->session->set_flashdata('success','Logged in successfully');
                redirect('admin/dashboard');
            }
            else
            {
                $this->session->set_flashdata('failure','Your account is inactive');
                redirect('admin');
            }
        }
        else
        {
            $this->session->set_flashdata('failure','Username/password is invalid');
            redirect('admin');
        }
    }  

    public function logout() 
    {
        $this->session->sess_destroy();
        redirect('admin');
    }

    public function manage_doctors()
    {
        if($this->data['access'] == 0)
        {
            redirect('admin/login');
        }
        else
        {
            $data = array('title' => 'Mobile Clinic | Manage Doctors', 'page' => 'admin/manage_doctors',  'errorCls' => NULL,'page_params' => NULL);
            @$options['key']=' where UR.user_role="Doctors"';
            $optionsets=array();
            if(isset($_GET['q']) && $_GET['q']!='')
            {
                $q = '%'.$_GET['q'].'%';
                $optionsets[] = "users.username LIKE '$q' or users.name LIKE '$q' or users.email LIKE '$q' or users.device_id LIKE '$q'"; 
            } 
            if(isset($_GET['stat']) && ($_GET['stat']!=''))
            {
                $stat = $_GET['stat'];
                $optionsets[] = "is_active='$stat'"; 
            } 
        
            if(!empty($optionsets))
            {
                $options['key'].=' and '.implode(' and ',$optionsets);
            }
            @$options['key'] .=' order by users.id desc';
            $config = array();
            $config["base_url"] = base_url()."admin/manage_doctors";
            $config['first_url'] = base_url()."admin/manage_doctors?q=".@$_GET['q']."&stat=".@$_GET['stat']."";
            $config["suffix"] ="?q=".@$_GET['q']."&stat=".@$_GET['stat']."";
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $config["per_page"] = 30;
            $config["uri_segment"] = 3;
            $config["total_rows"] = $this->admin_model->get_doctors_details($options,'counts');
            $options['limit'] = $config["per_page"]; 

            $options['offset'] = $page; 
            $data['offset'] = $page; 

            $data['paginate'] = @$page; 
            $data['q']=@$_GET['q'];
            $data['stat']=@$_GET['stat'];
            $data['from_date']=@$_GET['from_date'];
            $data['total_doctors']=$this->admin_model->get_doctors_details($options);

            if(empty($data['total_doctors']) && !empty($page))
            {
                $paginate=$page-$config["per_page"];
                redirect('admin/manage_doctors/'.@$paginate.'?q='.@$_GET['q'].'&stat='.@$_GET['stat']);
            }
            $this->pagination->initialize($config);
            $data["links"] = $this->pagination->create_links(); 

            $data = $data + $this->data;
            $this->load->view($data['template'],$data);
        }
    }

    public function adddoctor()
    {
        if($this->data['access'] == 0)
        {
            redirect('admin/login');
        }
        else
        {
            if((!empty($_POST['adddoctor'])) && (isset($_POST['adddoctor'])))
            {         
                $userrole=array('table'=>'user_role','key'=>' where user_role="Doctors"');
                $users=$this->admin_model->get_details($userrole);
                if(!empty($users))
                {
                    $data['username']=$this->input->post('username');
                    $data['password']=$this->input->post('password');
                    $data['name']=$this->input->post('name');
                    $data['email']=$this->input->post('email');
                    $data['user_role']=$users[0]['id'];
                    $data['isactive']=$this->input->post('isactive');
                    $result=$this->admin_model->adddoctor($data);
                    if(!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Doctor details inserted Successfully');
                        redirect('admin/manage_doctors');
                    }
                    else
                    {                    
                        $this->session->set_flashdata('failure', 'Cannot insert doctor details !!!');
                        redirect('admin/manage_doctors');
                    }
                }
                else
                {
                    $this->session->set_flashdata('failure', 'User role is not there please contact admin');
                    redirect('admin/manage_doctors');
                }
            }
        }
    }

    public function editdoctor()
    { 
        if($this->data['access'] == 0)
        {
            redirect('admin/login');
        }
        else
        {
            $data['id']=$this->input->post('editid');
            $data['username']=$this->input->post('editusername');
            $data['name']=$this->input->post('editname');
            $data['email']=$this->input->post('editemail');
            $data['is_active']=$this->input->post('editstatus');
            if($this->input->post('reset')=='reset')
            {
                $data['device_id']='reset';
            }
            $result=$this->admin_model->editdoctor($data);
            if($result['status'] == 'success')
            {
                $this->session->set_flashdata('success', 'Doctor details updated successfully');
                redirect('admin/manage_doctors?q='.@$_GET['q']);
            }
            else
            {
                $this->session->set_flashdata('failure', 'Cannot updated doctor details !!!');
                redirect('admin/manage_doctors?q='.@$_GET['q']);
            }
        }   
    }

    public function deletedoctor() 
    {
        if($this->data['access'] == 0)
        {
            redirect('admin/login');
        }
        else
        {
            if(!empty($_GET['paginate']))
            {
                $paginate='/'.$_GET['paginate'];
            }
            $result=$this->admin_model->deletedoctor($_POST['deleteid']);
            if($result)
            {
                $this->session->set_flashdata('success', 'Doctor details deleted successfully !!!');
                redirect('admin/manage_doctors'.$paginate.'?q='.@$_GET['q'].'&len='.@$_GET['len']);
            }
            else
            {
                $this->session->set_flashdata('failure', 'Can not delete the doctor details');
                redirect('admin/manage_doctors'.$paginate.'?q='.@$_GET['q'].'&len='.@$_GET['len']);
       
            }
        }
    }

    public function manage_workers()
    {
        if($this->data['access'] == 0)
        {
            redirect('admin/login');
        }
        else
        {
            $data = array('title' => 'Mobile Clinic | Manage Workers', 'page' => 'admin/manage_workers',  'errorCls' => NULL,'page_params' => NULL);
            @$options['key']=' where UR.user_role="Health Workers"';
            $optionsets=array();
            if(isset($_GET['q']) && $_GET['q']!='')
            {
                $q = '%'.$_GET['q'].'%';
                $optionsets[] = "users.username LIKE '$q' or users.name LIKE '$q' or users.email LIKE '$q' or users.device_id LIKE '$q'"; 
            } 
            if(isset($_GET['stat']) && ($_GET['stat']!=''))
            {
                $stat = $_GET['stat'];
                $optionsets[] = "is_active='$stat'"; 
            } 
        
            if(!empty($optionsets))
            {
                $options['key'].=' and '.implode(' and ',$optionsets);
            }
            @$options['key'] .=' order by users.id desc';
            $config = array();
            $config["base_url"] = base_url()."admin/manage_workers";
            $config['first_url'] = base_url()."admin/manage_workers?q=".@$_GET['q']."&stat=".@$_GET['stat']."";
            $config["suffix"] ="?q=".@$_GET['q']."&stat=".@$_GET['stat']."";
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $config["per_page"] = 30;
            $config["uri_segment"] = 3;
            $config["total_rows"] = $this->admin_model->get_workers_details($options,'counts');
            $options['limit'] = $config["per_page"]; 

            $options['offset'] = $page; 
            $data['offset'] = $page; 

            $data['paginate'] = @$page; 
            $data['q']=@$_GET['q'];
            $data['stat']=@$_GET['stat'];
            $data['from_date']=@$_GET['from_date'];
            $data['total_workers']=$this->admin_model->get_workers_details($options);

            if(empty($data['total_workers']) && !empty($page))
            {
                $paginate=$page-$config["per_page"];
                redirect('admin/manage_workers/'.@$paginate.'?q='.@$_GET['q'].'&stat='.@$_GET['stat']);
            }
            $this->pagination->initialize($config);
            $data["links"] = $this->pagination->create_links(); 

            $data = $data + $this->data;
            $this->load->view($data['template'],$data);
        }
    }

    public function addworkers()
    {
        if($this->data['access'] == 0)
        {
            redirect('admin/login');
        }
        else
        {
            if((!empty($_POST['addworker'])) && (isset($_POST['addworker'])))
            {         
                $userrole=array('table'=>'user_role','key'=>' where user_role="Health Workers"');
                $users=$this->admin_model->get_details($userrole);
                if(!empty($users))
                {
                    $data['username']=$this->input->post('username');
                    $data['password']=$this->input->post('password');
                    $data['name']=$this->input->post('name');
                    $data['email']=$this->input->post('email');
                    $data['user_role']=$users[0]['id'];
                    $data['isactive']=$this->input->post('isactive');
                    $result=$this->admin_model->addworkers($data);
                    if(!empty($result))
                    {
                        $this->session->set_flashdata('success', 'Health worker details inserted Successfully');
                        redirect('admin/manage_workers');
                    }
                    else
                    {                    
                        $this->session->set_flashdata('failure', 'Cannot insert health worker details !!!');
                        redirect('admin/manage_workers');
                    }
                }
                else
                {
                    $this->session->set_flashdata('failure', 'User role is not there please contact admin');
                    redirect('admin/manage_workers');
                }
            }
        }
    }

    public function username() 
    {
        if(!empty($_POST['username']))
        {
            @$value['key']=" where username='".$_POST['username']."'";
        }
        elseif(!empty($_POST['editusername']))
        {
            $value['key']=" where username='".$_POST['editusername']."'";
        }
        $value['table']='users';
        $result=$this->admin_model->get_details($value);
        if(!$result)
        {
            $response ='true';
        }
        else
        {
            $response = 'false';
        }
        echo $response;
   }

    public function deleteworker()
    {
        if($this->data['access'] == 0)
        {
            redirect('admin/login');
        }
        else
        {
            if(!empty($_GET['paginate']))
            {
                $paginate='/'.$_GET['paginate'];
            }
            $result=$this->admin_model->deleteworker($_POST['deleteid']);
            if($result)
            {
                $this->session->set_flashdata('success', 'Health worker details deleted successfully !!!');
                redirect('admin/manage_workers'.$paginate.'?q='.@$_GET['q'].'&len='.@$_GET['len']);
            }
            else
            {
                $this->session->set_flashdata('failure', 'Can not delete the health worker details');
                redirect('admin/manage_workers'.$paginate.'?q='.@$_GET['q'].'&len='.@$_GET['len']);
       
            }
        }
    } 

    public function editworker()
    { 
        if($this->data['access'] == 0)
        {
            redirect('admin/login');
        }
        else
        {
            $data['id']=$this->input->post('editid');
            $data['username']=$this->input->post('editusername');
            $data['name']=$this->input->post('editname');
            $data['email']=$this->input->post('editemail');
            $data['is_active']=$this->input->post('editstatus');
            if($this->input->post('reset')=='reset')
            {
                $data['device_id']='reset';
            }
            $result=$this->admin_model->editworker($data);
            if($result['status'] == 'success')
            {
                $this->session->set_flashdata('success', 'Health worker updated successfully');
                redirect('admin/manage_workers?q='.@$_GET['q']);
            }
            else
            {        
                $this->session->set_flashdata('failure', 'Cannot updated health worker details !!!');
                redirect('admin/manage_workers?q='.@$_GET['q']);
            }
        }
    } 

    public function manage_prescription()
    {
        if($this->data['access'] == 0)
        {
            redirect('admin/login');
        }
        else
        {
            $data = array('title' => 'Mobile Clinic | Manage Prescription', 'page' => 'admin/manage_prescription',  'errorCls' => NULL,'page_params' => NULL);
         
            $optionsets=array();
            if(isset($_GET['q']) && $_GET['q']!='')
            {
                $q = '%'.$_GET['q'].'%';
                $optionsets[] = "users.name LIKE '$q' or reg.first_name LIKE '$q' or reg.last_name LIKE '$q' or CONCAT( reg.initials, ' ',reg.first_name,  ' ', reg.last_name ) LIKE '$q'"; 
            }          
            if(!empty($optionsets))
            {
                $options['key']=' where '.implode(' and ',$optionsets);
            }
            @$options['key'] .=' order by pc.date_of_prescription desc';
            $config = array();
            $config["base_url"] = base_url()."admin/manage_prescription";
            $config['first_url'] = base_url()."admin/manage_prescription?q=".@$_GET['q']."";
            $config["suffix"] ="?q=".@$_GET['q']."";
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $config["per_page"] = 30;
            $config["uri_segment"] = 3;
            $config["total_rows"] = $this->admin_model->manage_prescription($options,'counts');
            $options['limit'] = $config["per_page"]; 

            $options['offset'] = $page; 
            $data['offset'] = $page; 

            $data['paginate'] = @$page; 
            $data['q']=@$_GET['q'];
            $data['stat']=@$_GET['stat'];
            $data['from_date']=@$_GET['from_date'];
            $data['prescription_info']=$this->admin_model->manage_prescription($options);
            if(empty($data['prescription_info']) && !empty($page))
            {
                $paginate=$page-$config["per_page"];
                redirect('admin/manage_prescription/'.@$paginate.'?q='.@$_GET['q']);
            }
            $this->pagination->initialize($config);
            $data["links"] = $this->pagination->create_links(); 

            $data = $data + $this->data;
            $this->load->view($data['template'],$data);
        }
    }  

    public function manage_diagnosis()
    {
        if($this->data['access'] == 0)
        {
            redirect('admin/login');
        }
        else
        {
            $data = array('title' => 'Mobile Clinic | Manage Diagnosis', 'page' => 'admin/manage_diagnosis',  'errorCls' => NULL,'page_params' => NULL);
            $optionsets=array();
            $options=array();
            if(isset($_GET['q']) && $_GET['q']!='')
            {
                $q = '%'.$_GET['q'].'%';
                $optionsets[] = "users.name LIKE '$q' or reg.first_name LIKE '$q' or reg.last_name LIKE '$q' or CONCAT( reg.initials, ' ',reg.first_name,  ' ', reg.last_name ) LIKE '$q'"; 
            }         
        
            if(!empty($optionsets))
            {
                @$options['key'].=' where '.implode(' and ',$optionsets);
            }
            @$options['key'] .=' order by dg.date_of_diagnosis desc';
            $config = array();
            $config["base_url"] = base_url()."admin/manage_diagnosis";
            $config['first_url'] = base_url()."admin/manage_diagnosis?q=".@$_GET['q']."&stat=".@$_GET['stat']."";
            $config["suffix"] ="?q=".@$_GET['q']."&stat=".@$_GET['stat']."";
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $config["per_page"] = 30;
            $config["uri_segment"] = 3;
            $config["total_rows"] = $this->admin_model->manage_diagnosis($options,'counts');
            $options['limit'] = $config["per_page"]; 

            $options['offset'] = $page; 
            $data['offset'] = $page; 

            $data['paginate'] = @$page; 
            $data['q']=@$_GET['q'];
            $data['stat']=@$_GET['stat'];
            $data['from_date']=@$_GET['from_date'];
            $data['diagnosis_info']=$this->admin_model->manage_diagnosis($options);
            @$options1['key'] .=' order by pc.date_of_prescription desc';
            $data['prescription_info']=$this->admin_model->manage_prescription($options1);

            if(empty($data['diagnosis_info']) && !empty($page))
            {
                $paginate=$page-$config["per_page"];
                redirect('admin/manage_diagnosis/'.@$paginate.'?q='.@$_GET['q'].'&stat='.@$_GET['stat']);
            }
            $this->pagination->initialize($config);
            $data["links"] = $this->pagination->create_links(); 
        // var_dump($data['diagnosis_info']); exit;
            $data = $data + $this->data;
            $this->load->view($data['template'],$data);
        }
    }

    public function viewDiagnosis()
    {
        if($this->data['access'] == 0)
        {
            redirect('admin/login');
        }
        else
        {
            if(!empty($_POST['id']))
            {
                @$options['key'] =" where dg.diagnosis_id like '".$_POST['id']."'";
                $data['diagnosis']=$this->admin_model->manage_diagnosis($options);
                $this->load->view('admin/view_diagnosis',$data);
            }
            else
            {
                echo "Id is not found.";
            }
        }
        // var_dump($data['diagnosis_info']);
    }

    public function patient_diagnosis()
    {
        if($this->data['access'] == 0)
        {
            redirect('admin/login');
        }
        else
        {
            $data = array('title' => 'Mobile Clinic | Patient Diagnosis', 'page' => 'admin/patient_diagnosis',  'errorCls' => NULL,'page_params' => NULL);
            $options=array();             
            $patient_id = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            @$options['key'] .=" where patient_id=$patient_id order by dg.date_of_diagnosis desc limit 10";
            $data['diagnosis_info']=$this->admin_model->manage_diagnosis($options);
            // var_dump($data['diagnosis_info']); exit;
            $data = $data + $this->data;
            $this->load->view($data['template'],$data);
        }
    } 

    public function patient_prescription()
    {
        if($this->data['access'] == 0)
        {
            redirect('admin/login');
        }
        else
        {
            $data = array('title' => 'Mobile Clinic | Patient Prescription', 'page' => 'admin/patient_prescription',  'errorCls' => NULL,'page_params' => NULL);    
            $options=array();        
            $id = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            @$options['key'] =" where pc.patient_id=$id order by pc.id desc limit 30";
         
            $data['prescription_info']=$this->admin_model->manage_prescription($options);
            $data = $data + $this->data;
            $this->load->view($data['template'],$data);
        }
    }

    public function manage_referrals()
    {
        if($this->data['access'] == 0)
        {
            redirect('admin/login');
        }
        else
        {
            $data = array('title' => 'Mobile Clinic | Manage Referrals', 'page' => 'admin/manage_referrals',  'errorCls' => NULL,'page_params' => NULL);
            $optionsets=array();
            $options=array();
            if(isset($_GET['q']) && $_GET['q']!='')
            {
                $q = '%'.$_GET['q'].'%';
                $optionsets[] = "users.name LIKE '$q' or reg.first_name LIKE '$q' or reg.last_name LIKE '$q' or CONCAT( reg.initials, ' ',reg.first_name,  ' ', reg.last_name ) LIKE '$q' or rf.referred_to like '$q' or hl.hospital_name like '$q' or rf.preliminary_diagnosis like '$q' or rf.final_diagnosis like '$q'"; 
            }         
        
            if(!empty($optionsets))
            {
                @$options['key'].=' where '.implode(' and ',$optionsets);
            }
            @$options['key'] .=' order by rf.id desc';
            $config = array();
            $config["base_url"] = base_url()."admin/manage_referrals";
            $config['first_url'] = base_url()."admin/manage_referrals?q=".@$_GET['q']."";
            $config["suffix"] ="?q=".@$_GET['q']."";
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $config["per_page"] = 30;
            $config["uri_segment"] = 3;
            $config["total_rows"] = $this->admin_model->manage_referrals($options,'counts');
            $options['limit'] = $config["per_page"]; 

            $options['offset'] = $page; 
            $data['offset'] = $page; 

            $data['paginate'] = @$page; 
            $data['q']=@$_GET['q'];
            $data['stat']=@$_GET['stat'];
            $data['from_date']=@$_GET['from_date'];
            $data['referrals_info']=$this->admin_model->manage_referrals($options);

            if(empty($data['referrals_info']) && !empty($page))
            {  
                $paginate=$page-$config["per_page"];
                redirect('admin/manage_referrals/'.@$paginate.'?q='.@$_GET['q']);
            }
            $this->pagination->initialize($config);
            $data["links"] = $this->pagination->create_links(); 
            //var_dump($data['referrals_info']); exit;
            $data = $data + $this->data;
            $this->load->view($data['template'],$data);
        }
    }

    public function manage_state()
    {
        if($this->data['access'] == 0)
        {
            redirect('admin/login');
        }
        else
        {
            $data = array('title' => 'Mobile Clinic | Manage State', 'page' => 'admin/manage_state',  'errorCls' => NULL,'page_params' => NULL);
            $optionsets=array();
            $options=array();
            if(isset($_GET['q']) && $_GET['q']!='')
            {
                $q = '%'.$_GET['q'].'%';
                $optionsets[] = "state_name LIKE '$q'"; 
            }         
            
            if(!empty($optionsets))
            {
                @$options['key'].=' where '.implode(' and ',$optionsets);
            }
            @$options['key'] .=' order by id desc';
            $config = array();
            $config["base_url"] = base_url()."admin/manage_state";
            $config['first_url'] = base_url()."admin/manage_state?q=".@$_GET['q']."";
            $config["suffix"] ="?q=".@$_GET['q']."";
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $config["per_page"] = 30;
            $config["uri_segment"] = 3;
            $config["total_rows"] = $this->admin_model->manage_state($options,'counts');
            $options['limit'] = $config["per_page"]; 
            $options['offset'] = $page; 
            $data['offset'] = $page; 
            $data['paginate'] = @$page; 
            $data['q']=@$_GET['q'];
            $data['state_info']=$this->admin_model->manage_state($options);
            if(empty($data['state_info']) && !empty($page))
            {
                $paginate=$page-$config["per_page"];
                redirect('admin/manage_state/'.@$paginate.'?q='.@$_GET['q']);
            }
            $this->pagination->initialize($config);
            $data["links"] = $this->pagination->create_links(); 
            //var_dump($data['referrals_info']); exit;
            $data = $data + $this->data;
            $this->load->view($data['template'],$data);
        }
    } 

    public function add_state()
    {
        if($this->data['access'] == 0)
        {
            redirect('admin/login');
        }
        else
        {
            if((!empty($_POST['addstate'])) && (isset($_POST['addstate'])))
            {  
                
                $data['state_name']=$this->input->post('state_name');
                $result=$this->admin_model->add_state($data);
                if(!empty($result))
                {
                    $this->session->set_flashdata('success', 'State inserted Successfully');
                    redirect('admin/manage_state');
                }
                else
                {                    
                    $this->session->set_flashdata('failure', 'Cannot insert state!!!');
                    redirect('admin/manage_state');
                }
                
            }
        }
    }

    public function statename() 
    {
        if(!empty($_POST['state_name']))
        {
            @$value['key']=" where state_name like '".$_POST['state_name']."'";
        }
        elseif(!empty($_POST['editstatename']))
        {
            $value['key']=" where state_name like '".$_POST['editstatename']."'";
        }
        $value['table']='state_list';
        $result=$this->admin_model->get_details($value);
        if(!$result)
        {
            $response ='true';
        }
        else
        {
            $response = 'false';
        }
        echo $response;
    }

    public function editstate()
    { 
        if($this->data['access'] == 0)
        {
            redirect('admin/login');
        }
        else
        {
            $data['id']=$this->input->post('editid');
            $data['state_name']=$this->input->post('editstatename');                       
            $result=$this->admin_model->editstate($data);
            if($result['status'] == 'success')
            {
                $this->session->set_flashdata('success', 'State updated successfully');
                redirect('admin/manage_state?q='.@$_GET['q']);
            }
            else
            {        
                $this->session->set_flashdata('failure', 'Cannot updated state!!!');
                redirect('admin/manage_state?q='.@$_GET['q']);
            }
        }
    }

    public function deletestate() 
    {
        if($this->data['access'] == 0)
        {
            redirect('admin/login');
        }
        else
        {
            if(!empty($_GET['paginate']))
            {
                $paginate='/'.$_GET['paginate'];
            }
            $result=$this->admin_model->deletestate($_POST['deleteid']);
            if($result)
            {
                $this->session->set_flashdata('success', 'State deleted successfully !!!');
                redirect('admin/manage_state'.$paginate.'?q='.@$_GET['q']);
            }
            else
            {
                $this->session->set_flashdata('failure', 'Can not delete the State');
                redirect('admin/manage_state'.$paginate.'?q='.@$_GET['q']);
       
            }
        }
    } 

    public function manage_hospitals()
    {
        if($this->data['access'] == 0)
        {
            redirect('admin/login');
        }
        else
        {
            $data = array('title' => 'Mobile Clinic | Referral Hospital', 'page' => 'admin/manage_hospital',  'errorCls' => NULL,'page_params' => NULL);
            $optionsets=array();
            $options=array();
            if(isset($_GET['q']) && $_GET['q']!='')
            {
                $q = '%'.$_GET['q'].'%';
                $optionsets[] = "hospital_name LIKE '$q'"; 
            }         
            
            if(!empty($optionsets))
            {
                @$options['key'].=' where '.implode(' and ',$optionsets);
            }
            @$options['key'] .=' order by id desc';
            $config = array();
            $config["base_url"] = base_url()."admin/manage_hospital";
            $config['first_url'] = base_url()."admin/manage_hospital?q=".@$_GET['q']."";
            $config["suffix"] ="?q=".@$_GET['q']."";
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $config["per_page"] = 30;
            $config["uri_segment"] = 3;
            $config["total_rows"] = $this->admin_model->manage_hospitals($options,'counts');
            $options['limit'] = $config["per_page"]; 
            $options['offset'] = $page; 
            $data['offset'] = $page; 
            $data['paginate'] = @$page; 
            $data['q']=@$_GET['q'];
            $data['hospital_info']=$this->admin_model->manage_hospitals($options);
            if(empty($data['hospital_info']) && !empty($page))
            {
                $paginate=$page-$config["per_page"];
                redirect('admin/manage_hospital/'.@$paginate.'?q='.@$_GET['q']);
            }
            $this->pagination->initialize($config);
            $data["links"] = $this->pagination->create_links(); 
            //var_dump($data['referrals_info']); exit;
            $data = $data + $this->data;
            $this->load->view($data['template'],$data);
        }
    } 

    public function add_hospital()
    {
        if($this->data['access'] == 0)
        {
            redirect('admin/login');
        }
        else
        {
            if((!empty($_POST['addhospital'])) && (isset($_POST['addhospital'])))
            {  
                
                $data['hospital_name']=$this->input->post('hospital_name');
                $result=$this->admin_model->add_hospital($data);
                if(!empty($result))
                {
                    $this->session->set_flashdata('success', 'Hospital is inserted Successfully');
                    redirect('admin/manage_hospitals');
                }
                else
                {                    
                    $this->session->set_flashdata('failure', 'Cannot insert hospital!!!');
                    redirect('admin/manage_hospitals');
                }
                
            }
        }
    }

    public function hospitalname() 
    {
        if(!empty($_POST['hospital_name']))
        {
            @$value['key']=" where hospital_name like '".$_POST['hospital_name']."'";
        }
        elseif(!empty($_POST['edithospitalname']))
        {
            $value['key']=" where hospital_name like '".$_POST['edithospitalname']."'";
        }
        $value['table']='hospitals_list';
        $result=$this->admin_model->get_details($value);
        if(!$result)
        {
            $response ='true';
        }
        else
        {
            $response = 'false';
        }
        echo $response;
    }
    public function edithospital()
    { 
        if($this->data['access'] == 0)
        {
            redirect('admin/login');
        }
        else
        {
            $data['id']=$this->input->post('editid');
            $data['hospital_name']=$this->input->post('edithospitalname');                       
            $result=$this->admin_model->edithospital($data);
            if($result['status'] == 'success')
            {
                $this->session->set_flashdata('success', 'Hospital name updated successfully');
                redirect('admin/manage_hospitals?q='.@$_GET['q']);
            }
            else
            {        
                $this->session->set_flashdata('failure', 'Cannot updated hospital name!!!');
                redirect('admin/manage_hospitals?q='.@$_GET['q']);
            }
        }
    }

    public function deletehospital() 
    {
        if($this->data['access'] == 0)
        {
            redirect('admin/login');
        }
        else
        {
            if(!empty($_GET['paginate']))
            {
                $paginate='/'.$_GET['paginate'];
            }
            $result=$this->admin_model->deletehospital($_POST['deleteid']);
            if($result)
            {
                $this->session->set_flashdata('success', 'Hospital deleted successfully !!!');
                redirect('admin/manage_hospitals'.$paginate.'?q='.@$_GET['q']);
            }
            else
            {
                $this->session->set_flashdata('failure', 'Can not delete the hospital');
                redirect('admin/manage_hospitals'.$paginate.'?q='.@$_GET['q']);
       
            }
        }
    } 

    public function manage_district()
    {
        if($this->data['access'] == 0)
        {
            redirect('admin/login');
        }
        else
        { 
            $data = array('title' => 'Mobile Clinic | Manage District', 'page' => 'admin/manage_district',  'errorCls' => NULL,'page_params' => NULL);
            $optionsets=array();
            $options=array();
            if(isset($_GET['q']) && $_GET['q']!='')
            {
                $q = '%'.$_GET['q'].'%';
                $optionsets[] = "sl.state_name LIKE '$q' or dl.district_name like '$q'"; 
            }         
            
            if(!empty($optionsets))
            {
                @$options['key'].=' where '.implode(' and ',$optionsets);
            }
            @$options['key'] .=' order by dl.id desc';
            $config = array();
            $config["base_url"] = base_url()."admin/manage_district";
            $config['first_url'] = base_url()."admin/manage_district?q=".@$_GET['q']."";
            $config["suffix"] ="?q=".@$_GET['q']."";
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $config["per_page"] = 30;
            $config["uri_segment"] = 3;
            $config["total_rows"] = $this->admin_model->manage_district($options,'counts');
            $options['limit'] = $config["per_page"]; 
            $options['offset'] = $page; 
            $data['offset'] = $page; 
            $data['paginate'] = @$page; 
            $data['q']=@$_GET['q'];
            $data['district_info']=$this->admin_model->manage_district($options);
            $data['state_info']=$this->admin_model->manage_state();
            if(empty($data['district_info']) && !empty($page))
            {
                $paginate=$page-$config["per_page"];
                redirect('admin/manage_district/'.@$paginate.'?q='.@$_GET['q']);
            }
            $this->pagination->initialize($config);
            $data["links"] = $this->pagination->create_links(); 
            //var_dump($data['referrals_info']); exit;
            $data = $data + $this->data;
            $this->load->view($data['template'],$data);
        }
    } 

    public function add_district()
    {
        if($this->data['access'] == 0)
        {
            redirect('admin/login');
        }
        else
        {
            if((!empty($_POST['adddistrict'])) && (isset($_POST['adddistrict'])))
            {  
                
                $data['district_name']=$this->input->post('district_name');
                $data['state_id']=$this->input->post('state_id');
                $result=$this->admin_model->add_district($data);
                if(!empty($result))
                {
                    $this->session->set_flashdata('success', 'District inserted Successfully');
                    redirect('admin/manage_district');
                }
                else
                {                    
                    $this->session->set_flashdata('failure', 'Cannot insert district!!!');
                    redirect('admin/manage_district');
                }
                
            }
        }
    }

    public function districtname() 
    {
        if(!empty($_POST['district_name']))
        {
            @$value['key']=" where district_name like '".$_POST['district_name']."'";
        }
        elseif(!empty($_POST['editdistrictname']))
        {
            $value['key']=" where district_name like '".$_POST['editdistrictname']."'";
        }
        $value['table']='district_list';
        $result=$this->admin_model->get_details($value);
        if(!$result)
        {
            $response ='true';
        }
        else
        {
            $response = 'false';
        }
        echo $response;
    }

    public function editdistrict()
    { 
        if($this->data['access'] == 0)
        {
            redirect('admin/login');
        }
        else
        {
            $data['id']=$this->input->post('editid');
            $data['state_id']=$this->input->post('editstate_id'); 
            $data['district_name']=$this->input->post('editdistrictname');                       
            $result=$this->admin_model->editdistrict($data);
            if($result['status'] == 'success')
            {
                $this->session->set_flashdata('success', 'District updated successfully');
                redirect('admin/manage_district?q='.@$_GET['q']);
            }
            else
            {        
                $this->session->set_flashdata('failure', 'Cannot updated district!!!');
                redirect('admin/manage_district?q='.@$_GET['q']);
            }
        }
    }

    public function deletedistrict() 
    {
        if($this->data['access'] == 0)
        {
            redirect('admin/login');
        }
        else
        {
            if(!empty($_GET['paginate']))
            {
                $paginate='/'.$_GET['paginate'];
            }
            $result=$this->admin_model->deletedistrict($_POST['deleteid']);
            if($result)
            {
                $this->session->set_flashdata('success', 'District deleted successfully !!!');
                redirect('admin/manage_district'.$paginate.'?q='.@$_GET['q']);
            }
            else
            {
                $this->session->set_flashdata('failure', 'Can not delete the district');
                redirect('admin/manage_district'.$paginate.'?q='.@$_GET['q']);
       
            }
        }
    }

    public function manage_city()
    {
        if($this->data['access'] == 0)
        {
            redirect('admin/login');
        }
        else
        { 
            $data = array('title' => 'Mobile Clinic | Manage City', 'page' => 'admin/manage_city',  'errorCls' => NULL,'page_params' => NULL);
            $optionsets=array();
            $options=array();
            if(isset($_GET['q']) && $_GET['q']!='')
            {
                $q = '%'.$_GET['q'].'%';
                $optionsets[] = "sl.state_name LIKE '$q' or dl.district_name like '$q' or cb.city_name like '$q'"; 
            }         
            
            if(!empty($optionsets))
            {
                @$options['key'].=' where '.implode(' and ',$optionsets);
            }
            @$options['key'] .=' order by cb.id desc';
            $config = array();
            $config["base_url"] = base_url()."admin/manage_city";
            $config['first_url'] = base_url()."admin/manage_city?q=".@$_GET['q']."";
            $config["suffix"] ="?q=".@$_GET['q']."";
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $config["per_page"] = 30;
            $config["uri_segment"] = 3;
            $config["total_rows"] = $this->admin_model->manage_city($options,'counts');
            $options['limit'] = $config["per_page"]; 
            $options['offset'] = $page; 
            $data['offset'] = $page; 
            $data['paginate'] = @$page; 
            $data['q']=@$_GET['q'];
            $data['city_info']=$this->admin_model->manage_city($options);
            $data['state_info']=$this->admin_model->manage_state();
            if(empty($data['city_info']) && !empty($page))
            {
                $paginate=$page-$config["per_page"];
                redirect('admin/city_info/'.@$paginate.'?q='.@$_GET['q']);
            }
            $this->pagination->initialize($config);
            $data["links"] = $this->pagination->create_links(); 
            //var_dump($data['referrals_info']); exit;
            $data = $data + $this->data;
            $this->load->view($data['template'],$data);
        }
    } 

    public function onloaddistrict()
    {
        if(!empty($_POST) && !empty($_POST['state_id']))
        {            
            $id=$_POST['state_id'];
            if(!empty($_POST['eselect']))
            {
                $select=$_POST['eselect'];
            }
            else
            {
                $select='';
            }
            if(!empty($id))
            {
                @$stateop['key'] =' where state_id='.$id.' order by district_name asc';
                $stateop['table']='district_list'; 
                $data=$this->admin_model->get_details($stateop);
            }
        }
        $namespace=@$_POST['name'];
        $block='<select class="form-control" name="'.$namespace.'" id="'.$namespace.'">
                    <option value="">--Select--</option>';
                   
        if(!empty($data))
        {
            foreach ($data as $value)
            {
                $selected='';
                if($value['id']==$select)
                {
                    $selected="selected='selected'";
                }
                $block.='<option value="'.$value['id'].'"'.@$selected.'>'.$value["district_name"].'</option>';
            }
        }
        $block.='</select>';
        echo $block;
        //var_dump($_POST);
    }

    public function cityname() 
    {
        if(!empty($_POST['city_name']))
        {
            @$value['key']=" where city_name like '".$_POST['city_name']."'";
        }
        elseif(!empty($_POST['editcityname']))
        {
            $value['key']=" where city_name like '".$_POST['editcityname']."'";
        }
        $value['table']='city_or_block';
        $result=$this->admin_model->get_details($value);
        if(!$result)
        {
            $response ='true';
        }
        else
        {
            $response = 'false';
        }
        echo $response;
    }

    public function add_city()
    {
        if($this->data['access'] == 0)
        {
            redirect('admin/login');
        }
        else
        {
            if((!empty($_POST['addcity'])) && (isset($_POST['addcity'])))
            {  
                
                $data['city_name']=$this->input->post('city_name');
                $data['district_id']=$this->input->post('district_id');
                $data['state_id']=$this->input->post('state_id');
                $result=$this->admin_model->add_city($data);
                if(!empty($result))
                {
                    $this->session->set_flashdata('success', 'City or Block inserted Successfully');
                    redirect('admin/manage_city');
                }
                else
                {                    
                    $this->session->set_flashdata('failure', 'Cannot insert City or Block!!!');
                    redirect('admin/manage_city');
                }
                
            }
        }
    }

    public function editcity()
    { 
        if($this->data['access'] == 0)
        {
            redirect('admin/login');
        }
        else
        {
            $data['id']=$this->input->post('editid');
            $data['state_id']=$this->input->post('editstate_id'); 
            $data['district_id']=$this->input->post('editdistrict_id');
            $data['city_name']=$this->input->post('editcityname');                       
            $result=$this->admin_model->editcity($data);
            if($result['status'] == 'success')
            {
                $this->session->set_flashdata('success', 'City or Block updated successfully');
                redirect('admin/manage_city?q='.@$_GET['q']);
            }
            else
            {        
                $this->session->set_flashdata('failure', 'Cannot updated city or block!!!');
                redirect('admin/manage_city?q='.@$_GET['q']);
            }
        }
    }

    public function deletecity() 
    {
        if($this->data['access'] == 0)
        {
            redirect('admin/login');
        }
        else
        {
            if(!empty($_GET['paginate']))
            {
                $paginate='/'.$_GET['paginate'];
            }
            $result=$this->admin_model->deletecity($_POST['deleteid']);
            if($result)
            {
                $this->session->set_flashdata('success', 'City or block deleted successfully !!!');
                redirect('admin/manage_city'.$paginate.'?q='.@$_GET['q']);
            }
            else
            {
                $this->session->set_flashdata('failure', 'Can not delete the city or block');
                redirect('admin/manage_city'.$paginate.'?q='.@$_GET['q']);
       
            }
        }
    }

    public function manage_panchayat()
    {
        if($this->data['access'] == 0)
        {
            redirect('admin/login');
        }
        else
        { 
            $data = array('title' => 'Mobile Clinic | Manage Panchayat', 'page' => 'admin/manage_panchayat',  'errorCls' => NULL,'page_params' => NULL);
            $optionsets=array();
            $options=array();
            if(isset($_GET['q']) && $_GET['q']!='')
            {
                $q = '%'.$_GET['q'].'%';
                $optionsets[] = "sl.state_name LIKE '$q' or dl.district_name like '$q' or cb.city_name like '$q' or wp.panchayat_name like '$q'"; 
            }         
            
            if(!empty($optionsets))
            {
                @$options['key'].=' where '.implode(' and ',$optionsets);
            }
            @$options['key'] .=' order by wp.id desc';
            $config = array();
            $config["base_url"] = base_url()."admin/manage_panchayat";
            $config['first_url'] = base_url()."admin/manage_panchayat?q=".@$_GET['q']."";
            $config["suffix"] ="?q=".@$_GET['q']."";
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $config["per_page"] = 30;
            $config["uri_segment"] = 3;
            $config["total_rows"] = $this->admin_model->manage_panchayat($options,'counts');
            $options['limit'] = $config["per_page"]; 
            $options['offset'] = $page; 
            $data['offset'] = $page; 
            $data['paginate'] = @$page; 
            $data['q']=@$_GET['q'];
            $data['panchayat_info']=$this->admin_model->manage_panchayat($options);
            $data['state_info']=$this->admin_model->manage_state();
            if(empty($data['panchayat_info']) && !empty($page))
            {
                $paginate=$page-$config["per_page"];
                redirect('admin/manage_panchayat/'.@$paginate.'?q='.@$_GET['q']);
            }
            $this->pagination->initialize($config);
            $data["links"] = $this->pagination->create_links(); 
            //var_dump($data['referrals_info']); exit;
            $data = $data + $this->data;
            $this->load->view($data['template'],$data);
        }
    }

    public function onloadcity()
    {
        if(!empty($_POST) && !empty($_POST['state_id']) && !empty($_POST['district_id']))
        {            
            $id1=$_POST['state_id'];
            $id2=$_POST['district_id'];
            if(!empty($_POST['eselect']))
            {
                $select=$_POST['eselect'];
            }
            else
            {
                $select='';
            }
            if(!empty($id1))
            {
                @$stateop['key'] =' where state_id='.$id1.' and district_id ='.$id2.' order by city_name asc';
                $stateop['table']='city_or_block'; 
                $data=$this->admin_model->get_details($stateop);
            }
        }
        $namespace=@$_POST['name'];
        $block='<select class="form-control" name="'.$namespace.'" id="'.$namespace.'">
                    <option value="">--Select--</option>';
                   
        if(!empty($data))
        {
            foreach ($data as $value)
            {
                $selected='';
                if($value['id']==$select)
                {
                    $selected="selected='selected'";
                }
                $block.='<option value="'.$value['id'].'"'.@$selected.'>'.$value["city_name"].'</option>';
            }
        }
        $block.='</select>';
        echo $block;
        //var_dump($_POST);
    }

    public function add_panchayat()
    {
        if($this->data['access'] == 0)
        {
            redirect('admin/login');
        }
        else
        {
            if((!empty($_POST['addpanchayat'])) && (isset($_POST['addpanchayat'])))
            {  
                
                $data['panchayat_name']=$this->input->post('panchayat_name');
                $data['city_id']=$this->input->post('city_id');
                $data['district_id']=$this->input->post('district_id');
                $data['state_id']=$this->input->post('state_id');
                $result=$this->admin_model->add_panchayat($data);
                if(!empty($result))
                {
                    $this->session->set_flashdata('success', 'Ward or panchayat inserted Successfully');
                    redirect('admin/manage_panchayat');
                }
                else
                {                    
                    $this->session->set_flashdata('failure', 'Cannot insert ward or panchayat!!!');
                    redirect('admin/manage_panchayat');
                }
                
            }
        }
    }

    public function panchayatname() 
    {
        if(!empty($_POST['panchayat_name']))
        {
            @$value['key']=" where panchayat_name like '".$_POST['panchayat_name']."'";
        }
        elseif(!empty($_POST['editpanchayatname']))
        {
            $value['key']=" where panchayat_name like '".$_POST['editpanchayatname']."'";
        }
        $value['table']='ward_or_panchayat';
        $result=$this->admin_model->get_details($value);
        if(!$result)
        {
            $response ='true';
        }
        else
        {
            $response = 'false';
        }
        echo $response;
    }

    public function editpanchayat()
    { 
        if($this->data['access'] == 0)
        {
            redirect('admin/login');
        }
        else
        {
            $data['id']=$this->input->post('editid');
            $data['state_id']=$this->input->post('editstate_id'); 
            $data['district_id']=$this->input->post('editdistrict_id');
            $data['city_id']=$this->input->post('editcity_id');  
            $data['panchayat_name']=$this->input->post('editpanchayatname');                      
            $result=$this->admin_model->editpanchayat($data);
            if($result['status'] == 'success')
            {
                $this->session->set_flashdata('success', 'Ward or panchayat updated successfully');
                redirect('admin/manage_panchayat?q='.@$_GET['q']);
            }
            else
            {        
                $this->session->set_flashdata('failure', 'Cannot updated ward or panchayat!!!');
                redirect('admin/manage_panchayat?q='.@$_GET['q']);
            }
        }
    }

    public function deletepanchayat() 
    {
        if($this->data['access'] == 0)
        {
            redirect('admin/login');
        }
        else
        {
            if(!empty($_GET['paginate']))
            {
                $paginate='/'.$_GET['paginate'];
            }
            $result=$this->admin_model->deletepanchayat($_POST['deleteid']);
            if($result)
            {
                $this->session->set_flashdata('success', 'Ward or panchayat deleted successfully !!!');
                redirect('admin/manage_panchayat'.$paginate.'?q='.@$_GET['q']);
            }
            else
            {
                $this->session->set_flashdata('failure', 'Can not delete the ward or panchayat');
                redirect('admin/manage_panchayat'.$paginate.'?q='.@$_GET['q']);
       
            }
        }
    }

    public function manage_village()
    {
        if($this->data['access'] == 0)
        {
            redirect('admin/login');
        }
        else
        { 
            $data = array('title' => 'Mobile Clinic | Manage Village', 'page' => 'admin/manage_village',  'errorCls' => NULL,'page_params' => NULL);
            $optionsets=array();
            $options=array();
            if(isset($_GET['q']) && $_GET['q']!='')
            {
                $q = '%'.$_GET['q'].'%';
                $optionsets[] = "sl.state_name LIKE '$q' or dl.district_name like '$q' or cb.city_name like '$q' or wp.panchayat_name like '$q' or sv.village_name like '$q'" ; 
            }         
            
            if(!empty($optionsets))
            {
                @$options['key'].=' where '.implode(' and ',$optionsets);
            }
            @$options['key'] .=' order by sv.id desc';
            $config = array();
            $config["base_url"] = base_url()."admin/manage_village";
            $config['first_url'] = base_url()."admin/manage_village?q=".@$_GET['q']."";
            $config["suffix"] ="?q=".@$_GET['q']."";
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $config["per_page"] = 30;
            $config["uri_segment"] = 3;
            $config["total_rows"] = $this->admin_model->manage_village($options,'counts');
            $options['limit'] = $config["per_page"]; 
            $options['offset'] = $page; 
            $data['offset'] = $page; 
            $data['paginate'] = @$page; 
            $data['q']=@$_GET['q'];
            $data['village_info']=$this->admin_model->manage_village($options);
            $data['state_info']=$this->admin_model->manage_state();
            if(empty($data['village_info']) && !empty($page))
            {
                $paginate=$page-$config["per_page"];
                redirect('admin/manage_village/'.@$paginate.'?q='.@$_GET['q']);
            }
            $this->pagination->initialize($config);
            $data["links"] = $this->pagination->create_links(); 
            //var_dump($data['referrals_info']); exit;
            $data = $data + $this->data;
            $this->load->view($data['template'],$data);
        }
    }

    public function onloadpanchayat()
    {
        if(!empty($_POST) && !empty($_POST['state_id']) && !empty($_POST['district_id']) && !empty($_POST['city_id']))
        {            
            $id1=$_POST['state_id'];
            $id2=$_POST['district_id'];
            $id3=$_POST['city_id'];
            if(!empty($_POST['eselect']))
            {
                $select=$_POST['eselect'];
            }
            else
            {
                $select='';
            }
            if(!empty($id1))
            {
                @$stateop['key'] =' where state_id='.$id1.' and district_id ='.$id2.' and city_id ='.$id3.' order by panchayat_name asc';
                $stateop['table']='ward_or_panchayat'; 
                $data=$this->admin_model->get_details($stateop);
            }
        }
        $namespace=@$_POST['name'];
        $block='<select class="form-control" name="'.$namespace.'" id="'.$namespace.'">
                    <option value="">--Select--</option>';
                   
        if(!empty($data))
        {
            foreach ($data as $value)
            {
                $selected='';
                if($value['id']==$select)
                {
                    $selected="selected='selected'";
                }
                $block.='<option value="'.$value['id'].'"'.@$selected.'>'.$value["panchayat_name"].'</option>';
            }
        }
        $block.='</select>';
        echo $block;
        //var_dump($_POST);
    }

    public function villagename() 
    {
        if(!empty($_POST['village_name']))
        {
            @$value['key']=" where village_name like '".$_POST['village_name']."'";
        }
        elseif(!empty($_POST['editvillagename']))
        {
            $value['key']=" where village_name like '".$_POST['editvillagename']."'";
        }
        $value['table']='slum_or_village';
        $result=$this->admin_model->get_details($value);
        if(!$result)
        {
            $response ='true';
        }
        else
        {
            $response = 'false';
        }
        echo $response;
    }

    public function add_village()
    {
        if($this->data['access'] == 0)
        {
            redirect('admin/login');
        }
        else
        {
            if((!empty($_POST['addvillage'])) && (isset($_POST['addvillage'])))
            {  
                
                $data['village_name']=$this->input->post('village_name');
                $data['panchayat_id']=$this->input->post('panchayat_id');
                $data['city_id']=$this->input->post('city_id');
                $data['district_id']=$this->input->post('district_id');
                $data['state_id']=$this->input->post('state_id');
                $result=$this->admin_model->add_village($data);
                if(!empty($result))
                {
                    $this->session->set_flashdata('success', 'Slum or village inserted Successfully');
                    redirect('admin/manage_village');
                }
                else
                {                    
                    $this->session->set_flashdata('failure', 'Cannot insert slum or Village
                        !!!');
                    redirect('admin/manage_village');
                }
                
            }
        }
    }

    public function editvillage()
    { 
        if($this->data['access'] == 0)
        {
            redirect('admin/login');
        }
        else
        {
            $data['id']=$this->input->post('editid');
            $data['state_id']=$this->input->post('editstate_id'); 
            $data['district_id']=$this->input->post('editdistrict_id');
            $data['city_id']=$this->input->post('editcity_id');  
            $data['panchayat_id']=$this->input->post('editpanchayat_id');  
            $data['village_name']=$this->input->post('editvillagename');                      
            $result=$this->admin_model->editvillage($data);
            if($result['status'] == 'success')
            {
                $this->session->set_flashdata('success', 'Slum or village updated successfully');
                redirect('admin/manage_village?q='.@$_GET['q']);
            }
            else
            {        
                $this->session->set_flashdata('failure', 'Cannot updated slum or village!!!');
                redirect('admin/manage_village?q='.@$_GET['q']);
            }
        }
    }

    public function deletevillage() 
    {
        if($this->data['access'] == 0)
        {
            redirect('admin/login');
        }
        else
        {
            if(!empty($_GET['paginate']))
            {
                $paginate='/'.$_GET['paginate'];
            }
            $result=$this->admin_model->deletevillage($_POST['deleteid']);
            if($result)
            {
                $this->session->set_flashdata('success', 'Slum or village deleted successfully !!!');
                redirect('admin/manage_village'.$paginate.'?q='.@$_GET['q']);
            }
            else
            {
                $this->session->set_flashdata('failure', 'Can not delete the slum or village');
                redirect('admin/manage_village'.$paginate.'?q='.@$_GET['q']);
       
            }
        }
    }

    public function patient_view()
    {
        if($this->data['access'] == 0)
        {
            redirect('admin/login');
        }
        else
        {
            $data = array('title' => 'Mobile Clinic | Patient View', 'page' => 'admin/patient_full_info',  'errorCls' => NULL,'page_params' => NULL);
            

            $patient_id = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            
            $segment1 = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
            $segment2 = ($this->uri->segment(6)) ? $this->uri->segment(6) : 0;
            $segment3 = ($this->uri->segment(8)) ? $this->uri->segment(8) : 0;
            $dgn =0;$psc=0;$ref=0;    
            if($segment1 === 'dgn')
            {
                $dgn=($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
                $dgnuri=5;
            }
            if($segment2 === 'dgn')
            {
                $dgn=($this->uri->segment(7)) ? $this->uri->segment(7) : 0;
                $dgnuri=7;
            }
            if($segment3 === 'dgn')
            {

                $dgn=($this->uri->segment(9)) ? $this->uri->segment(9) : 0;
                $dgnuri=9;
            }
            if($segment1 === 'psc')
            {
                $psc=($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
                $pscuri=5;
            }
            if($segment2 === 'psc')
            {
                $psc=($this->uri->segment(7)) ? $this->uri->segment(7) : 0;
                $pscuri=7;
            }
            if($segment3 === 'psc')
            {
                //echo "string";
                $psc=($this->uri->segment(9)) ? $this->uri->segment(9) : 0;
                $pscuri=9;
            }
            if($segment1 === 'ref')
            {
                $ref=($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
                $refuri=5;
            }
            if($segment2 === 'ref')
            {
                $ref=($this->uri->segment(7)) ? $this->uri->segment(7) : 0;
                $refuri=7;
            }
            if($segment3 === 'ref')
            {
                $ref=($this->uri->segment(9)) ? $this->uri->segment(9) : 0;
                $refuri=9;
            }  
           
            $options1=array();             
           
            @$options1['key'] .=" where dg.patient_id=$patient_id order by dg.date_of_diagnosis desc";
            $config1 = array();
            $config1["base_url"] = base_url()."admin/patient_view/$patient_id/psc/$psc/ref/$ref/dgn/";
            $config1['first_url'] = base_url()."admin/patient_view/$patient_id/psc/$psc/ref/$ref/dgn/?q=".@$_GET['q']."";
            $config1["suffix"] ="?q=".@$_GET['q']."";
            $config1["per_page"] = 10;
            $config1["uri_segment"] = @$dgnuri;
            $config1["total_rows"] = $this->admin_model->manage_diagnosis($options1,'counts');
            $options1['limit'] = $config1["per_page"]; 
            $options1['offset'] = $dgn; 
            $data['diagnosis_info']=$this->admin_model->manage_diagnosis($options1);
            $this->pagination->initialize($config1);
            $data["dgnlinks"] = $this->pagination->create_links(); 

            $options2=array(); 
            @$options2['key'] =" where pc.patient_id=$patient_id order by pc.id desc";
            $config2 = array();
            $config2["base_url"] = base_url()."admin/patient_view/$patient_id/dgn/$dgn/ref/$ref/psc/";
            $config2['first_url'] = base_url()."admin/patient_view/$patient_id/dgn/$dgn/ref/$ref/psc/?q=".@$_GET['q']."";
            $config2["suffix"] ="?q=".@$_GET['q']."";
            $config2["per_page"] = 10;
            $config2["uri_segment"] = @$pscuri;
            $config2["total_rows"] = $this->admin_model->manage_prescription($options2,'counts');
            $options2['limit'] = $config2["per_page"]; 
            $options2['offset'] = $psc;
            $data['prescription_info']=$this->admin_model->manage_prescription($options2);
            $this->pagination->initialize($config2);
            $data["psclinks"] = $this->pagination->create_links(); 

            $options3=array(); 
            @$options3['key'] =" where reg.id=$patient_id";         
            $data['personal']=$this->admin_model->get_patient_details($options3);

            $options4=array(); 
            @$options4['key'] =" where patient_id=$patient_id";  
            $options4['table']='patient_child';       
            $data['patient_child']=$this->admin_model->get_details($options4);

            $options5=array();
            @$options5['key'] =" where patient_id = $patient_id order by rf.id desc";
            $config3 = array();
            $config3["base_url"] = base_url()."admin/patient_view/$patient_id/dgn/$dgn/psc/$psc/ref/";
            $config3['first_url'] = base_url()."admin/patient_view/$patient_id/dgn/$dgn/psc/$psc/ref/?q=".@$_GET['q']."";
            $config3["suffix"] ="?q=".@$_GET['q']."";
            $config3["per_page"] = 10;
            $config3["uri_segment"] = @$refuri;
            //$config2['use_page_numbers'] = TRUE;
            $config3["total_rows"] = $this->admin_model->manage_referrals($options5,'counts');
            $options5['limit'] = $config3["per_page"]; 
            $options5['offset'] = $ref; 
            $data['referrals_info']=$this->admin_model->manage_referrals($options5);
            $this->pagination->initialize($config3);
            $data["reflinks"] = $this->pagination->create_links(); 
           
            $data['downloadurl']=base_url()."admin/download/$patient_id/dgn/$dgn/psc/$psc/ref/$ref";
            $data = $data + $this->data;
            $this->load->view($data['template'],$data);
            
        }
    }

     public function download()
    {
        if($this->data['access'] == 0)
        {
            redirect('admin/login');
        }
        else
        {
            $data = array('title' => 'Mobile Clinic | Patient View', 'page' => 'admin/patient_full_info',  'errorCls' => NULL,'page_params' => NULL);
            

            $patient_id = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            
            $segment1 = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
            $segment2 = ($this->uri->segment(6)) ? $this->uri->segment(6) : 0;
            $segment3 = ($this->uri->segment(8)) ? $this->uri->segment(8) : 0;
            $dgn =0;$psc=0;$ref=0;    
            if($segment1 === 'dgn')
            {
                $dgn=($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
                $dgnuri=5;
            }
            if($segment2 === 'dgn')
            {
                $dgn=($this->uri->segment(7)) ? $this->uri->segment(7) : 0;
                $dgnuri=7;
            }
            if($segment3 === 'dgn')
            {

                $dgn=($this->uri->segment(9)) ? $this->uri->segment(9) : 0;
                $dgnuri=9;
            }
            if($segment1 === 'psc')
            {
                $psc=($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
                $pscuri=5;
            }
            if($segment2 === 'psc')
            {
                $psc=($this->uri->segment(7)) ? $this->uri->segment(7) : 0;
                $pscuri=7;
            }
            if($segment3 === 'psc')
            {
                //echo "string";
                $psc=($this->uri->segment(9)) ? $this->uri->segment(9) : 0;
                $pscuri=9;
            }
            if($segment1 === 'ref')
            {
                $ref=($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
                $refuri=5;
            }
            if($segment2 === 'ref')
            {
                $ref=($this->uri->segment(7)) ? $this->uri->segment(7) : 0;
                $refuri=7;
            }
            if($segment3 === 'ref')
            {
                $ref=($this->uri->segment(9)) ? $this->uri->segment(9) : 0;
                $refuri=9;
            }  
           
            $options1=array();             
           
            @$options1['key'] .=" where dg.patient_id=$patient_id order by dg.date_of_diagnosis desc";
            $options1['limit'] = 10; 
            $options1['offset'] = $dgn; 
            $diagnosis_info=$this->admin_model->manage_diagnosis($options1);

            $options2=array(); 
            @$options2['key'] =" where pc.patient_id=$patient_id order by pc.id desc";
            $options2['limit'] = 10; 
            $options2['offset'] = $psc;
            $prescription_info=$this->admin_model->manage_prescription($options2);

            $options3=array(); 
            @$options3['key'] =" where reg.id=$patient_id";         
            $personal=$this->admin_model->get_patient_details($options3);

            $options4=array(); 
            @$options4['key'] =" where patient_id=$patient_id";  
            $options4['table']='patient_child';       
            $patient_child=$this->admin_model->get_details($options4);

            $options5=array();
            @$options5['key'] =" where patient_id = $patient_id order by rf.id desc";
            $options5['limit'] = 10; 
            $options5['offset'] = $ref; 
            $referrals_info=$this->admin_model->manage_referrals($options5);


            $this->load->library('Excel/PHPExcel');
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->getDefaultStyle()->getFont()->setName('Times New Roman')->setSize(11);
            $objPHPExcel->getProperties()->setCreator("Mobile Clinic")
                                         ->setLastModifiedBy("Mobile Clinic Admin")
                                         ->setTitle("Mobile Clinic")
                                         ->setSubject("Mobile Clinic")
                                         ->setDescription("Mobile Clinic")
                                         ->setKeywords("Report")
                                         ->setCategory("Mobile Clinic");
            $j=1;
            
            $name1=ucfirst(@$personal[0]['title']).' '.ucfirst(@$personal[0]['initials']);
            $name2=ucfirst(@$personal[0]['first_name']).' '.ucfirst(@$personal[0]['last_name']);
            $reportname="Report : ".trim($name1).' '.trim($name2);
            $objPHPExcel->getActiveSheet()->mergeCells('A1:Q1');
            $objPHPExcel->getActiveSheet()->setCellValue('A1',$reportname)->getStyle()->getFont()->setBold(true)->setSize(16);
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(22);   
            
            if(!empty($personal)) {
                $j++;

                $objPHPExcel->getActiveSheet()->setCellValue("A$j", 'Title')->getStyle()->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue("B$j", ucfirst(@$personal[0]['title']))->getStyle()->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue("C$j", 'District')->getStyle()->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue("D$j", @$personal[0]['district_name'])->getStyle()->getFont()->setBold(true);                
                $objPHPExcel->getActiveSheet()->getStyle("A$j")->getFont()->setBold(true); 
                $objPHPExcel->getActiveSheet()->getStyle("C$j")->getFont()->setBold(true); 
                $j++;

                $objPHPExcel->getActiveSheet()->setCellValue("A$j", 'Initials')->getStyle()->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue("B$j", ucfirst(@$personal[0]['initials']))->getStyle()->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue("C$j", 'State')->getStyle()->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue("D$j", @$personal[0]['state_name'])->getStyle()->getFont()->setBold(true);                
                $objPHPExcel->getActiveSheet()->getStyle("A$j")->getFont()->setBold(true); 
                $objPHPExcel->getActiveSheet()->getStyle("C$j")->getFont()->setBold(true); 
                $j++;

                $objPHPExcel->getActiveSheet()->setCellValue("A$j", 'First Name')->getStyle()->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue("B$j", ucfirst(@$personal[0]['first_name']))->getStyle()->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue("C$j", 'Mobile')->getStyle()->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle("D$j")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $objPHPExcel->getActiveSheet()->setCellValue("D$j", @$personal[0]['mobile'])->getStyle()->getFont()->setBold(true);                
                $objPHPExcel->getActiveSheet()->getStyle("A$j")->getFont()->setBold(true); 
                $objPHPExcel->getActiveSheet()->getStyle("C$j")->getFont()->setBold(true); 
                $j++;

                $objPHPExcel->getActiveSheet()->setCellValue("A$j", 'Last Name')->getStyle()->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue("B$j", ucfirst(@$personal[0]['last_name']))->getStyle()->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue("C$j", 'Email')->getStyle()->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue("D$j", @$personal[0]['email'])->getStyle()->getFont()->setBold(true);                
                $objPHPExcel->getActiveSheet()->getStyle("A$j")->getFont()->setBold(true); 
                $objPHPExcel->getActiveSheet()->getStyle("C$j")->getFont()->setBold(true); 
                $j++;

                $objPHPExcel->getActiveSheet()->setCellValue("A$j", 'Date of Birth')->getStyle()->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue("B$j", date('d-m-Y',strtotime(@$personal[0]['dob'])))->getStyle()->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue("C$j", 'Occupation')->getStyle()->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue("D$j", @$personal[0]['occupation'])->getStyle()->getFont()->setBold(true);                
                $objPHPExcel->getActiveSheet()->getStyle("A$j")->getFont()->setBold(true); 
                $objPHPExcel->getActiveSheet()->getStyle("C$j")->getFont()->setBold(true); 
                $j++;

                $objPHPExcel->getActiveSheet()->setCellValue("A$j", 'Gender')->getStyle()->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue("B$j", @$personal[0]['gender'])->getStyle()->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue("C$j", 'Marital Status')->getStyle()->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue("D$j", @$personal[0]['marital_status'])->getStyle()->getFont()->setBold(true);                
                $objPHPExcel->getActiveSheet()->getStyle("A$j")->getFont()->setBold(true); 
                $objPHPExcel->getActiveSheet()->getStyle("C$j")->getFont()->setBold(true); 
                $j++;

                $objPHPExcel->getActiveSheet()->setCellValue("A$j", 'Address')->getStyle()->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue("B$j", @$personal[0]['address'])->getStyle()->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue("C$j", 'Husband / Father Name')->getStyle()->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue("D$j", @$personal[0]['husband_or_father_name'])->getStyle()->getFont()->setBold(true);                
                $objPHPExcel->getActiveSheet()->getStyle("A$j")->getFont()->setBold(true); 
                $objPHPExcel->getActiveSheet()->getStyle("C$j")->getFont()->setBold(true); 
                $j++;

                $objPHPExcel->getActiveSheet()->setCellValue("A$j", 'Slum / Village')->getStyle()->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue("B$j", @$personal[0]['village_name'])->getStyle()->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue("C$j", 'Monthly Income')->getStyle()->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle("D$j")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $objPHPExcel->getActiveSheet()->setCellValue("D$j", @$personal[0]['monthly_income'])->getStyle()->getFont()->setBold(true);                
                $objPHPExcel->getActiveSheet()->getStyle("A$j")->getFont()->setBold(true); 
                $objPHPExcel->getActiveSheet()->getStyle("C$j")->getFont()->setBold(true); 
                $j++;

                $objPHPExcel->getActiveSheet()->setCellValue("A$j", 'Ward or Panchayat')->getStyle()->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue("B$j", @$personal[0]['panchayat_name'])->getStyle()->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue("C$j", 'Registration By')->getStyle()->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue("D$j", @$personal[0]['register_name'])->getStyle()->getFont()->setBold(true);                
                $objPHPExcel->getActiveSheet()->getStyle("A$j")->getFont()->setBold(true); 
                $objPHPExcel->getActiveSheet()->getStyle("C$j")->getFont()->setBold(true); 
                $j++;

                $objPHPExcel->getActiveSheet()->setCellValue("A$j", 'City or Block')->getStyle()->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue("B$j", @$personal[0]['city_name'])->getStyle()->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue("C$j", 'Diagnosis Date')->getStyle()->getFont()->setBold(true);
                if($personal[0]['date_of_registration'] !='0000-00-00') 
                { 
                    $register=date('d-m-Y',strtotime(@$personal[0]['date_of_registration']));
                }
                else
                {
                    $register='';
                }
                $objPHPExcel->getActiveSheet()->setCellValue("D$j",@$register)->getStyle()->getFont()->setBold(true);                
                $objPHPExcel->getActiveSheet()->getStyle("A$j")->getFont()->setBold(true); 
                $objPHPExcel->getActiveSheet()->getStyle("C$j")->getFont()->setBold(true); 
                $j++;
            }
            $j++;

        if(!empty($patient_child)) 
            {
                $objPHPExcel->getActiveSheet()->setCellValue("A$j", 'Child Name')->getStyle()->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue("B$j", 'Child Date of Birth')->getStyle()->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue("C$j", 'Child Gender')->getStyle()->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle("A$j:C$j")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('D8D8D8D8');
                $objPHPExcel->getActiveSheet()->getStyle("A$j:C$j")->getFont()->setBold(true);  
                $j++;
                foreach($patient_child as $child)
                {
                    $objPHPExcel->getActiveSheet()->setCellValue("A$j", $child['child_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue("B$j", date('d-m-Y',strtotime(@$child['child_dob'])));
                    $objPHPExcel->getActiveSheet()->setCellValue("C$j", $child['child_gender']);
                    $objPHPExcel->getActiveSheet()->getRowDimension($j)->setRowHeight(16);  
                    $j++;
                }
                $j++;
            }

            // DIAGNOSIS TABLE START
            if(!empty($diagnosis_info)) 
            {
                $j++;
                $objPHPExcel->getActiveSheet()->setCellValue("A$j", 'Circulatory and respiratory')->getStyle()->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue("B$j", 'Digestive system and abdomen')->getStyle()->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue("C$j", 'Skin and subcutaneous tissue')->getStyle()->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue("D$j", 'Nervous and musculoskeletal systems')->getStyle()->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue("E$j", 'Urinary system')->getStyle()->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue("F$j", 'Cognition, perception, emotional')->getStyle()->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue("G$j", 'Speech and voice')->getStyle()->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue("H$j", 'General symptoms and signs')->getStyle()->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue("I$j", 'Blood')->getStyle()->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue("J$j", 'Urine')->getStyle()->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue("K$j", 'Body fluids, substances and tissues')->getStyle()->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue("L$j", 'Imaging and in function studies')->getStyle()->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue("M$j", 'Ill-defined and unknown causes of mortality')->getStyle()->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue("N$j", 'Preliminary diagnosis')->getStyle()->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue("O$j", 'Final diagnosis')->getStyle()->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue("P$j", 'Diagnosis By')->getStyle()->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue("Q$j", 'Diagnosis Date')->getStyle()->getFont()->setBold(true);
                      
                $objPHPExcel->getActiveSheet()->getStyle("A$j:Q$j")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('D8D8D8D8');
                $objPHPExcel->getActiveSheet()->getStyle("A$j:Q$j")->getFont()->setBold(true);  
                $j++;
                foreach($diagnosis_info as $diagnosis)
                {
                    $objPHPExcel->getActiveSheet()->setCellValue("A$j", $diagnosis['circulatory_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue("B$j", $diagnosis['digestive_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue("C$j", $diagnosis['skin_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue("D$j", $diagnosis['nervous_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue("E$j", $diagnosis['urinary_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue("F$j", $diagnosis['cognition_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue("G$j", $diagnosis['speech_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue("H$j", $diagnosis['general_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue("I$j", $diagnosis['blood']);
                    $objPHPExcel->getActiveSheet()->setCellValue("J$j", $diagnosis['urine']);
                    $objPHPExcel->getActiveSheet()->setCellValue("K$j", $diagnosis['body_fluids']);
                    $objPHPExcel->getActiveSheet()->setCellValue("L$j", $diagnosis['imaging']);
                    $objPHPExcel->getActiveSheet()->setCellValue("M$j", $diagnosis['mortality']);
                    $objPHPExcel->getActiveSheet()->setCellValue("N$j", $diagnosis['preliminary_diagnosis']);
                    $objPHPExcel->getActiveSheet()->setCellValue("O$j", $diagnosis['final_diagnosis']);
                    $objPHPExcel->getActiveSheet()->setCellValue("P$j", $diagnosis['diagnosis_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue("Q$j", date('d-m-Y',strtotime($diagnosis['date_of_diagnosis'])));
                    $objPHPExcel->getActiveSheet()->getRowDimension($j)->setRowHeight(16);  
                    $j++;
                }
               $j++;
            }
            // DIAGNOSIS TABLE END

            // PRESCRIPTION TABLE START
            if(!empty($prescription_info)) 
            {
                $j++;
                $objPHPExcel->getActiveSheet()->setCellValue("A$j", 'Tab / cap / syrup')->getStyle()->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue("B$j", 'Description')->getStyle()->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue("C$j", 'BB')->getStyle()->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue("D$j", 'AB')->getStyle()->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue("E$j", 'BL')->getStyle()->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue("F$j", 'AL')->getStyle()->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue("G$j", 'Evening')->getStyle()->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue("H$j", 'BM')->getStyle()->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue("I$j", 'AM')->getStyle()->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue("J$j", 'No.Of Days')->getStyle()->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue("K$j", 'Prescribed By')->getStyle()->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue("L$j", 'Prescription Date')->getStyle()->getFont()->setBold(true);  
                $objPHPExcel->getActiveSheet()->getStyle("A$j:L$j")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('D8D8D8D8');
                $objPHPExcel->getActiveSheet()->getStyle("A$j:L$j")->getFont()->setBold(true);  
                $j++;
                foreach($prescription_info as $prescription)
                {
                    $objPHPExcel->getActiveSheet()->setCellValue("A$j", $prescription['tab_cap_syrup']);
                    $objPHPExcel->getActiveSheet()->setCellValue("B$j", $prescription['description']);
                    $objPHPExcel->getActiveSheet()->setCellValue("C$j", $prescription['bb']?'Yes':'No');
                    $objPHPExcel->getActiveSheet()->setCellValue("D$j", $prescription['ab']?'Yes':'No');
                    $objPHPExcel->getActiveSheet()->setCellValue("E$j", $prescription['bl']?'Yes':'No');
                    $objPHPExcel->getActiveSheet()->setCellValue("F$j", $prescription['al']?'Yes':'No');
                    $objPHPExcel->getActiveSheet()->setCellValue("G$j", $prescription['eve']?'Yes':'No');
                    $objPHPExcel->getActiveSheet()->setCellValue("H$j", $prescription['bm']?'Yes':'No');
                    $objPHPExcel->getActiveSheet()->setCellValue("I$j", $prescription['am']?'Yes':'No');
                    $objPHPExcel->getActiveSheet()->setCellValue("J$j", $prescription['days']);
                    $objPHPExcel->getActiveSheet()->setCellValue("K$j", $prescription['prescript_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue("L$j", date('d-m-Y',strtotime($prescription['date_of_prescription'])));
                    $objPHPExcel->getActiveSheet()->getRowDimension($j)->setRowHeight(16);  
                    $j++;
                }
                $j++;
        
            }
            //PRESCRIPTION TABLE END

            //REFERRAL TABLE START
             if(!empty($referrals_info)) 
            {
                $j++;
                $objPHPExcel->getActiveSheet()->setCellValue("A$j", 'Referred To')->getStyle()->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue("B$j", 'Hospital Name / Pharmacy')->getStyle()->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue("C$j", 'Preliminary Diagnosis')->getStyle()->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue("D$j", 'Final Diagnosis')->getStyle()->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue("E$j", 'Referred By')->getStyle()->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->setCellValue("F$j", 'Referred Date')->getStyle()->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle("A$j:F$j")->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('D8D8D8D8');
                $objPHPExcel->getActiveSheet()->getStyle("A$j:F$j")->getFont()->setBold(true);  
                $j++;
                foreach($referrals_info as $referral)
                {
                    $objPHPExcel->getActiveSheet()->setCellValue("A$j", $referral['referred_to']);
                    $objPHPExcel->getActiveSheet()->setCellValue("B$j", $referral['hospital_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue("C$j", $referral['preliminary_diagnosis']);
                    $objPHPExcel->getActiveSheet()->setCellValue("D$j", $referral['final_diagnosis']);
                    $objPHPExcel->getActiveSheet()->setCellValue("E$j", $referral['referral_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue("F$j", date('d-m-Y',strtotime($referral['referred_date'])));
                    $objPHPExcel->getActiveSheet()->getRowDimension($j)->setRowHeight(16);  
                    $j++;
                }
                $j++;
        
            }
            

            $objPHPExcel->setActiveSheetIndex(0);
            if(!empty(trim($name2)))
            {
                $filename='Report_'.trim($name2).'.xls';
            }
            else
            {
                $filename='Report.xls';
            }
            // Redirect output to a client’s web browser (Excel5)
            header('Content-Type: application/vnd.ms-excel');
            header("Content-Disposition: attachment;filename=$filename");
            header('Cache-Control: max-age=0');
            // If you're serving to IE 9, then the following may be needed
            header('Cache-Control: max-age=1');
            
            // If you're serving to IE over SSL, then the following may be needed
            header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
            header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header ('Pragma: public'); // HTTP/1.0
            
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
            exit;
        }
    }

    public function manage_awareness_type()
    {
        if($this->data['access'] == 0)
        {
            redirect('admin/login');
        }
        else
        {
            $data = array('title' => 'Mobile Clinic | Manage Awareness Type', 'page' => 'admin/manage_awareness_type',  'errorCls' => NULL,'page_params' => NULL);
            $optionsets=array();
            $options=array();
            if(isset($_GET['q']) && $_GET['q']!='')
            {
                $q = '%'.$_GET['q'].'%';
                $optionsets[] = "awareness_type LIKE '$q'"; 
            }         
            
            if(!empty($optionsets))
            {
                @$options['key'].=' where '.implode(' and ',$optionsets);
            }
            @$options['key'] .=' order by id desc';
            $config = array();
            $config["base_url"] = base_url()."admin/manage_awareness_type";
            $config['first_url'] = base_url()."admin/manage_awareness_type?q=".@$_GET['q']."";
            $config["suffix"] ="?q=".@$_GET['q']."";
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $config["per_page"] = 30;
            $config["uri_segment"] = 3;
            $config["total_rows"] = $this->admin_model->manage_awareness_type($options,'counts');
            $options['limit'] = $config["per_page"]; 
            $options['offset'] = $page; 
            $data['offset'] = $page; 
            $data['paginate'] = @$page; 
            $data['q']=@$_GET['q'];
            $data['awarenesstype_info']=$this->admin_model->manage_awareness_type($options);
            if(empty($data['awarenesstype_info']) && !empty($page))
            {
                $paginate=$page-$config["per_page"];
                redirect('admin/manage_awareness_type/'.@$paginate.'?q='.@$_GET['q']);
            }
            $this->pagination->initialize($config);
            $data["links"] = $this->pagination->create_links(); 
            //var_dump($data['referrals_info']); exit;
            $data = $data + $this->data;
            $this->load->view($data['template'],$data);
        }
    }

    public function awarenessType() 
    {
        if(!empty($_POST['awareness_type']))
        {
            @$value['key']=" where awareness_type like '".$_POST['awareness_type']."'";
        }
        elseif(!empty($_POST['editawtype']))
        {
            $value['key']=" where awareness_type like '".$_POST['editawtype']."'";
        }
        $value['table']='awareness_type';
        $result=$this->admin_model->get_details($value);
        if(!$result)
        {
            $response ='true';
        }
        else
        {
            $response = 'false';
        }
        echo $response;
    }

    public function add_awarenessType()
    {
        if($this->data['access'] == 0)
        {
            redirect('admin/login');
        }
        else
        {
            if((!empty($_POST['addAwarenessType'])) && (isset($_POST['addAwarenessType'])))
            {  
                
                $data['awareness_type']=$this->input->post('awareness_type');
                $result=$this->admin_model->add_awarenessType($data);
                if(!empty($result))
                {
                    $this->session->set_flashdata('success', 'Awareness type is inserted Successfully');
                    redirect('admin/manage_awareness_type');
                }
                else
                {                    
                    $this->session->set_flashdata('failure', 'Cannot insert awareness type!!!');
                    redirect('admin/manage_awareness_type');
                }
                
            }
        }
    }

    public function editAwarnessType()
    { 
        if($this->data['access'] == 0)
        {
            redirect('admin/login');
        }
        else
        {
            $data['id']=$this->input->post('editid');
            $data['awareness_type']=$this->input->post('editawtype');  
            $data['status']=$this->input->post('editstatus');                      
            $result=$this->admin_model->editAwarnessType($data);
            if($result['status'] == 'success')
            {
                $this->session->set_flashdata('success', 'Awareness type updated successfully');
                redirect('admin/manage_awareness_type?q='.@$_GET['q']);
            }
            else
            {        
                $this->session->set_flashdata('failure', 'Cannot updated awareness type!!!');
                redirect('admin/manage_awareness_type?q='.@$_GET['q']);
            }
        }
    }

    public function deleteAwarenessType() 
    {
        if($this->data['access'] == 0)
        {
            redirect('admin/login');
        }
        else
        {
            if(!empty($_GET['paginate']))
            {
                $paginate='/'.$_GET['paginate'];
            }
            $result=$this->admin_model->deleteAwarenessType($_POST['deleteid']);
            if($result)
            {
                $this->session->set_flashdata('success', 'Awareness type deleted successfully !!!');
                redirect('admin/manage_awareness_type'.$paginate.'?q='.@$_GET['q']);
            }
            else
            {
                $this->session->set_flashdata('failure', 'Can not delete the awareness type');
                redirect('admin/manage_awareness_type'.$paginate.'?q='.@$_GET['q']);
       
            }
        }
    }

    public function manage_awareness()
    {
        if($this->data['access'] == 0)
        {
            redirect('admin/login');
        }
        else
        {
            $data = array('title' => 'Mobile Clinic | Manage Awareness', 'page' => 'admin/manage_awareness',  'errorCls' => NULL,'page_params' => NULL);
            $optionsets=array();
            $options=array();
            if(isset($_GET['q']) && $_GET['q']!='')
            {
                $q = '%'.$_GET['q'].'%';
                $optionsets[] = "sl.state_name like '$q' or dl.district_name like '$q' or cb.city_name like '$q' or wp.panchayat_name like '$q' or sv.village_name like '$q' or at.awareness_type like '$q' or users.name like '$q'"; 
            }         
            
            if(!empty($optionsets))
            {
                @$options['key'].=' where '.implode(' and ',$optionsets);
            }
            @$options['key'] .=' order by id desc';
            $config = array();
            $config["base_url"] = base_url()."admin/manage_awareness";
            $config['first_url'] = base_url()."admin/manage_awareness?q=".@$_GET['q']."";
            $config["suffix"] ="?q=".@$_GET['q']."";
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $config["per_page"] = 30;
            $config["uri_segment"] = 3;
            $config["total_rows"] = $this->admin_model->manage_awareness($options,'counts');
            $options['limit'] = $config["per_page"]; 
            $options['offset'] = $page; 
            $data['offset'] = $page; 
            $data['paginate'] = @$page; 
            $data['q']=@$_GET['q'];
            $data['awareness_info']=$this->admin_model->manage_awareness($options);
            if(empty($data['awareness_info']) && !empty($page))
            {
                $paginate=$page-$config["per_page"];
                redirect('admin/manage_awareness/'.@$paginate.'?q='.@$_GET['q']);
            }
            $this->pagination->initialize($config);
            $data["links"] = $this->pagination->create_links(); 
            //var_dump($data['referrals_info']); exit;
            $data = $data + $this->data;
            $this->load->view($data['template'],$data);
        }
    }

    public function manage_masters()
    {
        if($this->data['access'] == 0)
        {
            redirect('admin/login');
        }
        else
        { 
            $data = array('title' => 'Mobile Clinic | Manage Masters', 'page' => 'admin/manage_masters',  'errorCls' => NULL,'page_params' => NULL);
            $optionsets=array();
            $options=array();
            if(isset($_GET['q']) && $_GET['q']!='')
            {
                $q = '%'.$_GET['q'].'%';
                $optionsets[] = "ms.master_value LIKE '$q' or mt.master_name like '$q'"; 
            }         
            
            if(!empty($optionsets))
            {
                @$options['key'].=' where '.implode(' and ',$optionsets);
            }
            @$options['key'] .=' order by id desc';
            $config = array();
            $config["base_url"] = base_url()."admin/manage_masters";
            $config['first_url'] = base_url()."admin/manage_masters?q=".@$_GET['q']."";
            $config["suffix"] ="?q=".@$_GET['q']."";
            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
            $config["per_page"] = 30;
            $config["uri_segment"] = 3;
            $config["total_rows"] = $this->admin_model->manage_masters($options,'counts');
            $options['limit'] = $config["per_page"]; 
            $options['offset'] = $page; 
            $data['offset'] = $page; 
            $data['paginate'] = @$page; 
            $data['q']=@$_GET['q'];
            $data['masters_info']=$this->admin_model->manage_masters($options);
            $data['masterstype_info']=$this->admin_model->manage_masterTypes();
            if(empty($data['masters_info']) && !empty($page))
            {
                $paginate=$page-$config["per_page"];
                redirect('admin/manage_masters/'.@$paginate.'?q='.@$_GET['q']);
            }
            $this->pagination->initialize($config);
            $data["links"] = $this->pagination->create_links(); 
            //var_dump($data['referrals_info']); exit;
            $data = $data + $this->data;
            $this->load->view($data['template'],$data);
        }
    } 

    public function diagnosisType() 
    {
        if(!empty($_POST['diagnosisTypeValue']))
        {
            @$value['key']=" where master_value like '".trim($_POST['diagnosisTypeValue'])."'";
        }
        elseif(!empty($_POST['editdiagnosisTypeValue']))
        {
            $value['key']=" where master_value like '".trim($_POST['editdiagnosisTypeValue'])."'";
        }
        $value['table']='masters';
        $result=$this->admin_model->get_details($value);
        if(!$result)
        {
            $response ='true';
        }
        else
        {
            $response = 'false';
        }
        echo $response;
    }

    public function add_diagnosisTypes()
    {
        if($this->data['access'] == 0)
        {
            redirect('admin/login');
        }
        else
        {
            if((!empty($_POST['addDiagnosisType'])) && (isset($_POST['addDiagnosisType'])))
            {  
                
                $data['master_type']=$this->input->post('diagnosisType');
                $data['master_value']=$this->input->post('diagnosisTypeValue');
                $result=$this->admin_model->add_diagnosisTypes($data);
                if(!empty($result))
                {
                    $this->session->set_flashdata('success', 'Diagnosis type value is inserted Successfully');
                    redirect('admin/manage_masters');
                }
                else
                {                    
                    $this->session->set_flashdata('failure', 'Cannot insert Diagnosis type value!!!');
                    redirect('admin/manage_masters');
                }
                
            }
        }
    }

    public function editdiagnosisTypes()
    { 
        if($this->data['access'] == 0)
        {
            redirect('admin/login');
        }
        else
        {
            $data['id']=$this->input->post('editid');
            $data['master_type']=$this->input->post('editdiagnosisType');  
            $data['master_value']=$this->input->post('editdiagnosisTypeValue');                      
            $result=$this->admin_model->editdiagnosisTypes($data);
            if($result['status'] == 'success')
            {
                $this->session->set_flashdata('success', 'Diagnosis type value updated successfully');
                redirect('admin/manage_masters?q='.@$_GET['q']);
            }
            else
            {        
                $this->session->set_flashdata('failure', 'Cannot updated diagnosis type value!!!');
                redirect('admin/manage_masters?q='.@$_GET['q']);
            }
        }
    }

    public function deletediagnosisType() 
    {
        if($this->data['access'] == 0)
        {
            redirect('admin/login');
        }
        else
        {
            if(!empty($_GET['paginate']))
            {
                $paginate='/'.$_GET['paginate'];
            }
            $result=$this->admin_model->deletediagnosisType($_POST['deleteid']);
            if($result)
            {
                $this->session->set_flashdata('success', 'diagnosis type value deleted successfully !!!');
                redirect('admin/manage_masters'.$paginate.'?q='.@$_GET['q']);
            }
            else
            {
                $this->session->set_flashdata('failure', 'Can not delete the diagnosis type value');
                redirect('admin/manage_masters'.$paginate.'?q='.@$_GET['q']);
       
            }
        }
    }
}
?>