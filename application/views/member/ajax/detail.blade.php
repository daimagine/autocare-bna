<div>
    <ul class="niceList params">
        <li>
            <div class="myInfo">
                <h5>{{ $member->customer->name }}</h5>
                <span class=""></span>
                <span class="myRole followers">autocare membership since {{ date('d F Y', strtotime($member->registration_date)) }}</span>
            </div>
            <div class="clear"></div>
        </li>
        <li class="on_off">
            <label><span class="icos-car"></span>Membership Number &nbsp; {{ $member->number }}</label>
            <div class="clear"></div>
        </li>
        <li class="on_off">
            <label><span class="icos-dates"></span>Membership valid until &nbsp; {{ date('d F Y', strtotime($member->registration_date)) }} </label>
            <div class="clear"></div>
        </li>
        <li class="on_off">
            <label><span class="icos-tags"></span>{{ $member->description }}</label>
            <div class="clear"></div>
        </li>
        <li class="on_off noBorderB">
            <div style="float: right">
                <a href="/member/delete/{{ $member->id }}" class="buttonM bRed"><span class="icol-exit"></span><span style="color: white">Revoke Membership</span></a>
            </div>
            <div class="clear"></div>
        </li>
    </ul>
</div>
<div class="clear"></div>