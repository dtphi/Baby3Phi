<template>
  <nav v-if="user" id="column-left" class="active" :style="navStyle">
    <div id="profile">
      <div>
        <b3p-emoji emoji="single-user" />
      </div>
      <div>
        <h4>User</h4>
        <small>{{ user.name }}</small>
        <small>{{ userPhone }}</small>
      </div>
    </div>
    <template v-if="!user.isAdmin">
      <ul style="list-style: none;
    padding: 10px;">
        <li id="dashboard">
          <a :href="_getHref('dashboards')">
            <b3p-emoji emoji="star-antom" />
            <span>{{ $options.setting.dashboards_title }}</span></a>
        </li>
      </ul>
      <ul babi-sidebar="admin" id="menu" :style="ulMenu">
        <li id="user">
          <a class="parent">
            <b3p-emoji emoji="single-user" />
            <span>{{ $options.setting.users_title }}</span></a>
          <ul class="collapse" :class="_getCollapseIn([
            'users'
          ])">
            <li>
              <a :href="_getHref('users')">
                <span>{{ $options.setting.users_title }}</span></a>
            </li>
          </ul>
        </li>
        <li id="category">
          <a class="parent">
            <b3p-emoji emoji="category" />
            <span>{{ $options.setting.category_root_title }}</span></a>
          <ul class="collapse" :class="_getCollapseIn([
            'news-categories', 'group-albums',
          ])">
            <li>
              <a :href="_getHref('news-categories')">{{
                  $options.setting.category_sub_cate_info_title
              }}</a>
            </li>
            <li>
              <a :href="_getHref('group-albums')">{{
                  $options.setting.group_albums_title
              }}</a>
            </li>
          </ul>
        </li>
        <li id="catalog">
          <a class="parent">
            <b3p-emoji emoji="information" />
            <span>{{ $options.setting.information_root_title }}</span></a>
          <ul class="collapse" :class="_getCollapseIn([
            'albums', 'informations', 'slide-info-specials'
          ])">
            <li>
              <a :href="_getHref('informations')">{{
                  $options.setting.category_sub_info_title
              }}</a>
            </li>
            <li>
              <a :href="_getHref('slide-info-specials')">{{
                  $options.setting.slide_info_special_title
              }}</a>
            </li>
            <li>
              <a :href="_getHref('albums')">{{
                  $options.setting.albums_title
              }}</a>
            </li>
          </ul>
        </li>

        <li id="files">
          <a class="parent">
            <b3p-emoji emoji="photo" />
            <span>{{
              $options.setting.category_sub_image_title
          }}</span></a>
          <ul class="collapse">
            <li>
              <a :href="_getHref('filemanagers')">{{
                  $options.setting.category_sub_image_title
              }}</a>
            </li>
          </ul>
        </li>
        <li id="module">
          <a class="parent">
            <b3p-emoji emoji="module" />
            <span>{{ $options.setting.module_title }}</span></a>
          <ul class="collapse" :class="_getCollapseIn(['module-category-left-side-bars', 'module-home-banners',
            'module-category-icon-side-bars', 'module-noi-bats'
          ])">
            <li>
              <a :href="_getHref('module-category-left-side-bars')">{{
                  $options.setting.module_category_left_side_bar
              }}</a>
            </li>
            <li>
              <a :href="_getHref('module-home-banners')">{{
                  $options.setting.module_home_banner
              }}</a>
            </li>
            <li>
              <a :href="_getHref('module-category-icon-side-bars')">{{
                  $options.setting.module_category_icon_side_bar
              }}</a>
            </li>
            <li>
              <a :href="_getHref('module-noi-bats')">{{
                  $options.setting.module_noi_bat
              }}</a>
            </li>
          </ul>
        </li>
        <li id="system">
          <a class="parent">
            <b3p-emoji emoji="setting" />
            <span>{{ $options.setting.system_root_title }}</span></a>
          <ul class="collapse" :class="_getCollapseIn([
            'system', 'restrict-ips'
          ])">
            <li>
              <a :href="_getHref('system')">{{ $options.setting.sytem_title }}</a>
            </li>
            <li>
              <a :href="_getHref('restrict-ips')">{{ $options.setting.restrict_ips_title }}</a>
            </li>
          </ul>
        </li>
      </ul>
    </template>
    <template v-else>
      <ul babi-sidebar="user" style="list-style: none;
    padding: 10px;">
        <li id="dashboard">
          <a :href="_getHref('dashboards')">
            <b3p-emoji emoji="star-antom" />
            <span>{{ $options.setting.dashboards_title }}</span></a>
        </li>
      </ul>
      <ul v-html="_renderMenu()" id="menu" :style="ulMenu"></ul>
    </template>
  </nav>
</template>

<script>
import { mapState, } from 'vuex'
import { MODULE_AUTH, } from 'store@admin/types/module-types'
import { unserialize, } from 'php-serialize'

export default {
  name: 'LeftSideBar',
  data() {
    return {
      collapseIn: ''
    }
  },
  computed: {
    ...mapState(MODULE_AUTH, {
      user: (state) => state.user,
      userPhone: (state) => state.linhMucExpectSignInPhone,
    }),
    navStyle() {
      return {
        'min-height': innerHeight + 'px',
        'background-color': '#122934',
      }
    },
    ulMenu() {
      return {
        'height': '530px',
        'overflow-x': 'hidden',
        'overflow-y': 'scroll',
      }
    },
    subCollapse() {
      return this.collapseIn
    },
  },
  methods: {
    _renderMenu() {
      const self = this
      const rules = (this.user?.ruleSelect) ? unserialize(this.user.ruleSelect) : []
      let menuHtml = ''

      Object.entries(rules).forEach(function (item) {
        if (item[1]?.abilities?.list) {
          const links = self._getRuleHref(item[0])
          menuHtml += '<li><a href=\'' + links.href + '\'>'
          menuHtml += '<span>' + links.name + '</span></a></li>'
        }
      })

      return menuHtml
    },
    _getHref(path) {
      return this.$helper.fn_admin_base_url() + '/' + path
    },
    _getRuleHref(ruleKey) {
      const links = this.$options.setting.permisstionGroupTexts[ruleKey]

      return {
        href: this.$helper.fn_admin_base_url() + '/' + links.path,
        name: links.name,
      }
    },
    _getCollapseIn(groupPath) {
      let regex = this.$route.path.replace(`/${this.$cmsCfg.adminPrefix}/`, '').split('/')
      return groupPath.includes(regex[0]) ? ' in' : ''
    },
  },
  setting: {
    permisstionGroupTexts: {
      setting: { name: 'Cài đặt', path: 'system', },
      news_group: { name: 'Tin tức Danh mục', path: 'news-categories', },
      tin_tuc: { name: 'Tin tức', path: 'informations', },
      slide_info_specials: { name: 'Slide tiêu điểm', path: 'slide-info-specials', },
      album_group: { name: 'Danh mục Album', path: 'group-albums', },
      album: { name: 'Album', path: 'albums', },
    },
    dashboards_title: 'Quản trị',
    users_title: 'Người dùng',
    category_root_title: 'Danh Mục',
    information_root_title: 'Tin Tức',
    category_sub_cate_info_title: 'Danh mục',
    category_sub_info_title: 'Tin tức',
    category_sub_image_title: 'Hình ảnh',
    module_title: 'Mở rộng',
    module_category_left_side_bar: 'Danh mục trái',
    module_category_icon_side_bar: 'Danh mục Icon',
    module_home_banner: 'Banner trang chủ',
    module_noi_bat: 'Nổi bật',
    system_root_title: 'Hệ thống',
    sytem_title: 'Cài đặt',
    slide_info_special_title: 'Slide tiêu điểm',
    restrict_ips_title: 'Restrict ip',
    album_root_title: 'Album hình ảnh',
    group_albums_title: 'Danh mục hình',
    albums_title: 'Album',
  },
}
</script>

<style lang="scss">
.panel-body {
  .admin-cusstom-paging {
    padding-top: 15px;
    border-top: 1px solid #bcbabaab;
  }
}

.table-responsive {
  max-height: 450px;
}

/* custom scrollbar */
::-webkit-scrollbar {
  width: 15px;
}

::-webkit-scrollbar-track {
  background-color: transparent;
}

::-webkit-scrollbar-thumb {
  background-color: #d7dddf;
  border-radius: 20px;
  border: 6px solid transparent;
  background-clip: content-box;
}

::-webkit-scrollbar-thumb:hover {
  background-color: #595a5a;
}

li.active.open {
  background-color: red !important;
}
</style>
