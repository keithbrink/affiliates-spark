Vue.component('affiliates-spark-kiosk-affiliates', {
    props: ['user'],
    data() {
        return {
            affiliates: [],
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
        openAddAffiliateModal() {
            $('#modal-add-affiliate').modal('show');
        },
        openAddAffiliatePlanModal() {
            $('#modal-add-affiliate-plan').modal('show');
        },
    }
});
