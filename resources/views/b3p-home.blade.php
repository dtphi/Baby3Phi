@if(isset($data->settings['isStatusPage']) && $data->settings['isStatusPage'])
    @include('./' . $data->settings['viewTemplate'])
@else
    @if(!empty($data->settings['page']))
        @include('./b3p-front')
    @endif
@endif
