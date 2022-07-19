<link href="<?php echo base_url(); ?>main_assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />

<!-- Date Filter -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>main_assets/lightpick/lightpick.css" />

<style>
   .dashboard_img img {
      max-width: 60px;
      margin-bottom: 20px;
   }
</style>

<main class="page-content">

   <!-- alert box -->
   <div class="alert border-0 bg-light-success alert-dismissible fade show py-4">
      <div class="ms-3">
         <div>
            <h6 class="m-0"> Not sure how Social Referral Finder works? Please check our
               <a href="<?php echo base_url() ?>start">Installation & Customation Guide.</a>
            </h6>
         </div>
      </div>
   </div>


   <div class="row">

      <!-- Date Range Filter -->
      <div class="col-md-12">
         <div class="card">
            <div class="card-body">
               <h4 class="mb-0 text-primary">Select Date Range Filter</h4>
               <hr>
               <form class="row g-3" method="post" action="<?php echo base_url(); ?>dashboard">
                  <div class="col-12">
                     <div class="row align-items-end">
                        <div class="col-4">
                           <label class="form-label">From Date</label>
                           <input type="text" id="datepicker_from" name="datepicker_from" class="form-control datepicker" />
                        </div>
                        <div class="col-4">
                           <label class="form-label">To Date</label>
                           <input type="text" id="datepicker_to" name="datepicker_to" class="form-control datepicker" />
                        </div>
                        <div class="col-4">
                           <button type="submit" id="submit_report_btn" class="btn btn-primary">Filter</button>
                        </div>
                     </div>
                  </div>
               </form>
               <br>
            </div>
         </div>
      </div>




      <div class="col col-md-8">

         <div class="row row-cols-1">
            <div class="col">
               <div class="card radius-10 w-100">
                  <div class="card-body">
                     <div class="d-flex align-items-center">
                        <h6 class="mb-0">Revenue</h6>
                        <div class="fs-5 ms-auto dropdown">
                           <div class="dropdown-toggle dropdown-toggle-nocaret cursor-pointer" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></div>
                           <ul class="dropdown-menu">
                              <li><a class="dropdown-item" href="#">Action</a></li>
                              <li><a class="dropdown-item" href="#">Another action</a></li>
                              <li>
                                 <hr class="dropdown-divider">
                              </li>
                              <li><a class="dropdown-item" href="#">Something else here</a></li>
                           </ul>
                        </div>
                     </div>
                     <div id="recordcounthistory"></div>
                  </div>
               </div>
            </div>
         </div>

         <!-- datatable -->
         <div class="row">
            <div class="col-sm-12">
               <div class="card">
                  <div class="card-body">
                     <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                           <thead>
                              <tr>
                                 <th>FB Group</th>
                                 <th>Recommendations</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php
                              if (isset($recommendationsgroups)) {
                                 foreach ($recommendationsgroups as $group) : ?>
                                    <tr>
                                       <td><?php echo $group['fb_group_name']; ?></td>
                                       <td><?php echo $group['ids']; ?></td>
                                    </tr>
                              <?php endforeach;
                              }
                              ?>
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
            </div>
         </div>

      </div>
      <div class="col col-md-4">
         <div class="row row-cols-1">
            <div class="col">
               <div class="card overflow-hidden radius-10">
                  <div class="card-body">
                     <div class="text-center">

                        <div class="dashboard_img my-4">
                           <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="80px" height="80px" viewBox="0 0 536.071 536.07" style="enable-background:new 0 0 536.071 536.07;" xml:space="preserve">
                              <g>
                                 <path style="fill:#3BABA6" d="M147.128,91.076c0-37.95,30.766-68.716,68.721-68.716c37.95,0,68.719,30.766,68.719,68.716s-30.769,68.715-68.719,68.715
		C177.894,159.792,147.128,129.026,147.128,91.076z M248.873,206.607c0.689-14.963,5.84-28.812,14.127-40.261
		c-5.816-1.218-11.827-1.865-17.995-1.865h-58.304c-6.15,0-12.153,0.642-17.939,1.845c8.819,12.232,14.094,27.171,14.18,43.343
		c10.72-5.896,23.02-9.253,36.085-9.253C229.625,200.416,239.714,202.624,248.873,206.607z M260.505,212.775
		c19.96,12.517,33.957,33.688,36.517,58.274c8.133,3.801,17.171,5.994,26.746,5.994c34.968,0,63.311-28.346,63.311-63.313
		c0-34.971-28.343-63.311-63.311-63.311C289.12,150.42,261.031,178.257,260.505,212.775z M219.026,342.411
		c34.962,0,63.307-28.354,63.307-63.311c0-34.962-28.345-63.311-63.307-63.311c-34.965,0-63.322,28.348-63.322,63.311
		C155.705,314.057,184.061,342.411,219.026,342.411z M245.882,346.72h-53.717c-44.697,0-81.069,36.369-81.069,81.072v65.703
		l0.171,1.029l4.522,1.406c42.658,13.323,79.718,17.779,110.224,17.779c59.571,0,94.114-16.987,96.242-18.074l4.231-2.141h0.449
		v-65.703C326.936,383.089,290.585,346.72,245.882,346.72z M350.638,281.364h-53.314c-0.579,21.332-9.683,40.542-24.081,54.35
		c39.732,11.815,68.802,48.657,68.802,92.178v20.245c52.629-1.938,82.963-16.846,84.961-17.851l4.232-2.152h0.449v-65.715
		C431.693,317.728,395.324,281.364,350.638,281.364z M364.889,149.069c19.961,12.519,33.957,33.691,36.511,58.277
		c8.134,3.801,17.171,5.99,26.746,5.99c34.975,0,63.316-28.342,63.316-63.304c0-34.972-28.342-63.311-63.316-63.311
		C393.503,86.717,365.416,114.56,364.889,149.069z M455.01,217.658h-53.303c-0.579,21.332-9.682,40.542-24.08,54.349
		c39.731,11.811,68.801,48.658,68.801,92.179v20.245c52.624-1.934,82.964-16.84,84.962-17.852l4.226-2.145h0.455v-65.723
		C536.077,254.024,499.708,217.658,455.01,217.658z M107.937,277.044c12.386,0,23.903-3.618,33.67-9.777
		c3.106-20.241,13.958-37.932,29.454-49.975c0.065-1.188,0.174-2.361,0.174-3.561c0-34.971-28.351-63.311-63.298-63.311
		c-34.977,0-63.316,28.339-63.316,63.311C44.621,248.704,72.959,277.044,107.937,277.044z M164.795,335.714
		c-14.331-13.742-23.404-32.847-24.072-54.055c-1.971-0.147-3.928-0.295-5.943-0.295H81.069C36.366,281.364,0,317.728,0,362.425
		v65.709l0.166,1.023l4.528,1.412c34.214,10.699,64.761,15.616,91.292,17.153v-19.837
		C95.991,384.371,125.054,347.523,164.795,335.714z" />
                              </g>
                              <g>
                              </g>
                              <g>
                              </g>
                              <g>
                              </g>
                              <g>
                              </g>
                              <g>
                              </g>
                              <g>
                              </g>
                              <g>
                              </g>
                              <g>
                              </g>
                              <g>
                              </g>
                              <g>
                              </g>
                              <g>
                              </g>
                              <g>
                              </g>
                              <g>
                              </g>
                              <g>
                              </g>
                              <g>
                              </g>
                           </svg>

                        </div>

                        <h3 class=""><strong><?php
                                             if (isset($request_count)) {
                                                echo $request_count;
                                             } else {
                                                echo "0";
                                             } ?>
                           </strong></h3>
                        <h5>Recommendation Requests</h5>
                     </div>
                  </div>
               </div>
            </div>

            <div class="col">
               <div class="card overflow-hidden radius-10">
                  <div class="card-body">
                     <div class="text-center">

                        <div class="dashboard_img  my-4">
                           <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="80px" height="80px" viewBox="0 0 85.988 85.987" style="enable-background:new 0 0 85.988 85.987;" xml:space="preserve">
                              <g>
                                 <path style="fill:#3BABA6" d="M77.993,30.884c-2.692,0-4.878,2.185-4.878,4.868c0,2.685,2.186,4.867,4.878,4.867
		c2.683,0,4.867-2.183,4.867-4.867C82.86,33.069,80.675,30.884,77.993,30.884z M8.005,30.884c-2.692,0-4.878,2.185-4.878,4.868
		c0,2.685,2.186,4.867,4.878,4.867c2.685,0,4.87-2.183,4.87-4.867C12.875,33.069,10.69,30.884,8.005,30.884z M63.504,22.03
		c-3.997,0-7.239,3.25-7.239,7.25c0,3.992,3.242,7.236,7.239,7.236c3.998,0,7.25-3.244,7.25-7.236
		C70.754,25.284,67.502,22.03,63.504,22.03z M85.988,66.088h-8.254V50.896c0-2.61-0.767-5.033-1.999-7.146
		c0.726-0.212,1.471-0.363,2.258-0.363c4.401,0,7.995,3.594,7.995,8.006V66.088z M22.483,22.03c-4,0-7.25,3.25-7.25,7.25
		c0,3.992,3.25,7.236,7.25,7.236c3.987,0,7.237-3.244,7.237-7.236C29.72,25.284,26.471,22.03,22.483,22.03z M8.005,43.387
		c0.787,0,1.522,0.15,2.25,0.363c-1.245,2.113-1.999,4.536-1.999,7.146v15.192H0V51.393C0,46.98,3.596,43.387,8.005,43.387z
		 M42.986,7.555c-5.9,0-10.71,4.805-10.71,10.711c0,5.905,4.805,10.716,10.71,10.716c5.906,0,10.717-4.811,10.717-10.716
		C53.708,12.359,48.892,7.555,42.986,7.555z M75.083,71.742H62.438V48.627c0-3.179-0.839-6.136-2.195-8.787
		c1.035-0.306,2.123-0.523,3.262-0.523c6.38,0,11.578,5.188,11.578,11.579V71.742z M23.537,48.627v23.115H10.908V50.896
		c0-6.385,5.191-11.579,11.581-11.579c1.139,0,2.216,0.217,3.249,0.523C24.381,42.491,23.537,45.448,23.537,48.627z M26.188,78.433
		h33.598V48.627c0-9.264-7.539-16.798-16.801-16.798c-9.269,0-16.797,7.534-16.797,16.798V78.433z" />
                              </g>
                              <g>
                              </g>
                              <g>
                              </g>
                              <g>
                              </g>
                              <g>
                              </g>
                              <g>
                              </g>
                              <g>
                              </g>
                              <g>
                              </g>
                              <g>
                              </g>
                              <g>
                              </g>
                              <g>
                              </g>
                              <g>
                              </g>
                              <g>
                              </g>
                              <g>
                              </g>
                              <g>
                              </g>
                              <g>
                              </g>
                           </svg>

                        </div>

                        <h3 class=""><strong><?php 
                        
                        if (isset($keyword)) {
                           echo $keyword;
                        } else {
                           echo "0";
                        } ?></strong></h3>
                        <h5>Current Keywords</h5>
                     </div>
                  </div>
               </div>
            </div>

            <div class="col">
               <div class="card overflow-hidden radius-10">
                  <div class="card-body">
                     <div class="text-center">

                        <div class="dashboard_img my-4">
                           <svg height="80px" viewBox="0 0 512.00049 512" width="80px" xmlns="http://www.w3.org/2000/svg">
                              <path style="fill:#3BABA6" d="m512 210c0 36.46875-9.5 72.402344-27.472656 103.910156-5.472656 9.59375-17.6875 12.933594-27.28125 7.464844-9.59375-5.476562-12.9375-17.691406-7.460938-27.285156 14.53125-25.480469 22.214844-54.558594 22.214844-84.089844 0-93.738281-76.261719-170-170-170s-170 76.261719-170 170 76.261719 170 170 170c29.171875 0 57.941406-7.507812 83.195312-21.710938 9.628907-5.410156 21.824219-2 27.238282 7.628907 5.414062 9.628906 2 21.820312-7.628906 27.234375-31.230469 17.566406-66.777344 26.847656-102.804688 26.847656-50.476562 0-96.847656-17.90625-133.105469-47.695312l-134.800781 133.886718c-3.898438 3.871094-8.996094 5.808594-14.09375 5.808594-5.140625 0-10.28125-1.96875-14.191406-5.90625-7.78125-7.835938-7.738282-20.5.097656-28.285156l134.621094-133.703125c-30.285156-36.402344-48.527344-83.160157-48.527344-134.105469 0-115.792969 94.207031-210 210-210s210 94.207031 210 210zm-181 80v-40h-60v40c0 11.046875-8.953125 20-20 20s-20-8.953125-20-20v-128c0-38.597656 31.402344-70 70-70s70 31.402344 70 70v128c0 11.046875-8.953125 20-20 20s-20-8.953125-20-20zm0-80v-48c0-16.542969-13.457031-30-30-30s-30 13.457031-30 30v48zm0 0" />
                           </svg>
                        </div>
                        <h3 class=""><strong><?php

                           if (isset($groups)) {
                           echo $groups;
                        } else {
                           echo "0";
                        } ?></strong></h3>
                        <h5>Current Connected Groups</h5>

                     </div>
                  </div>
               </div>
            </div>

         </div>
      </div>
      <!--end row-->
</main>
<script src="<?php echo base_url(); ?>main_assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>main_assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
<script src="<?php echo base_url(); ?>main_assets/js/table-datatable.js"></script>

<!-- Date Filter -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>main_assets/lightpick/lightpick.js"></script>


<script src="<?php echo base_url(); ?>main_assets/plugins/chartjs/js/Chart.min.js"></script>
<script src="<?php echo base_url(); ?>main_assets/plugins/chartjs/js/Chart.extension.js"></script>
<script src="<?php echo base_url(); ?>main_assets/js/index.js"></script>

<script>
   $(document).ready(function() {

      var picker = new Lightpick({
         field: document.getElementById('datepicker_from'),
         secondField: document.getElementById('datepicker_to'),
         singleDate: false,
         format: 'YYYY-MM-DD'
      });

      $('#example').DataTable();


      var options = {
         series: [{

            <?php
            $series = '';
            if (isset($day)) {
               foreach ($day as $id) {
                  $series .=  $id['ids'] . ",";
               }
            }
            if (isset($weeks)) {
               foreach ($weeks as $week) {
                  $series .=  $week['count'] . ",";
               }
            }

            if (isset($months)) {
               foreach ($months as $month) {
                  $series .=  $month['count'] . ",";
               }
            }
            ?>

            name: "Group History",
            data: [<?php echo rtrim($series, ',') ?>]
         }],
         chart: {
            type: "area",
            // width: 130,
            stacked: true,
            height: 280,
            toolbar: {
               show: !1
            },
            zoom: {
               enabled: !1
            },
            dropShadow: {
               enabled: 0,
               top: 3,
               left: 14,
               blur: 4,
               opacity: .12,
               color: "#3461ff"
            },
            sparkline: {
               enabled: !1
            }
         },
         markers: {
            size: 0,
            colors: ["#3461ff"],
            strokeColors: "#fff",
            strokeWidth: 2,
            hover: {
               size: 7
            }
         },
         grid: {
            row: {
               colors: ["transparent", "transparent"],
               opacity: .2
            },
            borderColor: "#f1f1f1"
         },
         plotOptions: {
            bar: {
               horizontal: !1,
               columnWidth: "20%",
               //endingShape: "rounded"
            }
         },
         dataLabels: {
            enabled: !1
         },
         stroke: {
            show: !0,
            width: [2.5],
            //colors: ["#3461ff"],
            curve: "smooth"
         },
         fill: {
            type: 'gradient',
            gradient: {
               shade: 'light',
               type: 'vertical',
               shadeIntensity: 0.5,
               gradientToColors: ['#3461ff'],
               inverseColors: false,
               opacityFrom: 0.5,
               opacityTo: 0.1,
               // stops: [0, 100]
            }
         },
         colors: ["#3461ff"],
         xaxis: {
            <?php
            $cate = '';
            if (isset($day)) {
               $cate = '';
               foreach ($day as $date) {
                  $cate .=  "'" . date('M d', strtotime($date['fb_request_date'])) . "',";
               }
            }
            // print_r($weeks);


            $cate = '';

            // print_r($weeks);

            if (isset($weeks)) {
               foreach ($weeks as $week) {
                  $cate .=  "'" . $week['name'] . "',";
               }
               // $cate.=  "'".date('M d', strtotime($week['name']))."',";         
            }
            // print_r($months);
            if (isset($months)) {
               $cate = '';
               foreach ($months as $month) {
                  $cate .=  "'" . $month['name'] . "',";
                  // $cate.=  "'".date('M', strtotime($mo['fb_request_date']))."',";
               }
            }
            ?>

            categories: [<?php echo rtrim($cate, ','); ?>],
         },
         responsive: [{
            breakpoint: 1000,
            options: {
               chart: {
                  type: "area",
                  // width: 130,
                  stacked: true,
               }
            }
         }],
         legend: {
            show: false
         },
         tooltip: {
            theme: "dark"
         }
      };

      var chart = new ApexCharts(document.querySelector("#recordcounthistory"), options);
      chart.render();

   });
</script>