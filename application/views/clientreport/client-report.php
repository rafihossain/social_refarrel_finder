<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    

    <!-- Report styling -->
    <style>
        body {
            padding: 0;
            margin: 0;
            background-color: #fbfcfe;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        }

        h1,
        h2,
        h3 {
            color: #343c6a;
        }

        h1 {
            font-size: 36px;
            font-weight: 700;
        }

        h1.number {
            font-size: 50px;
            padding: 0;
            margin: 0;
            margin-top: 20px;
        }

        h2 {
            font-size: 28px;
        }

        h3 {
            font-size: 24px;
        }

        p,
        span,
        ul,
        li {
            color: #718fbf;
            font-size: 12px;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
        }

        .report-header {
            width: 100%;
            float: left;
            padding-top: 30px;
            padding-bottom: 30px;
            text-align: center;
        }

        .report-content {
            width: 100%;
            float: left;
        }

        .board {
            width: 98%;
            margin-left: 1%;
            margin-right: 1%;
            float: left;
            border-radius: 15px;
            background-color: #fff;
            border: 2px solid #e7f0f7;
            margin-bottom: 25px;
        }

        .board-content {
            width: 100%;
            margin-top: 15px;
            float: left;
            text-align: center;
        }

        .board-left {
            width: 70%;
            float: left;
        }

        .board-right {
            float: right;
            width: 30%;
        }

        .board-content .icon {
            margin-top: 20px;
            margin: 0 auto;
            width: 70px;
            height: 70px;
            background-color: #e7edff;
            border-radius: 50%;
        }

        .icon-img {
            margin-top: 15px;
            width: 35px;
            height: 35px;
        }

        .board-content .icon-requests {
            background-color: #fff5d9;
        }

        .board-content .icon-no-tags {
            background-color: #dcfaf8;
        }

        .block-container {
            width: 100%;
            float: left;
        }

        .block-1-1 {
            float: left;
            width: 98%;
            padding: 0 1%;
        }

        .block-1-2 {
            float: left;
            width: 48%;
            padding: 0 1%;
        }

        .block-1-3 {
            float: left;
            width: 33.33%;
        }

        .center {
            text-align: center;
        }

        .triggers-container {
            width: 100%;
            float: left;
            margin-bottom: 25px;
        }

        .trigger-card {
            float: left;
            width: calc(100% - 30px);
            border-radius: 15px;
            background-color: #fff;
            border: 2px solid #e7f0f7;
            margin-bottom: 10px;
            padding: 0 15px;
        }

        .product-insights {
            width: calc(100% - 30px);
            float: left;
            border-radius: 15px;
            background-color: #ffeaf4;
            padding: 10px 15px;
            margin-top: 35px;
            margin-bottom: 35px;
        }

        .product-insights .photo {
            width: 220px;
            height: 220px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 50%;
            text-align: center;
        }

        .product-insights .photo img {
            width: 150px;
            height: 150px;
            margin-top: 35px;
            overflow: hidden;
        }

        ul li {
            padding: 10px 0;
        }

        table {
            font-size: 12px;
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid #fbf2f6;
            text-align: left;
            padding: 8px;
        }

        tr {
            background-color: #fff;
        }

        tr:nth-child(even) {
            background-color: red;
        }
    </style>

</head>

<body>

    <div class="container">
        <div class="report-header">
            <img src="<?php echo base_url() ?>main_assets/report/social-referral-finder-logo.png" />
            <h1>Client Report</h1>
            <h2>
                <?php
                    echo date("m/d/Y", strtotime($client_reports['date_from'])) . ' - ' . 
                    date("m/d/Y", strtotime($client_reports['date_to']));
                ?>
            </h2>
            <p><?php echo $client_reports['client_name']; ?></p>
        </div>

        <div class="report-content">
            <h2>Summary</h2>
            <div class="block-container">

            <table border="0" style="width:100%" >

        <tbody>
            <tr>
                <td>
                <div class="block-1-3">
                    <div class="board">
                        <div class="board-content">
                            <div class="icon icon-requests" style="margin-top: 20px; margin: 0 auto; width: 70px; height: 70px; background-color: #e7edff; border-radius: 50%;">
                                <img class="icon-img" src="<?php echo base_url() ?>main_assets/report/thumbs-up-solid.png" />
                            </div>
                            <h1 class="number"><?php echo $total_groups_distinct; ?></h1>
                            <p>Total Requests</p>
                        </div>
                    </div>
                </div>
                </td>
                <td>
                <div class="block-1-3">
                    <div class="board">
                        <div class="board-content">
                            <div class="icon" style="margin-top: 20px; margin: 0 auto; width: 70px; height: 70px; background-color: #e7edff; border-radius: 50%;">
                                <img class="icon-img" src="<?php echo base_url() ?>main_assets/report/tag-solid.png" />
                            </div>
                            <h1 class="number"><?php echo $total_groups_distinct; ?></h1>
                            <p>Tagged</p>
                        </div>
                    </div>
                </div>
                </td>
                <td>
                <div class="block-1-3">
                    <div class="board">
                        <div class="board-content">
                            <div class="icon icon-no-tags" style="margin-top: 20px; margin: 0 auto; width: 70px; height: 70px; background-color: #e7edff; border-radius: 50%;">
                                <img class="icon-img" src="<?php echo base_url() ?>main_assets/report/empty-set-solid.png" />
                            </div>
                            <h1 class="number"><?php echo $total_non_tag_distinct; ?></h1>
                            <p>Non-Tagged</p>
                        </div>
                    </div>
                </div>
                </td>
            </tr>
        </tbody>

            </table>



                
                

           
            </div>

            <div class="center">

            <?php 
            $groups_count_name = "groups";

            if ($total_groups_distinct == 1){
                $groups_count_name = "group";
            }
            
            ?>
            
                <h3>Requests came from <?php echo $total_groups_distinct. ' ' .$groups_count_name ; ?> </h3>
            </div>

            <h2>Requests by Tags</h2>
            <p>The following table represents the total number of requets received grouped by each tag. Note that one request might have one or multiple tags applied to it, and as a result the summation of the requests in the table below might be greater than the total requests received.</p>

            <table>
                <thead>
                    <tr style="background-color: #ddd;">
                        <th>Tag</th>
                        <th>Requests</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
        
                    foreach($tagwise as $key => $val) : ?>
                        <tr>
                            <td><?php echo $key; ?></td>
                            <td><?php echo $val; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>


            <h2>Triggers List</h2>
            <p>The number of requests grouped by triggers:</p>
       <div class="triggers-container">
                <div class="trigger-card">
                <?php
        
        foreach($keywords as $keys) : ?>
                <p>
                <?php echo $keys->keyword; ?> |
                <strong>
                    <?php echo $keys->totalid; ?> requests
                </strong>
                </p>
        <?php endforeach; ?>

                    
                </div>

            </div> 

            <div class="product-insights">
                <div class="photo">
                    <img src="<?php echo base_url() ?>main_assets/report/product-insights.png">
                </div>
                <h2>Product Insights!</h2>
                <p><?php echo $client_reports['product_insights']; ?></p>
            </div>

            <h2>Glossary</h2>
            <p>Please find definitions for terms below:</p>

            <ul>
                <li>
                    <strong>Glossary: </strong>
                    Definitions of terms found in this report.
                </li>
            </ul>

        </div>
</body>

</html>