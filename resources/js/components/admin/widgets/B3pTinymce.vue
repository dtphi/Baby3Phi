<template>
  <div>
    <validation-provider v-slot="{ errors }" :rules="getRules" :name="column" :vid="name" ref="provider" tag="div">
      <tinymce :id="id" :other_options="other_options" v-model="data" />
      <span class="cms-text-red">{{ errors[0] }}</span>
    </validation-provider>
  </div>
</template>

<script>
import tinymce from 'vue-tinymce-editor'
export default {
  components: {
    tinymce,
  },
  props: {
    name: {
      type: String,
      default: '',
    },
    id: {
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
    isShowError: {
      type: Boolean,
      default: true,
    },
    options: {
      type: Object,
      default: () => ({}),
    },
    other_options: {
      type: Object,
      default: () => ({}),
    },
  },
  data() {
    return {
      maxlength: 500,
      type: 'textarea',
      data: '',
    }
  },
  computed: {
    getRules() {
      return this.rules.charAt(0) === '{' ? JSON.parse(this.rules) : this.rules
    },
  },
  watch: {
    data(newData, oldData) {
      this.$emit('input', newData)
    }
  },
  mounted() {
    if (this.options.maxLength) this.maxLength = this.options.maxLength
    if (this.options.type) this.type = this.options.type
  },
}
</script>
