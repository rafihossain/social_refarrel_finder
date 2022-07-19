<link href="<?php echo base_url(); ?>main_assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/css/selectize.bootstrap4.min.css" />

<main class="page-content">
    <h4 class="text-primary mb-4">New Tag List <a class="btn text-light radius-30 bg-primary circlebtn" href="javascript:void(0)" id="clickFroFbGroup"><i class="m-0 bx bx-plus"></i></a> </h4>
    <?php 
        if($this->session->flashdata('success')){ ?>
            <div class="alert border-0 bg-light-success alert-dismissible fade show py-2">
                <div class="d-flex align-items-center">
                  <div class="fs-3 text-success"><i class="bi bi-check-circle-fill"></i>
                  </div>
                  <div class="ms-3">
                    <div class="text-success"><?php echo $this->session->flashdata('success');?></div>
                  </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
        <?php } ?>

    <div class="show_add_client_form">
        <form class="row g-3" method="post" action="<?php echo base_url(); ?>taglist_add">
            <div class="col-12">
                <label class="form-label">Tag List Name</label>
                <input type="text" class="form-control" name="tag_name" required>
            </div>
            <div class="col-12">
                <label class="form-label">Tags (comma separated)</label>
                <input type="text" id="input-tags" class="form-control" name="tag_list" required>
            </div>
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-primary px-5">Save Tag List</button>
            </div>
        </form>
    </div>

    <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>Tag List Name</th>
                    <th>Tags</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($managetags as $managetag) : ?>
                    <tr>
                        <td><?= $managetag->tag_list_name; ?></td>
                        <td><?= $managetag->tags; ?></td>
                        <td>
                            <a class="btn btn-sm btn-danger" id="tagDelete" data-id="<?= $managetag->id; ?>">
                                Remove Tag List
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</main>
<script src="<?php echo base_url(); ?>main_assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>main_assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
<script src="<?php echo base_url(); ?>main_assets/js/table-datatable.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/js/standalone/selectize.min.js" integrity="sha512-pF+DNRwavWMukUv/LyzDyDMn8U2uvqYQdJN0Zvilr6DDo/56xPDZdDoyPDYZRSL4aOKO/FGKXTpzDyQJ8je8Qw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    $(document).ready(function() {

        $("#input-tags").selectize({
            delimiter: ",",
            persist: false,
            create: function(input) {
                return {
                    value: input,
                    text: input,
                };
            },
        });

        $('.circlebtn').on('click', function() {
            $('.show_add_client_form').toggle();
        });
        
        //sweetalert
        $(document).on('click', '#tagDelete', function() {
        var tagId = $(this).attr('data-id');
        console.log(tagId);

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
                        url: "<?php echo base_url() ?>taglist_delete/" + tagId,
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

    })
</script>