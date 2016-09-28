<?php
$vendor = isset( $vendor ) ? $vendor : yith_get_vendor( 'current', 'product' );
if( $vendor->is_valid() && $vendor->vacation_message ) : ?>
    <div class="vacation woocommerce-info">
        <i class="fa fa-calendar-times-o" aria-hidden="true"></i>
        <?php echo $vendor->vacation_message; ?>
    </div>
<?php endif; ?>