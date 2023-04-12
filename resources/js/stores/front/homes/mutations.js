import { INIT_LIST, SET_ERROR, } from '@app/stores/front/types/mutation-types'

export const MUTATIONS = {
  MAIN_MENU(state, value) {
    state.mainMenus = value
  },
  [INIT_LIST](state, payload) {
    state.pageLists = payload
  },
  [SET_ERROR](state, payload) {
    state.errors = payload
  },
  setLoading(state, payload) {
    state.loading = payload
  },
}
