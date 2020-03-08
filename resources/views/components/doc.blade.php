@foreach($data as $firstLevelKey => $firstLevel)
    @if (!is_numeric($firstLevelKey))
        <div class="row justify-content-center">
            <div class="col-md-8 col-sm-12 mt-4">
                <h3 class="text-left mt-4 text-white">{{ __($firstLevelKey) }}</h3>
            </div>
        </div>
    @endif
    @if(is_array($firstLevel))
        @foreach($firstLevel as $secondLevelKey => $secondLevel)
            @if(is_array($secondLevel))
                <div class="row justify-content-center">
                    <div class="col-md-8 col-sm-12 mt-4">
                        <div class="card bg-light">
                            @if (!is_numeric($secondLevelKey))
                                <div class="card-header text-white h3">{{ __($secondLevelKey) }}</div>
                            @endif
                            <div class="card-body pl-5 pr-5 pt-5">
                                @foreach($secondLevel as $key=> $thirdLevel)
                                    @if(is_array($thirdLevel))
                                        @if (!is_numeric($key))
                                            <strong>@markdown($key)</strong>
                                        @endif
                                        <ul>
                                            @foreach($thirdLevel as $key=> $fourLevel)
                                                @if(is_array($fourLevel))
                                                    @if (!is_numeric($key))
                                                        <strong>@markdown($key)</strong>
                                                    @endif
                                                    <ul>
                                                        @foreach($fourLevel as $key=> $fiveLevel)
                                                            @if (!is_numeric($key))
                                                                <strong>@markdown($key)</strong>
                                                            @endif
                                                            @markdown($fiveLevel)
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    @if (!is_numeric($key))
                                                        <strong>@markdown($key)</strong>
                                                    @endif
                                                    @markdown($fourLevel)
                                                @endif
                                            @endforeach
                                        </ul>
                                    @else
                                        @if (!is_numeric($key))
                                            <strong>@markdown($key)</strong>
                                        @endif
                                        @markdown($thirdLevel)
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="row justify-content-center">
                    <div class="col-md-8 col-sm-12 mt-4">
                        <div class="card">
                            <div class="card-body pl-5 pr-5 pt-5">
                                @markdown($secondLevel)
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    @else
        @if (!is_numeric($firstLevelKey))
            @markdown($firstLevelKey)
        @endif
        @markdown($firstLevel)
    @endif
@endforeach
