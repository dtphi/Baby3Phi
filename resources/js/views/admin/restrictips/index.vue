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
      <transition v-if="_infoList">
        <div>
          <table class="table table-bordered table-hover">
            <thead>
              <tr role="row">
                <th style="width: 5%" class="text-center">
                  <input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" />
                </th>
                <th style="width: 5%" class="text-left">STT</th>
                <th style="width: 30%" class="text-left">Ip</th>
                <th style="width: 20%" class="text-left">Active</th>
                <th style="width: 10%" class="text-right">Action</th>
              </tr>
            </thead>
            <tbody v-if="_infoList.length">
              <item v-for="(item, index) in _infoList" :info="item" :no="index" :key="item.id"></item>
            </tbody>
          </table>
        </div>
      </transition>
    </template>
  </b3p-list>
</template>

<script>
import { mapState, mapGetters, mapActions, } from 'vuex'
import Item from './components/TheItem'
import TheHeaderPage from './components/TheHeaderPage'
import { MODULE_MODULE_RESTRICT_IP, } from 'store@admin/types/module-types'
import {
  ACTION_GET_INFO_LIST,
  ACTION_RESET_NOTIFICATION_INFO,
} from 'store@admin/types/action-types'

export default {
  name: 'ListRestrictIp',
  components: {
    TheHeaderPage,
    Item,
  },
  data() {
    return {
      fullPage: false,
    }
  },
  watch: {
    updateSuccess(newValue) {
      if (newValue) {
        this._notificationUpdate(newValue)
      }
    },
  },
  computed: {
    ...mapState({
      perPage: state => state.cfApp.perPage,
    }),
    ...mapGetters(MODULE_MODULE_RESTRICT_IP, ['infos']),
    ...mapState(MODULE_MODULE_RESTRICT_IP, ['loading', 'updateSuccess']),
    _infoList() {
      return this.infos
    },
  },
  methods: {
    ...mapActions(MODULE_MODULE_RESTRICT_IP, {
      getInfoList: ACTION_GET_INFO_LIST,
      resetNotification: ACTION_RESET_NOTIFICATION_INFO,
    }),
    _submitAction(event) {
      this[event.target.value]({
        action: event.target.value,
      })
    },
    _notificationUpdate(notification) {
      this.$notify(notification)
      this.resetNotification()
    },
  },
  mounted() {
    const params = {
      perPage: this.perPage,
    }
    this.getInfoList(params)
  },
  setting: {
    list_title: 'Danh sách IP',
  },
}
</script>
