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
                <th style="width: 5%" class="text-left">No</th>
                <th style="width: 35%" class="text-left">Tên</th>
                <th style="width: 10%" class="text-left">Hình ảnh</th>
                <th style="width: 10%" class="text-center">
                  Ngày hoạt động
                </th>
                <th style="width: 10%" class="text-center">Ngày tạo</th>
                <th style="width: 5%" class="text-center">
                  Trạng thái
                </th>
                <th style="width: 10%" class="text-center">
                  <select @change="_submitAction" class="form-control">
                    <option>Thêm</option>
                    <option value="module_special_info_ids">
                      Tiêu điểm
                    </option>
                  </select>
                </th>
                <th style="width: 10%" class="text-right">Action</th>
              </tr>
            </thead>
            <tbody>
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
import { MODULE_INFO, } from 'store@admin/types/module-types'
import {
  ACTION_GET_INFO_LIST,
  ACTION_RESET_NOTIFICATION_INFO,
} from 'store@admin/types/action-types'

export default {
  name: 'InformationList',
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
      perPage: (state) => state.cfApp.perPage,
    }),
    ...mapGetters(['isNotEmptyList']),
    ...mapState(MODULE_INFO, ['infos', 'loading', 'updateSuccess']),
    _infoList() {
      return this.infos
    },
    _notEmpty() {
      return this.isNotEmptyList
    },
  },
  methods: {
    ...mapActions(MODULE_INFO, {
      getInfoList: ACTION_GET_INFO_LIST,
      resetNotification: ACTION_RESET_NOTIFICATION_INFO,
      module_special_info_ids: 'module_special_info_ids',
      get_module_special_info_ids: 'get_module_special_info_ids',
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
  created() {
    this.get_module_special_info_ids()
  },
  mounted() {
    const params = {
      perPage: this.perPage,
    }
    this.getInfoList(params)
  },
  setting: {
    list_title: 'Danh sách tin tức',
  },
}
</script>
