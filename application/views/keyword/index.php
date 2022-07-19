<style>
  .hover-effects {
    position: relative;
    min-width: 100px;
    text-align: center;
  }

  .hover-effects .button-groups {
    display: none;
  }

  .hover-effects:hover .button-groups {
    display: flex;
    position: absolute;
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;
    background: rgba(0, 0, 0, .2);
    border-radius: 60px;
    align-items: center;
    justify-content: center;
  }

  .hover-effects:hover .button-groups a {
    font-size: 12px;
    line-height: 12px;
    padding: 5px;
  }

  .replybtn_main {
    position: relative;
  }

  .replybtn_plus {
    padding-right: 60px;
  }

  .custome_plusbtn {
    position: absolute;
    bottom: 0;
    right: 10px;
    background: transparent;
    padding: 0;
    margin: 0;
    color: #194E6C;
    width: 40px;
    height: 38px;
    border: none;
    font-size: 30px;
  }
</style>

<header class="top-header">
  <nav class="navbar navbar-expand gap-3 d-md-none ">
    <div class="mobile-toggle-icon fs-3">
      <i class="bi bi-list"></i>
    </div>
  </nav>
  <div class="header-page">
    <h4 class="heading-title">Keyword</h4>
  </div>
</header>

<!--new profile body-->
<main class="page-content rs-tab-content">
  <div class="row">
    <div class="col-12 col-lg-12 col-xl-12">
      <div class="card">
        <div class="card-body">
          <div class="keyword-list">

            <h4 class="text-primary">Keywords</h4>
            <div class="d-flex float-end fw-bold">
              <p class="upload_bulk" style="color:#3BABA6">
                <i class="bi bi-upload"></i> Bulk Keywords Upload
              </p>
            </div>
            <br>

            <?php if ($this->session->flashdata('sucess')) : ?>
              <div class="alert border-0 bg-light-success alert-dismissible fade show py-2">
                <div class="d-flex align-items-center">
                  <div class="fs-3 text-success"><i class="bi bi-check-circle-fill"></i>
                  </div>
                  <div class="ms-3">
                    <div class="text-success"><?php echo $this->session->flashdata('sucess'); ?></div>
                  </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            <?php endif ?>

            <div class="keyword-details">
              <div class="col-md-4">
                <div class="row align-items-end">
                  <div class="col-md-10">
                    <label for="">Add New Keyword</label>
                    <input type="text" class="form-control keyword-value">
                  </div>
                  <div class="col-md-2">
                    <button type="button" class="btn btn-primary custom-btn addkeyword">Add</button>
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <label for="">Suggested Keywords</label>
                <div class="suggestion-btnlist">
                  <div class="show-keyword"></div>
                </div>
              </div>
            </div>
          </div>

          <div class="table-responsive">
            <table id="client_keyword" class="table table-striped table-bordered d-none" style="width:100%">
              <thead>
                <tr>
                  <th>id</th>
                  <th>Keyword</th>
                  <th>Must-Include Keyword(s)</th>
                  <th>Must-Include Condition</th>
                  <th>Must-Exclude Keyword(s)</th>
                  <th>Recommended Reply</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody id="keyTable">

              </tbody>
            </table>


            <form id="keywordAddGroup" method="post" action="<?php echo base_url(); ?>addClientkeyword">
              <textarea name="keyword" class="d-none" id="keywordData"></textarea>
          </div>

          <div class="cl_add_keyword"></div>

          <div class="col-md-8 text-center m-auto">
            <button type="submit" class="btn btn-primary py-2" id="for_keywordData">Insert Keyword</button>
          </div>

          </form>

        </div>
      </div>
    </div>
  </div>


</main>


<!--  Modal content for the above example -->
<div id="keywordModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myExtraLargeModalLabel">Keywords</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="container">
          <form action="" id="keywordModalForm">
            <button type="button" class="btn rounded-pill keyword-btntag" id="keyword"></button>

            <div class="col-md-12 mb-4">
              <div class="row">
                <div class="col-md-6">
                  <label class="form-label">Must-Include Keyword(s)</label>
                  <input type="text" name="must_include_keywords" class="form-control" id="mustIncludeKeywords" placeholder="Insert your Must-Include keywords" />
                </div>
                <div class="col-md-6">
                  <label class="form-label">Must-Include Condition:</label>
                  <select name="must_include_condition" class="form-control" id="mustIncludeCondition">
                    <option value="all">All keywords</option>
                    <option value="one" selected>At least one keyword</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-md-12 mb-4">
              <label class="form-label">Must-Exclude Keyword(s) <i class="fa fa-question-circle"></i></label>
              <input type="text" name="must_exclude_keywords" class="form-control" id="mustExcludeKeywords" placeholder="Insert your Must-Exclude keywords" />
            </div>

            <div class="col-md-12 mb-4">
              <div class="row">
                <div class="replybtn_main">
                  <label class="form-label">Your Recommended Reply for this keyword</label>
                  <input type="text" name="recommended_reply[]" class="form-control addRecommendedReply replybtn_plus" placeholder="Recommended Reply..." />
                  <button class="prplusbtn custome_plusbtn"> + </button>
                </div>
              </div>
              <div id="append_html"></div>
            </div>

            <div class="col-md-12 d-flex mt-4">
              <a class="btn btn-outline-danger btn-rounded btn-lg" data-bs-dismiss="modal">Cancel</a>
              <button type="button" class="btn btn-primary ms-auto btn-rounded btn-lg saveKeyword">Save</button>
            </div>
          </form>

        </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!--  Modal content for the above example -->
<div id="suggestedKeywordModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myExtraLargeModalLabel">Keywords</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="suggested-keyword-content"></div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!--  Modal content for the above example -->
<div id="uploadKeywordModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myExtraLargeModalLabel">Keyword Bulk Uploads</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="post" action="<?= base_url() ?>clientcsv_keyword/<?= $this->session->userdata('id'); ?>" enctype="multipart/form-data">
          <div class="col-md-10">
            <div class="mb-2">
              <label for="">Upload a file</label>
              <input type="file" name="enter_csv">
            </div>
            <div class="mb-2">
              <p>Please download the template
                <a href="<?php echo base_url() ?>main_assets/uploads/csv/social_referral_finder_keywords.csv">Keyword.csv</a>
              </p>
            </div>
            <div class="mb-2 text-end">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary" >Upload</button>
            </div>
          </div>
        </form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

</div>

</div>
</div>

<!-- multifield -->
<script src="<?php echo base_url(); ?>main_assets/js/jquery.multifield.min.js"></script>

<script>
  var keywordArray = [];

  var string = '<?php echo json_encode($this->session->userdata('keyword_data')); ?>';
  var getkeywords = JSON.parse(string);
  console.log(getkeywords);

  
  $(document).ready(function() {
    /*---new keyword code---*/
    if (getkeywords != undefined) {
      keywordArray = getkeywords
       $('#keywordData').val(JSON.stringify(keywordArray))
       showSuggestedKeyword(keywordArray);
    }

    $('.addkeyword').click(function() {
      $('#keywordModalForm')[0].reset();
      $('#keywordModal').modal('show');

      var suggestedKey = $('.keyword-value').val();
      // console.log(suggestedKey);
      $('.keyword-btntag').html(suggestedKey);

    });
    $('.suggested-key').click(function() {
      $('#keywordModal').modal('show');
      var suggestedKey = $(this).val();
      $('.keyword-btntag').html(suggestedKey);
      // $('.suggested-key').val(suggestedKey);
    });


    $('#for_keywordData').click(function(e) {
      e.preventDefault();

      if (keywordArray.length == 0) {
        $('.cl_add_keyword').html('<div class="alert alert-danger" role="alert">Please Add Keyword.</div>');
        return;
      }

      $('#keywordAddGroup').submit();

    });


    $('.upload_bulk').click(function() {
      // alert('hi');

      $('#uploadKeywordModal').modal('show');


    });

    /*========================================
      Add Multiple Recommendation Keyword
    ==========================================*/

    $(document).delegate(".recomreply", "click", function() {
      // e.preventDefault();
      // alert('hello');

      // console.log(this);
      // console.log($(this).find('.row').html());

      $(this).multifield({
        section: '.row',
        btnAdd: '.addrecomreply',
        btnRemove: '.removerecomreply',
        max: 4,
        locale: 'default'
      });

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
      html += '<div class="replybtn_main"><input type="text" name="recommended_reply[]" class="form-control addRecommendedReply replybtn_plus" placeholder="Recommended Reply..." />';
      html += '<button nid="' + div_i + '" class="prminusbtn custome_plusbtn"> - </button></div>';
      html += '</div>'
      $('#append_html').append(html);

    });

    $("#append_html").delegate(".prminusbtn", "click", function(e) {
      e.preventDefault();
      div_i = div_i - 1;
      let id = 'keyid' + $(this).attr('nid');
      $('#' + id).remove();
    });

    $('.saveKeyword').click(function() {

      // $('.keyword-value').val('');
      $('#keywordModal').modal('hide');

      var keyword = $('#keyword').html();
      var mustIncludeKeywords = $('#mustIncludeKeywords').val();
      var mustIncludeCondition = $('#mustIncludeCondition').val();
      var mustExcludeKeywords = $('#mustExcludeKeywords').val();

      let storeRecom = [];
      $('.addRecommendedReply').each(function() {
        storeRecom.push($(this).val());
      });
      console.log(storeRecom);

      var recommendedReply = storeRecom.toString();

      if (recommendedReply == '') {
        alert('RecommendedReply is Empty');
        return;
      }


      var arrKeyword = {
        'keyword': keyword,
        'must_include_keywords': mustIncludeKeywords,
        'must_include_condition': mustIncludeCondition,
        'must_exclude_keywords': mustExcludeKeywords,
        'recommended_reply': recommendedReply,
      }

      keywordArray.push(arrKeyword);

      console.log(keywordArray);


      
      $('#keywordData').val(JSON.stringify(keywordArray));
      showSuggestedKeyword(keywordArray);
      //showInsertedKeywordData(keywordArray);

    });

  });

  function suggestedKeywordDelete(id) {
    keywordArray.splice(id, 1);

    var html = "";
    for (var i = 0; i < keywordArray.length; i++) {
      var g = i + 1;

      html += '<button type="button" class="btn rounded-pill btn-custome suggested-key hover-effects mt-4 me-2" value="' + keywordArray[i].keyword + '">' + keywordArray[i].keyword + '<div class="button-groups"><a class="btn btn-primary btn-sm me-2" onclick="suggestedKeywordEdit(' + i + ')" title="Edit"><i class="bi bi-pencil-fill"></i></a><a class="btn btn-danger btn-sm" onclick="suggestedKeywordDelete(' + i + ')" id="deleteGroup" title="Delete"><i class="bi bi-trash-fill"></i></a></div></button>';
    }

    $('.show-keyword').html(html);
  }

  function suggestedKeywordUpdate(id) {
    $('#suggestedKeywordModal').modal('hide');

    var keyword = keywordArray[id].keyword;
    // console.log(keyword);

    var mustIncludeKeywords = $('.mustIncludeKeywords').val();
    var mustIncludeCondition = $('.mustIncludeCondition').val();
    var mustExcludeKeywords = $('.mustExcludeKeywords').val();

    let storeRecom = [];
    $('.editRecommendedReply').each(function() {
      storeRecom.push($(this).val());
    });
    console.log(storeRecom);

    var recommendedReply = storeRecom.toString();
    // var recommendedReply = substring.substring(1);


    var arrKeyword = {
      'keyword': keyword,
      'must_include_keywords': mustIncludeKeywords,
      'must_include_condition': mustIncludeCondition,
      'must_exclude_keywords': mustExcludeKeywords,
      // 'recommended_reply': storeRecom,
      'recommended_reply': recommendedReply,
    }
    // console.log(arrKeyword);
    keywordArray.splice(id, 1, arrKeyword);

    // showSuggestedKeyword(keywordArray);

    $('#keywordData').val(JSON.stringify(keywordArray));
    showSuggestedKeyword(keywordArray);
  }

  function suggestedKeywordEdit(id) {
    console.log(id);
    $('#suggestedKeywordModal').modal('show');
    var html = '';

    var text = keywordArray[id].recommended_reply;
    var splitText = text.split(',');
    // console.log(splitText);

    var recomText = '';
    if (splitText.length > 0) {
      for (var j = 0; j < splitText.length; j++) {
        recomText += '<div class="row"><div class="col-md-8"><div class="mb-3"><label for="">Your Recommended Reply for this keyword</label><input type="text" name="recommended_reply[]" class="form-control editRecommendedReply" placeholder="Recommended Reply..."value="' + splitText[j] + '" /></div></div><div class="col-md-4"><div class="mt-4"><button class="btn btn-primary addrecomreply">+</button><button class="btn btn-danger removerecomreply d-inline" style="display: none;">-</button></div></div></div>';
      }
    }


    html += '<div class="container"><button type="button" class="btn rounded-pill btn-primary btn-custome suggested-key pr-2 mb-3 keyword" id="keyword" value="' + keywordArray[id].keyword + '">' + keywordArray[id].keyword + '</button><div class="col-md-12 mb-4"><div class="row"><div class="col-md-6"><label class="form-label">Must-Include Keyword(s)</label><input type="text" name="must_include_keywords" class="form-control mustIncludeKeywords" placeholder="Insert your Must-Include keywords" value="' + keywordArray[id].must_include_keywords + '" /></div><div class="col-md-6"><label class="form-label">Must-Include Condition:</label><select name="must_include_condition" class="form-control mustIncludeCondition"><option value="all">All keywords</option><option value="one" selected>At least one keyword</option></select></div></div></div><div class="col-md-12 mb-4"><div class="row"><div class="col-md-6"><label class="form-label">Must-Exclude Keyword(s) <i class="fa fa-question-circle"></i></label><input type="text" name="must_exclude_keywords" class="form-control mustExcludeKeywords" placeholder="Insert your Must-Exclude keywords" value="' + keywordArray[id].must_exclude_keywords + '" /></div></div></div><div class="recomreply"><div class="col-12 mb-2">' + recomText + '</div></div><div class="col-md-12 d-flex mt-4"><a class="btn btn-outline-danger btn-rounded btn-lg" data-bs-dismiss="modal">Cancel</a><button type="submit" class="btn btn-primary ms-auto btn-rounded btn-lg" onclick="suggestedKeywordUpdate(' + id + ')">Update</button></div></div>';

    $('.suggested-keyword-content').html(html);

  }

  function showSuggestedKeyword(data) {
    $('#keyword').val('');
    $('.recommendedReply').val('');
    $('#mustIncludeKeywords').val('');
    // $('#mustIncludeCondition').val('At least one keyword');
    $('#mustExcludeKeywords').val('');
    $('.keyword-btntag').val('');

    var html = "";
    for (var i = 0; i < data.length; i++) {
      var g = i + 1;

      html += '<button type="button" class="btn rounded-pill btn-custome suggested-key hover-effects mt-4 me-2" value="' + data[i].keyword + '">' + data[i].keyword + '<div class="button-groups"><a class="btn btn-primary btn-sm me-2" onclick="suggestedKeywordEdit(' + i + ')" title="Edit"><i class="bi bi-pencil-fill"></i></a><a class="btn btn-danger btn-sm" onclick="suggestedKeywordDelete(' + i + ')" id="deleteGroup" title="Delete"><i class="bi bi-trash-fill"></i></a></div></button>';

    }

    $('.show-keyword').html(html);
  }
</script>