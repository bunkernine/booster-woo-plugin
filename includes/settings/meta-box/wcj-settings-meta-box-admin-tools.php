<?php
/**
 * Booster for WooCommerce - Settings Meta Box - Admin Tools
 *
 * @version 6.0.0
 * @since  1.0.0
 * @author  Pluggabl LLC.
 * @todo    [dev] (maybe) sort `$products` with available variations listed at the top
 * @package Booster_Plus_For_WooCommerce/meta-boxs
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$products = wcj_get_product_ids_for_meta_box_options( get_the_ID(), true );
$settings = array();
foreach ( $products as $product_id => $desc ) {
	$settings = array_merge(
		$settings,
		array(
			array(
				'type'  => 'title',
				/* translators: %s: translators Added */
				'title' => sprintf( __( 'Product ID: %s', 'woocommerce-jetpack' ), $product_id ) . $desc,
				'css'   => 'background-color:#cddc39;color:black;',
			),
			array(
				'name'       => '_regular_price_' . $product_id,
				'default'    => '',
				'type'       => 'price',
				'title'      => __( 'Regular price', 'woocommerce' ) . ' (' . get_woocommerce_currency_symbol() . ')',
				'product_id' => $product_id,
				'meta_name'  => '_regular_price',
			),
			array(
				'name'       => '_sale_price_' . $product_id,
				'default'    => '',
				'type'       => 'price',
				'title'      => __( 'Sale price', 'woocommerce' ) . ' (' . get_woocommerce_currency_symbol() . ')',
				'product_id' => $product_id,
				'meta_name'  => '_sale_price',
			),
		)
	);
}
return $settings;
