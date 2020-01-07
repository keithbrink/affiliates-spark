<affiliate-discount :user="user" :team="team" :billable-type="billableType" inline-template>
    <div class="card card-success" v-if="currentDiscount">
        <div class="card-header">Current Discount</div>

        <div class="card-body">
            You currently receive a discount of @{{ formattedDiscount(currentDiscount) }}
            for @{{ formattedDiscountDuration(currentDiscount) }}. The discount has already been applied to the plans below.
        </div>
    </div>
</affiliate-discount>