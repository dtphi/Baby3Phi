import { apiEmailSubscribe, } from '@app/api/front/subscribes'
import { SET_ERROR, SET_LOADING,
} from '@app/stores/front/types/mutation-types'

export const ACTIONS = {
  ACTION_SUBSCRIBE_REGISTRY_TO_NEWSLETTER({ commit, }, subscribe) {
    commit(SET_LOADING, true)
    apiEmailSubscribe(subscribe,
      (responses) => {
        if (responses) {
          commit(SET_ERROR, [])
          commit(SET_LOADING, false)
          commit('RESET_SUB', '')
          commit('SET_INSERT_SUCCESS', true)
        }
      },
      (errors) => {
        commit(SET_ERROR, errors)
        commit(SET_LOADING, false)
        commit('SET_INSERT_SUCCESS', false)
      })
  },
  RESET_NOTIFICATION({ commit, }, msg) {
    commit('SET_INSERT_SUCCESS', msg)
  },
}
