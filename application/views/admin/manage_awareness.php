
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Manage Awareness Program</h3>
              </div>
               <form method="GET" action="<?php echo base_url('admin/manage_awareness');?>" >
               <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                  <div class="input-group">
                    <input class="form-control" placeholder="Search for..." name="q" value="<?php echo @$q;?>" type="text">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="submit">Go!</button>
                    </span>
                  </div>
                </div>
              </div>
              </form>
            </div>

           


              <div class="clearfix"></div>

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Awareness List</h2>
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

                    <p>We can search the state using state, district, block, panchayat, village, awareness type, reported by wise.</p>
                    
                    
                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">
                            <th class="column-title" nowrap>State </th>
                            <th class="column-title" nowrap>District</th>
                            <th class="column-title" nowrap>Block </th>
                            <th class="column-title" nowrap>Panchayat</th>
                            <th class="column-title" nowrap>Village </th>
                            <th class="column-title" nowrap>Awareness Type</th>
                            <th class="column-title" nowrap>attendees </th>
                            <th class="column-title" nowrap>Boys : ( age < 18 ) </th>
                            <th class="column-title" nowrap>Girls : ( age < 18 )</th>
                            <th class="column-title" nowrap>Male : ( age < 30 )</th>
                            <th class="column-title" nowrap>Female : ( age < 30 )</th>
                            <th class="column-title" nowrap>Male : ( age > 30 ) </th>
                            <th class="column-title" nowrap>Female : ( age > 30 ) </th>
                            <th class="column-title" nowrap>Reported By </th>
                            <th class="column-title" nowrap>Reported Date </th>
                          </tr>
                        </thead>

                        <tbody>
                          <?php if(!empty($awareness_info)) {
                            foreach ($awareness_info as $awareness) {
                             
                            ?>
                          <tr class="even pointer">
                            <td class=" "><?php echo $awareness['state_name'];?></td>
                            <td class=" "><?php echo $awareness['district_name'];?></td>
                            <td class=" "><?php echo $awareness['city_name'];?></td>
                            <td class=" "><?php echo $awareness['panchayat_name'];?></td>
                            <td class=" "><?php echo $awareness['village_name'];?></td>
                            <td class=" "><?php echo $awareness['awareness_type'];?></td>
                            <td class=" "><?php echo $awareness['attendees'];?></td>
                            <td class=" "><?php echo $awareness['boys_above_18'];?></td>
                            <td class=" "><?php echo $awareness['girls_above_18'];?></td>
                            <td class=" "><?php echo $awareness['male_above_30'];?></td>
                            <td class=" "><?php echo $awareness['female_above_30'];?></td>
                            <td class=" "><?php echo $awareness['male_below_30'];?></td>
                            <td class=" "><?php echo $awareness['female_below_30'];?></td>
                            <td class=" "><?php echo @$awareness['name'];?></td>
                            <td class=" "><?php echo date('d-m-Y',strtotime(@$awareness['reported_date']));?></td>
                          </tr>
                          <?php } } else {?>
                           <tr class="even pointer"><td colspan="15">No awareness program found.</td> </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                    </div>
                     <?php echo $links;?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->
       

  