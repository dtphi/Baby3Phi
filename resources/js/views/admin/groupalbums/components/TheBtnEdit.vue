<template>
  <b3p-button @click="_showModal" custom-color="primary" title="Chi tiết danh mục">
    <b3p-emoji emoji="edit" />
  </b3p-button>
</template>

<script>
import { fn_redirect_url, } from '@app/api/utils/fn-helper'

export default {
  name: 'TheButtonEditAlbumCategory',
  props: {
    isRedirect: {
      type: Boolean,
      default: true,
    },
    infoId: {
      type: Number,
      default: 0,
      validator: (value) => {
        return value && Number.isInteger(value)
      },
    },
    hrefEdit: {
      type: String,
      default: '',
    },
  },
  data() {
    return {}
  },
  methods: {
    _showModal() {
      if (this.isRedirect) {
        this._redirectUrl()
      }
    },
    _redirectUrl() {
      if (this.hrefEdit) return (window.location.href = this.hrefEdit)

      return fn_redirect_url(
        `${this.$cmsCfg.adminPrefix}/group-albums/edit/${this.infoId}`
      )
    },
  },
}
</script>
