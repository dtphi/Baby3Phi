<template>
  <b3p-form :errors="_errorToArrs()">
    <template #form_loading>
      <loading-over-lay :active.sync="loading" :is-full-page="fullPage"></loading-over-lay>
    </template>
    <template #button_action>
      <button type="button" @click="_submitInfo" data-toggle="tooltip" title="Cập nhật" class="btn btn-primary">
        <b3p-emoji emoji="save" />
      </button>
      <the-btn-back-list-page></the-btn-back-list-page>
      <btn-add></btn-add>
    </template>
    <template #breadcrum>
      <h1>{{ $options.setting.panel_title }}</h1>
      <b3p-breadcrumb />
    </template>
    <template #form_body>
      <validation-observer ref="observerInfo" @submit.prevent="_submitInfo">
        <info-edit-form ref="formAddInfo"></info-edit-form>
      </validation-observer>
    </template>
  </b3p-form>
</template>

<script>
import { mapState, mapGetters, mapActions, } from 'vuex'
import TheBtnBackListPage from '../components/TheBtnBackListPage'
import InfoEditForm from 'com@admin/Form/Infos/EditForm'
import BtnAdd from '../components/TheBtnAdd'
import {
  MODULE_INFO_EDIT,
  MODULE_MODULE_SPECIAL_INFO_CAROUSEL,
} from 'store@admin/types/module-types'
import {
  ACTION_SHOW_MODAL_EDIT,
  ACTION_RESET_NOTIFICATION_INFO,
} from 'store@admin/types/action-types'
import { fn_redirect_url, } from '@app/api/utils/fn-helper'

export default {
  name: 'InformationEdit',
  components: {
    TheBtnBackListPage,
    InfoEditForm,
    BtnAdd,
  },
  beforeCreate() {
    const infoId = parseInt(this.$route.params.infoId)
    if (!infoId) {
      return fn_redirect_url('admin/informations')
    }
  },
  data() {
    return {
      fullPage: false,
      updateLog: 0,
    }
  },
  mounted() {
    const infoId = parseInt(this.$route.params.infoId)
    if (infoId) {
      this.showModal(infoId)
    }
  },
  updated() {
    this.updateLog++
    if (this.isNotExistValidate) {
      fn_redirect_url('admin/informations')
    }
  },
  computed: {
    ...mapGetters(MODULE_MODULE_SPECIAL_INFO_CAROUSEL, ['specialInfoCarousel']),
    ...mapState(MODULE_INFO_EDIT, [
      'loading',
      'updateSuccess',
      'errors',
      'infoId'
    ]),
    ...mapGetters(MODULE_INFO_EDIT, ['isNotExistValidate']),
    _errors() {
      return this.errors.length
    },
  },
  watch: {
    updateSuccess(newValue) {
      if (newValue) {
        this._notificationUpdate(newValue)
      }
    },
  },
  methods: {
    ...mapActions(MODULE_INFO_EDIT, {
      resetNotification: ACTION_RESET_NOTIFICATION_INFO,
      showModal: ACTION_SHOW_MODAL_EDIT,
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
    _notificationUpdate(notification) {
      this.$notify(notification)
      this.resetNotification()
    },
    _submitInfo() {
      this.update_special_carousel(this.specialInfoCarousel)
      this.$refs.observerInfo.validate().then(isValid => {
        if (isValid) {
          this.$refs.formAddInfo._submitInfo()
        }
      })
    },
  },
  setting: {
    panel_title: 'Tin Tuc',
    frm_title: 'Them tin tuc',
  },
}
</script>
