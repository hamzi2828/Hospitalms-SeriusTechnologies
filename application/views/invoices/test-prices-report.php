<?php header ( 'Content-Type: application/pdf' ); ?>
<html>
<head>
    <style>
        @page {
            size   : auto;
            header : myheader;
            footer : myfooter;
        }
        
        body {
            font-family : sans-serif;
            font-size   : 10pt;
        }
        
        p {
            margin : 0pt;
        }
        
        table.items {
            border : 0.1mm solid #000000;
        }
        
        table#print-info {
            border : 0;
        }
        
        td {
            vertical-align : top;
        }
        
        .items td {
            border-left  : 0.1mm solid #000000;
            border-right : 0.1mm solid #000000;
        }
        
        #print-info td {
            border-left  : 0;
            border-right : 0;
        }
        
        table thead td {
            background-color : #EEEEEE;
            text-align       : center;
            border           : 0.1mm solid #000000;
            font-variant     : small-caps;
        }
        
        .items td.blanktotal {
            background-color : #EEEEEE;
            border           : 0.1mm solid #000000;
            background-color : #FFFFFF;
            border           : 0mm none #000000;
            border-top       : 0.1mm solid #000000;
            border-right     : 0.1mm solid #000000;
        }
        
        .items td.totals {
            text-align  : right;
            border      : 0.1mm solid #000000;
            font-weight : 800 !important;
        }
        
        .items td.cost {
            text-align : center;
        }
        
        .totals {
            font-weight : 800 !important;
        }
        
        .parent {
            padding-left : 25px;
        }
        
        #print-info tr td {
            border-bottom : 1px dotted #000000;
            padding-left  : 0;
        }
    </style>
</head>
<body>
<!--mpdf
<htmlpageheader name="myheader">
    <?php require 'pdf-header.php'; ?>
</htmlpageheader>

<htmlpagefooter name="myfooter">
    <?php require 'pdf-footer.php'; ?>
</htmlpagefooter>

<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->
<?php require 'search-criteria.php'; ?>
<br>

<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> Test Prices Report </strong></h3>
        </td>
    </tr>
</table>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; margin-top: 10px;" cellpadding="8"
       border="1">
    <thead>
    <tr>
        <th width="5%"> Sr. No</th>
        <th align="left" width="10%"> Code</th>
        <th align="left" width="25%"> Name</th>
        <th align="left" width="10%"> Type</th>
        <th align="left" width="10%"> Category</th>
        <th align="left" width="25%"> Panel</th>
        <th align="left" width="15%"> Price</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $counter = 1;
        $net     = 0;
        if ( count ( $reports ) > 0 ) {
            foreach ( $reports as $report ) {
                $test   = get_test_by_id ( $report -> test_id );
                $panels = get_test_panels ( $report -> test_id );
                ?>
                <tr>
                    <td align="center"> <?php echo $counter++ ?> </td>
                    <td> <?php echo @$test -> code ?> </td>
                    <td> <?php echo @$test -> name ?> </td>
                    <td> <?php echo @ucwords ( $test -> type ) ?> </td>
                    <td> <?php echo @ucwords ( $test -> category ) ?> </td>
                    <td>
                        <?php
                            if ( count ( $panels ) > 0 ) {
                                foreach ( $panels as $panel ) {
                                    $panelInfo = get_panel_by_id ( $panel -> panel_id );
                                    echo $panelInfo -> name . '<br/>';
                                }
                            }
                        ?>
                    </td>
                    <td>
                        <?php
                            if ( count ( $panels ) > 0 ) {
                                foreach ( $panels as $panel ) {
                                    $net += $panel -> price;
                                    echo number_format ( $panel -> price, 2 ) . '<br/>';
                                }
                            }
                        ?>
                    </td>
                </tr>
                <?php
            }
        }
    ?>
    </tbody>
    <tfoot>
    <tr>
        <td colspan="6" align="right">
            <strong>Total</strong>
        </td>
        <td><?php echo number_format ( $net, 2 ) ?></td>
    </tr>
    </tfoot>
</table>

</body>
</html>
