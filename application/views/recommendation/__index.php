<link href="<?php echo base_url(); ?>main_assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css'>
<link href="<?php echo base_url() ?>main_assets/plugins/datetimepicker/css/classic.css" rel="stylesheet" />
<link href="<?php echo base_url() ?>main_assets/plugins/datetimepicker/css/classic.time.css" rel="stylesheet" />
<link href="<?php echo base_url() ?>main_assets/plugins/datetimepicker/css/classic.date.css" rel="stylesheet" />
<link rel="stylesheet" href="<?php echo base_url() ?>main_assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.min.css">

<!-- line awesome-->
<link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">

<style>
   .addclass i {
      font-size: 24px;
   }

   /*============================================
            Recommendations filter
==============================================*/

   .pr_new_list .recommendation-reply-box {
      width: 100%;
      max-width: 403px;
      position: absolute;
      right: 90px;
      z-index: 100;
      margin-top: -25px;
   }

   .pr_new_list .recommendation-reply-box .recommendation-title {
      font-weight: 700;
      font-size: 16px;
      color: #000000;
      padding: 26px 19px 0px 19px;
   }

   .pr_new_list .recommendation-reply-box .replies-list {
      font-weight: 400;
      font-size: 12px;
      color: #000000;
      padding: 16px 19px;
   }

   .pr_new_list .recommendation-reply-box .recommendation-replies {
      background: #fff;
      width: 50px;
      height: 50px;
      border-radius: 50%;
      margin-left: auto;
   }

   .pr_new_list .recommendation-reply-box .card-body {
      padding: 0;
   }

   .pr_new_list .recommendation-reply-box .replies-list .card-body {
      padding: 10px;
   }

   .pr_new_list .recommendation-reply-box .replies-list .card {
      box-shadow: none;
   }

   .pr_new_list .recommendation-reply-box .replies-list .replies-text {
      color: #000000;
      font-weight: 400;
      font-size: 12px;
      margin: 0;
   }

   .page-content .recommendation-item .recommendation-reply-box .replies-list .card-body {
      border: 1px solid #CDCDCD;
      border-radius: 4px;
   }
</style>

<main class="page-content">
   <div class="row">
      <div class="col-12 col-lg-12 col-xl-12">
         <div class="card radius-10 w-100">
            <div class="card-body">
               <h4 class="mb-0 text-primary">Recommendations For <?= $clients->full_name; ?></h4>
               <p>You will find here all people who requested recommendations in your connected groups with the keywords that you defined.</p>
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
                     <div class="row align-items-end">
                        <div class="col-4">
                           <label class="form-label">From Date</label>
                           <input type="text" id="datepicker_from" name="datepicker_from" date_format="d/m/yyyy" value="<?php echo date("Y-m-d"); ?>" class="form-control datepicker" />
                        </div>
                        <div class="col-4">
                           <label class="form-label">To Date</label>
                           <input type="text" id="datepicker_to" name="datepicker_to" date_format="d/m/yyyy" value="<?php echo date("Y-m-d"); ?>" class="form-control datepicker" />
                        </div>
                        <div class="col-4">
                           <!-- <button  type="submit" id="submit_report_btn"  class="btn btn-primary btn-lg px-5">Filter</button> -->
                           <button type="button" id="btn-filter" class="btn btn-primary px-5" style="height: 40px;">Filter</button>
                        </div>
                     </div>
                  </div>
               </form>

            </div>
         </div>

      </div>
   </div>

   <div id="repotrs"></div>

   <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="staticBackdropLabel">Apply Tags</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <p>Select the tag(s) you want to apply to this recommendation request then click "Save".</p>
               <input type="hidden" id="recommendation_id" value="" name="recommendation_id">
               <select id="updated_tags" name="updated_tags[]" class="selectpicker" data-actions-box="true" data-live-search="true" multiple>
                  <?php foreach ($tags as $tag) { ?>
                     <option value="<?php echo $tag->tag; ?>"><?php echo $tag->tag; ?></option>
                  <?php } ?>

               </select>

            </div>
            <div class="modal-footer">
               <button type="submit" id="tag_submit" class="btn btn-primary">Save</button>
            </div>
         </div>
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
   $(document).ready(function() {

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
            },
            error: function(jqXHR, textStatus, errorThrown) {
               console.log(textStatus, errorThrown);
            }
         });
      });

      $('#btn-filter').click(function() {
            var filter_tags = $('#filter_tags').val();
            var datepicker_from = $('#datepicker_from').val();
            var datepicker_to = $('#datepicker_to').val();
            var txtTriggers = $('#txtTriggers').val();
            var exact_match = $('#exact_match').val();
         if (filter_tags != '') {
             $.ajax({
                "url": "<?php echo base_url() . 'getrecommendation' ?>",
                "type": "POST",
                "data": {
                    "filter_tags": filter_tags,
                    "datepicker_from": datepicker_from,
                    "datepicker_to": datepicker_to,
                    "txtTriggers": txtTriggers,
                    "exact_match": exact_match,
                },
                success: function(response) {
                   var nhtml = JSON.parse(response);
                   $('#repotrs').html(nhtml);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                   // console.log(textStatus, errorThrown);
                }
             });
         } else {
            alert('Please select filter tag');
            return;
         }
         
      });

      $('#tag_submit').on('click', function() {
         var rm_id = $('#recommendation_id').val();
         var tags = $('#updated_tags').val();
         // console.log(rm_id,ff);

         $.ajax({
            "url": "<?php echo base_url() . 'update_ambass_tag' ?>",
            "type": "POST",
            data: {
               'rm_id': rm_id,
               'tags': tags
            },
            dataType: 'html',
            success: function(data) {
               $('#tag_div_' + rm_id).html(data);
               $("#staticBackdrop").modal("hide");
            }

         });

      })

   });

   function open_post(post_link, input_id) {

      var input_re = document.getElementById(input_id);

      input_re.select();

      document.execCommand("copy");

      window.open(post_link, "_blank");
   }

   function show_modal_tags(ev) {
      $("#staticBackdrop").modal("toggle");
      $('#recommendation_id').val(ev)
   }
</script>