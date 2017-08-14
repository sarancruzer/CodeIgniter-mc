<?php
require_once APPPATH . '/libraries/JWT.php';
use \Firebase\JWT\JWT;
function tocken_auth($jwt)
    {
      try {

               JWT::$leeway = 600;
               $DecodedDataArray = JWT::decode($jwt,"my Secret key!",['HS256']); 
               $output['id']=$DecodedDataArray->id;
               $output['statuscode']='200';
                return $output;
 
              // echo  "{'status' : 'success' ,'data':".$DecodedDataArray." }";die();
 
               } catch (\Firebase\JWT\ExpiredException $e) {

                 $invalidLogin['statuscode']='404';
                 $invalidLogin['message'] = "Unauthourized";
                 return $invalidLogin;
                // $this->set_response($invalidLogin, REST_Controller::HTTP_NOT_FOUND);
               }

              /* JWT::$leeway = 600;
               $DecodedDataArray = JWT::decode($jwt,"my Secret key!",['HS256']); 
               if(!empty($DecodedDataArray->id))
               {
               $output['id']=$DecodedDataArray->id;
               $output['statuscode']='200';
                return $output;
               }
               else
               {
                 return $DecodedDataArray;
               }*/
    }
    ?>