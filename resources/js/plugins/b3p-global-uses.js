import Vue from 'vue'
import VModal from 'vue-js-modal'
import Notifications from 'vue-notification'
import Router from 'vue-router'

Vue.config.productionTip = false

/* user router */
Vue.use(Router)

/*Add vue js modal and dialog*/
Vue.use(VModal, {
  dialog: true,
  dynamic: true,
  dynamicDefaults: {
    clickToClose: false,
  },
})

/*Add vue notification*/
Vue.use(Notifications)
