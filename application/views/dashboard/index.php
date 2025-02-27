<!-- BEGIN DASHBOARD STATS -->
<div class="row">
    <div class="col-xs-12">
        <div class="header-container greetings">
            <div class="logo">
                <img class="img-responsive" src="<?php echo base_url('/assets/img/dashlogo.png'); ?>" alt="Logo"/>
            </div>
            <h1>
                <span> <?php echo site_name ?> </span>
            </h1>
        </div>
        
    </div>
</div>
<!-- END DASHBOARD STATS -->

<style>
    .header-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        width: 100%;
        margin-top: 1px;
    }

    .logo img {
        width: 250px; 
        display: block;
    }

    .site-title {
        text-align: center;
        font-size: 50px;
        font-weight: 800;
        margin-top: 10px; /* Adjust spacing */
        color: #333;
    }

    .greetings {
        width: 100%;
        height: 350px;
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        margin-bottom: 80px;
    }

    .greetings h1 {
        font-weight: 900 !important;
    }
    .greetings span {
        font-size: 50px;
        font-weight: 800;
    }
</style>
