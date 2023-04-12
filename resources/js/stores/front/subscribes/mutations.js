import { SET_SUBSCRIBE, SET_ERROR, SET_LOADING,
} from '@app/stores/front/types/mutation-types'

export const MUTATIONS = {
  [SET_SUBSCRIBE](state, payload) {
    state.subscribe = payload
  },
  [SET_ERROR](state, payload) {
    state.errors = payload
  },
  [SET_LOADING](state, payload) {
    state.loading = payload
  },
  RESET_SUB(state, payload) {
    state.subscribe.email = payload
  },
  SET_INSERT_SUCCESS(state, payload) {
    state.insertSuccess = payload
  },
}
