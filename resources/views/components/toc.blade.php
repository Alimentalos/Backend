@foreach($data as $firstLevelKey => $firstLevel)
    @if (!is_numeric($firstLevelKey))
        <div class="row">
            <div class="col-md-8 col-sm-12">
                <a href="/about/{{$base}}/{{strtolower(str_replace(' ', '-', $firstLevelKey))}}">
                    <div class="text-left h4 mb-4 ml-2 p-1">{{ __($firstLevelKey) }}</div>
                </a>
            </div>
        </div>
    @endif
    @if(is_array($firstLevel))
        @foreach($firstLevel as $secondLevelKey => $secondLevel)
            @if(is_array($secondLevel))
                <div class="row">
                    <div class="col-md-8 col-sm-12">
                        @if (!is_numeric($secondLevelKey))
                            <a href="/about/{{$base}}/{{strtolower(str_replace(' ', '-', $firstLevelKey))}}#{{strtolower($secondLevelKey)}}">
                                <div class="h5 pb-0 mb-0 mb-3 ml-4 p-1">{{ __($secondLevelKey) }}</div>
                            </a>
                        @endif
                    </div>
                </div>
            @else
            @endif
        @endforeach
    @else
        @markdown($firstLevel)
    @endif
@endforeach
