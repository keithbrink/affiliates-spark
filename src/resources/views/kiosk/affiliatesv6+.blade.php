<affiliates-spark-kiosk-affiliates :user="user" inline-template>
    <div>
        <div class="card card-default mb-4">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h2 class="card-title mb-0">{{__('Affiliates')}}</h2>
                    </div>
                    <div class="col-md-6 text-right">
                        <button type="button" class="btn btn-primary">
                            Add Affiliate
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row" v-for="affiliate in affiliates" v-key="affiliate.id">
                    <div class="col-md-12">
                        <div class="card card-default">
                            <div class="card-header">@{{ affiliate.name }} - Subscribers</div>
                            <div class="table-responsive">
                                <table class="table table-valign-middle mb-0">
                                    <thead>
                                        <th>Name</th>
                                        <th>Subscribers</th>
                                    </thead>

                                    <tbody>
                                        <tr v-for="(count, plan) in affiliate.plan">
                                            <!-- Plan Name -->
                                            <td>
                                                <div class="btn-table-align">
                                                    @{{ plan }}
                                                </div>
                                            </td>

                                            <!-- Subscriber Count -->
                                            <td>
                                                <div class="btn-table-align">
                                                    @{{ count }}
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</affiliates-spark-kiosk-affiliates>