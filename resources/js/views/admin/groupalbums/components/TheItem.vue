<template>
  <tr>
    <td class="text-center">
      <input type="checkbox" name="selected[]" :id="`info_select_id_${info.id}`" :value="info.id" />
    </td>
    <td>{{ _getNo() }}</td>
    <td class="text-left">{{ info.group_name }}</td>
    <td class="text-left">
      <b3p-button @click="_changeStatus" title="Thay đổi trạng thái">
        <i v-if="info.status == 1" class="fa fa-check-circle btn_blue"></i>
        <i v-else class="fa fa-minus-circle btn_red"></i>
      </b3p-button>
    </td>
    <td class="text-right">
      <the-btn-edit :info-id="info.id"></the-btn-edit>
      <the-btn-delete :info-id="info.id" :no="no"></the-btn-delete>
    </td>
  </tr>
</template>

<script>
import TheBtnEdit from './TheBtnEdit'
import TheBtnDelete from './TheBtnDelete'
import { mapState, mapActions, } from 'vuex'
import { MODULE_MODULE_GROUP_ALBUMS, } from 'store@admin/types/module-types'
import {
  ACTION_CHANGE_STATUS,
} from 'store@admin/types/action-types'

export default {
  name: 'TheItem',
  components: {
    TheBtnEdit,
    TheBtnDelete,
  },
  props: {
    info: {
      type: Object,
    },
    no: {
      default: 1,
    },
  },
  data() {
    return {}
  },
  computed: {
    ...mapState({
      meta: state => state.cfApp.collectionData,
      perPage: state => state.cfApp.perPage,
    }),
  },
  methods: {
    _getNo() {
      return parseInt(this.no) + parseInt(this.meta.from)
    },
    ...mapActions(MODULE_MODULE_GROUP_ALBUMS, [
      ACTION_CHANGE_STATUS,
    ]),
    _changeStatus() {
      if (this.info.status == 1) {
        this.info.status = 0
      } else { this.info.active = 1 }
      this[ACTION_CHANGE_STATUS]({ id: this.info.id, status: this.info.status, perPage: this.perPage, })
    },
  },
}
</script>
<style scoped>
.btn_blue {
  color: blue;
}

.btn_red {
  color: red;
}
</style>
