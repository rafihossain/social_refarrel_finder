<link href="<?php echo base_url(); ?>main_assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/css/selectize.bootstrap4.min.css" />

<main class="page-content">
    <div class="card">
        <div class="card-body">
            <h2>Edit Facebook Group</h2>

            <form method="post" action="<?= base_url() ?>editgroup/<?= $gid; ?>/<?= $id; ?>">
                <div class="col-12 mb-2">
                    <label class="form-label">FB Group Name</label>
                    <input type="text" class="form-control group_name" name="group_name" value="<?= $getgroupdata->fb_group_name; ?>">
                </div>
                <div class="col-12  mb-2">
                    <label class="form-label">FB Group URL</label>
                    <input type="text" class="form-control group_url" name="group_url" value="<?= $getgroupdata->fb_group_uri; ?>">
                </div>
                <div class="col-12  mb-2">
                    <label class="form-label">FB Group Category</label>
                    <input type="text" class="form-control" name="group_category" value="<?= $getgroupdata->group_category; ?>">
                </div>

                <div class="col-12 mb-2">
                    <label class="form-label">Type</label>
                    <select name="type" id="type" class="form-control type">
                        <option value="private"
                            <?php if($getgroupdata->type == 'private') {echo 'selected';} ?>
                        >Private</option>
                        <option value="public"
                            <?php if($getgroupdata->type == 'public') {echo 'selected';} ?>
                        >public</option>
                    </select>
                </div>
                <br>
                <div class="d-flex mt-4">
                    <a class="btn btn-outline-danger btn-rounded" href="<?= base_url() ?>editcrawler/<?= $gid; ?>">Cancel</a>
                    <button type="submit" class="btn btn-primary ms-auto btn-rounded">Update</button>
                </div>
            </form>

        </div>
    </div>

</main>