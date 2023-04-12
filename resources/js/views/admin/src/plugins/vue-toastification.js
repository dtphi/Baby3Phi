import Vue from 'vue'
import Toast from 'vue-toastification'
import 'vue-toastification/dist/index.css'

Vue.use(Toast, {
  position: 'bottom-center',
  timeout: 5000,
  hideProgressBar: true,
  closeButton: 'button',
  transition: 'Vue-Toastification__fade',
  maxToasts: 20,
})
