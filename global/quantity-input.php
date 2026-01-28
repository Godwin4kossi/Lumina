<?php
/**
 * Product quantity inputs
 *
 * This template can be overridden by copying it to lumina/woocommerce/global/quantity-input.php.
 *
 * @package WooCommerce\Templates
 * @version 7.8.0 
 */

defined( 'ABSPATH' ) || exit;

$label = ! empty( $args['product_name'] ) ? sprintf( esc_html__( '%s quantity', 'woocommerce' ), wp_strip_all_tags( $args['product_name'] ) ) : esc_html__( 'Quantity', 'woocommerce' );
?>
<div class="quantity">
	<button type="button" class="qty-btn minus" aria-label="<?php esc_attr_e( 'Decrease quantity', 'woocommerce' ); ?>">−</button>
	
	<label class="screen-reader-text" for="<?php echo esc_attr( $input_id ); ?>"><?php echo esc_attr( $label ); ?></label>
	<input
		type="number"
		id="<?php echo esc_attr( $input_id ); ?>"
		class="<?php echo esc_attr( join( ' ', (array) $classes ) ); ?>"
		name="<?php echo esc_attr( $input_name ); ?>"
		value="<?php echo esc_attr( $input_value ); ?>"
		aria-label="<?php esc_attr_e( 'Product quantity', 'woocommerce' ); ?>"
		size="4"
		min="<?php echo esc_attr( $min_value ); ?>"
		max="<?php echo esc_attr( 0 < $max_value ? $max_value : '' ); ?>" 
		<?php if ( ! $readonly ) : ?>
			step="<?php echo esc_attr( $step ); ?>"
			placeholder="<?php echo esc_attr( $placeholder ); ?>"
			inputmode="<?php echo esc_attr( $inputmode ); ?>"
			autocomplete="<?php echo esc_attr( isset( $autocomplete ) ? $autocomplete : 'on' ); ?>"
		<?php endif; ?>
		<?php if ( $readonly ) : ?>
			readonly="readonly"
		<?php endif; ?> 
	/>
	
	<button type="button" class="qty-btn plus" aria-label="<?php esc_attr_e( 'Increase quantity', 'woocommerce' ); ?>">+</button>
</div>
<?php