@foreach($data as $firstLevelKey => $firstLevel)
    @if (!is_numeric($firstLevelKey))
        <h3 class="text-left pt-3 mb-4" id="{{strtolower($firstLevelKey)}}">{{ __($firstLevelKey) }}</h3>
    @endif
    @if(is_array($firstLevel))
        @foreach($firstLevel as $secondLevelKey => $secondLevel)
            @if(is_array($secondLevel))

                @if (!is_numeric($secondLevelKey))

                    <div class="mt-5"></div>
                    <div class="h4 mb-4">@markdown(__($secondLevelKey))</div>
                @endif

                @foreach($secondLevel as $key=> $thirdLevel)
                    @if(is_array($thirdLevel))
                        @if (!is_numeric($key))
                            <div class="h4 mb-4 pb-2 pt-4">@markdown($key)</div>
                        @endif
                        <ul>
                        @foreach($thirdLevel as $key=> $fourLevel)
                            @if(is_array($fourLevel))
                                @if (!is_numeric($key))
                                    <div class="h6">@markdown($key)</div>
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
                                <div class="mb-3">
                                    @markdown($fourLevel)
                                </div>
                            @endif
                        @endforeach
                        </ul>
                    @else
                        @if (!is_numeric($key))
                            <div class="h4 mb-4 pt-4">@markdown($key)</div>
                        @endif
                        <div class="pt-2 pl-3">
                            @markdown($thirdLevel)
                        </div>
                    @endif
                @endforeach
            @else
                <div class="pt-2 pl-3">
                    @markdown($secondLevel)
                </div>
            @endif
        @endforeach
    @else
        2@markdown($firstLevel)
    @endif
@endforeach
