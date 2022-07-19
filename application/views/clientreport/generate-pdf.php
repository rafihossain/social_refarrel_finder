<!DOCTYPE html>
<html>

<head>
    <title><?php echo $client; ?> Performance Report</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
</head>

<body>
    <div class="container" style="width:700px;">
        <form method="post" action="<?php echo base_url(); ?>generate_pdf">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <span class="">
                        <div style="text-align:left;position:relative;">
                            <table>
                                <tr>
                                    <td style="width:20%;">
                                        <span style="width:30%;">
                                            <img src="<?php echo $end_client_logo_url; ?>" alt="end_client_logo_url" height="85px">
                                        </span>
                                    </td>
                                    <td>
                                        <span style="font-size:30px;font-weight:700;text-align:left;">
                                            <?php echo $end_client; ?>
                                        </span>
                                    </td>
                                </tr>
                            </table>

                        </div>

                        <!--<h1 style="text-decoration:none;margin-top:0px;">-->
                        <!--    Summary For: jondoe-->
                        <!--</h1><br /><br />-->

                        <h4 style="color:#001849;font-size:18px;">
                            Number of groups currently monitored:
                            <?php
                                if($groupsmonitored){
                                    $groups_monitored = number_format($groupsmonitored);
                                }else{
                                    $groups_monitored = 'N/A';
                                }
                            ?>
                            <span style="color:black;"><?php echo $groups_monitored; ?></span>
                        </h4>

                        <h4 style="color:#001849;font-size:18px;">
                            Number of posts reviewed: 

                            <?php
                                if($postsreviewed){
                                    $posts_reviewed = number_format($postsreviewed);
                                }else{
                                    $posts_reviewed = 'N/A';
                                }
                            ?>

                            <span style="color:black;"><?php echo $posts_reviewed; ?></span>
                        </h4>

                        <h4 style="color:#001849;font-size:18px;"> 
                            Number of comments made:
                            <?php
                                if($commentsreviewed){
                                    $comments_made = number_format($commentsreviewed);
                                }else{
                                    $comments_made = 'N/A';
                                }
                            ?>
                            <span style="color:black;"><?php echo $comments_made; ?></span>
                        </h4>

                        <h4 style="color:#001849;font-size:18px;">
                            Relevancy Rate:
                            <?php
                                $posts_reviewed = intval(preg_replace('/[^\d.]/', '', $posts_reviewed));
                                $comments_made = intval(preg_replace('/[^\d.]/', '', $comments_made));

                                if($posts_reviewed != 0 && $posts_reviewed != 'N/A' && $comments_made != 'N/A'){
                                    $percent_relevant =intval(($comments_made/$posts_reviewed)*100);
                                }else{
                                    $percent_relevant = 'N/A';				
                                }
                            ?>
                            <span style="color:black;"><?php echo $percent_relevant; ?>%</span>
                        </h4>

                    </span>

                    <!--<div class="">-->
                    <!--    <h1 style="text-decoration:none;text-align:left;">-->
                    <!--        HISTORICAL TRACKING SUMMARY CHART-->
                    <!--    </h1><br /><br />-->

                    <!--    <table border="1" cellspacing="0" cellpadding="5" width="100%">-->
                    <!--        <tr style="background-color:#001849;color:white;font-weight:800;text-align:center;">-->
                    <!--            <th>Alert Reviewed</th>-->
                    <!--            <th>Comments Made</th>-->
                    <!--            <th>Relevancy rate %</th>-->
                    <!--            <th>Page Views</th>-->
                    <!--            <th>Bounce Rate</th>-->
                    <!--        </tr>-->
                    <!--        <tr>-->
                    <!--            <td></td>-->
                    <!--            <td></td>-->
                    <!--            <td></td>-->
                    <!--            <td></td>-->
                    <!--            <td></td>-->
                    <!--        </tr>-->
                    <!--    </table>-->

                    <!--</div>-->
                </table>
                <br />

                <div class="col-sm-12 text-left cover page"> 
                    <h1>TRENDS & INSIGHTS</h1>
                    <ul>
                        <?php if($insights_1 != null && $insights_1 !='') : ?>
                            <li><?php echo $insights_1; ?></li>
                        <?php endif; ?>
                        <?php if($insights_2 != null && $insights_2 !='') : ?>
                            <li><?php echo $insights_2; ?></li>
                        <?php endif; ?>
                        <?php if($insights_3 != null && $insights_3 !='') : ?>
                            <li><?php echo $insights_3; ?></li>
                        <?php endif; ?>
                    </ul>
                </div>

                <div class="" style="text-align:left;"> 
                    <h1>UPDATES & IMPROVEMENTS</h1>
                    <?php if($tweaks != null && $tweaks !='') : ?>
                        <p style="font-size:16px;color:#001849;"><?php echo $tweaks; ?></p>
                    <?php endif; ?>
                </div>

                <div class="col-sm-12 text-left cover page" style="text-align:left;"> 
                    <h1>POST & COMMENT EXAMPLES</h1>
                    <?php if($image_1 != null && $image_1 !='') : ?>
                        <div><img src="<?= base_url('main_assets/uploads/' . $image_1) ?>" alt="" width="350px"></div>
                    <?php endif; ?>
                    <?php if($image_2 != null && $image_2 !='') : ?>
                        <div><img src="<?= base_url('main_assets/uploads/' . $image_2) ?>" alt="" width="350px"></div>
                    <?php endif; ?>
                    <?php if($image_3 != null && $image_3 !='') : ?>
                        <div><img src="<?= base_url('main_assets/uploads/' . $image_3) ?>" alt="" width="350px"></div>
                    <?php endif; ?>
                    <?php if($image_4 != null && $image_4 !='') : ?>
                        <div><img src="<?= base_url('main_assets/uploads/' . $image_4) ?>" alt="" width="350px"></div>
                    <?php endif; ?>
                    <?php if($image_5 != null && $image_5 !='') : ?>
                        <div><img src="<?= base_url('main_assets/uploads/' . $image_5) ?>" alt="" width="350px"></div>
                    <?php endif; ?>
                    <?php if($image_6 != null && $image_6 !='') : ?>
                        <div><img src="<?= base_url('main_assets/uploads/' . $image_6) ?>" alt="" width="350px"></div>
                    <?php endif; ?>
                </div>

                </div>

                <div class="col-sm-12 text-left cover page" style="padding-left:10%; padding-right:10%;text-align:left;">
                    <center>
                            <h1 style="color:#001849;">If you have any questions or concerns regarding this report, please reach out to <b style="color:black;">Mariah Smith</b> at SRF via email at <br><br><span style="color:black;">mariah@socialreferralfinder.com</span>
                            <br><br>
                            <b>Your feedback is always appreciated!</b>
                        </h1>
                    </center>
                </div>

            </div>
        </form>
    </div>
</body>

</html>