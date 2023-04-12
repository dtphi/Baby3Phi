<template>
  <a
    href="javascript:void(0);"
    data-toggle="tooltip"
    @click="_showModal()"
    class="btn btn-default cms-btn"
    data-original-title="Sửa User"
  >
  <b3p-emoji emoji="edit" />
  </a>
</template>

<script>
import { mapActions, } from 'vuex'
import { MODULE_USER_EDIT_MODAL, } from 'store@admin/types/module-types'
import { ACTION_SHOW_MODAL, } from 'store@admin/types/action-types'

export default {
  name: 'TheButtonEdit',
  props: {
    userId: {
      type: Number,
      default: 0,
      validator: (value) => {
        return value && Number.isInteger(value)
      },
    },
  },
  methods: {
    ...mapActions(MODULE_USER_EDIT_MODAL, {
      showModal: ACTION_SHOW_MODAL,
    }),
    _showModal() {
      this.showModal(this.userId)
    },
  },
}
</script>
