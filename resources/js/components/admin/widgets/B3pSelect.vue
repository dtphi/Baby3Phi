<template>
  <div>
    <select :value="value" @input="input" @blur="input" class="form-control">
      <option v-if="isShowDefault" value=""> {{ options.defaultText || 'Chọn giá trị' }} </option>
      <option v-for="(item, idx) in items" :value="item[itemKey]" :key="idx"> {{ item[itemLabel] }} </option>
    </select>
  </div>
</template>

<script>
export default {
  props: {
    value: {
      type: [String, Number],
      default: '',
    },
    name: {
      type: String,
      default: '',
    },
    column: {
      type: String,
      default: '',
    },
    rules: {
      type: String,
      default: '',
    },
    items: {
      type: Array,
      default: () => [],
    },
    itemKey: {
      type: String,
      default: 'value',
    },
    itemLabel: {
      type: String,
      default: 'label',
    },
    isShowError: {
      type: Boolean,
      default: true,
    },
    options: {
      type: Object,
      default: () => ({}),
    },
  },
  data() {
    return {
      isShowDefault: true,
    }
  },
  mounted() {
    if (this.options.isShowDefault !== undefined) {
      this.isShowDefault = this.options.isShowDefault
    }
  },
  methods: {
    input(e) {
      this.$emit('input', e.target.value)
      this.$emit('change', e.target.value)
      if (this.options.filter) {
        this.$emit('filtering', e.target.value)
      }
    },
  },
}
</script>
