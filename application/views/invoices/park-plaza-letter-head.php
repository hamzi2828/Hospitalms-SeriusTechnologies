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
<table width="100%">
    <tbody>
    <tr>
        <td width="50%" style="padding: 15px 15px 0 15px">
            <img src="<?php echo base_url ( '/assets/Park-view-black.jpg' ) ?>" style="height: 100px; float:left;">
        </td>
        
        <td width="50%" style="float: right; text-align: right; padding: 15px 15px 0 15px; font-size: 12pt">
            <p style="color: #000">
                <strong><u>Address:</u></strong>
                Office# MF-4, Asian Business Center, <br/> Entrance of Bahria Town Phase 7, G.T Road, <br/> Rawalpindi, Pakistan.
            </p>
        </td>
    </tr>
    </tbody>
</table>
<hr/>
</htmlpageheader>
<htmlpagefooter name="myfooter">
<div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 4mm;">
    <strong>Site Address:</strong>
    Plot No 8A, Overseas East, Sector D, Capital Smart City, Islamabad, Pakistan.
</div>
</htmlpagefooter>
<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->


</body>
</html>