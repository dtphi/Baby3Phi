<template>
  <div id="content">
    <transition v-if="_errors">
      <div class="alert alert-danger">
        <b3p-emoji emoji="exclamation-circle" />
        <button type="button" class="close" data-dismiss="alert">
          &times;
        </button>
        <h3 v-for="(err, idx) in _errorToArrs()" :key="idx">{{ err }}</h3>
      </div>
    </transition>
    <transition v-if="loading">
      <loading-over-lay :active.sync="loading" :is-full-page="fullPage"></loading-over-lay>
    </transition>
    <validation-observer ref="observerInfo" @submit.prevent="_submitInfo">
      <div class="page-header">
        <div class="container-fluid">
          <div class="pull-right">
            <b3p-button @click="_submitInfo" custom-color="primary" :original-title="$options.setting.btn_save_txt">
              <b3p-emoji emoji="save" />
            </b3p-button>
            <b3p-button @click="_submitInfoBack" custom-color="info"
              :original-title="$options.setting.btn_save_back_txt">
              <b3p-emoji emoji="save" />
            </b3p-button>
            <the-btn-back-list-page></the-btn-back-list-page>
          </div>
          <h1>{{ $options.setting.panel_title }}</h1>
          <b3p-breadcrumb />
        </div>
      </div>
      <div class="container-fluid">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">
              <b3p-emoji emoji="edit" />{{ $options.setting.frm_title }}
            </h3>
          </div>
          <div class="panel-body">
            <info-edit-form ref="formEditGroupAlbums"></info-edit-form>
          </div>
        </div>
      </div>
    </validation-observer>
  </div>
</template>

<script>
import { mapState, mapActions, } from 'vuex'
import InfoEditForm from 'com@admin/Form/GroupAlbums/EditForm'
import TheBtnBackListPage from './components/TheBtnBackListPage'
import { MODULE_MODULE_GROUP_ALBUMS_EDIT, } from 'store@admin/types/module-types'
import {
  ACTION_RESET_NOTIFICATION_INFO,
  ACTION_GET_INFO_BY_ID,
} from 'store@admin/types/action-types'
import { fn_redirect_url, } from '@app/api/utils/fn-helper'

export default {
  name: 'GroupAlbumsEdit',
  beforeCreate() {
    const infoId = parseInt(this.$route.params.infoId)
    if (!infoId) {
      return fn_redirect_url('admin/group-albums')
    }
  },
  components: {
    TheBtnBackListPage,
    InfoEditForm,
  },
  data() {
    return {
      fullPage: true,
    }
  },
  computed: {
    ...mapState(MODULE_MODULE_GROUP_ALBUMS_EDIT, {
      loading: state => state.loading,
      errors: state => state.errors,
      updateSuccess: state => state.updateSuccess,
      info: state => state.info.data,
    }),
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
    ...mapActions(MODULE_MODULE_GROUP_ALBUMS_EDIT, [
      ACTION_RESET_NOTIFICATION_INFO,
      ACTION_GET_INFO_BY_ID
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
          this.$refs.formEditGroupAlbums._submitInfo()
        }
      })
    },
    _submitInfoBack() {
      this.$refs.observerInfo.validate().then(isValid => {
        if (isValid) {
          this.$refs.formEditGroupAlbums._submitInfoBack()
        }
      })
    },
    _notificationUpdate(notification) {
      this.$notify(notification)
      this[ACTION_RESET_NOTIFICATION_INFO]('')
    },
  },
  setting: {
    panel_title: 'Danh mục album',
    frm_title: 'Sửa danh mục album',
    btn_save_txt: 'Cập nhật',
    btn_save_back_txt: 'Cập nhật trở về danh sách',
    error_msg_system: 'Danh mục album đã tồn tại',
  },
  mounted() {
    const infoId = parseInt(this.$route.params.infoId)
    if (infoId) {
      this[ACTION_GET_INFO_BY_ID](infoId)
    }
  },
}
</script>
