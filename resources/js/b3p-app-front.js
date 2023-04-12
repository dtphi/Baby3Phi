require('./b3p-app-bootstrap')
require('./views/front/b3p-init')

import routes from './routes/b3p-rts-front'
import store from 'store@front'
import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

const layout = JSON.parse(window.page.replace(/\\/g, '\\\\'))
const router = new Router({
  history: true,
  mode: 'history',
  routes: [
    ...routes
  ],
})
const initParamsApp = {
  type: 'init',
  pathName: window.location.pathname,
  layout: layout.page,
}
router.beforeEach(async(to, from, next) => {
  if (Object.keys(to.meta.layout_content).length === 0) {
    to.meta.layout_content = layout.layout_content
  }
  next()
})
store.dispatch('appSettings', initParamsApp).then(() => {
  return new Vue({
    el: '#babi-3-phi-front',
    router,
    store,
  })
})
delete window.page
delete window['page']
