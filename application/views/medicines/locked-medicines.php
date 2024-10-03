<style>
    .locked-medicines {
        display: flex;
        position: absolute;
        justify-content: end;
        top: 0;
        right: 0;
    }
    
    .locked-medicines .medicines {
        background: #fff;
        width: 500px;
        display: flex;
        height: 200px;
        margin: 100px 20px;
        border-radius: 8px !important;
        border: 1px solid #000;
        padding: 15px;
        flex-direction: column;
    }
    
    .locked-medicines .medicines .heading {
        border-bottom: 1px solid #000;
        display: flex;
        width: 100%;
        justify-content: space-between;
        margin-bottom: 10px;
    }
    
    .locked-medicines .medicines .heading h4 {
    
    }
    
    .locked-medicines .medicines .heading a {
        font-size: 24px;
        color: #000;
    }
    
    .locked-medicines .medicines ol {
        padding: 0 20px;
        overflow: auto;
    }
    
    .locked-medicines .medicines ol li {
        margin-bottom: 10px;
    }
</style>
<?php if ( count ( $medicines ) > 0 ) : ?>
    <div class="locked-medicines">
        <div class="medicines">
            <div class="heading">
                <h4>Locked Medicines</h4>
                <a href="javascript:void(0)" id="close-popup">
                    <i class="fa fa-times-circle"></i>
                </a>
            </div>
            <ol>
                <?php
                    foreach ( $medicines as $medicine ) {
                        ?>
                        <li>
                            <?php
                                $name = $medicine -> name;
                                
                                if ( $medicine -> form_id > 1 )
                                    $name .= get_form ( $medicine -> form_id ) -> title;
                                
                                if ( $medicine -> strength_id > 1 )
                                    $name .= ' - ' . get_strength ( $medicine -> strength_id ) -> title;
                                
                                echo '<strong>' . $name . '</strong>' . ' with batch ' . '<strong>' . $medicine -> batch . '</strong>' . ' locked by ' . '<strong>' . $medicine -> user . '</strong>';
                            ?>
                        </li>
                        <?php
                    }
                ?>
            </ol>
        </div>
    </div>
<?php endif; ?>