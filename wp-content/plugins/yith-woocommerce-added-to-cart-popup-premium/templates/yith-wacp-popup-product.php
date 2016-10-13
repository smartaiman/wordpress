<?php
/*
 * This file belongs to the YIT Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 *
 */
/**
 * Popup product template
 *
 * @version 1.1.0
 */

// get cart
$cart = WC()->cart->get_cart();
// get cart info
$cart_info = yith_wacp_get_cart_info();

?>

<?php if( $thumb ) : ?>
	<div class="product-thumb">
			<?php
			$thumbnail = $product->get_image( 'yith_wacp_image_size' );

			if ( ! $product->is_visible() ) {
				echo $thumbnail;
			} else {
				printf( '<a href="%s">%s</a>', esc_url( $product->get_permalink() ), $thumbnail );
			}

			?>
	</div>
<?php endif; ?>

<div class="info-box">

	<div class="product-info">
		<h3 class="product-title">
			<a href="<?php echo esc_url( $product->get_permalink() ) ?>">
				<?php echo $product->get_title(); ?>
			</a>
		</h3>
		<span class="product-price">
			<?php echo $product->get_price_html(); ?>
		</span>
		<?php if( $product->product_type == 'variation' && get_option( 'yith-wacp-show-product-variation' ) == 'yes' ) : ?>
			<div class="product-variation">
				<?php foreach( $cart as $key => $value ) {
					if( isset( $value['variation_id'] ) && $value['variation_id'] == $product->variation_id ){
						// Meta data
						echo WC()->cart->get_item_data( $cart[$key] );
						break;
					}
				}?>
			</div>
		<?php endif; ?>
	</div>

	<?php if( ( $cart_shipping || $cart_total || $cart_tax ) && ! empty( $cart ) ) : ?>

	<div class="cart-info">
		<?php if( $cart_shipping && isset( $cart_info['shipping'] ) ) :	?>
			<div class="cart-shipping">
				<?php echo __( 'Shipping Cost', 'yith-woocommerce-added-to-cart-popup' ) . ':' ?>
				<span class="shipping-cost">
					<?php echo $cart_info['shipping']; ?>
				</span>
			</div>
		<?php endif; ?>

		<?php if( $cart_tax && isset( $cart_info['tax'] ) ) :	?>
			<div class="cart-tax">
				<?php echo __( 'Tax Amount', 'yith-woocommerce-added-to-cart-popup' ) . ':' ?>
				<span class="tax-cost">
					<?php echo $cart_info['tax']; ?>
				</span>
			</div>
		<?php endif; ?>

		<?php if( $cart_total && isset( $cart_info['total'] ) ) : ?>
			<div class="cart-totals">
				<?php echo __( 'Cart Total', 'yith-woocommerce-added-to-cart-popup' ) . ':' ?>
				<span class="cart-cost">
					<?php echo $cart_info['total']; ?>
				</span>
			</div>
		<?php endif; ?>
	</div>

	<?php endif; ?>

</div>