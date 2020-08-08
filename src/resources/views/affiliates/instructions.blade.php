<div style="font-size: 24px; margin-bottom: 10px;">
    <h4>Your Affiliate Link</h4>
    <a href="{{url('/')}}/?ref={{$affiliate_token}}">{{url('/')}}/?ref={{$affiliate_token}}</a>
</div>
<div style="margin-bottom: 10px;">
    <p style="margin-bottom: 0;">You can also add "?ref={{$affiliate_token}}" to the end of any of our other pages</a>, such as:</p>
    <a class="mt-0" href="{{url('/')}}/blog?ref={{$affiliate_token}}">{{url('/')}}/blog/<b>?ref={{$affiliate_token}}</b></a>
</div>
<div>
    <h3>Your Affiliate Plan</h3>
    @if($affiliate->commissionAmount()->value() > 0)
        <p>You receive a <br /><strong>{{$affiliate->commissionAmount()}} commission</strong>
            @if($affiliate->commissionDuration() > 0)
                <br />for the first <strong>{{$affiliate->commissionDuration()}} months</strong> of the subscription
            @else
                <br />for the <strong>lifetime</strong> of the subscription
            @endif
            <br />from every user you refer.</p>
    @elseif($affiliate->commissionPercentage() > 0)
    <p>You receive a<br /><strong>{{round($affiliate->commissionPercentage()*100)}}% commission</strong>
        @if($affiliate->commissionDuration() > 0)
            <br />for the first <strong>{{$affiliate->commissionDuration()}} months</strong> of the subscription
            @else
            <br />for the <strong>lifetime</strong> of the subscription
            @endif
        <br />from every user you refer.</p>
    @endif
    @if($affiliate->discountAmount()->value() > 0)
    <p>Users who sign up through your link receive a {{$affiliate->discountAmount()}} discount.</p>
    @elseif($affiliate->discountPercentage() > 0)
    <p>Users who sign up through your link receive a {{round($affiliate->discountPercentage()*100)}}% discount.</p>
    @endif
</div>
