<link href="<?php echo base_url(); ?>main_assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
<main class="page-content">


    <div class='container'>
        <div class="card">
            <div class="card-body">
                <h1>INSTALLATION &amp; CUSTOMIZATION GUIDE</h1>
                <p>Thank you for choosing Social Referral Finder (or SRF, for short). SRF helps you find people looking for recommendations related to topics you're interested in across your Facebook groups, without having to stay on Facebook all day long. In order for SRF to work, you have to first install our Chrome Extension, through which you can connect your groups and keep it running on one active tabs on Chrome and it will loop through your connected groups, lookup for new recommendations and send them to SRF.</p>
                <p>Before you begin receiving requests to your dashboard, you need to define your keywords or triggers.</p>

                <h2>1. Install Our Chrome Extension</h2>
                <p>Our Chrome Extension is important to loop through your connected Facebook Groups. Facebook has made several changes to their Groups API, and because of privacy concerns they have limited reading groups feed to the bare minimum. Our Chrome Extension will loop through groups in the background as if you were manually doing it on your computer, without needing to rely on Facebook's API to grab the data.</p>
                <p>Please install our Chrome Extension from the link below:</p>
                <p><a class='blue-link' target='_blank' href='https://chrome.google.com/webstore/detail/social-referral-finder/pkhhnkmokokfkgoolecgpkcgicjkcjnd'>https://chrome.google.com/webstore/detail/social-referral-finder/pkhhnkmokokfkgoolecgpkcgicjkcjnd</a></p>

                <p>Once installed, click the SRF icon from the extensions lists and log-in to your SRF account.</p>

                <h2>2. Connect Your Groups</h2>
                <p>Once you're logged-in through our Chrome Extension, click the SRF icon again and click the "Connect Groups" button.</p>
                <p>This will open all your Facebook Groups in a separate page inside Facebook, with "Connect Group" buttons next to all groups. To connected a group, simply click the button next to it. The status of the connection will show at the top of the page. If the group is already connected, or if you have reached your plan's group limit, then you will be notified.</p>
                <p>To <a class='blue-link' href='<?php echo base_url(); ?>ambass_groups_view'>disconnect groups</a>, please visit your SRF dashboard and then go to "Groups" under "Customize" from the left hand menu.</p>

                <h3>3. Define your keywords</h3>
                <p>A keyword is a word or phrase that needs to exists in the Facebook post/recommendation request before it goes to your dashboard. When you define a keyword, you will also be prompetd to define an optional "Recommended Reply", which is a common reply that gets copied to your clipboard upon seeing a requests.</p>
                <p>To <a class='blue-link' href='<?php echo base_url(); ?>ambass_key_view'>manage your keywords</a>, visit "Keywords" under "Customize" from your SRF dashboard's left menu.</p>
            </div>
        </div>
    </div>


</main>
<script src="<?php echo base_url(); ?>main_assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>main_assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
<script src="<?php echo base_url(); ?>main_assets/js/table-datatable.js"></script>