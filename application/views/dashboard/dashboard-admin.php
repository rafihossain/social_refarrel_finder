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

<header class="top-header">
   <nav class="navbar navbar-expand gap-3 d-md-none ">
      <div class="mobile-toggle-icon fs-3">
         <i class="bi bi-list"></i>
      </div>
   </nav>
   <div class="header-page">
      <h4 class="heading-title">Dashboard</h4>

      <div class="d-flex">

         <form method="post" action="<?php echo base_url(); ?>dashboard">
            <?php
               $date =  date('Y-m-d');
               $new_date = date('Y-m-d', strtotime($date . ' - 1 days'));
            ?>
            <!-- <label class="btn custome-btn active" for="today-form-submit">TODAY</label> -->
            <button type="submit" class="btn btn-primary custome-btn" id="today-form-submit">TODAY</button>
            
            <input type="hidden" name="datepicker_from" class="form-control datepicker" value="<?= $new_date; ?>"/>
            <input type="hidden" name="datepicker_to" class="form-control datepicker" value="<?= date('Y-m-d'); ?>" />
            <input type="hidden" name="value" value="today" />
         </form>

         <form method="post" action="<?php echo base_url(); ?>dashboard">
            <!-- <label class="btn custome-btn active" for="week-form-submit">LAST WEEK</label> -->
            <button type="submit" class="btn btn-primary custome-btn" id="week-form-submit">LAST WEEK</button>
            
            <?php
               $date =  date('Y-m-d');
               $week = date('Y-m-d', strtotime($date . ' - 7 days'));
               $month = date('Y-m-d', strtotime($date . ' - 31 days'));
            ?>

            <input type="hidden" name="datepicker_from" class="form-control datepicker" value="<?= $week ?>"/>
            <input type="hidden" name="datepicker_to" class="form-control datepicker" value="<?= date('Y-m-d'); ?>" />
            <input type="hidden" name="value" value="week" />
         </form>

         <form method="post" action="<?php echo base_url(); ?>dashboard">
            <!-- <label class="btn custome-btn active" for="month-form-submit">LAST MONTH</label> -->
            <button type="submit" class="btn btn-primary custome-btn" id="month-form-submit">LAST MONTH</button>
            
            <input type="hidden" name="datepicker_from" class="form-control datepicker" value="<?= $month; ?>"/>
            <input type="hidden" name="datepicker_to" class="form-control datepicker" value="<?= date('Y-m-d'); ?>" />
            <input type="hidden" name="value" value="month" />
         </form>

         <form method="post" action="<?php echo base_url(); ?>dashboard">
            <button type="button" class="btn btn-primary custome-btn mb-2" id="custom-btn-submit">CUSTOM <i class="las la-calendar"></i></button>
            
            <div class="custom-btn-form">
               <div class="d-flex justify-item-center">
                  <input type="text" id="datepicker_from" name="datepicker_from" class="form-control datepicker mr-2" value="<?= $week; ?>"/> &nbsp;
                  <input type="text" id="datepicker_to" name="datepicker_to" class="form-control datepicker" value="<?= date('Y-m-d'); ?>" />
                  <button type="submit" class="btn custome-btn">submit</button>
               </div>
            </div>
            
            
            <input type="hidden" name="value" value="custom" />
         </form>
      </div>

   </div>
</header>

<main class="page-content">
   <div class="row">
      <div class="col-md-4">
         <div class="card">
            <div class="card-body">
               <div class="dashboard-countdown d-flex align-items-center">
                  <img src="<?= base_url() ?>/main_assets/images/like.png" alt="recomendation">
                  <h4>Trigger Volume</h4>
                  <span><?php if(isset($request_count)){echo $request_count;} ?></span>
               </div>
            </div>
         </div>
      </div>
      <div class="col-md-4">
         <div class="card">
            <div class="card-body">
               <div class="dashboard-countdown d-flex align-items-center">
                  <img src="<?= base_url() ?>/main_assets/images/current_keyword.png" alt="recomendation">
                  <h4>Current Keywords</h4>
                  <span><?php if(isset($keyword)){echo $keyword;} ?></span>
               </div>
            </div>
         </div>
      </div>
      <div class="col-md-4">
         <div class="card">
            <div class="card-body">
               <div class="dashboard-countdown d-flex align-items-center">
                  <img src="<?= base_url() ?>/main_assets/images/users.png" alt="recomendation">
                  <h4>Facebook Groups</h4>
                  <span><?php if(isset($groups)){echo $groups;} ?></span>
               </div>
            </div>
         </div>
      </div>
   </div>

   <div class="row">
      <div class="col-md-12">
         <div class="card radius-10 w-100">
            <div class="card-body">
               <div class="d-flex align-items-center">
                  <h6 class="mb-0">Trigger Volume</h6>
                  <div class="fs-5 ms-auto dropdown">
                     <div class="dropdown-toggle dropdown-toggle-nocaret cursor-pointer" data-bs-toggle="dropdown"></div>
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
      <div class="col-md-12">
         <div class="card">
            <div class="card-body">
               <div class="table-responsive">
                  <h6 class="mb-0">Facebook Groups vs Recommendations</h6>
                  <table class="table table-striped table-bordered" style="width:100%">
                     <thead>
                        <tr>
                           <th>FB Group</th>
                           <th>Recommendations</th>
                           <th>Calculation</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php
                        if (isset($recommendationsgroups)) {
                           foreach ($recommendationsgroups as $group) : ?>
                              <tr>
                                 <td><?php echo $group['fb_group_name']; ?></td>
                                 <td><?php echo $group['ids']; ?></td>
                                 <td><?php echo number_format((float)$group['calculation'],2,'.',''); ?>%</td>
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
<script src="<?php echo base_url(); ?>main_assets/plugins/apexcharts-bundle/js/apexcharts.min.js"></script>
<script src="<?php echo base_url(); ?>main_assets/js/index.js"></script>

<script>
   $('.custom-btn-form').hide();
   $(document).ready(function (){
      $('.custome-btn').click(function (){
         $('.header-page .custome-btn').removeClass('active');
         $(this).addClass('active');
      });
      
      $('#custom-btn-submit').click(function (){
         $('.custom-btn-form').toggle();
      });

      var picker = new Lightpick({
         field: document.getElementById('datepicker_from'),
         secondField: document.getElementById('datepicker_to'),
         singleDate: false,
         format: 'YYYY-MM-DD'
      });

      $('#example').DataTable();
      /*==========================================
               Record Count History
      ===========================================*/

      var options = {
         series: [{
            <?php
            $series = '';
            if (isset($today)) {
               foreach ($today as $id) {
                  $series .=  $id['ids'] . ",";
               }
                  // $series .=  $today . ",";
            }
            if (isset($lweek)) {
               foreach ($lweek as $id) {
                  $series .=  $id['ids'] . ",";
               }
                  // $series .=  $lweek . ",";
            }
            if (isset($lmonths)) {
               foreach ($lmonths as $id) {
                  $series .=  $id['ids'] . ",";
               }
                  // $series .=  $lmonths . ",";
            }

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
            $date = date('Y-m-d');

            if (isset($today)) {
               foreach ($today as $date) {
                  $cate .=  "'" . date('M d', strtotime($date['fb_request_date'])) . "',";
               }
            }
            if (isset($lweek)) {
               foreach ($lweek as $date) {
                  $cate .=  "'" . date('M d', strtotime($date['fb_request_date'])) . "',";
               }
            }
            if (isset($lmonths)) {
               foreach ($lmonths as $date) {
                  $cate .=  "'" . date('M d', strtotime($date['fb_request_date'])) . "',";
               }
            }
            if (isset($day)) {
               foreach ($day as $date) {
                  $cate .=  "'" . date('M d', strtotime($date['fb_request_date'])) . "',";
               }
            }
            if (isset($weeks)) {
               foreach ($weeks as $week) {
                  $cate .=  "'" . $week['name'] . "',";
               }
               // $cate.=  "'".date('M d', strtotime($week['name']))."',";         
            }
            // print_r($months);
            if (isset($months)) {
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