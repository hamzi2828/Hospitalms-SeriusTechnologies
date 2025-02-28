<style>
    .popup {
        position: fixed;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        z-index: 999;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .popup .content {
        z-index: 999;
        position: absolute;
        width: 50%;
        background: rgba(0, 0, 0, 1);
    }
    .popup .content p {
    
    }
    .popup .content button {
    
    }
    
    @media only screen and (max-width: 767px) {
        .popup .content {
            width: 90%;
            max-height: 700px;
            overflow: auto;
        }
    }
    <?php /* if (isset($_COOKIE['condition-accepted']) and $_COOKIE['condition-accepted'] == '1') : ?>
    .popup {
        display: none;
    }
    <?php endif */ ?>
</style>
<div class="popup">
    <div class="content">
        <p>This disclaimer details our obligations to you regarding Zobia Hospital, Islamabad. Using the Website implies that you accept the terms of this disclaimer. You are permitted to use our Online Reporting for your own purposes and to print and download material from this Website provided that you do not modify any content without our consent. Material on this website must not be republished online or offline without our permission.</p>
    
        <p>
            <strong>1. VISITOR CONDUCT</strong><br/>
            When using this website you shall not post or send to or from this Website any material for which you have not obtained all necessary consents, is discriminatory, obscene, pornographic, defamatory, liable to incite racial hatred, in breach of confidentiality or privacy, which may cause annoyance or inconvenience to others, which encourages or constitutes conduct that would be deemed a criminal offence, give rise to a civil liability, or otherwise is contrary to the law in Pakistan.
        </p>
    
        <p>
            <strong>2. EXCLUSION OF LIABILITY</strong><br/>
            We take all reasonable steps to ensure that the information on this Website is correct. However, we do not guarantee the correctness or completeness of material on this Website. Neither we nor any other party (whether or not involved in producing, maintaining or delivering this Website), shall be liability or responsible for any kind of loss or damage that may result to you or a third party as a result of your or their use of our website. This exclusion shall include servicing or repair costs and, without limitation, any other direct, indirect or consequential loss.
        </p>
    
        <p>
            <strong>3. LAW AND JURISDICTION</strong><br/>
            The report delivered through the Online Reporting is not valid for Court.
        </p>
    
    
        <p>
            <?php
                echo site_name . '<br/>';
                echo hospital_address . '<br/>';
                echo '☎ ' . hospital_phone . '<br/>';
            ?>
        </p>
    
        <form method="post">
            <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                   value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
            <input type="hidden" name="action" value="accept_conditions">
            <button type="button" class="btn btn-primary" id="accepted-terms">
                <i class="fa fa-check-circle"></i> Accept
            </button>
        </form>
    
    </div>
</div>

<div class="content">
    <!-- BEGIN LOGIN FORM -->
    <?php if(validation_errors() != false) { ?>
        <div class="alert alert-danger validation-errors">
            <?php echo validation_errors(); ?>
        </div>
    <?php } ?>
    <?php if($this -> session -> flashdata('error')) : ?>
        <div class="alert alert-danger">
            <?php echo $this -> session -> flashdata('error') ?>
        </div>
    <?php endif; ?>
    <?php if($this -> session -> flashdata('response')) : ?>
        <div class="alert alert-success">
            <?php echo $this -> session -> flashdata('response') ?>
        </div>
    <?php endif; ?>
    <form class="login-form" method="post">
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
        <input type="hidden" name="action" value="do_verify_invoice_info">
        <h4 class="form-title">Get Your Reports Online</h4>
        <div class="form-group">
            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
            <label class="control-label visible-ie8 visible-ie9">Invoice No.</label>
            <div class="input-icon">
                <i class="fa fa-user"></i>
                <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Invoice No." name="sale_id"/>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label visible-ie8 visible-ie9">Password</label>
            <div class="input-icon">
                <i class="fa fa-lock"></i>
                <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password"/>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn blue pull-right">
                Get Report <i class="m-icon-swapright m-icon-white"></i>
            </button>
        </div>
    </form>
    <!-- END LOGIN FORM -->
</div>

<script>
    jQuery(document).ready(function() {
        App.init();
    });
    jQuery ( '#accepted-terms' ).on ( 'click', function ( e ) {
        jQuery ( '.popup' ).hide ();
    } )
</script>