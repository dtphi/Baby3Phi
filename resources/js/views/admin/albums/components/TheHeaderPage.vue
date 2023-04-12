<template>
  <b3p-page-header>
    <template #pull_right>
      <the-btn-add></the-btn-add>
      <the-btn-refresh></the-btn-refresh>
      <the-btn-select-delete></the-btn-select-delete>
    </template>
    <h1>{{$options.setting.title}}</h1>
    <b3p-breadcrumb />
    <ul class="cms-breadcrumb">
      <li>
        <b3p-select-perpage />
      </li>
      <li>
        <b3p-global-search />
      </li>
    </ul>
  </b3p-page-header>
</template>

<script>
import {
  mapState,
  mapActions,
  mapMutations,
} from 'vuex'
import TheBtnAdd from './TheBtnAdd'
import TheBtnRefresh from './TheBtnRefresh'
import TheBtnSelectDelete from './TheBtnSelectDelete'
import {
  MODULE_MODULE_RESTRICT_IP,
} from 'store@admin/types/module-types'

import {
  ACTION_GET_INFO_LIST,
  ACTION_SEARCH_ITEMS,
} from 'store@admin/types/action-types'
import {
  INFOS_SET_INFO_LIST,
} from 'store@admin/types/mutation-types'
import {
  config,
} from '@app/common/b3p-admin-config'
import debounce from 'lodash/debounce'

export default {
  name: 'RestrictIpHeaderPage',
  components: {
    TheBtnAdd,
    TheBtnRefresh,
    TheBtnSelectDelete,
  },
  data() {
    return {
      query: '',
      searchItemsSource:'',
    }
  },
  computed: {
    ...mapState({
      perPage: state => state.cfApp.perPage,
    }),
  },
  watch: {
    query: {
      handler: debounce(function() {
        this.preApiCall()
      }, 100),
    },
  },
  methods: {
    ...mapActions(MODULE_MODULE_RESTRICT_IP, {
      'getInfoList': ACTION_GET_INFO_LIST,
      'searchItems': ACTION_SEARCH_ITEMS,
    }),
    ...mapMutations(MODULE_MODULE_RESTRICT_IP, {
      'setResIp': INFOS_SET_INFO_LIST,
    }),

    isBlank(str) {
      return (!str || /^\s*$/.test(str))
    },
    _pushAddPage() {
      this.$router.push(`/${config.adminPrefix}/restrict-ips/add`)
    },
    _refreshList() {
      const params = {
        perPage: this.perPage,
      }
      this.getInfoList(params)
    },
    preApiCall() {
      this.apiCall(this.query)
    },

    apiCall(query) {
      if(!this.isBlank(query)) {
        this.searchItems(query)
      }else {
        this._refreshList()
      }
    },

  },
  setting: {
    title: 'Albums',
    refresh_txt: 'Tải lại danh sách',
  },
}
</script>
