Vue.component('affiliates-spark-kiosk-add-affiliate', {
    props: ['user'],
    data() {
        return {
            user_id: 0,
            sub_affiliate_of_id: 0,
            affiliate_plan_id: 0,
            token: '',
        };
    },
    created() {
        var self = this;

        Bus.$on('sparkHashChanged', function (hash, parameters) {
            if (hash == 'affiliates' && self.affiliates.length === 0) {
                self.getAffiliates();
            }
        });
    },
    methods: {
        getAffiliates() {
            axios.get('/affiliates-spark/kiosk/affiliates')
                .then(response => {
                    this.affiliates = response.data;
                });
        },
    }
});
