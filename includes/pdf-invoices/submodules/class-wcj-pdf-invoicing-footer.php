<?php
/**
 * Booster for WooCommerce - PDF Invoicing - Footer
 *
 * @version 6.0.0
 * @author  Pluggabl LLC.
 * @package Booster_Plus_For_WooCommerce/includes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WCJ_PDF_Invoicing_Footer' ) ) :
		/**
		 * WCJ_PDF_Invoicing_Footer.
		 */
	class WCJ_PDF_Invoicing_Footer extends WCJ_Module {

		/**
		 * Constructor.
		 */
		public function __construct() {
			$this->id         = 'pdf_invoicing_footer';
			$this->parent_id  = 'pdf_invoicing';
			$this->short_desc = __( 'Footer', 'woocommerce-jetpack' );
			$this->desc       = '';
			parent::__construct( 'submodule' );
		}

	}

endif;

return new WCJ_PDF_Invoicing_Footer();
