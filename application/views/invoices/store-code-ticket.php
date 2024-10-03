<?php header ( 'Content-Type: application/pdf' ); ?>
<?php require 'vendor/autoload.php'; ?>
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
            font-size: 25pt;
        }
    </style>
</head>
<body>

<table width="100%" border="0">
    <tbody>
    <tr>
        <td align="center"><?php echo $asset -> code ?></td>
    </tr>
    </tbody>
</table>

</body>
</html>