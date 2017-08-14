<?php
require_once APPPATH . '/libraries/REST_Controller.php';
require_once APPPATH . '/libraries/JWT.php';
use \Firebase\JWT\JWT;

class Register extends REST_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function patient_post()
	{
		$id = $this->Users_model->registration($username,$password);
		$this->load->helper('url');

		$result = array();
		$params= array();
		$params['title']=$_POST['title'];
		$params['title']=$_POST['initials'];
                $params['title']=$_POST['firstname'];


		   /*$regist['title']=trim($request->title);
		$regist['initials']=trim($request->initials);
		$regist['first_name']=trim($request->firstname);
		$regist['last_name']=trim($request->lastname);
		$regist['dob']=date('Y-m-d',strtotime($request->dob));
		$regist['gender']=trim($request->gender);
		$regist['address']=trim($request->address);
		$regist['slum_or_village']=trim($request->slum_or_village);
		$regist['ward_or_panchayat']=trim($request->ward_or_panchayat);
		$regist['city_block']=trim($request->city_block);
		$regist['district']=trim($request->district);
		$regist['mobile']=trim($request->mobile);
		$regist['email']=trim($request->email);
		$regist['occupation']=trim($request->occupation);
		$regist['martial_status']=trim($request->martial_status);
		$regist['husband_or_father_name']=trim($request->husband_or_father_name);
		$regist['child_one']=trim($request->child_one);
		$regist['monthly_income']=trim($request->monthly_income);
		$regist['registration_by']=trim($request->registration_by);
		$regist['date_of_registration']=date('Y-m-d h:i:s');*/
	}
}
