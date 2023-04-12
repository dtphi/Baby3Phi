@if (isset($b3pAdData->cssSetting['jsonLog']))
  @include('./log_dashboard')
@elseif ($b3pAdData->cssSetting['authentication'])
  @include('./admins/b3p-login')
@else
  @include('./admins/b3p-admin')
@endif
