<affiliates-spark-kiosk-add-affiliate-plan :user="user" inline-template>
    <div class="modal" id="modal-add-affiliate-plan" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{__('Add Affiliate Plan')}}
                    </h5>
                </div>

                <div class="modal-body">
                    <form role="form">
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{__('Plan Name')}}</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" :class="{'is-invalid': addForm.errors.has('name')}" name="name" v-model="addForm.name">

                                <span class="invalid-feedback" v-show="addForm.errors.has('name')">
                                    @{{ addForm.errors.get('name') }}
                                </span>
                            </div>
                        </div>

                        <p>For all the sections below, you can enter percentages, amounts, both, or neither (if you want to pay commission but don't offer any discounts, for example).</p>
                        <h3>Commission</h3>
                        <p>The amounts the affiliate will be paid for referrals.</p>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{__('Months of Commission')}} - Enter 0 for unlimited.</label>

                            <div class="col-md-6">
                                <input type="number" class="form-control"  :class="{'is-invalid': addForm.errors.has('months_of_commission')}" name="months_of_commission" v-model="addForm.months_of_commission">

                                <span class="invalid-feedback" v-show="addForm.errors.has('months_of_commission')">
                                    @{{ addForm.errors.get('months_of_commission') }}
                                </span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{__('Commission Percentage')}} - Enter whole number only, such as "40".</label>

                            <div class="col-md-6">
                                <input type="number" class="form-control" :class="{'is-invalid': addForm.errors.has('commission_percentage')}" name="commission_percentage" v-model="addForm.commission_percentage">

                                <span class="invalid-feedback" v-show="addForm.errors.has('commission_percentage')">
                                    @{{ addForm.errors.get('commission_percentage') }}
                                </span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{__('Commission Amount')}} - Dollar amount to pay each month.</label>

                            <div class="col-md-6">
                                <input type="number" class="form-control" :class="{'is-invalid': addForm.errors.has('commission_amount')}" name="commission_amount" v-model="addForm.commission_amount">

                                <span class="invalid-feedback" v-show="addForm.errors.has('commission_amount')">
                                    @{{ addForm.errors.get('commission_amount') }}
                                </span>
                            </div>
                        </div>

                        <h3>Discounts</h3>
                        <p>This is the offer the affiliate can make to their audience.</p>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{__('Months of Discount')}} - Enter 0 for unlimited.</label>

                            <div class="col-md-6">
                                <input type="number" class="form-control"  :class="{'is-invalid': addForm.errors.has('months_of_discount')}" name="months_of_discount" v-model="addForm.months_of_discount">

                                <span class="invalid-feedback" v-show="addForm.errors.has('months_of_discount')">
                                    @{{ addForm.errors.get('months_of_discount') }}
                                </span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{__('Discount Percentage')}} - Enter whole number only, such as "40".</label>

                            <div class="col-md-6">
                                <input type="number" class="form-control" :class="{'is-invalid': addForm.errors.has('discount_percentage')}" name="discount_percentage" v-model="addForm.discount_percentage">

                                <span class="invalid-feedback" v-show="addForm.errors.has('discount_percentage')">
                                    @{{ addForm.errors.get('discount_percentage') }}
                                </span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{__('Discount Amount')}} - Dollar amount to discount each month.</label>

                            <div class="col-md-6">
                                <input type="number" class="form-control" :class="{'is-invalid': addForm.errors.has('discount_amount')}" name="discount_amount" v-model="addForm.discount_amount">

                                <span class="invalid-feedback" v-show="addForm.errors.has('discount_amount')">
                                    @{{ addForm.errors.get('discount_amount') }}
                                </span>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Modal Actions -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{__('Close')}}</button>

                    <button type="button" class="btn btn-primary" @click="create" :disabled="addForm.busy">
                        {{__('Create')}}
                    </button>
                </div>
            </div>
        </div>
    </div>
</affiliates-spark-kiosk-add-affiliate>