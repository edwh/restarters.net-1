<div class="row row-expanded">
    <div class="col-lg-6">
        <header>
        @include('includes.logo-large')
        <div class="row">
            <p>@lang('login.lead')</p>
        </div>
        </header>
    </div>
    <div class="col-lg-6">
        <div class="row row-compressed stats">
            <div class="col">
                <h3>@lang('login.stat_1')</h3>
                <strong>{{ $device_count_status[0]->counter }}</strong>
            </div>
            <div class="col">
                <h3>@lang('login.stat_2')</h3>
                <strong>{{ number_format(round($co2Total), 0, '.', ',') }} kg</strong>
            </div>
            <div class="col">
                <h3>@lang('login.stat_3')</h3>
                <strong>{{ number_format(round($wasteTotal), 0, '.', ',') }} kg</strong>
            </div>
            <div class="col">
                <h3>@lang('login.stat_4')</h3>
                <strong>{{ $partiesCount }}</strong>
            </div>
        </div>
    </div>
</div>
