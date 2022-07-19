<link href="<?php echo base_url(); ?>main_assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/css/selectize.bootstrap4.min.css" />

<main class="page-content">
  <div class="card">
    <div class="card-body">
      <h2>Edit Keywords</h2>

      <form method="post" action="<?php echo base_url(); ?>updateCrwalerkeyword/<?php echo $keyword->id; ?>/<?php echo $cid; ?>">

        <div class="col-12 mb-3">
          <label class="form-label">Master Keyword (one keyword only)</label>
          <input type="text" name="keyword" class="form-control" placeholder="Insert your keyword" value="<?php echo $keyword->keyword;  ?>" />
        </div>


        <div class="recomreply">
          <div class="col-12 mb-2">

            <?php 
            
            $showAllRecom = explode(',',$keyword->recommended_reply);

            if(count($showAllRecom) > 0){
              for($i = 0; $i < count($showAllRecom); $i++) { ?>

                <div class="row">
                  <div class="col-md-8">
                    <div class="mb-3">
                      <label for="">Your Recommended Reply for this keyword</label>
                      <input type="text" name="recommended_reply[]" class="form-control" placeholder="Recommended Reply..." value="<?php echo $showAllRecom[$i];  ?>" />
                    </div>
                  </div>
                  <div class="col-md-4">

                    <div class="mt-4">
                      <button class="btn btn-primary addrecomreply">+</button>
                      <button class="btn btn-danger removerecomreply d-inline">-</button>
                    </div>

                  </div>
                </div>

              <?php } $i++;
            }
            ?>

          </div>
        </div>


        <div class="col-12 mb-3">
          <label class="form-label">Must-Include Keyword(s)
          Specify one or multiple keywords (comma-separated) that must be included in the original request in order for them to count after the original keyword is found.</label>
          <input type="text" name="must_include_keywords" class="form-control" value="<?php echo $keyword->must_include_keywords;  ?>" placeholder="Insert your Must-Include keywords" />
        </div>

        <div class="col-12 mb-3">
          <label class="form-label">Must-Include Condition:</label>
          <select name="must_include_condition" class="form-control">
            <option value="all" <?php echo ($keyword->must_include_condition == 'all' ? 'selected' : '');  ?>>All keywords</option>
            <option value="one" <?php echo ($keyword->must_include_condition == 'one' ? 'selected' : '');  ?>>At least one keyword</option>
          </select>
        </div>
        <div class="col-12 mb-3">
          <label class="form-label">Must-Exclude Keyword(s) <i data-toggle="tooltip" data-placement="bottom" title="Specify keyword(s) that must be excluded from the original request in order for them to count after the original keyword is found. Unlike your original keyword above, the Must-Exclude field can have multiple keywords comma separated. Keep this field empty if you don't want to add any Must-Exclude Keywords." class="fa fa-question-circle"></i></label>
          <input type="text" name="must_exclude_keywords" class="form-control" value="<?php echo $keyword->must_exclude_keywords;  ?>" placeholder="Insert your Must-Exclude keywords" />
        </div>
        <br>

        <div class="d-flex mt-4">
          <a class="btn btn-outline-danger btn-rounded" href="<?php echo base_url() ?>viewkeyword/<?= $cid; ?>">Cancel</a>
          <button type="submit" class="btn btn-primary ms-auto btn-rounded">Update Keyword</button>
        </div>


      </form>

    </div>
  </div>

</main>
<!-- multifield -->
<script src="<?php echo base_url(); ?>main_assets/js/jquery.multifield.min.js"></script>

<script>
  $(document).ready(function() {

    /*========================================
        Add Multiple Recommendation Keyword
        ==========================================*/

        $('.recomreply').multifield({
          section: '.row',
          btnAdd: '.addrecomreply',
          btnRemove: '.removerecomreply',
          max: 4,
          locale: 'default'
        });


      });
    </script>