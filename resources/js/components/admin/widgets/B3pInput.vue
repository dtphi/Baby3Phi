<template>
  <div>
    <validation-provider v-slot="{ errors }" :rules="getRules" :name="column" :vid="name" ref="provider" tag="div">
      <input :class="{ error: errors.length }" :name="name" :value="value" :maxlength="options.maxlength"
        :type="options.type" :placeholder="options.placeholder" @input="input" @blur="blur" @keydown.enter="enter"
        @pointerdown="pointerdown" class="form-control" />
      <span class="cms-text-red">{{ errors[0] }}</span>
    </validation-provider>
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
      maxlength: 100,
      type: 'text',
    }
  },
  computed: {
    getRules() {
      return this.rules.charAt(0) === '{' ? JSON.parse(this.rules) : this.rules
    },
  },
  mounted() {
    if (this.options.maxLength) this.maxLength = this.options.maxLength
    if (this.options.type) this.type = this.options.type
  },
  methods: {
    input(e) {
      this.$emit('input', e.target.value)
      this.$emit('change', e.target.value)
    },
    blur(e) {
      this.$emit('input', e.target.value)
      this.$emit('change', e.target.value)
      this.$emit('blur', e.target.value)
    },
    enter(e) {
      this.$emit('enter', e.target.value)
    },
    pointerdown(e) {
      this.$emit('pointerdown', e)
    },
  },
}
</script>
