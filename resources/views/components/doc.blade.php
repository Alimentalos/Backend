@foreach($data as $firstLevelKey => $firstLevel)
    @if (!is_numeric($firstLevelKey))
        <h3 class="text-center mt-4">{{ __($firstLevelKey) }}</h3>
    @endif
    @if(is_array($firstLevel))
        @foreach($firstLevel as $secondLevelKey => $secondLevel)
            @if(is_array($secondLevel))
                <div class="row justify-content-center">
                    <div class="col-md-8 mt-4">
                        <div class="card">
                            @if (!is_numeric($secondLevelKey))
                                <div class="card-header h3">{{ __($secondLevelKey) }}</div>
                            @endif
                            <div class="card-body pl-5 pr-5">
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
                    <div class="col-md-8 mt-4">
                        <div class="card">
                            <div class="card-body pl-5 pr-5 pt-4">
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
