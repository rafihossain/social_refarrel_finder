<!DOCTYPE html>
<html>

<head>
    <title><?php echo $client; ?> Performance Report</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
</head>

<body>
    <br /><br />
    <div class="container" style="width:700px;">
        <h3 align="center"><?php echo $client; ?> Performance Report</h3><br />
        <form method="post" action="<?php echo base_url(); ?>generate_pdf">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <span class="">

                        <div style="text-align:left;position:relative;">
                            <table>
                                <tr>
                                    <td style="width:20%;">
                                        <span style="width:30%;">
                                            <img src="<?php echo $end_client_logo_url; ?>" alt="" height="85px">
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

                </table>
                <br />
                <input type="submit" name="generate_pdf" class="btn btn-danger" value="Create PDF"/>
            </div>
        </form>
    </div>
</body>

</html>