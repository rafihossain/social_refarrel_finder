<link href="<?php echo base_url(); ?>main_assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
<link href="<?php echo base_url() ?>main_assets/plugins/datetimepicker/css/classic.css" rel="stylesheet" />
<link href="<?php echo base_url() ?>main_assets/plugins/datetimepicker/css/classic.time.css" rel="stylesheet" />
<link href="<?php echo base_url() ?>main_assets/plugins/datetimepicker/css/classic.date.css" rel="stylesheet" />
<link rel="stylesheet" href="<?php echo base_url() ?>main_assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.min.css">

<header class="top-header">
   <nav class="navbar navbar-expand gap-3 d-md-none ">
      <div class="mobile-toggle-icon fs-3">
         <i class="bi bi-list"></i>
      </div>
   </nav>
   <div class="header-page">
      <h4 class="heading-title">Notifications</h4>
   </div>
</header>

<main class="page-content">

   <div class="card ">
      <div class="card-body">
         <h4 class="mb-0 text-primary">Notifications</h4>
         <hr>
         <form class="row g-3" method="post" action="<?php echo base_url(); ?>notification">
            <!-- <form id="form-filter" class="row g-3"> -->

            <div class="col-12">
               <div class="row">
                  <div class="col-4">
                     <label class="form-label">From Date</label>
                     <input type="text" id="datepicker_from" name="datepicker_from" value="<?php echo $datepicker_from; ?>" date_format="d/m/yyyy" class="form-control datepicker" />
                  </div>
                  <div class="col-4">
                     <label class="form-label">To Date</label>
                     <input type="text" id="datepicker_to" name="datepicker_to" value="<?php echo $datepicker_to; ?>" date_format="d/m/yyyy" class="form-control datepicker" />
                  </div>
                  <div class="col-4">
                     <button type="button" id="submit_report_btn" class="btn btn-primary btn-lg px-5">Filter</button>
                  </div>
               </div>
            </div>
         </form>
      </div>
   </div>

   <br>


   <div class="table-responsive">
      <table id="table" class="table table-striped table-bordered" style="width:100%">
         <thead>
            <tr>
               <th>Date/Time</th>
               <th>Client</th>
               <th>Address</th>
               <th>Content</th>
            </tr>
         </thead>
         <tbody>



         </tbody>

      </table>
   </div>





</main>

<script src="<?php echo base_url(); ?>main_assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>main_assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
<script src="<?php echo base_url(); ?>main_assets/js/table-datatable.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js'></script>


<script src="<?php echo base_url(); ?>main_assets/plugins/datetimepicker/js/picker.js"></script>
<script src="<?php echo base_url(); ?>main_assets/plugins/datetimepicker/js/picker.time.js"></script>
<script src="<?php echo base_url(); ?>main_assets/plugins/datetimepicker/js/picker.date.js"></script>
<script src="<?php echo base_url(); ?>main_assets/js/form-date-time-pickes.js"></script>

<script type="text/javascript">
   var table;

   $(document).ready(function() {

      //datatables
      table = $('#table').DataTable({

         "processing": true, //Feature control the processing indicator.
         "serverSide": true, //Feature control DataTables' server-side processing mode.
         "order": [], //Initial no order.

         // Load data for the table's content from an Ajax source
         "ajax": {
            "url": "<?php echo base_url() . 'getNotification' ?>",
            "type": "POST",
            "data": function(data) {
               //data.filter_tags = $('#filter_tags').val();
               //data.crawler_account_id = $('#crawler_account_id').val();
               // data.txtTriggers = $('#txtTriggers').val();
               // data.exact_match = $('#exact_match').val();
               data.datepicker_from = $('#datepicker_from').val();
               data.datepicker_to = $('#datepicker_to').val();
            }
         },
         "columns": [{
               className: "text-wrap"
            },
            {
               className: "text-wrap"
            },
            {
               className: "text-wrap"
            },
            {
               className: "text-wrap"
            }
         ],
         //Set column definition initialisation properties.
         "columnDefs": [{
            "targets": [0], //first column / numbering column
            "orderable": false, //set not orderable
         }, ],

      });

      $('#submit_report_btn').click(function() { //button filter event click
         // alert(111);
         table.ajax.reload(); //just reload table
      });
      //  $('#btn-reset').click(function(){ //button reset event click
      //      $('#form-filter')[0].reset();
      //      table.ajax.reload();  //just reload table
      //  });

   });

   function open_post(post_link, input_id) {

      //  alert(11);     

      var input_re = document.getElementById(input_id);

      input_re.select();

      document.execCommand("copy");

      window.open(post_link, "_blank");



   }
</script>