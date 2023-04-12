<template>
  <b3p-form :errors="_errorToArrs()">
    <template #form_loading>
      <loading-over-lay :active.sync="loading" :is-full-page="fullPage"></loading-over-lay>
    </template>
    <template #button_action>
      <b3p-button @click="_submitInfo" custom-color="primary" :original-title="$options.setting.btn_save_txt">
        <b3p-emoji emoji="save" />
      </b3p-button>
      <b3p-button @click="_submitInfoBack" custom-color="info" :original-title="$options.setting.btn_save_back_txt">
        <b3p-emoji emoji="save" />
      </b3p-button>
      <the-btn-back-list-page></the-btn-back-list-page>
    </template>
    <template #breadcrum>
      <h1>{{ $options.setting.panel_title }}</h1>
      <b3p-breadcrumb />
    </template>
    <template #form_body>
      <validation-observer ref="observerInfo" @submit.prevent="_submitInfo">
        <info-add-form ref="formAddInfo"></info-add-form>
      </validation-observer>
    </template>
  </b3p-form>
</template>

<script>
import { mapState, mapActions, } from 'vuex'
import InfoAddForm from 'com@admin/Form/GroupAlbums/AddForm'
import TheBtnBackListPage from './components/TheBtnBackListPage'
import { MODULE_MODULE_GROUP_ALBUMS_ADD, } from 'store@admin/types/module-types'
import { ACTION_RESET_NOTIFICATION_INFO, } from 'store@admin/types/action-types'

export default {
  name: 'GroupAlbumsAdd',
  components: {
    TheBtnBackListPage,
    InfoAddForm,
  },
  data() {
    return {
      fullPage: true,
    }
  },
  computed: {
    ...mapState(MODULE_MODULE_GROUP_ALBUMS_ADD, {
      loading: state => state.loading,
      errors: state => state.errors,
      insertSuccess: state => state.insertSuccess,
    }),
    _errors() {
      return this.errors.length
    },
  },
  watch: {
    insertSuccess(newValue) {
      if (newValue) {
        this._notificationUpdate(newValue)
      }
    },
  },
  methods: {
    ...mapActions(MODULE_MODULE_GROUP_ALBUMS_ADD, [
      ACTION_RESET_NOTIFICATION_INFO
    ]),
    _errorToArrs() {
      let errs = []
      if (
        this.errors.length &&
        typeof this.errors[0].messages !== 'undefined'
      ) {
        errs = Object.values(this.errors[0].messages)
      }
      if (Object.entries(errs).length === 0 && this.errors.length) {
        errs.push(this.$options.setting.error_msg_system)
      }

      return errs
    },
    _submitInfo() {
      this.$refs.observerInfo.validate().then(isValid => {
        if (isValid) {
          this.$refs.formAddInfo._submitInfo()
        }
      })
    },
    _submitInfoBack() {
      this.$refs.observerInfo.validate().then(isValid => {
        if (isValid) {
          this.$refs.formAddInfo._submitInfoBack()
        }
      })
    },
    _notificationUpdate(notification) {
      this.$notify(notification)
      this[ACTION_RESET_NOTIFICATION_INFO]('')
    },
  },
  setting: {
    panel_title: 'Group Albums',
    frm_title: 'Thêm Group Albums',
    btn_save_txt: 'Lưu',
    btn_save_back_txt: 'Lưu trở về danh sách',
    error_msg_system: 'Group albums đã tồn tại',
  },
}
</script>
