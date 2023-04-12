require('./b3p-app-bootstrap')
require('./views/admin/b3p-init')
import Vue from 'vue'
import {
  config,
} from './common/b3p-admin-config'
import routes from './routes/b3p-rts-admin'
import store from 'store@admin'
import Router from 'vue-router'

const envBuild = process.env.NODE_ENV

const router = new Router({
  history: config.adminRoute.history,
  mode: config.adminRoute.mode,
  routes: [
    ...routes
  ],
})

router.beforeEach(async(to, from, next) => {
  document.title = to.meta.title
  if (store.state.auth.authenticated) {
    if (to.name === config.adminRoute.login.name) {
      window.location.href = store.state.auth.redirectUrl
    } else {
        next()
        return
    }
  } else {
    if (to.name === config.adminRoute.login.name) {
      next()
      return
    }
    window.location.href = store.state.auth.redirectLogoutUrl
  }
  next()
})

store.dispatch('auth/admin', {
  type: 'init',
}).then(() => {
  return new Vue({
    el: '#babi-3-phi-admin',
    router,
    store,
  })
})
