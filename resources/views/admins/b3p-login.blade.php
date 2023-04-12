<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Babi Ba Phi | Đăng nhập</title>
    <!-- Fav Icon -->
    <link href="{{ url('images/icons/favicon-33x33.png') }}" rel="shortcut icon" />
    <link rel="icon" type="image/x-icon" href="<?php echo asset('images/icons/favicon.png'); ?>" />
    <!-- third-generation iPad with high-resolution Retina display: -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo asset('images/icons/favicon-144x144.png'); ?>">
    <!-- iPhone with high-resolution Retina display: -->
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo asset('images/icons/favicon-114x114.png'); ?>">
    <!-- first- and second-generation iPad: -->
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo asset('images/icons/favicon-72x72.png'); ?>">
    <!-- non-Retina iPhone, iPod Touch, and Android 2.1+ devices: -->
    <link rel="apple-touch-icon-precomposed" href="<?php echo asset('images/icons/favicon-57x57.png'); ?>">
  <?php echo $b3pAdData->cssSetting['mapCss']; ?>
</head>
  <body>
    <div data-path="{{request()->path()}}" id="babi-3-phi-admin">
      <component :is="this.$route.meta.layout || 'div'">
        <router-view></router-view>
      </component>
    </div>
    <!-- Scripts -->

    <?php echo $b3pAdData->cssSetting['mapScript']; ?>
    <script src="{{ $b3pAdData->cssSetting['pageDir'] }}" defer></script>
  </body>
</html>
