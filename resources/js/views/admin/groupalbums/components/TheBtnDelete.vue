<template>
  <b3p-button @click="_showConfirm" custom-color="danger" title="Xóa danh mục">
    <b3p-emoji emoji="remove" />
  </b3p-button>
</template>

<script>
import { mapActions, mapGetters, } from 'vuex'
import { MODULE_MODULE_GROUP_ALBUMS, } from 'store@admin/types/module-types'
import { ACTION_DELETE_INFO_BY_ID, } from 'store@admin/types/action-types'

export default {
  name: 'TheButtonDeleteItem',
  props: {
    infoId: {
      type: Number,
      default: 0,
      validator: function (value) {
        return value && Number.isInteger(value)
      },
    },
    no: {
      type: Number,
    },
  },
  computed: {
    ...mapGetters(MODULE_MODULE_GROUP_ALBUMS, ['infos']),
  },
  methods: {
    ...mapActions(MODULE_MODULE_GROUP_ALBUMS, [ACTION_DELETE_INFO_BY_ID]),

    _delete() {
      this[ACTION_DELETE_INFO_BY_ID](this.infoId)
    },
    _showConfirm() {
      this.$modal.show('dialog', {
        title: 'Xóa Danh Mục Album',
        text: 'Bạn muốn xóa danh mục album ?',
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
              this.$delete(this.infos, this.no)
              this._delete()
              this.$modal.hide('dialog')
            },
          }
        ],
      })
    },
  },
}
</script>
