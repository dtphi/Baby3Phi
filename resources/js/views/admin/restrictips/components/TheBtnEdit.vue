<template>
  <a
    href="javascript:void(0);"
    data-toggle="tooltip"
    @click="_showModal()"
    class="btn btn-default cms-btn"
    data-original-title="Sửa giao xứ"
  >
  <b3p-emoji emoji="edit" />
  </a>
</template>

<script>
import { fn_redirect_url, } from '@app/api/utils/fn-helper'

export default {
  name: 'TheButtonEditGiaoXu',
  props: {
    isRedirect: {
      type: Boolean,
      default: true,
    },
    infoId: {
      type: Number,
      default: 0,
      validator: value => {
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
      if (this.hrefEdit) return window.location.href = this.hrefEdit

      return fn_redirect_url(
        `${this.$cmsCfg.adminPrefix}/restrict-ips/edit/${this.infoId}`
      )
    },
  },
}
</script>
