<?php
/**
 * Booster for WooCommerce - Settings - Custom Shipping
 *
 * @version 7.0.0
 * @since  1.0.0
 * @author  Pluggabl LLC.
 * @package Booster_Plus_For_WooCommerce/settings
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$wocommerce_shipping_settings_url = admin_url( 'admin.php?page=wc-settings&tab=shipping' );
$wocommerce_shipping_settings_url = '<a href="' . $wocommerce_shipping_settings_url . '">' . __( 'WooCommerce > Settings > Shipping', 'woocommerce-jetpack' ) . '</a>';
$settings                         = array(
	array(
		'id'   => 'custom_shipping_options',
		'type' => 'sectionend',
	),
	array(
		'id'      => 'custom_shipping_options',
		'type'    => 'tab_ids',
		'tab_ids' => array(
			'custom_shipping_custom_shipping_tab'        => __( 'Custom Shipping', 'woocommerce-jetpack' ),
			'custom_shipping_custom_shipping_Legacy_tab' => __( 'Custom Shipping (Legacy - without Shipping Zones)', 'woocommerce-jetpack' ),
		),
	),
	array(
		'id'   => 'custom_shipping_custom_shipping_tab',
		'type' => 'tab_start',
	),
	array(
		'title' => __( 'Custom Shipping', 'woocommerce-jetpack' ),
		'type'  => 'title',
		'id'    => 'wcj_shipping_custom_shipping_w_zones_options',
		'desc'  => __( 'This section lets you add custom shipping method.', 'woocommerce-jetpack' )
				/* translators: %s: translators Added */
			. ' ' . sprintf( __( 'Visit %s to set method\'s options.', 'woocommerce-jetpack' ), $wocommerce_shipping_settings_url ),
	),
	array(
		'title'   => __( 'Custom Shipping', 'woocommerce-jetpack' ),
		'desc'    => __( 'Enable', 'woocommerce-jetpack' ),
		'id'      => 'wcj_shipping_custom_shipping_w_zones_enabled',
		'default' => 'no',
		'type'    => 'checkbox',
	),
	array(
		'title'   => __( 'Admin Title', 'woocommerce-jetpack' ),
		'id'      => 'wcj_shipping_custom_shipping_w_zones_admin_title',
		'default' => __( 'Booster: Custom Shipping', 'woocommerce-jetpack' ),
		'type'    => 'text',
		'css'     => 'width:300px;',
	),
	array(
		'id'   => 'wcj_shipping_custom_shipping_w_zones_options',
		'type' => 'sectionend',
	),
	array(
		'id'   => 'custom_shipping_custom_shipping_tab',
		'type' => 'tab_end',
	),
	array(
		'id'   => 'custom_shipping_custom_shipping_Legacy_tab',
		'type' => 'tab_start',
	),
);
$settings                         = array_merge(
	$settings,
	array(
		array(
			'title' => __( 'Custom Shipping (Legacy - without Shipping Zones)', 'woocommerce-jetpack' ),
			'type'  => 'title',
			'id'    => 'wcj_shipping_custom_shipping_options',
			'desc'  => __( 'This section lets you set number of custom shipping methods to add.', 'woocommerce-jetpack' )
						/* translators: %s: translators Added */
				. ' ' . sprintf( __( 'After setting the number, visit %s to set each method options.', 'woocommerce-jetpack' ), $wocommerce_shipping_settings_url ),
		),
		array(
			'title'             => __( 'Custom Shipping Methods Number', 'woocommerce-jetpack' ),
			'desc_tip'          => __( 'Save module\'s settings after changing this option to see new settings fields.', 'woocommerce-jetpack' ),
			'id'                => 'wcj_shipping_custom_shipping_total_number',
			'default'           => 1,
			'type'              => 'custom_number',
			'custom_attributes' => array(
				'step' => '1',
				'min'  => '0',
			),
		),
	)
);
$custom_shipping_total_number     = wcj_get_option( 'wcj_shipping_custom_shipping_total_number', 1 );
for ( $i = 1; $i <= $custom_shipping_total_number; $i++ ) {
		$settings = array_merge(
			$settings,
			array(
				array(
					'title'   => __( 'Admin Title Custom Shipping', 'woocommerce-jetpack' ) . ' #' . $i,
					'id'      => 'wcj_shipping_custom_shipping_admin_title_' . $i,
					'default' => __( 'Custom', 'woocommerce-jetpack' ) . ' #' . $i,
					'type'    => 'text',
				),
			)
		);
}
$settings = array_merge(
	$settings,
	array(
		array(
			'id'   => 'wcj_shipping_custom_shipping_options',
			'type' => 'sectionend',
		),
		array(
			'id'   => 'custom_shipping_custom_shipping_Legacy_tab',
			'type' => 'tab_end',
		),
	)
);
return $settings;
