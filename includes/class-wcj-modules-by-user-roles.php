<?php
/**
 * Booster for WooCommerce - Module - Modules By User Roles
 *
 * @version 6.0.0
 * @since  1.0.0
 * @author  Pluggabl LLC.
 * @package Booster_Plus_For_WooCommerce/includes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'WCJ_Modules_By_User_Roles' ) ) :
	/**
	 * WCJ_Modules_By_User_Roles.
	 */
	class WCJ_Modules_By_User_Roles extends WCJ_Module {

		/**
		 * Constructor.
		 *
		 * @version 6.0.0
		 * @since  1.0.0
		 */
		public function __construct() {

			$this->id         = 'modules_by_user_roles';
			$this->short_desc = __( 'Modules By User Roles', 'woocommerce-jetpack' );
			$this->desc       = __( 'Enable/disable Booster Plus for WooCommerce modules by user roles.', 'woocommerce-jetpack' );
			$this->link_slug  = 'woocommerce-booster-modules-by-user-roles';
			parent::__construct();

		}
	}

endif;

return new WCJ_Modules_By_User_Roles();
