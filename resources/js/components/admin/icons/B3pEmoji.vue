<template>
  <transition>
    <span v-if="emoji === 'save'" class="b3p-emoji">&#x1F4BE;</span>
    <span v-else-if="emoji === 'edit'" class="b3p-emoji">&#x270E;</span>
    <span v-else-if="emoji === 'times'" class="b3p-emoji">&times;</span>
    <span v-else-if="emoji === 'list'" class="b3p-emoji">&#x1F3AB;</span>
    <span v-else-if="emoji === 'back'" class="b3p-emoji">&#x21A9;</span>
    <span v-else-if="emoji === 'refresh'" class="b3p-emoji">&#x1F504;</span>
    <span v-else-if="emoji === 'remove'" class="b3p-emoji">&#x1F5D1;</span>
    <span v-else-if="emoji === 'search'" class="b3p-emoji">&#x1F50D;</span>
    <span v-else-if="emoji === 'plus'" class="b3p-emoji">&#x271A;</span>
    <span v-else-if="emoji === 'single-user'" class="b3p-emoji">&#x1F464;</span>
    <span v-else-if="emoji === 'category'" class="b3p-emoji">&#x1F4DA;</span>
    <span v-else-if="emoji === 'information'" class="b3p-emoji">&#x1F4F0;</span>
    <span v-else-if="emoji === 'photo'" class="b3p-emoji">&#x1F4F8;</span>
    <span v-else-if="emoji === 'exclamation-circle'" class="b3p-emoji">&#x2757;</span>
    <span v-else-if="emoji === 'module'" class="b3p-emoji">&#x1F50C;</span>
    <span v-else-if="emoji === 'setting'" class="b3p-emoji">&#x1F506;</span>
    <span v-else-if="emoji === 'indent'" class="b3p-emoji">&#x2630;</span>
    <span v-else-if="emoji === 'bell'" class="b3p-emoji">&#x1F514;</span>
    <span v-else-if="emoji === 'logout'" class="b3p-emoji">&#x26BF;</span>
    <span v-else-if="emoji === 'down'" class="b3p-emoji">&nabla;</span>
    <span v-else-if="emoji === 'star-antom'" class="b3p-emoji">&#x269B;</span>
    <span v-else></span>
  </transition>
</template>

<script>
export default {
  props: {
    emoji: {
      type: String,
      default: '',
    },
  },
}
</script>

<style>
.b3p-emoji {
  display: inline-block;
  font: normal normal normal 14px/1;
  font-size: inherit;
  text-rendering: auto;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}
</style>
