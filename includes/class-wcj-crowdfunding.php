<?php
/**
 * Booster for WooCommerce - Module - Crowdfunding
 *
 * @version 6.0.0
 * @since  1.0.0
 * @author  Pluggabl LLC.
 * @package Booster_Plus_For_WooCommerce/includes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WCJ_Crowdfunding' ) ) :
	/**
	 * WCJ_Crowdfunding.
	 */
	class WCJ_Crowdfunding extends WCJ_Module {

		/**
		 * Constructor.
		 *
		 * @version 6.0.0
		 * @since  1.0.0
		 */
		public function __construct() {

			$this->id         = 'crowdfunding';
			$this->short_desc = __( 'Crowdfunding', 'woocommerce-jetpack' );
			$this->desc       = __( 'Add crowdfunding products to WooCommerce.', 'woocommerce-jetpack' );
			$this->link_slug  = 'woocommerce-crowdfunding';
			$this->extra_desc = __( 'When enabled, module will add Crowdfunding metabox to product edit.', 'woocommerce-jetpack' ) . '<br>' .
			'<ol>' .
			'<li>' .
			sprintf(
				/* translators: %s: translation added */
				__( 'To add crowdfunding info to the product, use <a href="%s" target="_blank">Booster\'s crowdfunding shortcodes</a>.', 'woocommerce-jetpack' ),
				'https://booster.io/category/shortcodes/products-crowdfunding/'
			) .
				'</li>' .
				'<li>' .
				sprintf(
					/* translators: %s: translation added */
					__( 'Shortcodes could be used for example in <a href="%s">Product Info module</a>.', 'woocommerce-jetpack' ),
					admin_url( wcj_admin_tab_url() . '&wcj-cat=products&section=product_custom_info' )
				) .
				'</li>' .
				'<li>' .
				sprintf(
					/* translators: %s: translation added */
					__( 'To change add to cart button labels use <a href="%s">Add to Cart Labels module</a>.', 'woocommerce-jetpack' ),
					admin_url( wcj_admin_tab_url() . '&wcj-cat=labels&section=add_to_cart' )
				) .
				'</li>' .
				'<li>' .
				sprintf(
					/* translators: %s: translation added */
					__( 'If you want to allow customers to choose dynamic price, Use <a href="%s">Product Open Pricing (Name Your Price) module</a>.', 'woocommerce-jetpack' ),
					admin_url( wcj_admin_tab_url() . '&wcj-cat=prices_and_currencies&section=product_open_pricing' )
				) .
				'</li>' .
			'</ol>';
			parent::__construct();

			if ( $this->is_enabled() ) {

				add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
				add_action( 'save_post_product', array( $this, 'save_meta_box' ), PHP_INT_MAX, 2 );

				add_action( 'woocommerce_is_purchasable', array( $this, 'check_dates' ), PHP_INT_MAX, 2 );
			}
		}

		/**
		 * Check_dates.
		 *
		 * @version 6.0.0
		 * @since   1.0.0
		 * @param bool           $purchasable defines the purchasable.
		 * @param string | array $_product defines the _product.
		 */
		public function check_dates( $purchasable, $_product ) {
			$_product_id = wcj_get_product_id_or_variation_parent_id( $_product );
			$goal        = get_post_meta( $_product_id, '_wcj_crowdfunding_goal_sum', true );
			if ( 0 !== $goal ) {
				$start_date_str = get_post_meta( $_product_id, '_wcj_crowdfunding_startdate', true );
				$end_date_str   = get_post_meta( $_product_id, '_wcj_crowdfunding_deadline', true );
				$start_date     = ( '' !== $start_date_str ) ? strtotime( $start_date_str ) : 0;
				$end_date       = ( '' !== $end_date_str ) ? strtotime( $end_date_str ) : 0;
				if ( $start_date > 0 && ( $start_date - wcj_get_timestamp_date_from_gmt() ) > 0 ) {
					$purchasable = false;
				}
				if ( $end_date > 0 && ( $end_date - wcj_get_timestamp_date_from_gmt() ) < 0 ) {
					$purchasable = false;
				}
			}
			return $purchasable;
		}

	}

endif;

return new WCJ_Crowdfunding();
