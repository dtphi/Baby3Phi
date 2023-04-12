import Vue from 'vue'
import {
  ValidationObserver,
  ValidationProvider,
} from 'vee-validate'
import LoadingOverLay from 'vue-loading-overlay'
//import 'vue-loading-overlay/dist/vue-loading.css'
import { ToggleButton } from 'vue-js-toggle-button'
import B3pEmoji from 'com@admin/icons/B3pEmoji'
import B3pButton from 'com@admin/buttons/B3pButton'
// Widgets
import B3pSelect from 'com@admin/widgets/B3pSelect'
import B3pInput from 'com@admin/widgets/B3pInput'
import B3pTextarea from 'com@admin/widgets/B3pTextarea'
import B3pBreadcrumb from 'com@admin/widgets/B3pBreadcrumb'
import B3pSelectPerpage from 'com@admin/widgets/B3pSelectPerpage'
import B3pPagination from 'com@admin/widgets/B3pPagination'
import B3pGlobalSearch from 'com@admin/widgets/B3pGlobalSearch'
// Parts
import B3pPageHeader from 'com@admin/parts/B3pPageHeader'
// Templates
import B3pList from 'com@admin/templates/B3pList'
import B3pForm from 'com@admin/templates/B3pForm'

/*Add vee validate*/
Vue.component('ValidationObserver', ValidationObserver)
Vue.component('ValidationProvider', ValidationProvider)
/*Add vue loading overplay*/
Vue.component('LoadingOverLay', LoadingOverLay)
Vue.component('ToggleButton', ToggleButton)
/*Add vue custom B3p*/
Vue.component('B3pEmoji', B3pEmoji)
Vue.component('B3pButton', B3pButton)
Vue.component('B3pSelect', B3pSelect)
Vue.component('B3pBreadcrumb', B3pBreadcrumb)
Vue.component('B3pSelectPerpage', B3pSelectPerpage)
Vue.component('B3pPagination', B3pPagination)
Vue.component('B3pGlobalSearch', B3pGlobalSearch)
Vue.component('B3pInput', B3pInput)
Vue.component('B3pTextarea', B3pTextarea)
Vue.component('B3pPageHeader', B3pPageHeader)
Vue.component('B3pList', B3pList)
Vue.component('B3pForm', B3pForm)
