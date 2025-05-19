<?php header ( 'Content-Type: application/pdf' ); ?>
<html>
<head>
    <style>
        @page {
            size: auto;
            header: myheader;
            footer: myfooter;
        }

        body {
            font-family: sans-serif;
            font-size: 10pt;
        }

        p {
            margin: 0pt;
        }

        table.items {
            border: 0.1mm solid #000000;
        }

        td {
            vertical-align: top;
        }

        .items td {
            border-left: 0.1mm solid #000000;
            border-right: 0.1mm solid #000000;
        }

        table thead td {
            background-color: #EEEEEE;
            text-align: center;
            border: 0.1mm solid #000000;
            font-variant: small-caps;
        }

        .items td.blanktotal {
            background-color: #EEEEEE;
            border: 0.1mm solid #000000;
            background-color: #FFFFFF;
            border: 0mm none #000000;
            border-top: 0.1mm solid #000000;
            border-right: 0.1mm solid #000000;
        }

        .items td.totals {
            text-align: right;
            border: 0.1mm solid #000000;
            font-weight: 800 !important;
        }

        .items td.cost {
            text-align: center;
        }

        .totals {
            font-weight: 800 !important;
        }

        .details {
            width: 100%;
            display: block;
            float: left;
            margin-bottom: 15px;
        }

        .left {
            width: 35%;
            float: left;
            display: block;
            border-right: 1px solid #a4a4a4;
            padding-right: 10px;
        }

        .right {
            width: 63%;
            float: right;
            display: block;
        }
    </style>
</head>
<body>
<!--mpdf
<htmlpageheader name="myheader">
<?php require_once 'pdf-header.php' ?>
</htmlpageheader>
<htmlpagefooter name="myfooter">
<div style="width:100%; display:block; text-align:right;">
    <small><b>Advice/Follow up:</b>
    
    <br/><br/><br/>
    _________________________________<br>
    <small><b>Doctor's Sign</b></small>
    <br/><br/><br/>
</div>
<?php require_once 'pdf-footer.php' ?>
</htmlpagefooter>
<sethtmlpageheader name="myheader" value="on" show-this-page="1"/>
<sethtmlpagefooter name="myfooter" value="on"/>
mpdf-->
<table width="100%">
    <tr>
        <td width="50%">
            <span style="font-weight: bold; font-size: 18pt;"></span>
            <span style="font-weight: bold; font-size: 10pt;"><br>
                
            </span>
            
        </td>
        <td width="50%" align="right" style="text-align: right;">
            <span style="font-weight: bold; font-size: 25pt;"></span>
            <br />
            <strong>Prescription Date:</strong> 
        </td>
    </tr>
</table>
<br /><br /><br />

<div class="left">
    <div class="details">
        
        <h3 style="border-bottom: 1px solid #a4a4a4; margin-top: -15px"><strong>Patient Information</strong></h3>
        EMR:
        <br>
        Name:
        <br>
        Age:
        <br>
        Gender:
        
    </div>
    <?php
      
        ?>
            <div class="details">
                <h3 style="border-bottom: 1px solid #a4a4a4"><strong>Patient Vitals</strong></h3>
                
            </div>
        
            <div class="details">
                <h3 style="border-bottom: 1px solid #a4a4a4"><strong>Patient Vitals</strong></h3>
                <br /><br /><br /><br />
            </div>
        

    
        <div class="details">
            <h3 style="border-bottom: 1px solid #a4a4a4"><strong>Complaints</strong></h3>
            
        </div>
    
        <div class="details">
            <h3 style="border-bottom: 1px solid #a4a4a4"><strong>Subjective Complaints</strong></h3>
            <br /><br /><br /><br /><br /><br /><br />
        </div>
    
        <div class="details">
            <h3 style="border-bottom: 1px solid #a4a4a4"><strong>Diagnosis</strong></h3>
            
        </div>
        
        <div class="details">
            <h3 style="border-bottom: 1px solid #a4a4a4"><strong>Objective Complaints</strong></h3>
            <br /><br /><br /><br /><br /><br /><br />
        </div>
</div>
<div class="right" style="margin-top: 10px">
    <h1 style="margin-top: -5px; margin-bottom: 0; margin-left: 3px"><strong>R<sub>x</sub></strong></h1>
    <div class="details">
 
    </div>
</div>
<div class="details">
    
            <h3 style="border-bottom: 1px solid #a4a4a4"><strong>Investigations (<small>Lab Tests</small>)</strong></h3>



</div>
</body>
</html>