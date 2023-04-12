<template>
  <a
    href="javascript:void(0);"
    data-toggle="tooltip"
    @click="_showDiaglogConfirm()"
    class="btn btn-default cms-btn"
    data-original-title="Xóa"
  >
  <b3p-emoji emoji="remove" />
  </a>
</template>

<script>
import { mapActions, } from 'vuex'
import { MODULE_INFO, } from 'store@admin/types/module-types'
import {
  ACTION_SET_INFO_DELETE_BY_ID,
  ACTION_DELETE_INFO_BY_ID,
} from 'store@admin/types/action-types'

export default {
  name: 'TheButtonDelete',
  props: {
    infoId: {
      type: Number,
      default: 0,
      validator: function(value) {
        return value && Number.isInteger(value)
      },
    },
  },
  data() {
    return {}
  },
  methods: {
    ...mapActions(MODULE_INFO, {
      setInfoDelete: ACTION_SET_INFO_DELETE_BY_ID,
      deleteInfo: ACTION_DELETE_INFO_BY_ID,
    }),
    _showDiaglogConfirm() {
      this.setInfoDelete(this.infoId)
      this.$modal.show('dialog', {
        title: 'Xóa Tin Tức',
        text: 'Bạn muốn xóa tin tức ?',
        buttons: [
          {
            title: 'Hủy',
            handler: () => {
              this.$modal.hide('dialog')
            },
          },
          {
            title: 'Xóa',
            handler: () => {
              this.deleteInfo(this.infoId)
              this.$modal.hide('dialog')
            },
          }
        ],
      })
    },
  },
}
</script>
