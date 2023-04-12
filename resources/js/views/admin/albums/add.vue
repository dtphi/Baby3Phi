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
        <info-add-form ref="formAddAlbums"></info-add-form>
      </validation-observer>
    </template>
  </b3p-form>
</template>

<script>
import { mapState, mapActions, mapGetters, } from 'vuex'
import TheBtnBackListPage from './components/TheBtnBackListPage'
import InfoAddForm from 'com@admin/Form/Albums/AddForm'
import { MODULE_MODULE_ALBUMS_ADD, } from 'store@admin/types/module-types'
import { ACTION_RESET_NOTIFICATION_INFO, } from 'store@admin/types/action-types'

export default {
  name: 'AlbumsAdd',
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
    ...mapState(MODULE_MODULE_ALBUMS_ADD, {
      loading: (state) => state.loading,
      errors: (state) => state.errors,
      insertSuccess: (state) => state.insertSuccess,
    }),
    ...mapGetters(MODULE_MODULE_ALBUMS_ADD, [
      'infoAlbumsImage'
    ]),
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
    ...mapActions(MODULE_MODULE_ALBUMS_ADD, {
      'resetNotification': ACTION_RESET_NOTIFICATION_INFO,
      'update_info_albums_image': 'update_info_albums_image',
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
      const _self = this
      this.update_info_albums_image(this.infoAlbumsImage)
      _self.$refs.observerInfo.validate().then((isValid) => {
        if (isValid) {
          _self.$refs.formAddAlbums._submitInfo()
        }
      })
    },

    _submitInfoBack() {
      const _self = this

      this.update_info_albums_image(this.infoAlbumsImage)

      _self.$refs.observerInfo.validate().then((isValid) => {
        if (isValid) {
          _self.$refs.formAddAlbums._submitInfoBack()
        }
      })
    },

    _notificationUpdate(notification) {
      this.$notify(notification)
      this.resetNotification('')
    },
  },
  setting: {
    panel_title: 'Albums',
    frm_title: 'Thêm Albums',
    btn_save_txt: 'Lưu',
    btn_save_back_txt: 'Lưu trở về danh sách',
  },
}
</script>
