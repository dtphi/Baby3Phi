<template>
  <b3p-form :errors="_errorToArrs()">
    <template #form_loading>
      <loading-over-lay :active.sync="loading" :is-full-page="fullPage"></loading-over-lay>
    </template>
    <template #button_action>
      <button type="button" @click="_submitInfo" data-toggle="tooltip" :title="$options.setting.btn_save_txt"
        class="btn btn-primary">
        <b3p-emoji emoji="save" />
      </button>
      <button type="button" @click="_submitInfoBack" data-toggle="tooltip" title="Lưu" class="btn btn-primary">
        {{ $options.setting.btn_save_back_txt }}
      </button>
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
import { mapState, mapActions, mapGetters, } from 'vuex'

import InfoAddForm from 'com@admin/Form/Infos/AddForm'
import TheBtnBackListPage from '../components/TheBtnBackListPage'
import {
  MODULE_INFO_ADD,
  MODULE_MODULE_SPECIAL_INFO_CAROUSEL,
} from 'store@admin/types/module-types'
import { ACTION_RESET_NOTIFICATION_INFO, } from 'store@admin/types/action-types'

export default {
  name: 'InformationAdd',
  components: {
    InfoAddForm,
    TheBtnBackListPage,
  },
  data() {
    return {
      fullPage: true,
    }
  },
  computed: {
    ...mapGetters(MODULE_MODULE_SPECIAL_INFO_CAROUSEL, ['specialInfoCarousel']),
    ...mapState(MODULE_INFO_ADD, {
      loading: (state) => state.loading,
      errors: (state) => state.errors,
      insertSuccess: (state) => state.insertSuccess,
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
    ...mapActions(MODULE_INFO_ADD, {
      resetNotification: ACTION_RESET_NOTIFICATION_INFO,
      update_special_carousel: 'update_special_carousel',
    }),
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
      this.update_special_carousel(this.specialInfoCarousel)
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
      this.resetNotification('')
    },
  },
  setting: {
    panel_title: 'Tin Tức',
    frm_title: 'Thêm tin',
    btn_save_txt: 'Lưu',
    btn_save_back_txt: 'Lưu trở về danh sách',
  },
}
</script>
