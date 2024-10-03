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
<?php if ( count ( $stores ) > 0 ) : ?>
    <div class="locked-medicines">
        <div class="medicines">
            <div class="heading">
                <h4>Locked Stock</h4>
                <a href="javascript:void(0)" id="close-popup">
                    <i class="fa fa-times-circle"></i>
                </a>
            </div>
            <ol>
                <?php
                    foreach ( $stores as $store ) {
                        ?>
                        <li>
                            <?php
                                $name = $store -> name;
                                echo '<strong>' . $name . '</strong>' . ' with batch ' . '<strong>' . $store -> batch . '</strong>' . ' locked by ' . '<strong>' . $store -> user . '</strong>';
                            ?>
                        </li>
                        <?php
                    }
                ?>
            </ol>
        </div>
    </div>
<?php endif; ?>