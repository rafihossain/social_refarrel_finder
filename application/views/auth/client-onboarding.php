<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="<?php echo base_url(); ?>/main_assets/images/favicon.png" type="image/png" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="<?php echo base_url(); ?>main_assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>main_assets/css/bootstrap-extended.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>main_assets/css/style.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>main_assets/css/icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link href="<?php echo base_url(); ?>main_assets/css/pace.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css'>
    <link href="<?php echo base_url(); ?>main_assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <link href="<?php echo base_url() ?>main_assets/select2/css/select2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/css/selectize.bootstrap4.min.css" />

    <title>Social Referral Finder</title>

    <style>
        /* .bootstrap-select .text{
            color: #000 !important;
        } */
    </style>

</head>

<body>
    <!--start wrapper-->
    <section class="onboarding-header">
        <div class="container">
            <div class="header-details">
                <div class="logo">
                    <img src="<?php echo base_url(); ?>main_assets/images/onboarding-logo.png" alt="">
                </div>
                <div class="text">
                    <h2>Clinet onboarding</h2>
                    <p>Complete below steps before we recommend you the post</p>
                </div>
            </div>
        </div>
    </section>

    <section class="onboarding-content">
        <form method="post" action="<?php echo base_url(); ?>onboarding_registration">
            <div class="container">
                <div class="customize-tab">
                    <ul class="nav nav-tabs nav-primary" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button type="button" class="nav-link active w-100" data-bs-toggle="tab" href="#client-details" role="tab" aria-selected="true">
                                <div class="d-flex align-items-center">
                                    <div class="tab-icon">
                                    </div>
                                    <div class="tab-title"><i class="las la-suitcase"></i> Client Details</div>
                                </div>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button type="button" class="nav-link w-100" data-bs-toggle="tab" href="#assignfb-groups" role="tab" aria-selected="false">
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
                    <div class="tab-pane fade show active" id="client-details" role="tabpanel">
                        <div class="row">
                            <div class="col-12 col-lg-12 col-xl-12 ">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="client-details">
                                            <h4 class="text-primary">Client Details</h4>
                                            <br>

                                            <div class="client_form">
                                                <div class="row mb-4">
                                                    <div class="col-md-4">
                                                        <label class="form-label">Business Name</label>
                                                        <input type="text" class="form-control" name="business_name" placeholder="Business Name" id="businessName">
                                                        <span class="business_error text-danger"></span>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label">Contact Name</label>
                                                        <input type="text" class="form-control" name="contact_name" placeholder="Contact Name" id="contactName">
                                                        <span class="contact_error text-danger"></span>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label">Email</label>
                                                        <input type="email" class="form-control email" name="client_email" id="checkValidEmail" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" placeholder="Client Email">
                                                        <div class="error_show"></div>
                                                        <span class="email_error text-danger"></span>
                                                    </div>
                                                </div>

                                                <div class="row mb-4">
                                                    <div class="col-md-4">
                                                        <label class="form-label">Dashboard Username</label>
                                                        <input type="text" class="form-control" name="dashboard_user" placeholder="Dashboard Username" id="dashboardUser">
                                                        <span class="dashboard_error text-danger"></span>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label">Dashboard Password</label>
                                                        <input type="password" class="form-control dashboardPass" name="dashboard_pass" id="showPass" placeholder="Dashboard Password">
                                                        <div class="mt-2">
                                                            <input type="checkbox" onclick="myFunction()"> Show Password
                                                        </div>
                                                        <span class="password_error text-danger"></span>
                                                    </div>
                                                    <div class="col-md-12 info">
                                                        <i class="las la-info-circle"></i><span> This username & password will be your dashboard login credentials</span>
                                                    </div>
                                                </div>

                                                <div class="col-md-4 mb-4">
                                                    <label class="form-label">SRF Team Member</label>
                                                    <select name="srf_team" id="teamId" class="form-control team_search">
                                                        <option value="">---Select SRF Team Member---</option>
                                                        <?php foreach ($teamMembers as $teamMember) : ?>
                                                            <option value="<?= $teamMember['id']; ?>"><?= $teamMember['full_name']; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    <div class="teammember_error"></div>
                                                </div>

                                            </div>
                                            <div class="mt-2 col-12 text-end">
                                                <button type="button" class="btn btn-primary btnNext" id="clientInfoNextBtn">Next</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="assignfb-groups" role="tabpanel">
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
                                                            <label for="">Select All</label>
                                                            <select name="multiple_category[]" id="groupCategory" class="form-control" multiple size="8">

                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <h5 class="text-primary">Select groups (01)</h5>
                                                    <div class="groups_list">

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-4 col-12 text-end">
                                                <textarea name="group" class="d-none" id="groupData"></textarea>
                                                <button type="button" class="btn btn-primary btnPrevious">Back</button>
                                                <button type="button" class="btn btn-primary btnNext  ms-3">Next</button>
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

                                            <div class="mt-4 col-12 text-end">
                                                <textarea name="keyword" class="d-none" id="keywordData"></textarea>
                                                <button type="button" class="btn btn-primary btnPrevious">Back</button>
                                                <button type="button" class="btn btn-primary btnNext  ms-3">Next</button>
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
                            <a class="btn btn-outline-danger btn-rounded btn-lg" href="<?php echo base_url() ?>clientkeyword">Cancel</a>
                            <button type="submit" class="btn btn-primary ms-auto btn-rounded btn-lg saveKeyword">Save</button>
                        </div>

                    </div>
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


    <script src="<?php echo base_url(); ?>main_assets/js/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>main_assets/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url(); ?>main_assets/js/pace.min.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js'></script>
    <script src="<?php echo base_url() ?>main_assets/select2/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/js/standalone/selectize.min.js" integrity="sha512-pF+DNRwavWMukUv/LyzDyDMn8U2uvqYQdJN0Zvilr6DDo/56xPDZdDoyPDYZRSL4aOKO/FGKXTpzDyQJ8je8Qw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <script>
        var groupArray = [];
        var keywordArray = [];
        var crawler_id = 0;

        $(document).ready(function() {
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
                    var email = $('.email').val();
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
                        $('.email_error').html('please insert email');
                        $('.email').focus();

                        $('.email').keyup(function() {
                            $('.email_error').html('');
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
                // $('.error_show').html('<div class="alert alert-danger" role="alert">Enter validate email address!</div>');
                $('.error_show').html('<div class="alert alert-danger" role="alert">Enter validate email address!</div>');
            } else {
                $('.error_show').html('');
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
                            'crawler_id' : crawlerId,
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

                html += '<tr><td>' + g + ' <input type="hidden" name="crawler_id" value="'+ data[i].crawler_id +'"> </td><td class="text-wrap">' + data[i].fb_group_name + '</td><td class="text-wrap">' + data[i].fb_group_uri + '</td><td>' + data[i].group_category + '</td><td>' + data[i].type + '</td><td>' + (data[i].join_status == 1 ? '<span class="badge bg-success rounded-pill">Joined</span>' : '<span class="badge bg-warning rounded-pill text-black">Not joined</span>') + '</td><td><a class="btn btn-primary" onclick="clickFunctionEdit(' + i + ')" title="Edit"><i class="bi bi-pencil-fill"></i></a><a class="btn btn-danger" onclick="fbGroupDelete(' + i + ')" id="deleteGroup" title="Delete"><i class="bi bi-trash-fill"></i></a></td></tr>';
            }

            $('#fbtbody').html(html);

        }
        function fbGroupDelete(id) {
            groupArray.splice(id, 1);
            $('#groupData').val(groupArray)
            var html = "";

            for (var i = 0; i < groupArray.length; i++) {
                var g = i + 1;

                html += '<tr><td>' + g + '<input type="hidden" name="crawler_id" value="'+ groupArray[i].crawler_id +'"></td><td class="text-wrap">' + groupArray[i].fb_group_name + '</td><td class="text-wrap">' + groupArray[i].fb_group_uri + '</td><td>' + groupArray[i].group_category + '</td><td>' + groupArray[i].type + '</td><td>' + (groupArray[i].join_status == 1 ? '<span class="badge bg-success rounded-pill">Joined</span>' : '<span class="badge bg-warning rounded-pill text-black">Not joined</span>') + '</td><td><a class="btn btn-primary" onclick="clickFunctionEdit(' + i + ')" title="Edit"><i class="bi bi-pencil-fill"></i></a><a onclick="fbGroupDelete(' + i + ')" class="btn btn-danger" id="deleteGroup" data-id="" title="Delete"><i class="bi bi-trash-fill"></i></a></td></tr>';
            }

            $('#fbtbody').html(html);
        }
        function clickFunctionEdit(id) {
            // console.log(id);
            $('#clientFbGroupsModal').modal('show');
            var html = '';
            html += '<div class="row" id=""><div class="col-md-12 mb-2"><label class="form-label">FB Group Name</label><input type="hidden" name="crawler_id" class="crawler_id" value="'+ groupArray[id].crawler_id +'"><input type="text" class="form-control fb_group_name" name="group_name" placeholder="FB Group Name" value="' + groupArray[id].fb_group_name + '"></div><div class="col-12  mb-2"><label class="form-label">FB Group URL</label><input type="text" class="form-control fb_group_url" name="group_url" placeholder="FB Group URL" value="' + groupArray[id].fb_group_uri + '"></div><div class="col-12 mb-2"><label class="form-label">FB Group Category</label><input type="text" class="form-control fb_group_category" name="group_category" placeholder="FB Group Category" value="' + groupArray[id].group_category + '"></div><div class="col-12  mb-2"><label class="form-label">Type</label><select name="type" class="form-control fb_group_type"><option value="private">Private</option><option value="public">Public</option></select></div><div class="col-12  mb-2"><label class="form-label">Join Status</label><select name="join_status" class="form-control join_status"><option value="1">Join</option><option value="0">Not join</option></select></div><br><div class="col-12 "><button type="button" class="btn btn-primary px-5 w-100 group_replace" onclick="groupReplace(' + id + ')"> Update Groups</button></div></div>';
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

</body>

</html>