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
      <h4 class="heading-title">Triggers</h4>
   </div>
</header>

<main class="page-content">
   <div class="row">
      <div class="col-12 col-lg-12 col-xl-12  ">
         <div class="card">
            <div class="card-body">
               <h4 class="mb-0 text-primary">Triggers</h4>
               <hr>
             <form class="row g-3" method="post" action="<?php echo base_url();?>trigger"> 
               <!-- <form id="form-filter" class="row g-3"> --> 
                  <div class="col-12">
                     <div class="row align-items-end">
                        <div class="col-4">
                           <label class="form-label">From Date</label>
                           <input type="text" id="datepicker_from" name="datepicker_from" value="<?php echo $datepicker_from; ?>" date_format="d/m/yyyy" class="form-control datepicker" />
                        </div>
                        <div class="col-4">
                           <label class="form-label">To Date</label>
                           <input type="text" id="datepicker_to" name="datepicker_to" value="<?php echo $datepicker_to; ?>" date_format="d/m/yyyy" class="form-control datepicker" />
                        </div>
                        <div class="col-4">
                          <button  type="submit" id="submit_report_btn"  class="btn btn-primary  ">Filter</button>
                        </div>
                     </div>
                  </div>
               </form> 
               <br>
            </div>
         </div>
              
               <?php if ( count($key_words) >0 ){ ?>

  
               <div class="table-responsive">
                  <table id="table" class="table table-striped table-bordered" style="width:100%">
                     <thead>
                        <tr>
                    <th>Keyword</th>
                    <th>Total Requests</th>
                        </tr>
                     </thead>
                     <tbody>
                 
                        <?php  foreach ($key_words as $key){  ?>
                        <tr>
                            <td><span class="badge bg-primary"><?php echo $key['key_word']; ?></span>  </td>
                            <td> <?php echo $key['counts'] ?></td>

                        <?php } ?>

                     </tbody>
                  
                  </table>
               </div>
            
   <?php } ?>
            </div>
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

  $('#table').DataTable({
     dom: 'Bfrtip',
     buttons: [{
        extend: 'csvHtml5',
        text: 'EXPORT TO CSV',
        className: 'btn btn-primary text-white ms-3', 
        exportOptions: {
           // modifier: {
           //    page: 'current'
           // }
        }
     }]
  });

});
 
</script>


