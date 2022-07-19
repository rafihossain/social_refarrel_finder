<link href="<?php echo base_url(); ?>main_assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/css/selectize.bootstrap4.min.css" />

<style>
  #newkeyword {
    display: none;
  }

  button#uplodcsv {
    width: 60%;
    min-width: 220px;
    margin-top: 30px;
  }

  div#for_flex {
    display: flex;
  }

  a#downloadTemplete {
    max-height: 40px;
    margin-right: 20px;
  }
</style>

<header class="top-header">
   <nav class="navbar navbar-expand gap-3 d-md-none ">
      <div class="mobile-toggle-icon fs-3">
         <i class="bi bi-list"></i>
      </div>
   </nav>
   <div class="header-page">
      <h4 class="heading-title">Keywords</h4>
   </div>
</header>

<main class="page-content">

  <div class="row">
    <div class="col-md-7">
      <div class="card">
        <div class="card-body">
          <h2>Keywords</h2>
          <p>Add your keywords and recommended replies here. We will notify you when any of these keywords are used in a new group post. <?php //if (isset($cinfo)) {
                                      //echo $cinfo->full_name;
                                    //} ?></p>

          <h4>Add Keyword <a class="btn text-light radius-30 bg-primary circlebtn" href="javascript:void(0)" id="clickForKeyword"><i class="m-0 bx bx-plus"></i></a></h4>


          <form method="post" id="newkeyword" action="<?php echo base_url(); ?>crawler_keyword">

            <div class="col-12 mb-3">
              <label class="form-label">Master Keyword (one keyword only)</label>
              <input type="text" name="keyword" class="form-control" placeholder="Insert your keyword" />
            </div>
            <div class="col-12 mb-3">
              <div class="row">
                <div class="col-md-8">
                  <label class="form-label">Your Recommended Reply for this keyword</label>
                  <input type="text" name="recommended_reply[]" class="form-control" placeholder="Recommended Reply..." />
                </div>
                <div class="col-md-4 ">
                  <button class="btn btn-dangers prplusbtn"> + </button>
                </div>
              </div>
            </div>

            <div id="append_html"></div>

            <div class="col-12 mb-3">
              <label class="form-label">Must-Include Keyword(s)

                Specify one or multiple keywords (comma-separated) that must be included in the original request in order for them to count after the original keyword is found.</label>
              <input type="text" name="must_include_keywords" class="form-control" placeholder="Insert your Must-Include keywords" />
            </div>

            <div class="col-12 mb-3">
              <label class="form-label">Must-Include Condition:</label>
              <select name="must_include_condition" class="form-control">
                <option value="all">All keywords</option>
                <option value="one" selected>At least one keyword</option>
              </select>
            </div>
            <div class="col-12 mb-3">
              <label class="form-label">Must-Exclude Keyword(s) <i data-toggle="tooltip" data-placement="bottom" title="Specify keyword(s) that must be excluded from the original request in order for them to count after the original keyword is found. Unlike your original keyword above, the Must-Exclude field can have multiple keywords comma separated. Keep this field empty if you don't want to add any Must-Exclude Keywords." class="fa fa-question-circle"></i></label>
              <input type="text" name="must_exclude_keywords" class="form-control" placeholder="Insert your Must-Exclude keywords" />
            </div>
            <br>
            <div class="col-12">
              <button type="submit" class="btn btn-primary px-5">Add Keyword</button>
            </div>


          </form>

        </div>
      </div>
    </div>
    <div class="col-md-5">
      <div class="card" style="min-height:160px">
        <div class="card-body text-center" id="for_flex">

          <a href="<?php echo base_url() ?>main_assets/uploads/csv/social_referral_finder_keywords.csv" class="btn btn-neutral rounded-pill text-uppercase" id="downloadTemplete">Download Template</a>

          <form method="post" action="<?= base_url() ?>crawlercsv_keyword/<?= $this->session->userdata('id'); ?>" enctype="multipart/form-data">
            <input type="file" onchange="this.form.submit()" name="enter_csv" id="uploadCsvId" class="d-none" />
            <label class="btn btn-neutral rounded-pill text-uppercase" for="uploadCsvId">
              Upload CSV
            </label>
          </form>

          <!-- <button class="btn btn-primary" id="uplodcsv"> Upload CSV </button> -->
        </div>

      </div>
    </div>
  </div>


  <?php if ($this->session->flashdata('success')) : ?>
    <div class="alert border-0 bg-light-success alert-dismissible fade show py-2">
      <div class="d-flex align-items-center">
        <div class="fs-3 text-success"><i class="bi bi-check-circle-fill"></i>
        </div>
        <div class="ms-3">
          <div class="text-success"><?php echo $this->session->flashdata('success'); ?></div>
        </div>
      </div>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php endif ?>

  <?php if (count($keywords) > 0) { ?>
    <div class="table-responsive mt-3">
      <table id="mytble" class="table table-striped table-bordered" style="width:100%">
        <thead>
          <tr>
            <th>Keyword</th>
            <th>Must-Include Keyword(s)</th>
            <th>Must-Include Condition</th>
            <th>Must-Exclude Keyword(s)</th>
            <th>Recommended Reply</th>
            <th>&nbsp;</th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 0;
          foreach ($keywords as $keyword) {  ?>
            <tr>
              <td class="text-wrap"><?php echo $keyword->keyword; ?></td>
              <td class="text-wrap">
                <?php

                $mustinckeywords = explode(',', $keyword->must_include_keywords);
                for ($j = 0; $j < count($mustinckeywords); $j++) {
                  $g = $j + 1;
                ?>
                  <div class="rowvalue_<?= $keyword->id; ?> parent_<?= $g; ?>">
                    <div class="d-flex mb-2 mt-2">
                      <div id="child_<?= $g; ?>"><?= $g; ?>)</div>
                      <div class="mustinckey_value"><?= $mustinckeywords[$j]; ?></div>
                    </div>
                    <button class="btn btn-sm btn-success editmustinckey" data-id="<?= $g; ?>" row-id="<?= $keyword->id; ?>"><i class="bi bi-pencil"></i></button>
                    <button class="btn btn-sm btn-danger deletemustinckey" data-id="<?= $g; ?>" row-id="<?= $keyword->id; ?>"><i class="bi bi-trash-fill"></i></button>
                  </div>
                <?php }
                $j++;
                $g++;
                ?>
              </td>
              <td class="text-wrap"><?php echo $keyword->must_include_condition;   ?></td>
              <td class="text-wrap"><?php echo $keyword->must_exclude_keywords;    ?></td>
              <td class="text-wrap">
                <?php
                $multirecomreply = explode(',', $keyword->recommended_reply);
                for ($j = 0; $j < count($multirecomreply); $j++) {
                  $g = $j + 1;
                ?>
                  <div class="row_<?= $keyword->id; ?> recomp_<?= $g; ?>">
                    <div class="d-flex mb-2 mt-2">
                      <div class=""><?= $g; ?>)</div>
                      <div class="recomreply_value"><?= $multirecomreply[$j]; ?></div>
                    </div>
                    <button class="btn btn-sm btn-success editrecomreply" data-id="<?= $g; ?>" row-id="<?= $keyword->id; ?>"><i class="bi bi-pencil"></i></button>
                    <button class="btn btn-sm btn-danger delrecomreply" data-id="<?= $g; ?>" row-id="<?= $keyword->id; ?>"><i class="bi bi-trash-fill"></i></button>
                  </div>
                <?php }
                $j++;
                $g++;
                ?>
              </td>
              <td class="text-wrap">
                <div class="table-actions d-flex align-items-center gap-3 fs-6">
                  <a class="btn btn-primary" href="<?php echo base_url() ?>crawler_update_keyword/<?php echo $keyword->id; ?>" class="text-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit"><i class="bi bi-pencil"></i></a>

                  <a class="btn btn-danger" id="deleteClientKeyword" data-id="<?php echo $keyword->id; ?>" class="text-danger" title="Delete"><i class="bi bi-trash-fill"></i></a>
                </div>
              </td>
            </tr>

          <?php } ?>

        </tbody>
      </table>
    </div>
  <?php } ?>
</main>

<!--  Modal content for the above example -->
<div id="mustInckeyModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myExtraLargeModalLabel">Update Must-Include Keyword Information</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="mustInckey"></div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!--  Modal content for the above example -->
<div id="recomReplyModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myExtraLargeModalLabel">Update Recommendation Reply</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="recomReply"></div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->





<script src="<?php echo base_url(); ?>main_assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>main_assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
<script src="<?php echo base_url(); ?>main_assets/js/table-datatable.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/js/standalone/selectize.min.js" integrity="sha512-pF+DNRwavWMukUv/LyzDyDMn8U2uvqYQdJN0Zvilr6DDo/56xPDZdDoyPDYZRSL4aOKO/FGKXTpzDyQJ8je8Qw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
  $(document).ready(function() {

    $('#clickForKeyword').on('click', function() {
      $('#newkeyword').toggle();
    });

    /*========================================
        Add Multiple Recommendation Keyword
        ==========================================*/
    var div_i = 0;
    $('.prplusbtn').on('click', function(e) {
      e.preventDefault();
      div_i = div_i + 1;
      var html = '';
      html += '<div class="col-12 mb-3 rs_main_divs" id="keyid' + div_i + '">';
      html += '<label>' + (div_i == 1 ? "2nd" : (div_i == 2 ? "3rd" : (div_i + 1) + "th")) + ' Keywords</label><br />';

      html += '<div class="row">';
      html += '<div class="col-md-8"><input type="text" name="recommended_reply[]" class="form-control" placeholder="Recommended Reply..." /></div>';
      html += '<div class="col-md-4"><button nid="' + div_i + '" class="btn btn-dangers prminusbtn mt-0"> - </button></div>';
      html += '</div>'
      $('#append_html').append(html);

    });

    $("#append_html").delegate(".prminusbtn", "click", function(e) {
      e.preventDefault();
      div_i = div_i - 1;
      let id = 'keyid' + $(this).attr('nid');
      $('#' + id).remove();
    });



    /*======================================================
                Edit And Delete Must Include Keyword
                ========================================================*/
    $('.editmustinckey').click(function() {
      $('#mustInckeyModal').modal('show');

      var valueid = 'parent_' + $(this).attr('data-id');
      var rowid = 'rowvalue_' + $(this).attr('row-id');
      var mainid = $(this).attr('row-id');
      var mydata = $(this).parent().find(".mustinckey_value");
      var test = mydata.html();

      var html = '';

      html += '<div class="row"><div class="col-md-12"><input type="hidden" id="hiddenValue" value="' + valueid + '"><input type="hidden" id="rowValue" value="' + rowid + '"><div class="mb-2"><textarea name="" id="mustIncValue" class="form-control">' + test + '</textarea></div><div class="mb-2"><button type="button" class="btn btn-primary w-100" name="" id="update" main-id="' + mainid + '">Update</button></div></div></div>';

      $('#mustInckey').html(html);
    });

    $(document).on("click", "#update", function() {

      $('#mustInckeyModal').modal('hide');
      var html = $('#hiddenValue').val();
      var content = $('.' + html).find('.mustinckey_value');
      var mustIncVal = $('#mustIncValue').val();
      content.html(mustIncVal);
      var rowValue = $('#rowValue').val();

      let updatedValue = [];
      $('.' + rowValue).each(function() {
        var getAllVal = $(this).find('.mustinckey_value');
        updatedValue.push(getAllVal.html());
      });

      var updateVal = updatedValue.toString();
      id = $(this).attr('main-id');

      $.ajax({
        type: "post",
        url: "<?php echo base_url() ?>update_mustinc_value",
        data: {
          id: id,
          updateVal: updateVal
        },
        dataType: "JSON",
        success: function(data) {
          window.location.reload();
        }
      });

    });

    $(document).on("click", ".deletemustinckey", function() {

      var test = $(this).parent().remove();
      var rowValue = 'rowvalue_' + $(this).attr('row-id');

      let deleteValue = [];
      $('.' + rowValue).each(function() {
        var removeVal = $(this).find('.mustinckey_value');
        deleteValue.push(removeVal.html());
      });
      var removeVal = deleteValue.toString();

      id = $(this).attr('row-id');

      $.ajax({
        type: "post",
        url: "<?php echo base_url() ?>remove_mustinc_value",
        data: {
          id: id,
          removeVal: removeVal
        },
        dataType: "JSON",
        success: function(data) {
          window.location.reload();
        }
      });

    });

    /*======================================================
                Edit And Delete Recommended Reply
                ========================================================*/
    $('.editrecomreply').click(function() {
      $('#recomReplyModal').modal('show');

      var valueid = 'recomp_' + $(this).attr('data-id');
      var rowid = 'row_' + $(this).attr('row-id');
      var mainid = $(this).attr('row-id');
      var mydata = $(this).parent().find(".recomreply_value");
      var test = mydata.html();

      var html = '';

      html += '<div class="row"><div class="col-md-12"><input type="hidden" id="recomValue" value="' + valueid + '"><input type="hidden" id="rowRecomValue" value="' + rowid + '"><div class="mb-2"><textarea name="" id="recomReplyValue" class="form-control">' + test + '</textarea></div><div class="mb-2"><button type="button" class="btn btn-primary w-100" name="" id="recomupdate" main-id="' + mainid + '">Update</button></div></div></div>';

      $('#recomReply').html(html);
    });

    $(document).on("click", "#recomupdate", function() {

      $('#recomReplyModal').modal('hide');
      var html = $('#recomValue').val();
      var content = $('.' + html).find('.recomreply_value');
      var mustIncVal = $('#recomReplyValue').val();
      content.html(mustIncVal);
      var rowValue = $('#rowRecomValue').val();

      let updatedValue = [];
      $('.' + rowValue).each(function() {
        var getAllVal = $(this).find('.recomreply_value');
        updatedValue.push(getAllVal.html());
      });

      var updateVal = updatedValue.toString();
      id = $(this).attr('main-id');

      $.ajax({
        type: "post",
        url: "<?php echo base_url() ?>update_recomreply_value",
        data: {
          id: id,
          updateVal: updateVal
        },
        dataType: "JSON",
        success: function(data) {
          window.location.reload();
        }
      });

    });

    $(document).on("click", ".delrecomreply", function() {

      var test = $(this).parent().remove();
      var recomRowValue = 'row_' + $(this).attr('row-id');
      // console.log(recomRowValue);

      let storeRecom = [];
      $('.' + recomRowValue).each(function() {
        var removeVal = $(this).find('.recomreply_value');
        storeRecom.push(removeVal.html());
      });
      // console.log(storeRecom);
      var removeRecomVal = storeRecom.toString();

      id = $(this).attr('row-id');

      $.ajax({
        type: "post",
        url: "<?php echo base_url() ?>remove_recomreply_value",
        data: {
          id: id,
          removeRecomVal: removeRecomVal
        },
        dataType: "JSON",
        success: function(data) {
          window.location.reload();
        }
      });

    });




    $('#mytble').DataTable();


    //sweetalert

    $(document).on('click', '#deleteClientKeyword', function() {
      var Id = $(this).attr('data-id');
      // console.log(Id);

      swal({
          title: "Are you sure?",
          text: "You want to delete this keyword!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            swal("Success! Keyword has been deleted!", {
              icon: "success",
            });

            $.ajax({
              url: "<?php echo base_url() ?>removekeyword/" + Id,
              dataType: "JSON",
              success: function(data) {
                window.location.reload();
              }
            });
          } else {
            swal("Your keyword is safe!");
          }

        });

    });

  })
</script>