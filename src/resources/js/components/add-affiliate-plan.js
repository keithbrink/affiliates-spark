Vue.component('affiliates-spark-kiosk-add-affiliate-plan', {
    props: ['user'],
    data() {
        return {
            addForm: new SparkForm({
                name: '',
                months_of_commission: 0,
                commission_percentage: 0,
                commission_amount: 0,
                months_of_discount: 0,
                discount_percentage: 0,
                discount_amount: 0,
                level_2_months_of_commission: 0,
                level_2_commission_percentage: 0,
                level_2_commission_amount: 0,
            }),      
        };
    },
    methods: {
        create() {
            Spark.post('/affiliates-spark/kiosk/affiliates/plans/add', this.addForm)
                .then(() => {
                    $('#modal-add-affiliate-plan').modal('hide');
                    window.location.reload();
                });
        },
    }
});
