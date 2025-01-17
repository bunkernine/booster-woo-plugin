<?php
/**
 * Booster for WooCommerce - Module - Tax Display
 *
 * @version 6.0.1
 * @since  1.0.0
 * @author  Pluggabl LLC.
 * @package Booster_Plus_For_WooCommerce/includes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WCJ_Tax_Display' ) ) :
		/**
		 * WCJ_Tax_Display.
		 *
		 * @version 6.0.0
		 * @since   1.0.0
		 */
	class WCJ_Tax_Display extends WCJ_Module {

		/**
		 * Constructor.
		 *
		 * @version 6.0.0
		 * @since  1.0.0
		 */
		public function __construct() {

			$this->id         = 'tax_display';
			$this->short_desc = __( 'Tax Display', 'woocommerce-jetpack' );
			$this->desc       = __( 'Customize WooCommerce tax display.', 'woocommerce-jetpack' );
			$this->link_slug  = 'woocommerce-tax-display';
			parent::__construct();

			if ( $this->is_enabled() ) {

				// Tax Incl./Excl. by product/category.
				if ( 'yes' === wcj_get_option( 'wcj_product_listings_display_taxes_by_products_enabled', 'no' ) ) {
					add_filter( 'option_woocommerce_tax_display_shop', array( $this, 'tax_display_by_product' ), PHP_INT_MAX );
				}

				// Tax Incl./Excl. by user role.
				if ( 'yes' === wcj_get_option( 'wcj_product_listings_display_taxes_by_user_role_enabled', 'no' ) ) {
					add_filter( 'option_woocommerce_tax_display_shop', array( $this, 'tax_display_by_user_role' ), PHP_INT_MAX );
					add_filter( 'option_woocommerce_tax_display_cart', array( $this, 'tax_display_by_user_role' ), PHP_INT_MAX );
				}

				// Tax toggle.
				if ( 'yes' === wcj_get_option( 'wcj_tax_display_toggle_enabled', 'no' ) ) {
					add_action( 'init', array( $this, 'tax_display_toggle_param' ), PHP_INT_MAX );
					add_filter( 'option_woocommerce_tax_display_shop', array( $this, 'tax_display_toggle' ), PHP_INT_MAX );
				}
			}
		}

		/**
		 * Tax_display_toggle_param.
		 *
		 * @version 6.0.1
		 * @since  1.0.0
		 */
		public function tax_display_toggle_param() {
			wcj_session_maybe_start();
			$wpnonce = isset( $_REQUEST['wcj-button-toggle-tax-display-nonce'] ) ? wp_verify_nonce( sanitize_key( $_REQUEST['wcj-button-toggle-tax-display-nonce'] ), 'wcj_button_toggle_tax_display' ) : false;
			if ( $wpnonce && isset( $_REQUEST['wcj_button_toggle_tax_display'] ) ) {
				$session_value = wcj_session_get( 'wcj_toggle_tax_display' );
				$current_value = ( '' === $session_value ? wcj_get_option( 'woocommerce_tax_display_shop', 'excl' ) : $session_value );
				$current_value = '' === $session_value || null === $session_value ? get_option( 'woocommerce_tax_display_shop' ) : $current_value;
				wcj_session_set( 'wcj_toggle_tax_display', ( 'incl' === $current_value ? 'excl' : 'incl' ) );
			}
		}

		/**
		 * Tax_display_toggle.
		 *
		 * @version 6.0.0
		 * @since   1.0.0
		 * @todo    [dev] widget
		 * @todo    [dev] (maybe) floating button or at least give CSS instructions ($)
		 * @todo    [dev] (maybe) position near the price or at least give "Product Info" instructions
		 * @param string $value Get value.
		 */
		public function tax_display_toggle( $value ) {
			if ( ! wcj_is_frontend() ) {
				return $value;
			}
			$session_value = wcj_session_get( 'wcj_toggle_tax_display' );
			if ( '' !== ( $session_value ) && null !== $session_value ) {
				return $session_value;
			}
			return $value;
		}

		/**
		 * Tax_display_by_user_role.
		 *
		 * @version 6.0.0
		 * @since   1.0.0
		 * @param string $value Get Value.
		 */
		public function tax_display_by_user_role( $value ) {
			if ( ! wcj_is_frontend() ) {
				return $value;
			}
			$display_taxes_by_user_role_roles = wcj_get_option( 'wcj_product_listings_display_taxes_by_user_role_roles', '' );
			if ( '' !== ( $display_taxes_by_user_role_roles ) ) {
				$current_user_roles = wcj_get_current_user_all_roles();
				foreach ( $current_user_roles as $current_user_first_role ) {
					if ( in_array( $current_user_first_role, $display_taxes_by_user_role_roles, true ) ) {
						$option_name = 'option_woocommerce_tax_display_shop' === current_filter() ? 'wcj_product_listings_display_taxes_by_user_role_' . $current_user_first_role : 'wcj_product_listings_display_taxes_on_cart_by_user_role_' . $current_user_first_role;
						$tax_display = wcj_get_option( $option_name, 'no_changes' );
						if ( 'no_changes' !== $tax_display ) {
							return $tax_display;
						}
					}
				}
			}
			return $value;
		}

		/**
		 * Tax_display_by_product.
		 *
		 * @version 6.0.0
		 * @since   1.0.0
		 * @param string $value Get Value.
		 */
		public function tax_display_by_product( $value ) {
			if ( ! wcj_is_frontend() ) {
				return $value;
			}
			$product_id = get_the_ID();
			if ( 'product' === get_post_type( $product_id ) ) {
				$products_incl_tax     = wcj_get_option( 'wcj_product_listings_display_taxes_products_incl_tax', '' );
				$products_excl_tax     = wcj_get_option( 'wcj_product_listings_display_taxes_products_excl_tax', '' );
				$product_cats_incl_tax = wcj_get_option( 'wcj_product_listings_display_taxes_product_cats_incl_tax', '' );
				$product_cats_excl_tax = wcj_get_option( 'wcj_product_listings_display_taxes_product_cats_excl_tax', '' );
				if ( '' !== $products_incl_tax || '' !== $products_incl_tax || '' !== $products_incl_tax || '' !== $products_incl_tax ) {
					// Products.
					if ( ! empty( $products_incl_tax ) ) {
						if ( in_array( (string) $product_id, $products_incl_tax, true ) ) {
							return 'incl';
						}
					}
					if ( ! empty( $products_excl_tax ) ) {
						if ( in_array( (string) $product_id, $products_excl_tax, true ) ) {
							return 'excl';
						}
					}
					// Categories.
					$product_categories = get_the_terms( $product_id, 'product_cat' );
					if ( ! empty( $product_cats_incl_tax ) ) {
						if ( ! empty( $product_categories ) ) {
							foreach ( $product_categories as $product_category ) {
								if ( in_array( (string) $product_category->term_id, $product_cats_incl_tax, true ) ) {
									return 'incl';
								}
							}
						}
					}
					if ( ! empty( $product_cats_excl_tax ) ) {
						if ( ! empty( $product_categories ) ) {
							foreach ( $product_categories as $product_category ) {
								if ( in_array( (string) $product_category->term_id, $product_cats_excl_tax, true ) ) {
									return 'excl';
								}
							}
						}
					}
				}
			}
			return $value;
		}

	}

endif;

return new WCJ_Tax_Display();
