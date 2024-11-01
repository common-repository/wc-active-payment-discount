<?php
if ( ! class_exists( 'WPA_Admin' ) )
{
	class WPA_Admin {

 		/**
		* All Methods listed here
		*/
		public function __construct() {
			add_action( 'admin_menu', array( $this, 'wpa_active_payment_menu' ) );  
			add_action( 'init', array( $this, 'wpa_save' ) );
			add_action( 'woocommerce_cart_calculate_fees', array($this, 'wap_separate_payments_totals_callback') );
			add_action( 'woocommerce_review_order_before_payment', array($this, 'wap_woocommerce_refresh_payment_method') );
		}

        /**
         * @param $cart_object
         */
		public function wap_separate_payments_totals_callback($cart_object)
		{
			if (!is_admin() || defined('DOING_AJAX')) {
                $wap_payment_status = get_option('wap_payment_status');
                $wap_payment_data = get_option('wap_payment_data');
                if ($wap_payment_status == 1) 
				{
                    $payment = WC()->session->get('chosen_payment_method');
                    $discount_full = $discount_amount = "";
					
                    foreach ($wap_payment_data as $value) 
					{
                        $wap_payment = $value['selected_payment'];
                        $wap_discount = $value['wap_discount_type'];
                        $cart_total = $cart_object->cart_contents_total;

                        if ($wap_discount == 0) {
                            $discount_full = $value['wap_discount_full_amount'];
                        }
                        if ($wap_discount == 1) {
                            $discount_amount = $value['wap_discount_percentage_amount'];
                        }

                        if ($payment == $wap_payment) {
                            if ($wap_discount == "0") {
                                $cart_object->add_fee(__("Discount"), -$discount_full, false);
                            }

                            if ($wap_discount == "1") {
                                $discount = (($cart_total * $discount_amount) / 100);
                                $cart_object->add_fee(__("Discount"), -$discount, false);
                            }
                        }
                    }

                }
            }
            return;
        }


        /**
         * Ajax load when click on payment button
         */
        public function wap_woocommerce_refresh_payment_method()
		{
		?>
			<script type="text/javascript">
				(function($){
					$( 'form.checkout' ).on( 'change', 'input[name^="payment_method"]', function() {
						$('body').trigger('update_checkout');
					});
				})(jQuery);
			</script>
		<?php
		}

        /**
         * Admin Menu
         */
		public function wpa_active_payment_menu(){
			add_menu_page( 
				__( 'WC Active Payment Discount', 'wc-active-payment-discount' ),
				__( 'WC Active Payment Discount', 'wc-active-payment-discount' ),
				'manage_options',
				'wc-active-payment-methods',
				array( $this, 'wpa_active_payment_list' ),
				WAP_DIR_PATH . 'active-payment-method.svg',
				60		
			); 
		}

        /**
         * payment form template
         */
		public function wpa_active_payment_list(){
			$gateways = WC()->payment_gateways->get_available_payment_gateways();
			$enabled_gateways = array();

			if( !empty ( $gateways ) ) 
			{
				foreach( $gateways as $gateway ) {

					if( $gateway->enabled == 'yes' ) {

						$enabled_gateways[] = $gateway;

					}
				}
			}
			include_once WAP_PLUGIN_URL . 'admin/templates/settings.php';
		}

        /**
         * Settings store in database
         */
		public function wpa_save()
		{
		    if(isset($_POST['payment_details_submit']))
			{	
				$data = array();
				$wap_status = isset( $_POST['wap_payment_status'] ) ? sanitize_text_field( wp_unslash( $_POST['wap_payment_status'] ) ) : "";	
				
				if( !empty( $_POST['selected_payment'] ) )  // phpcs:ignore	
				{
					foreach( $_POST['selected_payment'] as $key => $value )  // phpcs:ignore
					{
						$data[$key]['selected_payment'] =  sanitize_text_field( wp_unslash( $value ) );
						
						$discount_type = isset($_POST['wap_discount_type'][$value]) ? sanitize_text_field(wp_unslash($_POST['wap_discount_type'][$value])) : "";
						
						$discount_amount = isset($_POST['wap_discount_full_amount'][$value]) ? sanitize_text_field(wp_unslash($_POST['wap_discount_full_amount'][$value])) : "";
						
						$discount_percentage = isset($_POST['wap_discount_percentage_amount'][$value]) ? sanitize_text_field(wp_unslash($_POST['wap_discount_percentage_amount'][$value])) : "";
						
						$data[$key]['wap_discount_type'] = $discount_type;		
						
						if($data[$key]['wap_discount_type'] == 0)
						{
							$data[$key]['wap_discount_full_amount'] = $discount_amount;					
						}
						else
						{ 
							$data[$key]['wap_discount_percentage_amount'] = $discount_percentage;
						}
										
					}
				}

				update_option( 'wap_payment_status', $wap_status );
				update_option( 'wap_payment_data', $data );
				
				$redirect_url = isset( $_SERVER['HTTP_REFERER'] ) && !empty( $_SERVER['HTTP_REFERER'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_REFERER'] ) ) : '';
				$redirect     = add_query_arg( array( 'wap_success_message' => 'WAP_SETTINGS_ADDED' ), $redirect_url );
				wp_safe_redirect( $redirect );			

			}
			
		}

		
	}
	new WPA_Admin();
}