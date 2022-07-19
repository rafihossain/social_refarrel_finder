<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css'>
<link href="<?php echo base_url() ?>main_assets/plugins/datetimepicker/css/classic.css" rel="stylesheet" />
<link href="<?php echo base_url() ?>main_assets/plugins/datetimepicker/css/classic.time.css" rel="stylesheet" />
<link href="<?php echo base_url() ?>main_assets/plugins/datetimepicker/css/classic.date.css" rel="stylesheet" />
<link rel="stylesheet" href="<?php echo base_url() ?>main_assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.min.css">
<main class="page-content">
   <div class="row">
      <div class="col-12 col-lg-12 col-xl-12 d-flex">
         <div class="card radius-10 w-100">
            <div class="card-body">
               <h4 class="text-primary mb-0">Reports</h4>
               <hr>
               <!-- <form class="row g-3" method="post" action="<?php //echo base_url();
                                                                  ?>report"> -->
               <form id="form-filter" class="row g-3">
                  <div class="col-4">
                     <label class="form-label">Filter by Tags</label>
                     <select id="filter_tags" name="filter_tags[]" class="selectpicker form-control" data-live-search="true" data-actions-box="true" multiple>
                        <optgroup label="Generic">
                           <option value="4"> <?php echo $filtered_tags; ?></option>
                           <option value="0" <?php if ($top_level_tag == "0") {
                                                echo "selected='selected'";
                                             } ?>>All Tags + Non-Tagged</option>
                           <option value="1" <?php if ($top_level_tag == "1") {
                                                echo "selected='selected'";
                                             } ?>>All Tags</option>
                           <option value="2" <?php if ($top_level_tag == "2") {
                                                echo "selected='selected'";
                                             } ?>>Non-Tagged</option>
                        </optgroup>


                        <?php foreach ($tags as $tag) { ?>
                           <option value="<?php echo $tag->tag; ?>"><?php echo $tag->tag; ?></option>
                        <?php  }   ?>

                     </select>
                  </div>
                  <div class="col-12">
                     <div class="row">
                        <div class="col-4">
                           <label class="form-label">Account</label>
                           <select id="crawler_account_id" name="crawler_account_id[]" class="selectpicker form-control" data-live-search="true" data-actions-box="true" multiple>
                              <?php foreach ($crawlers as $crawler) { ?>
                                 <option value="<?php echo $crawler->id; ?>"><?php echo $crawler->full_name; ?></option>
                              <?php  }   ?>
                           </select>
                        </div>
                        <div class="col-4">
                           <label class="form-label">Triggers (comma separated)</label>
                           <input value="<?php //echo $triggers; 
                                          ?>" type="text" class="form-control" id="txtTriggers" name="txtTriggers" />
                        </div>
                        <div class="col-4">
                           <label class="form-label">Triggers (comma separated)</label>
                           <select id="exact_match" name="exact_match" class="form-control">
                              <option value="1">Yes</option>
                              <option value="0">No</option>
                           </select>
                        </div>
                     </div>
                  </div>
                  <div class="col-12">
                     <div class="row">
                        <div class="col-4">
                           <label class="form-label">From Date</label>
                           <input type="text" id="datepicker_from" name="datepicker_from" date_format="d/m/yyyy"
                           value ="<?= date('Y-m-d'); ?>" class="form-control datepicker" />
                        </div>
                        <div class="col-4">
                           <label class="form-label">To Date</label>
                           <input type="text" id="datepicker_to" name="datepicker_to" date_format="d/m/yyyy" value ="<?= date('Y-m-d'); ?>" class="form-control datepicker" />
                        </div>
                        <div class="col-4">
                           <!-- <button  type="submit" id="submit_report_btn"  class="btn btn-primary btn-lg px-5">Filter</button> -->
                           <button type="button" id="btn-filter" class="btn btn-primary btn-lg px-5">Filter</button>
                        </div>
                     </div>
                  </div>
               </form>



            </div>
         </div>
      </div>
   </div>

   <div id="repotrs"> </div>
</main>
<script src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js'></script>

<script src="<?php echo base_url(); ?>main_assets/plugins/datetimepicker/js/picker.js"></script>
<script src="<?php echo base_url(); ?>main_assets/plugins/datetimepicker/js/picker.time.js"></script>
<script src="<?php echo base_url(); ?>main_assets/plugins/datetimepicker/js/picker.date.js"></script>
<script src="<?php echo base_url(); ?>main_assets/js/form-date-time-pickes.js"></script>


<script type="text/javascript">
   var table;

   $(document).on('click', '.myclass', function(e) {
      e.preventDefault();
      var hrl = $(this).attr('href');
      $.ajax({
         "url": hrl,
         "type": "POST",
         "data": '',
         success: function(response) {
            var nhtml = JSON.parse(response);
            $('#repotrs').html(nhtml);
            console.log(response);
         },
         error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
         }
      });
   })



   $(document).ready(function() {

      getAllReportWhenPageLoad();

      $('#btn-filter').click(function() {
         var filter_tags = $('#filter_tags').val();
         var crawler_account_id = $('#crawler_account_id').val();
         var txtTriggers = $('#txtTriggers').val();
         var exact_match = $('#exact_match').val();
         var datepicker_from = $('#datepicker_from').val();
         var datepicker_to = $('#datepicker_to').val();

         $.ajax({
            "url": "<?php echo base_url() . 'getreport/0' ?>",
            "type": "POST",
            "data": {
               "filter_tags": filter_tags,
               "crawler_account_id": crawler_account_id,
               "txtTriggers": txtTriggers,
               "exact_match": exact_match,
               "datepicker_from": datepicker_from,
               "datepicker_to": datepicker_to
            },
            success: function(response) {
               var nhtml = JSON.parse(response);
               $('#repotrs').html(nhtml);

               console.log(response);
               // You will get response from your PHP page (what you echo or print)
            },
            error: function(jqXHR, textStatus, errorThrown) {
               console.log(textStatus, errorThrown);
            }
         });
      });

   });

   function getAllReportWhenPageLoad() {      
      $.ajax({
         "url": "<?php echo base_url() . 'load_report' ?>",
         "type": "POST",
         success: function(response) {
            var nhtml = JSON.parse(response);
            $('#repotrs').html(nhtml);

            console.log(response);
            // You will get response from your PHP page (what you echo or print)
         },
         error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
         }
      });
   }
</script>