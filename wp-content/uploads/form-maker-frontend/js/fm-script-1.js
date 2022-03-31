    var fm_currentDate = new Date();
    var FormCurrency_1 = '$';
    var FormPaypalTax_1 = '0';
    var check_submit1 = 0;
    var check_before_submit1 = {};
    var required_fields1 = ["2","6","7"];
    var labels_and_ids1 = {"2":"type_text","6":"type_phone_new","7":"type_arithmetic_captcha","1":"type_submit_reset"};
    var check_regExp_all1 = [];
    var check_paypal_price_min_max1 = [];
    var file_upload_check1 = [];
    var spinner_check1 = [];
    var scrollbox_trigger_point1 = '20';
    var header_image_animation1 = 'none';
    var scrollbox_loading_delay1 = '0';
    var scrollbox_auto_hide1 = '1';
         function before_load1() {	
}	
 function before_submit1() {
	 }	
 function before_reset1() {	
}
 function after_submit1() {
  
}
    function onload_js1() {
								jQuery("#wdform_6_element1").intlTelInput({
									nationalMode: false,
									preferredCountries: [ "np" ],
									customPlaceholder: "Phone",
								});
							
  jQuery("#wd_arithmetic_captcha1").click(function() { captcha_refresh("wd_arithmetic_captcha","1") });
  jQuery("#_element_refresh1").click(function() {captcha_refresh("wd_arithmetic_captcha","1")});
  captcha_refresh("wd_arithmetic_captcha", "1");
    }
    function condition_js1() {
    }
    function check_js1(id, form_id) {
    if (id != 0) {
    x = jQuery("#" + form_id + "form_view"+id);
    }
    else {
    x = jQuery("#form"+form_id);
    }    }
    function onsubmit_js1() {
    
    var disabled_fields = "";
    jQuery("#form1 div[wdid]").each(function() {
      if(jQuery(this).css("display") == "none") {
        disabled_fields += jQuery(this).attr("wdid");
        disabled_fields += ",";
      }
    })
    if(disabled_fields) {
      jQuery("<input type=\"hidden\" name=\"disabled_fields1\" value =\""+disabled_fields+"\" />").appendTo("#form1");
    };    }
    form_view_count1 = 0;
    jQuery(document).ready(function () {
    if (jQuery('form#form1 .wdform_section').length > 0) {
    fm_document_ready(1);
    }
    else {
    jQuery("#form1").closest(".fm-form-container").removeAttr("style")
    }
    });
    jQuery(document).ready(function () {
    if (jQuery('form#form1 .wdform_section').length > 0) {
    formOnload(1);
    }
    });
    