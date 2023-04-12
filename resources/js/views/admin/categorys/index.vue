<template>
  <b3p-list>
    <template #page_header>
      <the-header-page></the-header-page>
    </template>
    <template #panel_title>
      <b3p-emoji emoji="list" /> {{ $options.setting.list_title }}
    </template>
    <template #content_list>
      <transition v-if="loading">
        <loading-over-lay :active.sync="loading" :is-full-page="fullPage"></loading-over-lay>
      </transition>
      <transition v-if="newsGroups">
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <td style="width: 1%" class="text-center">
                <input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" />
              </td>
              <td style="width: 50%" class="text-left">
                <a href="javascript:void(0);" class="asc">{{
                $options.setting.category_name_txt
                }}</a>
              </td>
              <td style="width: 24%" class="text-center">
                <a href="javascript:void(0);" class="asc">{{
                $options.setting.sort_order_txt
                }}</a>
              </td>
              <td style="width: 25%" class="text-right">
                {{ $options.setting.action_txt }}
              </td>
            </tr>
          </thead>
          <tbody>
            <the-category-item v-for="(item, idx) in newsGroups" :category-item="item" :key="idx">
            </the-category-item>
          </tbody>
        </table>
      </transition>
    </template>
  </b3p-list>
</template>

<script>
import { mapState, mapActions, } from 'vuex'
import TheCategoryItem from './components/TheCategoryItem'
import TheHeaderPage from './components/TheHeaderPage'
import { MODULE_NEWS_CATEGORY, } from 'store@admin/types/module-types'
import { ACTION_GET_NEWS_GROUP_LIST, } from 'store@admin/types/action-types'

export default {
  name: 'CategoryListPage',
  components: {
    TheCategoryItem,
    TheHeaderPage,
  },
  data() {
    return {
      fullPage: false,
    }
  },
  computed: {
    ...mapState({
      perPage: (state) => state.cfApp.perPage,
    }),
    ...mapState(MODULE_NEWS_CATEGORY, ['newsGroups', 'loading']),
  },
  mounted() {
    const params = {
      perPage: this.perPage,
    }
    this[ACTION_GET_NEWS_GROUP_LIST](params)
  },
  methods: {
    ...mapActions(MODULE_NEWS_CATEGORY, [ACTION_GET_NEWS_GROUP_LIST]),
  },
  setting: {
    list_title: 'Danh sách danh mục',
    category_name_txt: 'Tên danh mục',
    sort_order_txt: 'Sắp xếp',
    action_txt: 'Thực hiện',
  },
}
</script>
