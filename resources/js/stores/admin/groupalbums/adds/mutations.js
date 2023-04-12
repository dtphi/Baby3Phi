import {
  INFOS_MODAL_SET_LOADING,
  INFOS_MODAL_INSERT_INFO_SUCCESS,
  INFOS_MODAL_INSERT_INFO_FAILED,
  SET_ERROR,
} from '../../types/mutation-types'

export const MUTATIONS = {
  [INFOS_MODAL_SET_LOADING](state, payload) {
    state.loading = payload
  },

  [INFOS_MODAL_INSERT_INFO_SUCCESS](state, payload) {
    state.insertSuccess = payload
  },

  [INFOS_MODAL_INSERT_INFO_FAILED](state, payload) {
    state.insertSuccess = payload
  },

  [SET_ERROR](state, payload) {
    state.errors = payload
  },
}
