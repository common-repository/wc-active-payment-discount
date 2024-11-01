jQuery(function ($) {
	
	jQuery('.percentage-amount-discount, .full-amount-discount').on('keypress', function(key) {
		if(key.charCode < 48 || key.charCode > 57) return false;
	});
	
	var discountVal = jQuery('.discount_frm select#wap_list').val();
	var paymentStatus = jQuery('.check-status:checked').val();
	if(paymentStatus == 0){
		jQuery('.wpa_payment_tr').hide();	
	}
	
	jQuery('.selected_payment').each( function(){
		if(!jQuery(this).is(":checked"))
		{
			jQuery(this).closest('td').next('td').find('select').prop("disabled", true);  

		}
	} )
	
	
	if(discountVal === 0)
	{
		jQuery('#wap_full_amout').show();
		jQuery('#wap_percentage').hide();
		jQuery('#percentage_sign').hide();
	}
	else
	{
		jQuery('#wap_full_amout').hide();
		jQuery('#wap_percentage').show();
		jQuery('#percentage_sign').show();
	}
	
	jQuery('#wpa_discount_frm td select.wap_discount_type').each(function(i){
		var currenVal = jQuery(this).val();
		if(currenVal == 0 && currenVal != ''){
			jQuery(this).closest('td').next('.wap_discount_full_amount').show();
		}else{
			jQuery(this).closest('td').next('.wap_discount_full_amount').hide();
		}
		
		if(currenVal == 1 && currenVal != ''){
			jQuery(this).closest('td').next().next('.wap_discount_percentage_amount').show();
		}else{
			jQuery(this).closest('td').next().next('.wap_discount_percentage_amount').hide();
		}
	})
	
   
    const active_payment = {
        init: function () {
            jQuery(document).on('change', '.discount_frm select#wap_list', this.change_payment_type);            
            jQuery(document).on('change', '.wap_discount_type', this.change_discount_type);            
            jQuery(document).on('click', '.selected_payment', this.check_enable_payment);            
            jQuery(document).on('click', '.check-status', this.check_payment_staus);            
            jQuery(document).on('click', '#wpa_submit', this.save_data);            
        },
        change_payment_type : function (){
			var discountVal = jQuery(this).val();
			if( discountVal == 0 ) {
				jQuery('#wap_full_amout').show();  
				jQuery('#wap_percentage').hide();
				jQuery('#percentage_sign').hide();
			} else {
				jQuery('#wap_full_amout').hide();
				jQuery('#wap_percentage').show();
				jQuery('#percentage_sign').show();
			}	
			
			if( discountVal == ""){ 			
				jQuery('#wap_full_amout').hide();
				jQuery('#wap_percentage').hide();				
			}

        },
		change_discount_type : function(){
			var currenVal = jQuery(this).val();
			if(currenVal == 0 && currenVal != '') {
				jQuery(this).closest('td').next('.wap_discount_full_amount').show();
			} else {
				jQuery(this).closest('td').next('.wap_discount_full_amount').hide();
			}
			
			if(currenVal == 1 && currenVal != ''){
				jQuery(this).closest('td').next().next('.wap_discount_percentage_amount').show();
			}else{
				jQuery(this).closest('td').next().next('.wap_discount_percentage_amount').hide();
			}
		},
		check_enable_payment: function(){
			if(jQuery(this).prop('checked') == true) {
				jQuery(this).closest('td').next('td').find('select').prop("disabled", false);  
			} else {
				jQuery(this).closest('td').next('td').find('select').prop("disabled", true);  
				jQuery(this).closest('td').next().next('.wap_discount_full_amount').hide();
				jQuery(this).closest('td').next().next().next('.wap_discount_percentage_amount').hide();
			}
		},
		check_payment_staus: function(){			
			var currentVal = jQuery('.check-status:checked').val();
			
			if(currentVal == 0) {				
				jQuery('.wpa_payment_tr').hide();  
				jQuery('.add-data').hide();  
			} else {
				jQuery('.wpa_payment_tr').show();  
				jQuery('.add-data').show();  
				
			}
		},
		save_data: function(e){
			var checkedNum = jQuery('.selected_payment:checked').length;
			if(checkedNum == 0)
			{
				alert('Please check atleast one payment method');
				return false;
				
			} else {   				
				jQuery('.selected_payment').each(function(){
					if(jQuery(this).is(":checked"))
					{
						var payment_type = jQuery(this).parent().next().find('select').val();
						if(payment_type == "")
						{
							alert( 'Please select discount type' );
							e.preventDefault();					
						}
					}
				})
				
			}
				
		}
        
    }

    active_payment.init();
});



