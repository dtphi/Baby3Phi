<template>
  <b3p-button href="javascript:void(0)" :is-external="true" @click="_logout" custom-color="b3p nav-link"
    original-title="Logout Admin">
    <span class="hidden-xs hidden-sm hidden-md">Thoát</span>
    <b3p-emoji emoji="logout" />
  </b3p-button>
</template>

<script>
import { mapGetters, mapActions, } from 'vuex'

export default {
  name: 'LogoutSideBar',
  computed: {
    ...mapGetters('auth', ['authenticated']),
  },
  methods: {
    ...mapActions({
      signOut: 'auth/signOut',
      redirectLogout: 'auth/redirectLogoutSuccess',
    }),
    async _submit() {
      await this.signOut()
      if (!this.authenticated) {
        this.redirectLogout()
      }
    },
    _logout() {
      this._submit()
    },
  },
}
</script>
