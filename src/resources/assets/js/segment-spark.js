var segment_write_key = '*** UPDATE WRITE KEY ***';
var ss_mounted = 0;

const SegmentSpark = {
  install: function(Vue, options) {
    Vue.mixin({
    	created: function () {

    	},
    	mounted: function () {
    		if(!ss_mounted) {
	    		if(typeof analytics === 'undefined') {
		    		!function(){var analytics=window.analytics=window.analytics||[];if(!analytics.initialize)if(analytics.invoked)window.console&&console.error&&console.error("Segment snippet included twice.");else{analytics.invoked=!0;analytics.methods=["trackSubmit","trackClick","trackLink","trackForm","pageview","identify","reset","group","track","ready","alias","debug","page","once","off","on"];analytics.factory=function(t){return function(){var e=Array.prototype.slice.call(arguments);e.unshift(t);analytics.push(e);return analytics}};for(var t=0;t<analytics.methods.length;t++){var e=analytics.methods[t];analytics[e]=analytics.factory(e)}analytics.load=function(t){var e=document.createElement("script");e.type="text/javascript";e.async=!0;e.src=("https:"===document.location.protocol?"https://":"http://")+"cdn.segment.com/analytics.js/v1/"+t+"/analytics.min.js";var n=document.getElementsByTagName("script")[0];n.parentNode.insertBefore(e,n)};analytics.SNIPPET_VERSION="4.0.0";
					    analytics.load(segment_write_key);
					}}();
				    if(this.user) {
				    	analytics.identify(this.user.id, this.user);
				    }
				}
				if(window.location.href.indexOf("/settings") > -1) {
					var self = this;
					window.Bus.$on('sparkHashChanged', function (msg) {
					  	self.checkHash();
					});
				} else {
					analytics.page();
				};
				ss_mounted = 1;
			}
			
    	},
    	methods: {
    		checkHash: function () {
    			switch(location.hash) {
					case '#/profile':
						analytics.page("Settings - Profile");
						break;
					case '#/security':
						analytics.page("Settings - Security");
						break;
					case '#/api':
						analytics.page("Settings - API");
						break;
					case '#/subscription':
						analytics.page("Settings - Subscription");
						break;
					case '#/payment-method':
						analytics.page("Settings - Payment Method");
						break;
					case '#/invoices':
						analytics.page("Settings - Invoices");
						break;
					case '':
						analytics.page("Settings");
						break;
				}
    		},
    		viewCheckoutStep: function(step_number) {
    			analytics.track('Viewed Checkout Step', {
				  step: step_number
				});
			},
			completeCheckoutStep: function(step_number) {
    			analytics.track('Completed Checkout Step', {
				  step: step_number
				});
			},
			recordViewProduct: function(plan) {
				analytics.track('Product Viewed', {
					product_id: plan.id,
					sku: plan.id,
					name: plan.name,
					price: plan.price,
					quantity: 1,
					value: plan.price,
				});
			},
			recordAddProduct: function(plan) {
				analytics.track('Product Added', {
					product_id: plan.id,
					sku: plan.id,
					name: plan.name,
					price: plan.price,
					quantity: 1,
					value: plan.price,
				});
			},
    	},
    	watch: {
    		selectedPlan: function(plan) {
    			this.recordAddProduct(plan);
    			this.completeCheckoutStep(1);
    			this.viewCheckoutStep(2);
    		},
    		activeSubscription: function(subscription) {
    			this.completeCheckoutStep(2);
    		},
    		detailingPlan: function(plan) {
    			if(plan) {
    				this.recordViewProduct(plan);
    			}
    		},
    	}
    });
  }
}
module.exports = SegmentSpark;