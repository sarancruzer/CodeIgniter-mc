<div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="<?php echo base_url('admin')?>" class="site_title"><i class="fa fa-plus-square"></i> <span>Mobile Clinic</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile">
              <div class="profile_pic">
                <img src="<?php echo base_url();?>assets/images/img.jpg" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Welcome,</span>
                <h2><?php if($this->session->userdata['name']!='') {  echo ucfirst(@$this->session->userdata['name']); }?></h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-cog fa-spin fa-3x fa-fw"></i> Settings <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo base_url('admin/manage_state');?>">Manage State</a></li>
                      <li><a href="<?php echo base_url('admin/manage_district');?>">manage District</a></li>
                      <li><a href="<?php echo base_url('admin/manage_city');?>">Manage City or Block</a></li>
                      <li><a href="<?php echo base_url('admin/manage_panchayat');?>">Manage Ward or Panchayat</a></li>
                      <li><a href="<?php echo base_url('admin/manage_village');?>">Manage Slum or Village</a></li>
                      <li><a href="<?php echo base_url('admin/manage_hospitals');?>">Manage Hospitals</a></li>
                      <li><a href="<?php echo base_url('admin/manage_masters');?>">Manage Masters Diagnosis</a></li>
                    </ul> 
                  </li>

                  <li><a href="<?php echo base_url('admin/dashboard');?>"><i class="fa fa-home"></i> Dashboard </a>                    
                  </li> 

                  <li><a href="<?php echo base_url('admin/manage_patient');?>"><i class="fa fa-heartbeat fa-pulse"></i> Manage Patient </a>                    
                  </li>

                  <li><a href="<?php echo base_url('admin/manage_doctors');?>"><i class="fa fa fa-user-md"></i> Manage Doctors </a>                    
                  </li> 
                  
                  <li><a href="<?php echo base_url('admin/manage_workers');?>"><i class="fa fa-stethoscope"></i> Manage Workers </a>                    
                  </li>
                  
                  <li><a href="<?php echo base_url('admin/manage_diagnosis');?>"><i class="fa fa-columns"></i> Manage Diagnosis </a>                    
                  </li>

                  <li><a href="<?php echo base_url('admin/manage_prescription');?>"><i class="fa fa-files-o"></i> Manage Prescription </a>                    
                  </li>

                  <li><a href="<?php echo base_url('admin/manage_referrals');?>"><i class="fa fa-hospital-o"></i> Manage Referrals </a>                    
                  </li>   

                  <li><a href="<?php echo base_url('admin/manage_awareness_type');?>"><i class="fa fa-tags"></i> Manage Awareness Type </a>                    
                  </li>  

                  <li><a href="<?php echo base_url('admin/manage_awareness');?>"><i class="fa fa-bullhorn"></i> Manage Awareness </a>                    
                  </li>               

                </ul>
              </div>
            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <!--<div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Settings">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="FullScreen">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Lock">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
              </a>
              <a data-toggle="tooltip" data-placement="top" title="Logout">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>-->
            <!-- /menu footer buttons -->
          </div>
        </div>
<style type="text/css">
  /* Icon pulse */
.fa-pulse {
  display: inline-block;
  -moz-animation: pulse 2s infinite linear;
  -o-animation: pulse 2s infinite linear;
  -webkit-animation: pulse 2s infinite linear;
  animation: pulse 2s infinite linear;
}

@-webkit-keyframes pulse {
  0% { opacity: 1; }
  50% { opacity: 0; }
  100% { opacity: 1; }
}
@-moz-keyframes pulse {
  0% { opacity: 1; }
  50% { opacity: 0; }
  100% { opacity: 1; }
}
@-o-keyframes pulse {
  0% { opacity: 1; }
  50% { opacity: 0; }
  100% { opacity: 1; }
}
@-ms-keyframes pulse {
  0% { opacity: 1; }
  50% { opacity: 0; }
  100% { opacity: 1; }
}
@keyframes pulse {
  0% { opacity: 1; }
  50% { opacity: 0; }
  100% { opacity: 1; }
}
</style>