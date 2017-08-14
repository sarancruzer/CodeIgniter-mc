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
          defaultDate: "+1w",
          changeMonth: true,
          changeYear: true,
          numberOfMonths: 1
        })
        .on( "change", function() {
          to.datepicker( "option", "minDate", getDate( this ) );
        }),
      to = $( "#to" ).datepicker({
        dateFormat: dateFormat,
        defaultDate: "+1w",
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
  <script>
  $( function() {
    var dateFormat = "dd-mm-yy",
      from = $( "#from2" )
        .datepicker({
          dateFormat: dateFormat,
          defaultDate: "+1w",
          changeMonth: true,
          changeYear: true,
          numberOfMonths: 1
        })
        .on( "change", function() {
          to.datepicker( "option", "minDate", getDate( this ) );
        }),
      to = $( "#to2" ).datepicker({
        dateFormat: dateFormat,
        defaultDate: "+1w",
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
    <script>
  $( function() {
    $( "#dgndate" ).datepicker({
      dateFormat:"dd-mm-yy",
      changeMonth: true,
      changeYear: true
    });
  } );
  </script>
<!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Dashboard </h3>
              </div>

             <!-- <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button">Go!</button>
                    </span>
                  </div>
                </div>
              </div>-->
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


              <div class="col-md-12 col-sm-12 col-xs-12" >
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Patient Graph</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>                     
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="col-lg-10 col-md-12 col-sm-12 col-xs-12" style="border-right: 1px solid #ccc;">
                  <div class="x_content">

                    <div id="echart_pie" style="height:350px;"></div>

                  </div>
                  </div>
                  <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12">
                  <div class="x_content">
                  <form method="GET" action="<?php echo base_url('admin/dashboard'); ?>">
                  <p><lable><strong>Filters:</strong></lable></p>
                   <p> <select id="status" name="status" class="form-control">
                      <option value="">Marital Status</option>
                      <option value="Single" <?php if($status=='Single') { echo "selected"; }?>>Single</option>
                      <option value="Married" <?php if($status=='Married') { echo "selected"; }?>>Married</option>
                    </select> </p>
                   <p> <select id="agegroup" name="agegroup" class="form-control">
                      <option value="">Age Group</option>
                      <option value="below_18" <?php if($agegroup=='below_18') { echo "selected"; }?>>Age < 18</option>
                      <option value="below_30" <?php if($agegroup=='below_30') { echo "selected"; }?>>Age < 30</option>
                      <option value="above_30" <?php if($agegroup=='above_30') { echo "selected"; }?>>Age > 30</option>
                    </select></p>
                    <p><input type="text" name="from" id="from" value="<?php echo @$from; ?>" placeholder="From Date" class="form-control"></p>
                    <p><input type="text" name="to" id="to" value="<?php echo @$to; ?>" placeholder="To Date" class="form-control"></p>
                   <button type="submit" class="btn btn-success">Search</button>
                   </form>
                   </div>                                                                                                                 
                </div>
              </div>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Diagnosis Graph</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                   <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12" style="border-right: 1px solid #ccc;">
                  <div class="x_content">

                    <div id="mainb" style="height:450px;"></div>

                  </div>
                  <form method="GET" action="<?php echo base_url('admin/dashboard'); ?>" class="form-horizontal">
                  <div class="col-md-4">
                  <input type="text" name="dgndate" id="dgndate" placeholder="Diagnosis Date" class="form-control" value="<?php echo @$diagnosisDate;?>" >
                  </div>
                  <button type="submit" class="btn btn-success">Search</button>
                  </form>
                  </div>
                   <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                   <form method="GET" action="<?php echo base_url('admin/dashboard'); ?>">
                  <p><lable><strong>Filters:</strong></lable></p>
                   <p> <select id="status2" name="status2" class="form-control">
                      <option value="">Marital Status</option>
                      <option value="Single" <?php if($status2=='Single') { echo "selected"; }?>>Single</option>
                      <option value="Married" <?php if($status2=='Married') { echo "selected"; }?>>Married</option>
                    </select> </p>
                   <p> <select id="agegroup2" name="agegroup2" class="form-control">
                      <option value="">Age Group</option>
                      <option value="below_18" <?php if($agegroup2=='below_18') { echo "selected"; }?>>Age < 18</option>
                      <option value="below_30" <?php if($agegroup2=='below_30') { echo "selected"; }?>>Age < 30</option>
                      <option value="above_30" <?php if($agegroup2=='above_30') { echo "selected"; }?>>Age > 30</option>
                    </select></p>
                    <p><input type="text" name="from2" id="from2" value="<?php echo @$from2; ?>" placeholder="From Date" class="form-control"></p>
                    <p><input type="text" name="to2" id="to2" value="<?php echo @$to2; ?>" placeholder="To Date" class="form-control"></p>
                   <button type="submit" class="btn btn-success">Search</button>
                   </form>
                   <div class="x_content">

                    <div id="echart_pie2" style="height:200px;"></div>

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
      
      var echartBar = echarts.init(document.getElementById('mainb'), theme);

      echartBar.setOption({
        title: {
          text: 'Diagnosis Analysis',
          subtext: 'Gender Analysis'
        },
        tooltip: {
          trigger: 'axis'
        },
        legend: {
          data: ['Male', 'Female','Undefined']
        },
        toolbox: {
          show: false
        },
        calculable: false,
        xAxis: [{
          type: 'category',
          //data: ['1?', '2?', '3?', '4?', '5?', '6?', '7?', '8?', '9?', '10?', '11?', '12?']
          data: [<?php echo $dateDiagnosisList; ?>]
        }],
        yAxis: [{
          type: 'value'
        }],
        series: [{
          name: 'Male',
          type: 'bar',
          data: [<?php echo $maleDiagnosisList; ?>],
          markPoint: {
            data: [{
              type: 'max',
              name: 'Max'
            }, {
              type: 'min',
              name: 'Min'
            }]
          },
          markLine: {
            data: [{
              type: 'average',
              name: 'Average'
            }]
          }
        },{
          name: 'Female',
          type: 'bar',
          data: [<?php echo $femaleDiagnosisList; ?>],
          markPoint: {
            data: [{
              type: 'max',
              name: 'Max'
            }, {
              type: 'min',
              name: 'Min'
            }]
          },
          markLine: {
            data: [{
              type: 'average',
              name: 'Average'
            }]
          }
        },{
          name: 'Undefined',
          type: 'bar',
          data: [<?php echo $nullDiagnosisList; ?>],
          markPoint: {
            data: [{
              type: 'max',
              name: '???'
            }, {
              type: 'min',
              name: '???'
            }]
          },
          markLine: {
            data: [{
              type: 'average',
              name: 'Average'
            }]
          }
        }]
      });
      
      var echartPie = echarts.init(document.getElementById('echart_pie'), theme);

      echartPie.setOption({
        tooltip: {
          trigger: 'item',
          formatter: "{a} <br/>{b} : {c} ({d}%)"
        },
        legend: {
          x: 'center',
          y: 'bottom',
          data: ['Male', 'Female','Undefined']
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
            name: 'Male'
          }, {
            value: <?php echo $female;?>,
            name: 'Female'
          }, {
            value: <?php echo $nullvalue;?>,
            name: 'Undefined'
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
          data: ['Male', 'Female','Undefined']
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
            value: <?php echo $maledgncount;?>,
            name: 'Male'
          }, {
            value: <?php echo $femaledgncount;?>,
            name: 'Female'
          }, {
            value: <?php echo $nulldgncount;?>,
            name: 'Undefined'
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

    </script>