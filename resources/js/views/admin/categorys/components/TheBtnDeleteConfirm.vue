<template>
  <b3p-button @click="_showConfirm" custom-color="danger" title="Xóa danh mục">
    <b3p-emoji emoji="remove"/>
  </b3p-button>
</template>

<script>
import { mapActions, } from 'vuex'
import { MODULE_NEWS_CATEGORY, } from 'store@admin/types/module-types'
import { ACTION_DELETE_NEWS_GROUP_BY_ID, } from 'store@admin/types/action-types'

export default {
  name: 'TheBtnDeleteConfirm',
  props: {
    categoryId: {
      type: Number,
      default: 0,
      validator: function (value) {
        return value && Number.isInteger(value)
      },
    },
  },
  methods: {
    ...mapActions(MODULE_NEWS_CATEGORY, [ACTION_DELETE_NEWS_GROUP_BY_ID]),
    _delete() {
      this[ACTION_DELETE_NEWS_GROUP_BY_ID](this.categoryId)
    },
    _showConfirm() {
      this.$modal.show('dialog', {
        title: 'Xóa Danh Mục Tin Tức',
        text: 'Bạn muốn xóa danh mục tin tức ?',
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
