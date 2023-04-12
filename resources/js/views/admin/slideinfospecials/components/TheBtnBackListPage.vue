<template>
  <a
    :href="_getHref()"
    data-toggle="tooltip"
    title="Trở về"
    class="btn btn-default"
  >
  <b3p-emoji emoji="back" />
  </a>
</template>

<script>

export default {
  name: 'TheBtnBackListPage',
  methods: {
    _getHref() {
      return `${this.$cmsCfg.baseUrl}/${this.$cmsCfg.adminPrefix}/informations`
    },
  },
}
</script>
