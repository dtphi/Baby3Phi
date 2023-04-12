export default {
  methods: {
    checkLoad() {
      return this.$store.state.base.isLoaded[this.$route.name]
    },
    async sleepLogin() {
      let count = 0
      while (!this.$store.state.auth.check) {
        await this.ssleep(100)
        count += 100
        if (count > 3000) {
          break
        }
      }
      return this.$store.state.auth.isLogin
    },
    async loginOnly() {
      if (!(await this.sleepLogin())) {
        this.$router.replace('/login')
        return false
      }
      return true
    },
    async logoutOnly() {
      if (await this.sleepLogin()) {
        this.$router.replace('/')
        return false
      }
      return true
    },
    async sleep(msec) {
      await this.ssleep(msec)
    },
    ssleep(msec) {
      return new Promise((resolve) => setTimeout(resolve, msec))
    },
  },
}
