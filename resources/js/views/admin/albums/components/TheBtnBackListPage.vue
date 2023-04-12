<template>
  <b3p-button :is-external="true" :to="_getHref()" custom-color="primary" original-title="Trở lại danh sách">
    <b3p-emoji emoji="back" />
  </b3p-button>
</template>

<script>
import {
  config,
} from '@app/common/b3p-admin-config'

export default {
  name: 'TheBtnBackListPage',
  props: {},
  methods: {
    _getHref() {
      return `${this.$cmsCfg.baseUrl}/${config.adminPrefix}/albums`
    },
  },
}
</script>
