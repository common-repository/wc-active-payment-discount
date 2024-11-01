<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( isset( $_REQUEST['wap_success_message'] ) && $_REQUEST['wap_success_message'] == 'WAP_SETTINGS_ADDED' ) {
	echo '<div class="'.esc_attr('updated wap_message').'"><p><strong>' . sprintf( __( '%s', 'wc-active-payment-discount' ), 'Settings updated successfully' ) . '</strong></p></div>';

}	
?>
<h1 style="margin: 30px 0px;">	
	<?php echo sprintf( __( '%s', 'wc-active-payment-discount' ), 'Discount on Woocommerce payment' ); ?>
</h1>
<?php
$wap_payment_status = get_option( 'wap_payment_status' );
$wap_payment_data	= get_option( 'wap_payment_data' );
?>
<div class="wpa_discount_frm" id="wpa_discount_frm">
	<form method="post" name="disocunt_frm" class="<?php echo esc_attr('discount-amount'); ?>"/>
		<table>
		<tr>
			<th><?php echo __( 'Enable/Disable', 'wc-active-payment-discount' ); ?></th>
			<td>:</td>					
			<td>
				<input type="radio" class="<?php echo esc_attr('check-status'); ?>" name="wap_payment_status" value="<?php echo __( '1', 'wc-active-payment-discount' ); ?>" <?php echo ($wap_payment_status == 1) ? esc_attr('checked') : ''; ?>><?php echo esc_html('Enable'); ?>
				<input type="radio" class="<?php echo esc_attr('check-status'); ?>" name="wap_payment_status" value="<?php echo __( '0', 'wc-active-payment-discount' ); ?>" <?php echo ($wap_payment_status == 0) ? esc_attr('checked') : ''; ?>><?php echo esc_html('Disable'); ?>
			</td>		
		</tr>
		
		<tr class="<?php echo esc_attr('wpa_payment_tr'); ?>>
			<td colspan="3">
				<h3><?php echo __( 'Activated payment method', 'wc-active-payment-discount' ); ?></h3>
			</td>
		</tr>
		
		
		<?php
			$num = 1;
			foreach($enabled_gateways as $gateway)
			{
		?>
		<tr class="<?php echo esc_attr('wpa_payment_tr'); ?>">
			<th><?php echo sprintf(__( '%s %d', 'wc-active-payment-discount' ) , 'Payment method', $num );  ?></th>
			<td>:</td>
			<td>			
				<?php 				
				$selected = "";
				foreach($wap_payment_data as $selected_method){
					if($selected_method['selected_payment'] == $gateway->id) {
						$selected = esc_attr('checked'); 
					}
				}
				?>
				<input type="checkbox" class="<?php echo esc_attr('selected_payment'); ?>" name="selected_payment[]" <?php echo $selected; ?> value="<?php echo esc_attr($gateway->id); ?>" /> <?php echo esc_html($gateway->title); ?>				
				
			</td>			
			<td>
				<?php 				
				$valueCheck = '';				 
				foreach($wap_payment_data as $selected_method)
				{
					if($selected_method['selected_payment'] == $gateway->id) 
					{
						$valueCheck = $selected_method['wap_discount_type'];		
					}					
				}
				?>
				<select id="wap_discount_type" class="<?php echo esc_attr('wap_discount_type'); ?>" name='wap_discount_type[<?php echo esc_attr($gateway->id); ?>]'>
					<option value="" ><?php echo __( 'Select Discount Type', 'wc-active-payment-discount' ); ?></option>
					<option value="<?php echo __( '0', 'wc-active-payment-discount' ); ?>" <?php if($valueCheck == "0"){ echo 'selected'; }?>><?php echo esc_html('Full'); ?></option>
					<option value="<?php echo __( '1', 'wc-active-payment-discount' ); ?>" <?php if($valueCheck == "1"){ echo 'selected'; }?>><?php echo esc_html('Percentage'); ?></option>
					
				</select>			
			</td>
			
			
		<?php 				
			$amount = '';				 
			foreach($wap_payment_data as $selected_method)
			{
				if($selected_method['selected_payment'] == $gateway->id && $selected_method['wap_discount_type'] == 0) 
				{
					$amount = $selected_method['wap_discount_full_amount'];		
				}					
			}
		?>
			<td class="<?php echo esc_attr('wap_discount_full_amount'); ?>" style="display:none;">
				<input type="text" name="wap_discount_full_amount[<?php echo esc_attr($gateway->id); ?>]" placeholder="<?php echo __( 'Full Amount', 'wc-active-payment-discount' ); ?>" value="<?php echo $amount; ?>" class="<?php echo esc_attr('full-amount-discount'); ?>" />
				<span id="currency_sign" style='padding-left: 5px; font-weight:bold;'> 
					<?php echo get_woocommerce_currency_symbol(); ?>
				</span>				
			</td>
			
		<?php 				
			$discountCheck = '';				 
			foreach($wap_payment_data as $selected_method){
				if($selected_method['selected_payment'] == $gateway->id && $selected_method['wap_discount_type'] == 1) {
						$discountCheck = $selected_method['wap_discount_percentage_amount'];		
					}					
			}
		?>
			<td class="wap_discount_percentage_amount" style="display:none;">  
				<input type="text" name="wap_discount_percentage_amount[<?php echo esc_attr($gateway->id); ?>]"  placeholder="<?php echo __( 'Percentage', 'wc-active-payment-discount' ); ?>" value="<?php echo $discountCheck; ?>" class="<?php echo esc_attr('percentage-amount-discount'); ?>"/>
				<span id="percentage_sign" style='padding-left: 5px; font-weight:bold;'><?php echo __( '%', 'wc-active-payment-discount' ); ?></span>
			</td>
			
			
		</tr>
		<?php $num++; } ?>
		
		<tr>
			<td colspan="3">
				<input type="submit" id="wpa_submit"  name="payment_details_submit" value="<?php echo __( 'Add Discount', 'wc-active-payment-discount' ); ?>" />
			</td>	
		</tr>		
		
		</table>
	</form>
</div>	
