<template>
  <ul class="cms-breadcrumb">
    <li>
      <input v-model="query" type="text" class="form-control" placeholder="Tìm kiếm" aria-describedby="basic-addon2" />
    </li>
    <li>
      <b3p-button @click="getResults" @keyup.enter="getResults" custom-color="primary cms-btn"
        original-title="Tìm kiếm">
        <b3p-emoji emoji="search"/>
      </b3p-button>
    </li>
  </ul>
</template>

<script>
import { mapMutations, } from 'vuex'
import { MODULE_MODULE_RESTRICT_IP, } from 'store@admin/types/module-types'
import {
  INFOS_SET_INFO_LIST,
} from 'store@admin/types/mutation-types'
import debounce from 'lodash/debounce'

export default {
  name: 'ListSearch',
  data() {
    return {
      query: '',
      errors: null,
    }
  },
  watch: {
    query: {
      handler: debounce(function () {
        this.getResults()
      }, 500),
    },
  },
  methods: {
    ...mapMutations(MODULE_MODULE_RESTRICT_IP, {
      'setResIp': INFOS_SET_INFO_LIST,
    }),
    getResults() {
      axios.get('/api/search-ips', { params: { query: this.query, }, })
        .then(res => {
          this.setResIp(res.data.data.results)
        })
        .catch(error => { this.$data.errors = error })
    },
  },
}
</script>
