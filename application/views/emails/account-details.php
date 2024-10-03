<style>
    #order-content {
        width: 100%;
        float: left;
        display: block;
        box-sizing: border-box;
        background: #f5f5f5;
    }
    table {
        border-collapse: collapse;
        border-spacing: 0;
        width: 100%;
        table-layout: fixed; /* NEW */
    }
    .page-size {
        width: 760px;
        display: block;
        margin: 0 auto 25px auto;
        background: #fff;
        padding: 8px 8px 25px 8px;
    }
    td {
        padding: 7px 15px 0 15px;
        font-weight: 400;
    }
    .activate-link {
        background: #1AB385;
        padding: 5px 25px 10px 25px;
        margin-bottom: 25px;
        color: #fff;
        text-decoration: none;
    }
    .details-reg {
        font-size: 14px;
        padding: 10px 15px 5px 15px;
        border-bottom: 1px solid #a4a4a4;
        margin-bottom: 25px;
        float: left;
        width: 95%;
    }
    .account-credentials {
        font-weight: 600;
        font-size: 14px;
    }
</style>
<div id="order-content">
    <div style="width: 100%;float: left;display: table;margin-top: 25px;">
        <div class="page-size">
            <table style="width: 100%;margin-top: 25px">
                <tr>
                    <td style="width: 48%;float: left;">
                        <a href="<?php echo base_url() ?>" class="xs-logo">
                            <img src="<?php echo base_url() ?>/assets/img/logo.png">
                        </a>
                    </td>
                    <td style="width: 24%;float: right;line-height: 22px;text-align: right;">
                       <?php echo hospital_address ?>
                    </td>
                </tr>
            </table>

            <table style="width: 100%;margin-top: 25px; background: #f5f5f5;padding: 8px;color: #000;font-size: 16px;line-height: 24px;font-weight: 600;">
                <tr>
                    <td class="details-reg">
                        Thank you for becoming a member of our Hospital. Please find you login detail below. You need to use these credentials in order to login to your system. <br>
                        <b>Note:</b> Make sure you do not give these credentials to anyone. Our system is really strict and tracks every user record on daily basis. <br>
                        Before login you need to activate your account. Please click on activate account link.
                    </td>
                </tr>
                <tr>
                    <td class="account-credentials">Username: <?php echo $username ?></td>
                </tr>
                <tr>
                    <td class="account-credentials">Email: <?php echo $email ?></td>
                </tr>
                <tr>
                    <td class="account-credentials">Password: <?php echo $password ?></td>
                </tr>
                <tr>
                    <td style="padding: 25px 15px;">
                        <a href="<?php echo base_url('/activate/?email='.$email) ?>" class="activate-link">
                            Activate account
                        </a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>