<template>
  <transition>
    <a v-if="isExternal" @click="$emit('click')" data-toggle="tooltip" class="btn" :class="_class"
      :data-original-title="originalTitle" :href="to">
      {{ customTitle }}
      <slot></slot>
    </a>
    <button v-else @click="$emit('click')" type="button" data-toggle="tooltip" :title="customTitle" class="btn"
      :class="_class" :data-original-title="originalTitle">
      <slot></slot>
    </button>
  </transition>
</template>

<script>
export default {
  props: {
    customTitle: {
      type: String,
      default: '',
    },
    originalTitle: {
      type: String,
      default: 'Button',
    },
    to: {
      type: String,
      default: '',
    },
    customColor: {
      type: String,
      default: 'default',
    },
    size: {
      type: String,
      default: '',
    },
    isExternal: {
      type: Boolean,
      default: false,
    },
    disabled: {
      type: Boolean,
      default: false,
    },
  },
  computed: {
    _class() {
      return (this.customColor) ? 'btn-' + this.customColor + ' cms-btn' : 'btn-default cms-btn'
    }
  },
}
</script>

<style>
.cms-btn {
  margin-left: 0.7rem;
}
</style>
