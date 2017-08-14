 <!-- ECharts -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/datepicker/jquery-ui.css">
    <script src="<?php echo base_url();?>assets/vendors/echarts/dist/echarts.min.js"></script>
    <script src="<?php echo base_url();?>assets/vendors/echarts/map/js/world.js"></script>
    <script src="<?php echo base_url();?>assets/datepicker/jquery-ui.js"></script>
    <script>
  $( function() {
    var dateFormat = "dd-mm-yy",
      from = $( "#from" )
        .datepicker({
          dateFormat: dateFormat,
         // defaultDate: "+1w",
          changeMonth: true,
          changeYear: true,
          numberOfMonths: 1
        })
        .on( "change", function() {
          to.datepicker( "option", "minDate", getDate( this ) );
        }),
      to = $( "#to" ).datepicker({
        dateFormat: dateFormat,
        //defaultDate: "+1w",
        changeMonth: true,
        changeYear: true,
        numberOfMonths: 1
      })
      .on( "change", function() {
        from.datepicker( "option", "maxDate", getDate( this ) );
      });
 
    function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate( dateFormat, element.value );
      } catch( error ) {
        date = null;
      }
 
      return date;
    }
  } );
  </script>

   
<!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Dashboard </h3>
              </div>

             <div class="title_right">
                <div class="col-md-12 col-sm-12 col-xs-12 form-group pull-right">
                  <form method="GET" action="<?php echo base_url('admin/dashboard'); ?>" role="form" class="form-inline pull-right">                 
                   
                    <input type="text" name="from" id="from" value="<?php echo @$from; ?>" placeholder="From Date" class="form-control">
                    <input type="text" name="to" id="to" value="<?php echo @$to; ?>" placeholder="To Date" class="form-control">
                   <button type="submit"  class="btn btn-md btn-success">Search</button>
                   </form>
                </div>
              </div>
            </div>
            
            <div class="clearfix"></div>

            <div class="row">
              <!--<div class="col-md-8 col-sm-8 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Bar Graph</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <div id="mainb" style="height:350px;"></div>

                  </div>
                </div>
              </div>-->

             <!-- <div class="col-md-4 col-sm-4 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Mini Pie</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <div id="echart_mini_pie" style="height:350px;"></div>

                  </div>
                </div>
              </div>-->


              <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12" >
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Patient Gender</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>                     
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <div id="echart_pie" style="height:350px;"></div>

                  </div>
                
                 <!-- <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                  <div class="x_content">
                  <form method="GET" action="<?php echo base_url('admin/dashboard'); ?>">                 
                   <p> <select id="status" name="status" class="form-control">
                      <option value="">Marital Status</option>
                      <option value="Single" <?php if($status=='Single') { echo "selected"; }?>>Single</option>
                      <option value="Married" <?php if($status=='Married') { echo "selected"; }?>>Married</option>
                    </select> </p>
                    <p><input type="text" name="from" id="from" value="<?php echo @$from; ?>" placeholder="From Date" class="form-control"></p>
                    <p><input type="text" name="to" id="to" value="<?php echo @$to; ?>" placeholder="To Date" class="form-control"></p>
                   <button type="submit" class="btn btn-success">Search</button>
                   </form>
                   </div>                                                                                                                 
                </div>-->
              </div>
            </div>


             <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12" >
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Patient Age Group</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>                     
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  
                  <div class="row">
                  <div class="x_content">

                    <div id="echart_pie2" style="height:350px;"></div>
                  </div>
                  </div>
                <!-- <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                  <form method="GET" action="<?php echo base_url('admin/dashboard'); ?>" >
                    <p>               
                    <input type="text" name="from2" id="from2" value="<?php echo @$from2; ?>" placeholder="From Date" class="form-control">
                    </p>
                    <p>
                    <input type="text" name="to2" id="to2" value="<?php echo @$to2; ?>" placeholder="To Date" class="form-control ">
                    </p>
                   <button type="submit" class="btn btn-success">Search</button>
                   </form>
                                     
                </div>-->
              </div>
            </div>


            <div class="col-md-6 col-sm-8 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Circulatory and respiratory</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>                     
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <div id="circulatory" style="height:350px;"></div>

                  </div>
                </div>
              </div>  

              <div class="col-md-6 col-sm-8 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Digestive system and abdomen</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>                      
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <div id="digestive" style="height:350px;"></div>

                  </div>
                </div>
              </div>  

              <div class="col-md-6 col-sm-8 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Skin and subcutaneous tissue</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>                      
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <div id="skin" style="height:350px;"></div>

                  </div>
                </div>
              </div>   

              <div class="col-md-6 col-sm-8 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Nervous and musculoskeletal systems</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>                      
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <div id="nervous" style="height:350px;"></div>

                  </div>
                </div>
              </div>  

              <div class="col-md-6 col-sm-8 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Urinary system</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>                      
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <div id="urinary" style="height:350px;"></div>

                  </div>
                </div>
              </div> 

              <div class="col-md-6 col-sm-8 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Cognition, perception, emotional</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>                      
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <div id="cognition" style="height:350px;"></div>

                  </div>
                </div>
              </div>    

              <div class="col-md-6 col-sm-8 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Speech and voice</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>                      
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <div id="speech" style="height:350px;"></div>

                  </div>
                </div>
              </div>  

              <div class="col-md-6 col-sm-8 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>General symptoms and signs</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>                      
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <div id="general" style="height:350px;"></div>

                  </div>
                </div>
              </div>
           
            </div>
          </div>
        </div>
        <!-- /page content -->
     
    <script>
      var theme = {
          color: [
              '#26B99A', '#34495E', '#BDC3C7', '#3498DB',
              '#9B59B6', '#8abb6f', '#759c6a', '#bfd3b7'
          ],

          title: {
              itemGap: 8,
              textStyle: {
                  fontWeight: 'normal',
                  color: '#408829'
              }
          },

          dataRange: {
              color: ['#1f610a', '#97b58d']
          },

          toolbox: {
              color: ['#408829', '#408829', '#408829', '#408829']
          },

          tooltip: {
              backgroundColor: 'rgba(0,0,0,0.5)',
              axisPointer: {
                  type: 'line',
                  lineStyle: {
                      color: '#408829',
                      type: 'dashed'
                  },
                  crossStyle: {
                      color: '#408829'
                  },
                  shadowStyle: {
                      color: 'rgba(200,200,200,0.3)'
                  }
              }
          },

          dataZoom: {
              dataBackgroundColor: '#eee',
              fillerColor: 'rgba(64,136,41,0.2)',
              handleColor: '#408829'
          },
          grid: {
              borderWidth: 0
          },

          categoryAxis: {
              axisLine: {
                  lineStyle: {
                      color: '#408829'
                  }
              },
              splitLine: {
                  lineStyle: {
                      color: ['#eee']
                  }
              }
          },

          valueAxis: {
              axisLine: {
                  lineStyle: {
                      color: '#408829'
                  }
              },
              splitArea: {
                  show: true,
                  areaStyle: {
                      color: ['rgba(250,250,250,0.1)', 'rgba(200,200,200,0.1)']
                  }
              },
              splitLine: {
                  lineStyle: {
                      color: ['#eee']
                  }
              }
          },
          timeline: {
              lineStyle: {
                  color: '#408829'
              },
              controlStyle: {
                  normal: {color: '#408829'},
                  emphasis: {color: '#408829'}
              }
          },

          k: {
              itemStyle: {
                  normal: {
                      color: '#68a54a',
                      color0: '#a9cba2',
                      lineStyle: {
                          width: 1,
                          color: '#408829',
                          color0: '#86b379'
                      }
                  }
              }
          },
          map: {
              itemStyle: {
                  normal: {
                      areaStyle: {
                          color: '#ddd'
                      },
                      label: {
                          textStyle: {
                              color: '#c12e34'
                          }
                      }
                  },
                  emphasis: {
                      areaStyle: {
                          color: '#99d2dd'
                      },
                      label: {
                          textStyle: {
                              color: '#c12e34'
                          }
                      }
                  }
              }
          },
          force: {
              itemStyle: {
                  normal: {
                      linkStyle: {
                          strokeColor: '#408829'
                      }
                  }
              }
          },
          chord: {
              padding: 4,
              itemStyle: {
                  normal: {
                      lineStyle: {
                          width: 1,
                          color: 'rgba(128, 128, 128, 0.5)'
                      },
                      chordStyle: {
                          lineStyle: {
                              width: 1,
                              color: 'rgba(128, 128, 128, 0.5)'
                          }
                      }
                  },
                  emphasis: {
                      lineStyle: {
                          width: 1,
                          color: 'rgba(128, 128, 128, 0.5)'
                      },
                      chordStyle: {
                          lineStyle: {
                              width: 1,
                              color: 'rgba(128, 128, 128, 0.5)'
                          }
                      }
                  }
              }
          },
          gauge: {
              startAngle: 225,
              endAngle: -45,
              axisLine: {
                  show: true,
                  lineStyle: {
                      color: [[0.2, '#86b379'], [0.8, '#68a54a'], [1, '#408829']],
                      width: 8
                  }
              },
              axisTick: {
                  splitNumber: 10,
                  length: 12,
                  lineStyle: {
                      color: 'auto'
                  }
              },
              axisLabel: {
                  textStyle: {
                      color: 'auto'
                  }
              },
              splitLine: {
                  length: 18,
                  lineStyle: {
                      color: 'auto'
                  }
              },
              pointer: {
                  length: '90%',
                  color: 'auto'
              },
              title: {
                  textStyle: {
                      color: '#333'
                  }
              },
              detail: {
                  textStyle: {
                      color: 'auto'
                  }
              }
          },
          textStyle: {
              fontFamily: 'Arial, Verdana, sans-serif'
          }
      };
      
      
      var echartPie = echarts.init(document.getElementById('echart_pie'), theme);

      echartPie.setOption({
        tooltip: {
          trigger: 'item',
          formatter: "{a} <br/>{b} : {c} ({d}%)"
        },
        legend: {
          x: 'center',
          y: 'bottom',
          data: ["Male (<?php echo $male;?>)", "Female (<?php echo $female;?>)","Others (<?php echo $nullvalue;?>)"]
        },
        /*toolbox: {
          show: true,
          feature: {
            magicType: {
              show: true,
              type: ['pie', 'funnel'],
              option: {
                funnel: {
                  x: '25%',
                  width: '50%',
                  funnelAlign: 'left',
                  max: 1548
                }
              }
            },
            restore: {
              show: true,
              title: "Restore"
            },
            saveAsImage: {
              show: true,
              title: "Save Image"
            }
          }
        },*/
        calculable: true,
        series: [{
          name: 'Patient Gender',
          type: 'pie',
         // radius: '55%',
        //  center: ['50%', '48%'],
          data: [{
            value: <?php echo $male;?>,
            name: "Male (<?php echo $male;?>)"
          }, {
            value: <?php echo $female;?>,
            name: "Female (<?php echo $female;?>)"
          }, {
            value: <?php echo $nullvalue;?>,
            name: "Others (<?php echo $nullvalue;?>)"
          }
          ]
        }]
      });

      var dataStyle = {
        normal: {
          label: {
            show: false
          },
          labelLine: {
            show: false
          }
        }
      };

      var placeHolderStyle = {
        normal: {
          color: 'rgba(0,0,0,0)',
          label: {
            show: false
          },
          labelLine: {
            show: false
          }
        },
        emphasis: {
          color: 'rgba(0,0,0,0)'
        }
      };
     var echartPie2 = echarts.init(document.getElementById('echart_pie2'), theme);

      echartPie2.setOption({
        tooltip: {
          trigger: 'item',
          formatter: "{a} <br/>{b} : {c} ({d}%)"
        },
        legend: {
          x: 'center',
          y: 'bottom',
          data: ["Age < 18 (<?php echo $below_18;?>)","Age < 30 (<?php echo $below_30;?>)","Age > 30 (<?php echo $above_30;?>)"]
        },
        /*toolbox: {
          show: true,
          feature: {
            magicType: {
              show: true,
              type: ['pie', 'funnel'],
              option: {
                funnel: {
                  x: '25%',
                  width: '50%',
                  funnelAlign: 'left',
                  max: 1548
                }
              }
            },
            restore: {
              show: true,
              title: "Restore"
            },
            saveAsImage: {
              show: true,
              title: "Save Image"
            }
          }
        },*/
        calculable: true,
        series: [{
          name: 'Patient Age Group',
          type: 'pie',
         // radius: '55%',
        //  center: ['50%', '48%'],
          data: [{
            value: <?php echo $below_18;?>,
            name: "Age < 18 (<?php echo $below_18;?>)"
          }, {
            value: <?php echo $below_30;?>,
            name: "Age < 30 (<?php echo $below_30;?>)"
          },{
            value: <?php echo $above_30;?>,
            name: "Age > 30 (<?php echo $above_30;?>)"
          }
          ]
        }]
      });

      var dataStyle = {
        normal: {
          label: {
            show: false
          },
          labelLine: {
            show: false
          }
        }
      };

      var placeHolderStyle = {
        normal: {
          color: 'rgba(0,0,0,0)',
          label: {
            show: false
          },
          labelLine: {
            show: false
          }
        },
        emphasis: {
          color: 'rgba(0,0,0,0)'
        }
      };
    
      var echartPieCollapse = echarts.init(document.getElementById('circulatory'), theme);
      
      echartPieCollapse.setOption({
        tooltip: {
          trigger: 'item',
          formatter: "{a} <br/>{b} : {c} ({d}%)"
        },
        legend: {
          x: 'center',
          y: 'bottom',
          data: [<?php echo $circulatory_name;?>]
        },
        toolbox: {
          show: true,
          feature: {
            magicType: {
              show: true,
              type: ['pie', 'funnel']
            }
          
          }
        },
        calculable: true,
        series: [{
          name: 'Circulatory and Respiratory',
          type: 'pie',
          radius: [25, 90],
          center: ['50%', 170],
          roseType: 'area',
          x: '50%',
         // max: 40,
          sort: 'ascending',
          data: [<?php echo $circulatory_data;?>]
        }]
      });

      var echartPieCollapse = echarts.init(document.getElementById('digestive'), theme);
      
      echartPieCollapse.setOption({
        tooltip: {
          trigger: 'item',
          formatter: "{a} <br/>{b} : {c} ({d}%)"
        },
        legend: {
          x: 'center',
          y: 'bottom',
          data: [<?php echo $digestive_name;?>]
        },
        toolbox: {
          show: true,
          feature: {
            magicType: {
              show: true,
              type: ['pie', 'funnel']
            }
          
          }
        },
        calculable: true,
        series: [{
          name: 'Digestive system and abdomen',
          type: 'pie',
          radius: [25, 90],
          center: ['50%', 170],
          roseType: 'area',
          x: '50%',
         // max: 40,
          sort: 'ascending',
          data: [<?php echo $digestive_data;?>]
        }]
      });
      var echartPieCollapse = echarts.init(document.getElementById('skin'), theme);
      
      echartPieCollapse.setOption({
        tooltip: {
          trigger: 'item',
          formatter: "{a} <br/>{b} : {c} ({d}%)"
        },
        legend: {
          x: 'center',
          y: 'bottom',
          data: [<?php echo $skin_name;?>]
        },
        toolbox: {
          show: true,
          feature: {
            magicType: {
              show: true,
              type: ['pie', 'funnel']
            }
          
          }
        },
        calculable: true,
        series: [{
          name: 'Skin and subcutaneous tissue',
          type: 'pie',
          radius: [25, 90],
          center: ['50%', 170],
          roseType: 'area',
          x: '50%',
         // max: 40,
          sort: 'ascending',
          data: [<?php echo $skin_data;?>]
        }]
      });

      var echartPieCollapse = echarts.init(document.getElementById('nervous'), theme);
      
      echartPieCollapse.setOption({
        tooltip: {
          trigger: 'item',
          formatter: "{a} <br/>{b} : {c} ({d}%)"
        },
        legend: {
          x: 'center',
          y: 'bottom',
          data: [<?php echo $nervous_name;?>]
        },
        toolbox: {
          show: true,
          feature: {
            magicType: {
              show: true,
              type: ['pie', 'funnel']
            }
          
          }
        },
        calculable: true,
        series: [{
          name: 'Nervous and musculoskeletal systems',
          type: 'pie',
          radius: [25, 90],
          center: ['50%', 170],
          roseType: 'area',
          x: '50%',
         // max: 40,
          sort: 'ascending',
          data: [<?php echo $nervous_data;?>]
        }]
      });

      var echartPieCollapse = echarts.init(document.getElementById('urinary'), theme);
      
      echartPieCollapse.setOption({
        tooltip: {
          trigger: 'item',
          formatter: "{a} <br/>{b} : {c} ({d}%)"
        },
        legend: {
          x: 'center',
          y: 'bottom',
          data: [<?php echo $urinary_name;?>]
        },
        toolbox: {
          show: true,
          feature: {
            magicType: {
              show: true,
              type: ['pie', 'funnel']
            }
          
          }
        },
        calculable: true,
        series: [{
          name: 'Urinary system',
          type: 'pie',
          radius: [25, 90],
          center: ['50%', 170],
          roseType: 'area',
          x: '50%',
         // max: 40,
          sort: 'ascending',
          data: [<?php echo $urinary_data;?>]
        }]
      });


      var echartPieCollapse = echarts.init(document.getElementById('cognition'), theme);
      
      echartPieCollapse.setOption({
        tooltip: {
          trigger: 'item',
          formatter: "{a} <br/>{b} : {c} ({d}%)"
        },
        legend: {
          x: 'center',
          y: 'bottom',
          data: [<?php echo $cognition_name;?>]
        },
        toolbox: {
          show: true,
          feature: {
            magicType: {
              show: true,
              type: ['pie', 'funnel']
            }
          
          }
        },
        calculable: true,
        series: [{
          name: 'Cognition, perception, emotional',
          type: 'pie',
          radius: [25, 90],
          center: ['50%', 170],
          roseType: 'area',
          x: '50%',
         // max: 40,
          sort: 'ascending',
          data: [<?php echo $cognition_data;?>]
        }]
      });

      var echartPieCollapse = echarts.init(document.getElementById('speech'), theme);
      
      echartPieCollapse.setOption({
        tooltip: {
          trigger: 'item',
          formatter: "{a} <br/>{b} : {c} ({d}%)"
        },
        legend: {
          x: 'center',
          y: 'bottom',
          data: [<?php echo $speech_name;?>]
        },
        toolbox: {
          show: true,
          feature: {
            magicType: {
              show: true,
              type: ['pie', 'funnel']
            }
          
          }
        },
        calculable: true,
        series: [{
          name: 'Speech and voice',
          type: 'pie',
          radius: [25, 90],
          center: ['50%', 170],
          roseType: 'area',
          x: '50%',
         // max: 40,
          sort: 'ascending',
          data: [<?php echo $speech_data;?>]
        }]
      });

      var echartPieCollapse = echarts.init(document.getElementById('general'), theme);
      
      echartPieCollapse.setOption({
        tooltip: {
          trigger: 'item',
          formatter: "{a} <br/>{b} : {c} ({d}%)"
        },
        legend: {
          x: 'center',
          y: 'bottom',
          data: [<?php echo $general_name;?>]
        },
        toolbox: {
          show: true,
          feature: {
            magicType: {
              show: true,
              type: ['pie', 'funnel']
            }
          
          }
        },
        calculable: true,
        series: [{
          name: 'General symptoms and signs',
          type: 'pie',
          radius: [25, 90],
          center: ['50%', 170],
          roseType: 'area',
          x: '50%',
         // max: 40,
          sort: 'ascending',
          data: [<?php echo $general_data;?>]
        }]
      });
    </script>