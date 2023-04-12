<template>
  <header id="header" class="navbar navbar-static-top">
    <div class="navbar-header">
      <a type="button" id="button-menu" class="pull-left"
        ><b3p-emoji emoji="indent" /></a>
      <a :href="$helper.fn_admin_base_url()" class="navbar-brand">
        <admin-logo></admin-logo>
      </a>
    </div>
    <ul class="nav pull-right">
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown">
          <span class="label label-danger pull-left">1</span>
          <b3p-emoji emoji="bell" />
        </a>
      </li>
      <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown">
          <b3p-emoji emoji="star-antom" /></a>
        <ul class="dropdown-menu dropdown-menu-right">
          <li>
            <a :href="$cmsCfg.baseUrl" target="_blank">{{
              $options.setting.site_name
            }}</a>
          </li>
          <li class="divider"></li>
          <li class="dropdown-header" @click="_showHelpAbout()">
            <a href="javascript:void(0);"
              >{{ $options.setting.help_txt }}<b3p-emoji emoji="star-antom" /></a>
          </li>
        </ul>
      </li>
      <li><logout></logout></li>
    </ul>
  </header>
</template>
<script>
import Logout from '../Sidebar/Logout'
import AdminLogo from '../Logo'
import HelpAbout from '../Modal/HelpAbout'

export default {
  name: 'MainHeader',
  components: {
    Logout,
    AdminLogo,
  },
  props: {
    size: { type: Number, default: 21, },
  },
  methods: {
    _showHelpAbout() {
      this.$modal.show(
        HelpAbout,
        { text: '', },
        { height: 'auto', },
        { isToggle: true, },
        { 'before-close': () => {}, }
      )
    },
  },
  setting: {
    site_name: 'Babi3Phi',
    help_txt: 'Help',
  },
}
</script>

<style type="text/css" scoped="">
.navbar-brand > img {
  width: 18px;
  height: 24px;
}
</style>
