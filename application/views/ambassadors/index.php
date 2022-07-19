<link href="<?php echo base_url(); ?>main_assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css'>

<header class="top-header">
    <nav class="navbar navbar-expand gap-3 d-md-none ">
        <div class="mobile-toggle-icon fs-3">
            <i class="bi bi-list"></i>
        </div>
    </nav>
    <div class="header-page">
        <h4 class="heading-title">Ambassadors</h4>
    </div>
</header>

<main class="page-content">
    <h4 class="text-primary mb-4">Ambassadors <a class="btn text-light radius-30 bg-primary circlebtn" href="javascript:void(0)" id="clickFroFbGroup"><i class="m-0 bx bx-plus"></i></a> </h4>
    <div class="show_add_client_form">
        <form class="row g-3" method="post" action="<?php echo base_url(); ?>ambassadors_add">
            <div class="col-12">
                <label class="form-label">Name</label>
                <input type="text" class="form-control" name="name" required>
            </div>
            <div class="col-12">
                <label class="form-label">Email</label>
                <input name="email" type="email" id="emailValiditeCheck" class="form-control" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required>

                <div class="email_validite_message"></div>
            </div>
            <div class="col-12">
                <label class="form-label">Password</label>
                <input type="text" class="form-control" name="password" required>
            </div>
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-primary px-5" id="submitBtn">Submit</button>
            </div>
        </form>
    </div>

    <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Assign Clients</th>
                    <th>Reports</th>
                    <th>Active</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ambassadors as $ambassador) {  ?>
                    <form action="" id="reports" class="form-inline">
                        <tr>

                            <td><?php echo ($ambassador->full_name != '' ? $ambassador->full_name : '') ?></td>
                            <td><?php echo ($ambassador->email != '' ? $ambassador->email : '') ?></td>
                            <td>

                                <select id="" class="selectpicker" data-live-search="true" clid="<?php echo $ambassador->id; ?>" data-actions-box="true" multiple>
                                    <?php foreach ($clients as $client) { ?>
                                        <option value="<?php echo $client->id; ?>" <?php echo (in_array($client->id, $ambassador->clients) ? 'selected' : '')  ?>><?php echo $client->full_name; ?></option>
                                    <?php  }   ?>
                                </select>


                            </td>
                            <td>
                                <div class="form-check">
                                    <label class="form-check-label" for="dailyReport">Daily Report</label>
                                    <input type="checkbox" class="form-check-input selectItem" clid="<?php echo $ambassador->id; ?>" value="1" id="dailyReport" name="daily_progress" <?php if ($ambassador->reports != '' && $ambassador->reports->daily_progress == 1) {
                                                                                                                                                                                            echo "checked";
                                                                                                                                                                                        } ?>>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="weeklyReport">Weekly Report</label>
                                    <input type="checkbox" class="form-check-input selectItem" clid="<?php echo $ambassador->id; ?>" value="1" id="weeklyReport" name="weekly_progress" <?php if ($ambassador->reports != '' && $ambassador->reports->weekly_progress == 1) {
                                                                                                                                                                                            echo "checked";
                                                                                                                                                                                        } ?>>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="pickItUp">Pick it up</label>
                                    <input type="checkbox" class="form-check-input selectItem" clid="<?php echo $ambassador->id; ?>" value="1" id="pickItUp" name="pick_it_up" <?php if ($ambassador->reports != '' &&  $ambassador->reports->pick_it_up == 1) {
                                                                                                                                                                                    echo "checked";
                                                                                                                                                                                } ?>>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex justify-content-between">
                                    <?php if ($ambassador->active  ==  1) { ?>
                                        <a class="btn btn-danger" id="ambassadorDeactive" data-id="<?= $ambassador->id; ?>" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Deactive">Deactive</a>
                                    <?php } else { ?>
                                        <a class="btn btn-primary" href="<?php echo base_url(); ?>activeuser/<?php echo $ambassador->id ?>" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Active">Active</a>
                                    <?php } ?>
    
                                    <a href="<?= base_url() ?>ambassadors_edit/<?= $ambassador->id; ?>" class="btn btn-info" title="Edit">Edit</a>
                                </div>
                            </td>
                        </tr>
                    </form>
                <?php } ?>
            </tbody>
        </table>
    </div>

</main>
<script src="<?php echo base_url(); ?>main_assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>main_assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
<script src="<?php echo base_url(); ?>main_assets/js/table-datatable.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js'></script>

<script>
    $(document).ready(function() {

        $('.selectpicker').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
            var ambassador_id = $(this).attr("clid");
            var client_id = $(this).find('option').eq(clickedIndex).val();
            if (isSelected == true) {
                var action = "add";
            } else {
                var action = "delete";
            }
            $.ajax({
                url: "<?php echo base_url(); ?>ambassadors_dropdown",
                type: "post",
                data: {
                    ambassador_id: ambassador_id,
                    client_id: client_id,
                    action: action,
                },
                dataType: "JSON",
                success: function(data) {

                }
            });
        });

        $('.circlebtn').on('click', function() {
            $('.show_add_client_form').toggle();
        });

        $('.selectItem').on('change', function() {
            var name = $(this).attr('name');
            var ambassador_id = $(this).attr("clid");
            var issetval = 0;

            if (this.checked) {
                issetval = 1;
            }
            $.ajax({
                url: "<?php echo base_url(); ?>ambassadors_report",
                type: "post",
                data: {
                    "name": name,
                    "ambassador_id": ambassador_id,
                    "issetval": issetval
                },
                success: function(data) {
                    console.log(data);
                }
            });

        });

        //sweetalert
        $(document).on('click', '#ambassadorDeactive', function() {
            var Id = $(this).attr('data-id');
            // console.log(Id);

            swal({
                    title: "Are you sure?",
                    text: "You want to deactive this report!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        swal("Success! deactivated!", {
                            icon: "success",
                        });

                        $.ajax({
                            url: "<?php echo base_url(); ?>deactiveuser/" + Id,
                            dataType: "JSON",
                            success: function(data) {
                                window.location.reload();
                            }
                        });
                    } else {
                        swal("Your report is safe!");
                    }

                });

        });

        $('#emailValiditeCheck').on("change", function() {
            // alert('hi');
            var email = $(this).val();
            // console.log(crawler_id);
            $.ajax({
                url: "<?php echo base_url(); ?>email_validite_check",
                type: "post",
                data: {
                    email: email
                },
                success: function(data) {

                    if (data == 'success') {
                        $('.email_validite_message').html('<span class="text-success">Email Available !!</span>');
                        $("#submitBtn").attr("disabled", false);
                    } else {
                        $('.email_validite_message').html('<span class="text-danger">This email is already taken! please enter new email address !!</span>');
                        $("#submitBtn").attr("disabled", true);
                    }

                }
            });

        });


    });
</script>