import { apiGetLists, } from '@app/api/front/homes'
import { INIT_LIST, SET_ERROR, } from '@app/stores/front/types/mutation-types'
import { GET_LISTS, } from '@app/stores/front/types/action-types'

export const ACTIONS = {
  [GET_LISTS]({ commit, }, options) {
    commit('setLoading', true)
    apiGetLists((responses) => {
      commit(INIT_LIST, responses.pageLists)
      commit(SET_ERROR, [])
      commit('setLoading', false)
    }, (errors) => {
      commit(SET_ERROR, errors)
      commit('setLoading', false)
    }, options)
  },
}
