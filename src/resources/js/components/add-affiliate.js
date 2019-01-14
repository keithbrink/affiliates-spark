Vue.component('affiliates-spark-kiosk-add-affiliate', {
    props: ['user'],
    data() {
        return {
            addForm: new SparkForm({
                user_email: '',
                sub_affiliate_of_id: 0,
                affiliate_plan_id: 0,
                token: '',
            }),      
            affiliate_plans: [],      
        };
    },
    created() {
        var self = this;

        Bus.$on('sparkHashChanged', function (hash, parameters) {
            if (hash == 'affiliates' && self.affiliate_plans.length === 0) {
                self.getAffiliatePlans();
            }
        });
    },
    methods: {
        getAffiliatePlans() {
            axios.get('/affiliates-spark/kiosk/affiliates/plans')
                .then(response => {
                    this.affiliate_plans = response.data;
                });
        },
        create() {
            Spark.post('/affiliates-spark/kiosk/affiliates/add', this.addForm)
                .then(() => {
                    $('#modal-add-affiliate').modal('hide');
                    window.location.reload();
                });;
        },
    }
});
