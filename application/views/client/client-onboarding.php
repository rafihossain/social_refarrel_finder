<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css'>
<link href="<?php echo base_url(); ?>main_assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
<link href="<?php echo base_url() ?>main_assets/select2/css/select2.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/css/selectize.bootstrap4.min.css" />

<style>
    .cl_add_group {
        float: left;
        width: 100%;
    }
</style>

<!--start wrapper-->
<section class="onboarding-header">
    <div class="container">
        <div class="header-details">

            <div class="text">
                <h2>Clinet onboarding</h2>
                <p>Complete below steps before we recommend you the post</p>
            </div>
        </div>
    </div>
</section>

<main class="page-content">

    <?php if ($this->session->flashdata('success')) : ?>
        <div class="alert border-0 bg-light-success alert-dismissible fade show py-2">
            <div class="d-flex align-items-center">
                <div class="fs-3 text-success"><i class="bi bi-check-circle-fill"></i>
                </div>
                <div class="ms-3">
                    <div class="text-success"><?= $this->session->flashdata('success'); ?></div>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <section class="onboarding-content">
        <form method="post" action="<?php echo base_url(); ?>client_onboardingsubmit">
            <div class="container">
                <div class="customize-tab">
                    <ul class="nav nav-tabs nav-primary" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button type="button" class="nav-link active w-100" data-bs-toggle="tab" href="#assignfb-groups" role="tab" aria-selected="false">
                                <div class="d-flex align-items-center">
                                    <div class="tab-icon">
                                    </div>
                                    <div class="tab-title"><i class="lab la-facebook-f"></i> Assign Facebook Groups</div>
                                </div>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button type="button" class="nav-link w-100" data-bs-toggle="tab" href="#add-Keywords" role="tab" aria-selected="false">
                                <div class="d-flex align-items-center">
                                    <div class="tab-icon">
                                    </div>
                                    <div class="tab-title"><i class="las la-key"></i> Add Keywords</div>
                                </div>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button type="button" class="nav-link w-100" data-bs-toggle="tab" href="#notification-settings" role="tab" aria-selected="false">
                                <div class="d-flex align-items-center">
                                    <div class="tab-icon">
                                    </div>
                                    <div class="tab-title"><i class="lar la-bell"></i> Notification Settings</div>
                                </div>
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="tab-content rs-tab-content py-3">
                    <div class="tab-pane fade show active" id="assignfb-groups" role="tabpanel">
                        <div class="row">
                            <div class="col-12 col-lg-12 col-xl-12 ">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="facebook-group">
                                            <h4 class="text-primary">Assign Facebook Groups</h4>
                                            <br>

                                            <div class="row groups_categories g-0">
                                                <div class="col-md-4">
                                                    <div class="category-box">
                                                        <h5 class="text-primary">Group Categories</h5>
                                                        <div class="category-box-content">
                                                            <!-- <label for="">Select All</label> -->
                                                            <select name="multiple_category[]" id="groupCategory" class="form-control" multiple size="8">
                                                                <option value="<?= $crawlerinfo->id; ?>"><?= $crawlerinfo->full_name; ?></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <h5 class="text-primary">Select groups</h5>
                                                    <div class="groups_list">

                                                    </div>
                                                </div>
                                                <div class="col-12 text-center d-flex mt-2">
                                                    <div class="cl_add_group"></div>
                                                </div>
                                            </div>
                                            <div class="mt-4 col-12 text-end">
                                                <textarea name="group" class="d-none" id="groupData"></textarea>
                                                <button type="button" class="btn btn-primary btnPrevious">Back</button>
                                                <button type="button" class="btn btn-primary btnNext  ms-3" id="for_group">Next</button>
                                            </div>
                                        </div>

                                        <div class="table-responsive mt-5">
                                            <table id="client_fb_groups" border="0" class="table table-striped table-bordered" cellpadding="15">
                                                <thead>
                                                    <tr>
                                                        <th>Id</th>
                                                        <th>Name</th>
                                                        <th>URL</th>
                                                        <th>Category</th>
                                                        <th>Type</th>
                                                        <th>Join Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="fbtbody">

                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="add-Keywords" role="tabpanel">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="keyword-list">
                                            <h4 class="text-primary">Keywords</h4>
                                            <br>
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
                                                        <?php foreach ($suggested_keys as $suggestedKey) : ?>
                                                            <button type="button" class="btn rounded-pill btn-custome suggested-key mt-4" value="<?= $suggestedKey['keyword'] ?>"><?= $suggestedKey['keyword'] ?><i class="las la-times"></i></button>
                                                        <?php endforeach; ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="cl_add_keyword"></div>

                                            <div class="mt-4 col-12 text-end">
                                                <textarea name="keyword" class="d-none" id="keywordData"></textarea>
                                                <button type="button" class="btn btn-primary btnPrevious">Back</button>
                                                <button type="button" class="btn btn-primary btnNext ms-3" id="for_keywordData">Next</button>
                                            </div>
                                        </div>

                                        <div class="table-responsive mt-5">
                                            <table id="client_keyword" class="table table-striped table-bordered" style="width:100%">
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
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="notification-settings" role="tabpanel">
                        <div class="row">
                            <div class="col-12 col-lg-12 col-xl-12 ">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="notification-settings">
                                            <h4 class="text-primary">Notifications</h4>
                                            <br>

                                            <div class="notification_form">
                                                <div class="row mb-4">

                                                    <div class="col-md-8">
                                                        <label class="form-label">Email Addresses*</label>
                                                        <input type="text" class="form-control" name="notification_address" placeholder="Email Addressess" required>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <label class="form-label">Intervals</label>
                                                        <select class="form-control" name="notification_interval" id="notification_interval">
                                                            <option value="1">Every In 1 hour</option>
                                                            <option value="2">Every In 2 hour</option>
                                                            <option value="3">Every In 3 hour</option>
                                                            <option value="4">Every In 4 hour</option>
                                                            <option value="5">Every In 5 hour</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-12 info mt-2">
                                                        <i class="las la-info-circle"></i><span> You can add mulitple email addresses seprated by comma</span>
                                                    </div>
                                                </div>

                                                <div class="row mb-4">
                                                    <div class="col-md-4">
                                                        <label class="form-label">Time Zones</label>
                                                        <select class="form-control" name="notification_timezone" id="notification_timezone">
                                                            <?php
                                                            foreach ($timezones as $tz) : ?>
                                                                <option value="<?php echo $tz; ?>"><?php echo $tz; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label">Starts At*</label>
                                                        <input type="time" class="form-control" name="notification_starts" required>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label">Ends At*</label>
                                                        <input type="time" class="form-control" name="notification_ends" required>
                                                    </div>

                                                </div>

                                            </div>

                                            <div class="mt-4 col-12 text-end">
                                                <button type="button" class="btn btn-primary btnPrevious">Back</button>
                                                <button type="submit" class="btn btn-primary ms-3">Submit</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>

    <form method="post" action="<?= base_url() ?>client_fbgroupcsv" enctype="multipart/form-data">
        <input type="file" onchange="this.form.submit()" name="enter_csv" id="uploadCsvId" class="d-none" />
    </form>

    <!-- Client Table -->

    <div class="row d-none">
        <div class="col-sm-12">

            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Business name</th>
                            <th>Contact Name</th>
                            <th>Contact Email</th>
                            <th>Crawlers Name</th>
                            <th>View keyword</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($allClinets as $client) {  ?>
                            <tr>
                                <td><?php echo ($client['business_name'] != '' ? $client['business_name'] : '') ?></td>
                                <td><?php echo ($client['end_client'] != '' ? $client['end_client'] : '') ?></td>
                                <td><?php echo ($client['client_email'] != '' ? $client['client_email'] : '') ?></td>
                                <td>
                                    <?php getAllCrawlerUnderClient($client['end_client_id'], 0); ?>
                                </td>
                                <td> <a href="<?php echo base_url() ?>viewkeyword/<?php echo $client['end_client_id']; ?>">view keywords </a> </td>

                                <td> <a class="btn btn-primary " href="<?php echo base_url() ?>editclient/<?php echo $client['end_client_id']; ?>" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit"><i class="bi bi-pencil-fill"></i></a>
                                    <a class="btn btn-sm btn-danger" id="deleteClient" data-id="<?= $client['end_client_id']; ?>">
                                        <i class="bi bi-trash-fill"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>

                </table>
            </div>

        </div>
    </div>

    <!-- New Code End-->
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
                                    <option value="one">At least one keyword</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mb-4">
                        <!-- <div class="row"> -->
                        <!-- <div class="col-md-6"> -->
                        <label class="form-label">Must-Exclude Keyword(s) <i class="fa fa-question-circle"></i></label>
                        <input type="text" name="must_exclude_keywords" class="form-control" id="mustExcludeKeywords" placeholder="Insert your Must-Exclude keywords" />
                        <!-- </div> -->
                        <!-- <div class="col-md-6">
                              <label class="form-label">Must Exclude Condition(s) <i class="fa fa-question-circle"></i></label>
                              <input type="text" name="must_exclude_keywords" class="form-control" placeholder="Insert your Must-Exclude keywords" />
                           </div> -->
                        <!-- </div> -->
                    </div>
                    <div class="col-md-12 mb-4">
                        <div class="row">
                            <div class="col-md-8">
                                <label class="form-label">Your Recommended Reply for this keyword</label>
                                <input type="text" name="recommended_reply[]" class="form-control recommendedReply" placeholder="Recommended Reply..." />
                            </div>
                            <div class="col-md-4 ">
                                <button class="btn btn-dangers prplusbtn"> + </button>
                            </div>
                        </div>
                        <div id="append_html"></div>
                    </div>
                    <!-- <div class="col-md-12 d-flex text-center">
                        <button type="button" class="btn btn-white px-5">Cancel</button>
                        <button type="button" class="btn btn-primary px-5">Done</button>
                  </div> -->


                    <div class="col-md-12 d-flex mt-4">
                        <a class="btn btn-outline-danger btn-rounded btn-lg" data-bs-dismiss="modal">Cancel</a>
                        <button type="submit" class="btn btn-primary ms-auto btn-rounded btn-lg saveKeyword">Save</button>
                    </div>

                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!--  Modal content for the above example -->
<div id="crawlerModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myExtraLargeModalLabel">All Crawlers Name</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <table>
                    <tbody id="allCrawler">

                    </tbody>
                </table>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!--  Modal content for the above example -->
<div id="clientFbGroupsModal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myExtraLargeModalLabel">Update group information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="groups_update"></div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<script src="<?php echo base_url(); ?>main_assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>main_assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>

<script src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js'></script>
<script src="<?php echo base_url() ?>main_assets/select2/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/js/standalone/selectize.min.js" integrity="sha512-pF+DNRwavWMukUv/LyzDyDMn8U2uvqYQdJN0Zvilr6DDo/56xPDZdDoyPDYZRSL4aOKO/FGKXTpzDyQJ8je8Qw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    var groupArray = [];
    var keywordArray = [];
    var crawler_id = 0;

    $(document).ready(function() {

        /*==================================
              Crawler Modal Section
        ===================================*/

        $('.modalBtn').on('click', function() {
            $('#crawlerModal').modal('show');
            var crawlerVal = $(this).attr('data-id');

            $.ajax({
                url: "<?= base_url() ?>crawler_name",
                type: 'POST',
                data: {
                    crawlerVal: crawlerVal
                },
                success: function(data) {
                    var html = '';
                    $('#allCrawler').html(data);
                }
            });

        });

        /*==========================================
                 Get Crawler Group
        ============================================*/
        $('#groupCategory').on("change", function() {
            // alert('hi');
            crawler_id = $(this).val();

            $.ajax({
                url: "<?php echo base_url() ?>fb_group_category",
                type: "post",
                data: {
                    crawler_id: crawler_id
                },
                dataType: "JSON",

                success: function(data) {

                    var appendText = '';

                    if (data != undefined && data != '') {
                        for (var i = 0; i < data.length; i++) {

                            var check = ''
                            if (data[i].status == 1) {
                                check = "checked";
                            } else {
                                check = "";
                            }

                            var g = i + 1;
                            appendText += '<div class="group-list-item"><div class="check-box ' + check + '"><div class="checkbox_noselect"><input type="checkbox" ' + check + ' onChange="setData(' + data[i].id + ', this)" id="checkBoxItem_' + g + '" name="group_id" value="' + data[i].id + '"></div><label for="checkBoxItem_' + g + '" class="select_checkbox" data-id="' + g + '">' + data[i].fb_group_name + ' </label></div><div class="facebook-link"><a href="' + data[i].fb_group_uri + '">' + data[i].fb_group_uri + '</a></div></div>';

                            $('.groups_list').html(appendText);
                        }
                        g++;

                    } else {
                        $('.groups_list').html('<div class="alert alert-danger" role="alert">No Data Found.</div>');
                    }
                }
            });

        });


        $(document).on("click", ".rs-tab-content .checkbox_noselect input:checkbox", function() {
            $(this).parent().parent().toggleClass("checked");
        });


        $("#groups_categories select option").click(function() {
            $(this).toggleClass('active');
        });

        $('.addkeyword').click(function() {
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
        /*=============================
            Next Previous Button
        ===============================*/

        $('.btnNext').click(function() {
            var hasattr = $(this).attr('id');

            if (hasattr != undefined && hasattr == 'clientInfoNextBtn') {

                var businessName = $('#businessName').val();
                var contactName = $('#contactName').val();
                var email = $('.emailValiditeCheck').val();
                var dashboardUser = $('#dashboardUser').val();
                var dashboardPass = $('.dashboardPass').val();

                if (businessName.length == '') {
                    $('.business_error').html('please insert busseness name');
                    $('#businessName').focus();

                    $('#businessName').keyup(function() {
                        $('.business_error').html('');
                    });
                    return;
                }
                if (contactName.length == '') {
                    $('.contact_error').html('please insert contact name');
                    $('#contactName').focus();

                    $('#contactName').keyup(function() {
                        $('.contact_error').html('');
                    });
                    return;
                }
                if (email.length == '') {
                    $('.error_show').html('<span class="text-danger">please insert email</span>');
                    $('.emailValiditeCheck').focus();

                    $('.emailValiditeCheck').keyup(function() {
                        $('.error_show').html('');
                    });
                    return;
                }
                if (dashboardUser.length == '') {
                    $('.dashboard_error').html('please insert dashboard user');
                    $('#dashboardUser').focus();

                    $('#dashboardUser').keyup(function() {
                        $('.dashboard_error').html('');
                    });
                    return;
                }
                if (dashboardPass.length == '') {
                    $('.password_error').html('please insert dashboard password');
                    $('.dashboardPass').focus();

                    $('.dashboardPass').keyup(function() {
                        $('.password_error').html('');
                    });
                    return;
                }


                var selected = []
                selected = $('#teamId').val()
                if (selected.length == 0) {
                    $('.teammember_error').html('<div class="alert alert-danger" role="alert">Please Select Team Membar.</div>');
                    return;
                }
            }

            if (hasattr != undefined && hasattr == 'for_group') {
                if (groupArray.length == 0) {
                    $('.cl_add_group').html('<div class="alert alert-danger" role="alert">Please Select Group.</div>');
                    return;
                }
            }

            if (hasattr != undefined && hasattr == 'for_keywordData') {
                if (keywordArray.length == 0) {
                    $('.cl_add_keyword').html('<div class="alert alert-danger" role="alert">Please Add Keyword.</div>');
                    return;
                }

            }

            $('.nav-tabs .active').parent().next('li').children('button').trigger('click');
        });

        $('.btnPrevious').click(function() {
            $('.nav-tabs .active').parent().prev('li').children('button').trigger('click');
        });

        /*=============================
                SRF Team Member
        ===============================*/

        $('#teamId').on("change", function() {
            var Id = $(this).val();

            $.ajax({
                url: "<?php echo base_url() ?>/onboarding_team_depand/" + Id,
                type: "get",
                dataType: "JSON",
                success: function(data) {
                    // console.log(data);

                    $('#groupCategory').html('');
                    for (i = 0; i < data.length; i++) {
                        $('#groupCategory').append('<option value="' + data[i].user_id + '">' + data[i].full_name + '</option>');
                    }
                }
            });

        });

        /*=============================
                Check Email
        ===============================*/
        $(document).on('change', '#checkValidEmail', function() {
            var email = $(this).val();
            validateEmail(email);
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
            html += '<div class="col-md-8"><input type="text" name="recommended_reply[]" class="form-control recommendedReply" placeholder="Recommended Reply..." /></div>';
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

        $(document).on('change', '#checkValidEmail', function() {
            var email = $(this).val();
            validateEmail(email);

        });

        /*====================================
                Insert Keyword Table Data
        ======================================*/

        $('.saveKeyword').click(function() {
            $('#keywordModal').modal('hide');

            var keyword = $('#keyword').html();
            var mustIncludeKeywords = $('#mustIncludeKeywords').val();
            var mustIncludeCondition = $('#mustIncludeCondition').val();
            var mustExcludeKeywords = $('#mustExcludeKeywords').val();

            let storeRecom = [];
            $('.recommendedReply').each(function() {
                storeRecom.push($(this).val());
            });
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
            // console.log(arrKeyword);

            keywordArray.push(arrKeyword);

            $('#keywordData').val(JSON.stringify(keywordArray));
            showInsertedKeywordData(keywordArray);

        });

        //sweetalert

        $(document).on('click', '#deleteClient', function() {
            var Id = $(this).attr('data-id');

            swal({
                    title: "Are you sure?",
                    text: "You want to delete this file!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        swal("Success! Your file has been deleted!", {
                            icon: "success",
                        });

                        $.ajax({
                            url: "<?php echo base_url() ?>deleteclient/" + Id,
                            dataType: "JSON",
                            success: function(data) {
                                window.location.reload();
                            }
                        });
                    } else {
                        swal("Your file is safe!");
                    }

                });

        });



    });


    /*====================================
             Insert Keyword Table Data
    ======================================*/
    function keywordDelete(id) {
        keywordArray.splice(id, 1);

        var html = " ";
        for (i = 0; i < keywordArray.length; i++) {
            var g = i + 1;

            html += '<tr><td>' + g + '</td><td>' + keywordArray[i].keyword + '</td><td>' + keywordArray[i].must_include_keywords + '</td><td>' + keywordArray[i].must_include_condition + '</td><td>' + keywordArray[i].must_exclude_keywords + '</td><td>' + keywordArray[i].recommended_reply + '</td><td><a class="btn btn-danger" onclick="keywordDelete(' + i + ')" id="deleteGroup" title="Delete"><i class="bi bi-trash-fill"></i></a></td></tr>';
        }

        $('#keyTable').html(html);
    }

    function showInsertedKeywordData(data) {

        $('#keyword').val('');
        $('.recommendedReply').val('');
        $('#mustIncludeKeywords').val('');
        $('#mustIncludeCondition').val('');
        $('#mustExcludeKeywords').val('');

        var html = "";

        for (var i = 0; i < data.length; i++) {
            var g = i + 1;

            html += '<tr><td>' + g + '</td><td>' + data[i].keyword + '</td><td>' + data[i].must_include_keywords + '</td><td>' + data[i].must_include_condition + '</td><td>' + data[i].must_exclude_keywords + '</td><td>' + data[i].recommended_reply + '</td><td><a class="btn btn-danger" onclick="keywordDelete(' + i + ')" id="deleteGroup" title="Delete"><i class="bi bi-trash-fill"></i></a></td></tr>';
        }

        $('#keyTable').html(html);

    }

    function validateEmail(email) {
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        if (!emailReg.test(email)) {

            // alert('hi');
            // var email = $(this).val();
            // console.log(crawler_id);


            // $('.error_show').html('<div class="alert alert-danger" role="alert">Enter validate email address!</div>');
            $('.error_show').html('<div class="alert alert-danger" role="alert">Enter validate email address!</div>');
        } else {
            // $('.error_show').html('');
            $.ajax({
                url: "<?php echo base_url(); ?>email_validite_check",
                type: "post",
                data: {
                    email: email
                },
                success: function(data) {

                    if (data == 'success') {
                        $('.email_validite_message').html('<span class="text-success">Email Available !!</span>');
                        // $("#submitBtn").attr("disabled", false);
                    } else {
                        $('.email_validite_message').html('<span class="text-danger">This email is already taken! please enter new email address !!</span>');
                        // $("#submitBtn").attr("disabled", true);
                    }

                }
            });
        }
    }

    function myFunction() {
        var showPass = document.getElementById("showPass");

        if (showPass.type === 'password') {
            showPass.type = 'text';
        } else {
            showPass.type = 'password';
        }
    }

    function setData(x, y) {

        var action = '';
        var check = $("input:checkbox[value='" + x + "']").prop("checked");

        // console.log(check);

        if (check == true) {
            action = 'add';
        } else {
            action = 'delete';
        }

        $.ajax({
            url: "<?php echo base_url() ?>fetch_client_onboarding_groups",
            type: "post",
            data: {
                crawler_id: crawler_id,
                group_id: x,
                action: action
            },
            dataType: "JSON",
            success: function(data) {
                if (data.action == 'add') {
                    // console.log('group selected');
                    var fbGroupName = data.cgroupinfo.fb_group_name;
                    var fbGroupUrl = data.cgroupinfo.fb_group_uri;
                    var fbGroupCategory = data.cgroupinfo.group_category;
                    var fbGroupType = data.cgroupinfo.type;
                    var join_status = data.cgroupinfo.connected;

                    var crawlerId = data.cgroupinfo.crawler_id;


                    var myarr = {
                        'crawler_id': crawlerId,
                        'fb_group_name': fbGroupName,
                        'fb_group_uri': fbGroupUrl,
                        'group_category': fbGroupCategory,
                        'type': fbGroupType,
                        "join_status": join_status,
                    }

                    groupArray.push(myarr);

                    $('#groupData').val(JSON.stringify(groupArray));
                    showInsertedFbGroupData(groupArray);

                    // console.log(groupArray);
                }
            }
        });

    }

    function showInsertedFbGroupData(data) {
        var html = "";

        for (var i = 0; i < data.length; i++) {
            var g = i + 1;

            html += '<tr><td>' + g + ' <input type="hidden" name="crawler_id" value="' + data[i].crawler_id + '"> </td><td class="text-wrap">' + data[i].fb_group_name + '</td><td class="text-wrap">' + data[i].fb_group_uri + '</td><td>' + data[i].group_category + '</td><td>' + data[i].type + '</td><td>' + (data[i].join_status == 1 ? '<span class="badge bg-success rounded-pill">Joined</span>' : '<span class="badge bg-warning rounded-pill text-black">Not joined</span>') + '</td><td><a class="btn btn-primary" onclick="clickFunctionEdit(' + i + ')" title="Edit"><i class="bi bi-pencil-fill"></i></a><a class="btn btn-danger" onclick="fbGroupDelete(' + i + ')" id="deleteGroup" title="Delete"><i class="bi bi-trash-fill"></i></a></td></tr>';
        }

        $('#fbtbody').html(html);

    }

    function fbGroupDelete(id) {
        groupArray.splice(id, 1);
        $('#groupData').val(groupArray)
        var html = "";

        for (var i = 0; i < groupArray.length; i++) {
            var g = i + 1;

            html += '<tr><td>' + g + '<input type="hidden" name="crawler_id" value="' + groupArray[i].crawler_id + '"></td><td class="text-wrap">' + groupArray[i].fb_group_name + '</td><td class="text-wrap">' + groupArray[i].fb_group_uri + '</td><td>' + groupArray[i].group_category + '</td><td>' + groupArray[i].type + '</td><td>' + (groupArray[i].join_status == 1 ? '<span class="badge bg-success rounded-pill">Joined</span>' : '<span class="badge bg-warning rounded-pill text-black">Not joined</span>') + '</td><td><a class="btn btn-primary" onclick="clickFunctionEdit(' + i + ')" title="Edit"><i class="bi bi-pencil-fill"></i></a><a onclick="fbGroupDelete(' + i + ')" class="btn btn-danger" id="deleteGroup" data-id="" title="Delete"><i class="bi bi-trash-fill"></i></a></td></tr>';
        }

        $('#fbtbody').html(html);
    }

    function clickFunctionEdit(id) {
        // console.log(id);
        $('#clientFbGroupsModal').modal('show');
        var html = '';
        html += '<div class="row" id=""><div class="col-md-12 mb-2"><label class="form-label">FB Group Name</label><input type="hidden" name="crawler_id" class="crawler_id" value="' + groupArray[id].crawler_id + '"><input type="text" class="form-control fb_group_name" name="group_name" placeholder="FB Group Name" value="' + groupArray[id].fb_group_name + '"></div><div class="col-12  mb-2"><label class="form-label">FB Group URL</label><input type="text" class="form-control fb_group_url" name="group_url" placeholder="FB Group URL" value="' + groupArray[id].fb_group_uri + '"></div><div class="col-12 mb-2"><label class="form-label">FB Group Category</label><input type="text" class="form-control fb_group_category" name="group_category" placeholder="FB Group Category" value="' + groupArray[id].group_category + '"></div><div class="col-12  mb-2"><label class="form-label">Type</label><select name="type" class="form-control fb_group_type"><option value="private">Private</option><option value="public">Public</option></select></div><div class="col-12  mb-2"><label class="form-label">Join Status</label><select name="join_status" class="form-control join_status"><option value="1">Join</option><option value="0">Not join</option></select></div><br><div class="col-12 "><button type="button" class="btn btn-primary px-5 w-100 group_replace" onclick="groupReplace(' + id + ')"> Update Groups</button></div></div>';
        $('#groups_update').html(html);
    }

    function groupReplace(id) {
        $('#clientFbGroupsModal').modal('hide');

        var crawler_id = $('.crawler_id').val();
        var group_name = $('.fb_group_name').val();
        var group_url = $('.fb_group_url').val();
        var group_category = $('.fb_group_category').val();
        var type = $('.fb_group_type').val();
        var join_status = $('.join_status').val();

        var myarr = {
            'crawler_id': crawler_id,
            'fb_group_name': group_name,
            'fb_group_uri': group_url,
            'group_category': group_category,
            'type': type,
            "join_status": join_status
        }

        groupArray.splice(id, 1, myarr);

        $('#groupData').val(JSON.stringify(groupArray))
        showInsertedFbGroupData(groupArray);
    }
</script>