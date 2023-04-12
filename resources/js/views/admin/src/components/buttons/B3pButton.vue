<template lang="pug">
.b3p-button(
  :is="isExternal ? 'a' : to !== '' ? 'nuxt-link' : 'button'"
  :to="to"
  :href="to"
  :target="isExternal ? '_blank' : ''"
  :class="[color, 'size' + size]"
  :disabled="disabled"
  @click="$emit('click')"
)
  slot
</template>

<script>
export default {
  props: {
    to: {
      type: String,
      default: '',
    },
    color: {
      type: String,
      default: '',
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
}
</script>

<style lang="stylus">
.b3p-button
  b3p-button-base()
  &.primary
    color color-white
    background var(--color-btnPositive, color-btn-positive)
    span
      color color-white
    &:hover
      background var(--color-btnPositiveHover, color-btn-positive-hover)
  &.inverce-primary
    color var(--color-btnPositive, color-btn-positive)
    background color-white
    border 1px solid var(--color-border, color-border)
    span
      color var(--color-btnPositive, color-btn-positive)
    &:hover
      color color-white
      background var(--color-btnPositive, color-btn-positive)
  &.error
    color color-white
    background var(--color-error, color-error)
    span
      color color-white
    &:hover
      background var(--color-error, color-error)
  &.negative
    color var(--color-fontLight2, color-font-light2)
    background var(--color-btnNegative, color-btn-negative)
    span
      color var(--color-fontLight2, color-font-light2)
    &:hover
      background var(--color-btnNegativeHover, color-btn-negative-hover)
  &.inverce-negative
    color var(--color-fontLight3, color-font-light3)
    background color-white
    border 1px solid var(--color-border, color-border)
    span
      color var(--color-fontLight3, color-font-light3)
    &:hover
      color var(--color-fontLight2, color-font-light2)
      background var(--color-btnNegativeHover, color-btn-negative-hover)
  &.sizeS
    width 120px
    height 38px
    font-size rem(14px)
</style>
