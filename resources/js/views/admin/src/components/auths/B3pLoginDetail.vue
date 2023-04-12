<template lang="pug">
.b3p-login-detail
  .select-channel
  .thumbnail(@click="toggleMenu") Img
  ul.colorscheme(v-if="isShowColorscheme" v-click-outside="hideMenu")
    li(v-for="cs in colorschemes" @click="$store.dispatch('base/changeColorscheme', cs.code)") {{ cs.name }}
  span.login-name {{ userName }}
  .logout
    B3pButton(color="inverce-negative" @click="logout") Đăng xuất
</template>

<script>
import B3pButton from '../buttons/B3pButton.vue'
export default {
  components: { B3pButton },
  props: {
    userAvatar: {
      type: String,
      default: '/logo.png',
    },
  },
  data() {
    return {
      isShowColorscheme: false,
      colorschemes: ['#333333', '#ffffff'],
      userName: 'User name',
    }
  },
  methods: {
    async logout() {
      await this.$store.dispatch('auth/postLogout')
      window.location.href = '/login'
    },
    hideMenu() {
      this.isShowColorscheme = false
    },
    async toggleMenu() {
      /* this.$store.dispatch('base/showLoading')
            if (this.$store.state.base.colorschemes.length === 0) {
              await this.$store.dispatch('base/getColorschemes')
            }
            this.isShowColorscheme = !this.isShowColorscheme
            this.$store.dispatch('base/hideLoading') */
    },
  },
}
</script>

<style lang="stylus">
.b3p-login-detail
  display flex
  align-items center
  position relative
  +bp(sm)
    padding 15px 2%
    box-sizing border-box
    justify-content center
    border-bottom 1px solid var(--color-border, color-border)
  .select-channel
    margin-right 15px
  .thumbnail
    width 30px
    height 30px
    margin-right 15px
    border-radius 50%
    border 1px solid var(--color-border, color-border)
    display flex
    align-items center
    justify-content center
    +bp(sm)
      margin-right 10px
  .colorscheme
    position absolute
    top 50px
    background var(--color-bgSub, color-bg-sub)
    border-radius 5px
    box-shadow 0 0 20px color-shadow
    li
      font-size rem(14px)
      font-weight bold
      cursor pointer
      padding 5px 15px
      + li
        border-top 1px solid var(--color-border, color-border)
  .login-name
    font-size rem(14px)
    line-height rem(19px)
    font-weight 900
    margin-right 30px
  .logout
    width 80px
    min-width 60px
    height 30px
    border 1px solid var(--color-border, color-border)
    box-sizing border-box
    border-radius 4px
    display flex
    align-items center
    justify-content center
    cursor pointer
    .b3p-button
      font-size rem(12px)
      height 30px
      font-weight 700
</style>
