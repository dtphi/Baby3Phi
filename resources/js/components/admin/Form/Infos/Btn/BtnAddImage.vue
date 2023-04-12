<template>
  <b3p-button @click="_showModal" :original-title="$options.setting.btn_add_txt">
    <b3p-emoji emoji="plus" />
  </b3p-button>
</template>

<script>
import { mapActions, } from 'vuex'
import { MODULE_USER_MODAL, } from 'store@admin/types/module-types'
import { ACTION_SHOW_MODAL, } from 'store@admin/types/action-types'

export default {
  name: 'TheButtonAdd',
  methods: {
    ...mapActions(MODULE_USER_MODAL, [ACTION_SHOW_MODAL]),
    _showModal() {
      this[ACTION_SHOW_MODAL]({ action: 'add', })
    },
  },
  setting: {
    btn_add_txt: 'Thêm hình ảnh bổ sung',
  },
}
</script>
