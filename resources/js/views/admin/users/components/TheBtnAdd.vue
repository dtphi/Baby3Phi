<template>
  <a
    href="javascript:void(0);"
    data-toggle="tooltip"
    @click="_showModal()"
    class="btn btn-primary"
    data-original-title="Thêm User"
  >
  <b3p-emoji emoji="plus" />
  </a>
</template>

<script>
import { mapActions, } from 'vuex'
import { MODULE_USER_MODAL, } from 'store@admin/types/module-types'
import { ACTION_SHOW_MODAL, } from 'store@admin/types/action-types'

export default {
  name: 'TheButtonAdd',
  methods: {
    ...mapActions(MODULE_USER_MODAL, {
      showModal: ACTION_SHOW_MODAL,
    }),
    _showModal() {
      this.showModal({ action: 'add', })
    },
  },
  setting: {
    btn_add_txt: 'Thêm người dùng',
  },
}
</script>
