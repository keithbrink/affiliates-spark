var discount_mixin = require('mixins/discounts');

Vue.component('affiliate-discount', {
    props: ['user', 'team', 'billableType'],
    mixins: [discount_mixin],
    data() {
        return {
            currentDiscount: null,
        };
    },    
    created() {
        var self = this;

        this.$on('updateDiscount', function(){
            self.getCurrentDiscountForBillable(self.billableType, self.billable);

            return true;
        })
    },
    /**
     * Prepare the component.
     */
    mounted() {
        this.getCurrentDiscountForBillable(this.billableType, this.billable);
    },    
    methods: {
        /**
         * Get the formatted discount duration for the given discount.
         */
        formattedDiscountDuration(discount) {
            if ( ! discount) {
                return;
            }

            switch (discount.duration) {
                case 'forever':
                    return 'all future invoices';
                case 'once':
                    return 'a single invoice';
                case 'repeating':
                    return `all invoices during the next ${discount.duration_in_months} months`;
            }
        },
    },
});
