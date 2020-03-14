@foreach($data as $firstLevelKey => $firstLevel)
    @if (!is_numeric($firstLevelKey))
        <div class="row justify-content-center">
            <div class="col-md-8 col-sm-12 mt-4">
                <h2 class="text-left mt-4">{{ __($firstLevelKey) }}</h2>
            </div>
        </div>
    @endif
    @if(is_array($firstLevel))
        @foreach($firstLevel as $secondLevelKey => $secondLevel)
            @if(is_array($secondLevel))
                <div class="row justify-content-center">
                    <div class="col-md-8 col-sm-12 mt-4">

                        @if (!is_numeric($secondLevelKey))

                            <div class="mt-5"></div>
                            <div class="h3 mb-5 pb-4">{{ __($secondLevelKey) }}</div>
                        @endif

                        <div class="card">
                            <div class="card-body pl-5 pr-5 pt-5">

                                @foreach($secondLevel as $key=> $thirdLevel)
                                    @if(is_array($thirdLevel))
                                        @if (!is_numeric($key))
                                                <div class="h4 mb-4 pb-4 pt-4">@markdown($key)</div>
                                        @endif
                                        <ul class="pb-2">
                                            @foreach($thirdLevel as $key=> $fourLevel)
                                                @if(is_array($fourLevel))
                                                    @if (!is_numeric($key))
                                                        <div class="h5">@markdown($key)</div>
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
                                            <div class="h5 mb-4 pt-4">@markdown($key)</div>
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
