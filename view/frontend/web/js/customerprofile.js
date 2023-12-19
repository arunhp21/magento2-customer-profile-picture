define([
    'uiComponent',
    'Magento_Customer/js/customer-data'
], function (Component, customerData) {
    'use strict';

    return Component.extend({
    	initialize: function () {
        	this._super();
            this.customerprofile = customerData.get('customer_profile');
            this.customer = customerData.get('customer');
            this.isLoggedIn();
        },
        isLoggedIn: function() {  
            var customerInfo = customerData.get('customer')();
            var customerprofile = customerData.get('customer_profile');
            var customerLogin = customerInfo.firstname;
            if (customerLogin && customerprofile){
                return true
            }	
        }  
    });
});