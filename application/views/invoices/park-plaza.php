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

        .padding-content {
            padding: 0 15px 0 15px !important;
        }
    </style>
</head>
<body>
<!--mpdf
<htmlpageheader name="myheader">
<table width="100%" style="background: #000000; padding: 15px">
    <tbody>
    <tr>
        <td width="50%">
            <img src="<?php echo base_url ( '/assets/MKW-Associates-white-bg.png' ) ?>" style="height: 80px; float:left;">
        </td>
        
        <td width="50%" align="right">
            <p style="color: #fff">
                <strong><u>Address:</u></strong>
                Office# MF-4, Asian Business Center, <br/> Entrance of Bahria Town Phase 7, G.T Road, <br/> Rawalpindi, Pakistan.
            </p>
            <br/>
            <p style="color: #fff">
                <strong><u>Contact No:</u></strong>
                +92 300 5287112, +92 333 5318960,
                <br/>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                +92 333 5192653, +92 333 8360124
            </p>
        </td>
    </tr>
    </tbody>
</table>
</htmlpageheader>
<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
mpdf-->


</body>
</html>