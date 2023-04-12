<template>
  <div>
    <div class="col-sm-5">
      <label class="control-label">{{ groupData.date_available }}</label>
    </div>
    <div class="col-sm-5">
      <date-picker value-type="format" format="YYYY-MM-DD HH:mm:ss" v-model="data" type="datetime" />
    </div>
  </div>
</template>

<script>
  import DatePicker from 'vue2-datepicker'
  import 'vue2-datepicker/index.css'

export default {
  props: {
    groupData: {
      type: Object,
    },
  },
  data() {
    return {
      type: 'text',
      data: '',
    }
  },
  watch: {
    data(newData, oldData) {
      this.$emit('input', newData)
    }
  },
  components: { DatePicker, }
}
</script>
