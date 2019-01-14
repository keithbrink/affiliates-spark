<affiliates-spark-kiosk-add-affiliate :user="user" inline-template>
    <div class="modal" id="modal-add-affiliate" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{__('Add Affiliate')}}
                    </h5>
                </div>

                <div class="modal-body">
                    <form role="form">
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{__('Enter User Email')}}</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" :class="{'is-invalid': addForm.errors.has('user_email')}" name="token" v-model="addForm.user_email">

                                <span class="invalid-feedback" v-show="addForm.errors.has('user_email')">
                                    @{{ addForm.errors.get('user_email') }}
                                </span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{__('Token')}} - The unique code for this affiliate. All capitals, no spaces.</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" :class="{'is-invalid': addForm.errors.has('token')}" name="token" v-model="addForm.token">

                                <span class="invalid-feedback" v-show="addForm.errors.has('token')">
                                    @{{ addForm.errors.get('token') }}
                                </span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 col-form-label text-md-right">{{__('Select Commission Plan')}}</label>

                            <div class="col-md-6">
                                <select class="form-control" :class="{'is-invalid': addForm.errors.has('affiliate_plan_id')}" name="affiliate_plan_id" v-model="addForm.affiliate_plan_id">
                                    <option v-for="affiliate_plan in affiliate_plans" :value="affiliate_plan.id">@{{ affiliate_plan.name }}</option>
                                </select>
                                <span class="invalid-feedback" v-show="addForm.errors.has('affiliate_plan_id')">
                                    @{{ addForm.errors.get('affiliate_plan_id') }}
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