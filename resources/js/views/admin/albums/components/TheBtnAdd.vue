<template>
    <button @click="_redirectUrl()"
            data-toggle="tooltip" title=""
            class="btn btn-primary"
            data-original-title="Thêm Album">
            <b3p-emoji emoji="plus" />
    </button>
</template>

<script>
import {
  fn_redirect_url,
} from '@app/api/utils/fn-helper'
import {
  config,
} from '@app/common/b3p-admin-config'

export default {
  name: 'AddRestrictIp',
  props: {
    isRedirect: {
      type: Boolean,
      default: true,
    },
  },
  methods: {
    _redirectUrl() {
      return fn_redirect_url(`${config.adminPrefix}/albums/add`)
    },
  },
}
</script>
