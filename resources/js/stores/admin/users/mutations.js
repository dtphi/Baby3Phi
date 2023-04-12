import {
  USERS_SET_LOADING,
  USERS_GET_USER_LIST_SUCCESS,
  USERS_GET_USER_LIST_FAILED,
  USERS_DELETE_USER_BY_ID_SUCCESS,
  USERS_DELETE_USER_BY_ID_FAILED,
  USERS_SET_USER_LIST,
  USERS_USER_DELETE_BY_ID,
  SET_ERROR,
} from '../types/mutation-types'

export const GETTERS = {
  users(state) {
    return state.users
  },
  loading(state) {
    return state.loading
  },
  errors(state) {
    return state.errors
  },
  isError(state) {
    return state.errors.length
  },
}

export const MUTATIONS = {
  [USERS_SET_USER_LIST](state, payload) {
    state.users = payload
  },
  [USERS_USER_DELETE_BY_ID](state, payload) {
    state.userDelete = payload
  },
  [USERS_GET_USER_LIST_SUCCESS](state, payload) {
    state.isList = payload
  },
  [USERS_GET_USER_LIST_FAILED](state, payload) {
    state.isList = payload
  },
  [USERS_DELETE_USER_BY_ID_SUCCESS](state, payload) {
    state.isDelete = payload
  },
  [USERS_DELETE_USER_BY_ID_FAILED](state, payload) {
    state.isDelete = payload
  },
  [USERS_SET_LOADING](state, payload) {
    state.loading = payload
  },
  [SET_ERROR](state, payload) {
    state.errors = payload
  },
}
