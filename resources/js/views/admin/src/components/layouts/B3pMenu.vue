<template lang="pug">
.b3p-menu(:class="{ hide: !$store.state.base.nav.isOpen }")
  .mark
    .parent
      ul.top
        li(
          v-for="nav in $get($store.state.base.global.menu, 'top')"
          :key="nav.icon"
          :class="{ act: checkUrl(nav.code) || selectNav.name == nav.name }"
        )
          .menu
            a(@click="clickParent(nav)")
              .before
              b3pBadge.en(v-if="nav.unread") {{ nav.unread }}
              .icon
                font-awesome-icon(:icon="$options.filters.icon(nav.icon)")
              span.name {{ nav.name }}
      ul.bottom
        li(
          v-for="nav in $get($store.state.base.global.menu, 'bottom')"
          :key="nav.icon"
          :class="{ act: checkUrl(nav.code) || selectNav.name == nav.name }"
        )
          .menu
            nuxt-link(:to="nav.to" @click="clickParent(nav)")
              .before
              b3pBadge.en(v-if="nav.unread") {{ nav.unread }}
              .icon
                font-awesome-icon(:icon="$options.filters.icon(nav.icon)")
              span.name {{ nav.name }}
    .detail(
        v-if="selectNav.name"
      )
      .tit
        .icon
          font-awesome-icon(:icon="$options.filters.icon(selectNav.icon)" size="lg")
        h3 {{ selectNav.name }}
      ul
        li(v-for="child in selectNav.children" :class="{ act: (checkUrl(child.to)) }")
          nuxt-link(:to="child.to") {{ child.name }}
</template>

<script>
export default {
  data() {
    return {
      act: '',
      selectNav: {},
    }
  },
  computed: {
    base() {
      return this.$store.state.base
    },
  },
  async mounted() {
    this.$store.dispatch('base/addLoadTask', 'b3pMenu')
    try {
      await this.$store.dispatch('base/getMenus')
      this.$store.state.base.global.menu.top.forEach((nav) => {
        if (this.$route.path.includes(nav.to)) {
          this.act = nav.name
          this.selectNav = nav
        }
      })
    } finally {
      this.$store.dispatch('base/removeLoadTask', 'b3pMenu')
    }
  },
  methods: {
    checkUrl(url) {
      if (url === '/') {
        return this.$route.path === url
      }
      return this.$route.path.indexOf(url) === 0
    },
    clickParent(nav) {
      if (nav.children) {
        if (this.act === nav.name) {
          this.$store.dispatch('base/changeNavDetail', false)
          this.act = ''
        } else {
          this.$store.dispatch('base/changeNavDetail', true)
          this.act = nav.name
          this.selectNav = nav
        }
      } else {
        this.$router.push(nav.to)
      }
    },
  },
}
</script>

<style lang="stylus">
.b3p-menu
  height 100%
  &.hide
    .mark
      .parent
        width 58px
        li
          &:hover
          &.act
            .menu
              a
                .before
                  width calc(58px - 5px)
  .mark
    width 100%
    height 100%
    background var(--color-bgSub, color-bg-sub)
    position relative
    overflow hidden
    z-index 2
    display flex
    .parent
      width 230px
      transition .2s
      display flex
      flex-direction column
      justify-content space-between
      +bp(sm)
        width 100%
      > ul
        padding-top 46px
        width 230px
        &.bottom
          padding-top 0
        +bp(sm)
          padding-top 0
          width 100%
          height auto
          display flex
          align-items flex-start
          flex-wrap wrap
        > li
          position relative
          height 43px
          +bp(sm)
            height auto
            width calc(100% / 3 - 2% )
            border 1px solid var(--color-border, color-border)
            box-sizing border-box
            margin 0 3% 2% 0
            border-radius 8px
            &:nth-child(3n)
              margin-right 0
          + li
            margin-top 2px
            +bp(sm)
              margin-top 0
          .before
            display inline-block
            opacity 0
            width 3px
            height 33px
            border-radius 0 5px 5px 0
            background @css{rgba(var(--color-mainLight2-10, color-main-light2-10), .2)}
            position absolute
            left 0
            top 0
            bottom 0
            margin auto
            z-index 1
            +bp(sm)
              transform rotate(-90deg)
              top initial
              bottom -15px
              right 0
          .menu
            &:before
              +bp(sm)
                content ''
                width 100%
                display block
                padding-top 100%
            .icon
              width 58px
            a
              height 44px
              box-sizing border-box
              display flex
              align-items center
              justify-content flex-start
              position relative
              cursor pointer
              +bp(sm)
                height auto
                flex-direction column
                justify-content center
                position absolute
                top 0
                bottom 0
                right 0
                left 0
                margin auto
              .icon
                width 58px
                display flex
                justify-content center
                z-index 1
                svg
                  color var(--color-icon, color-icon)
                  +bp(md)
                    font-size 200%
              .num
                display none
              .name
                font-size rem(14px)
                font-weight 900
                margin-left 12px
                min-width 160px
                transform translateX(0px)
                transition .3s
                +bp(sm)
                  font-size 10px
                  margin-left 0
                  margin-top 15px
                  min-width initial
                  text-align center
          &:hover
          &.act
            +bp(sm)
              background @css{rgba(var(--color-mainLight2-10, color-main-light2-10), .2)}
            &:before
              opacity 1
            .menu
              a
                .before
                  display block
                  opacity 1
                  z-index 0
                  position absolute
                  width calc(100% - 10px)
                  height 100%
                  border-radius 0 8px 8px 0
                  transition .3s
                +bp(sm)
                  .before
                    background none
              a
                .icon
                  svg
                    color var(--color-iconHover, color-icon-hover)
            .name
              color var(--color-main, color-main)
  .detail
    width 232px
    height 100%
    background var(--color-bgSub, color-bg-sub)
    box-shadow 10px 0 20px 0 color-shadow
    border-left 1px solid var(--color-border, color-border)
    transition width .2s
    z-index 3
    +bp(sm)
      display none
    .tit
      width 202px
      height 88px
      background linear-gradient(129deg, var(--color-mainDark3, color-main-dark3) 0%, var(--color-mainDark2, color-main-dark2) 35%, var(--color-mainLight1, color-main-light1) 120%)
      border-radius 8px
      margin 10px 14px 0
      display flex
      justify-content center
      flex-direction column
      box-sizing border-box
      padding 20px
      .icon
        svg
          color color-white
      h3
        color color-white
        font-size rem(15px)
        font-weight 900
        margin-top 5px
    ul
      margin 23px 24px 0
      li
        font-size rem(13px)
        font-weight bold
        width 100%
        height 36px
        &.act
          a
            background @css{rgba(var(--color-mainLight2-10, color-main-light2-10), .2)}
            color var(--color-main, color-main)
        a
          display flex
          align-items center
          text-indent 9px
          height 100%
          border-radius 8px
          cursor pointer
          color var(--color-font, color-font)
          &:hover
            background @css{rgba(var(--color-mainLight2-10, color-main-light2-10), .2)}
            color var(--color-main, color-main)
</style>
