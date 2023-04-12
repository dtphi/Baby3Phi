import {
  apiGetUserById,
  apiGetUsers,
  apiDeleteUser,
  apiSearchAll,
} from 'api@admin/user'
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
import {
  ACTION_GET_USER_LIST,
  ACTION_DELETE_USER_BY_ID,
  ACTION_SET_USER_DELETE_BY_ID,
  ACTION_RELOAD_GET_USER_LIST,
  ACTION_SET_LOADING,
  ACTION_SEARCH_ALL,
} from '../types/action-types'
import { MODULE_USER, } from '../types/module-types'

export const ACTIONS = {
  async [ACTION_GET_USER_LIST]({ dispatch, commit, }, params) { console.log(this)
    dispatch(ACTION_SET_LOADING, true)
    await apiGetUsers(
      (users) => {
        dispatch(
          'setConfigApp',
          {
            links: { ...users.links, },
            meta: { ...users.meta, },
            moduleActive: {
              name: MODULE_USER,
              actionList: ACTION_GET_USER_LIST,
            },
          },
          {
            root: true,
          }
        )
        commit(USERS_SET_USER_LIST, users.data.results)
        commit(USERS_GET_USER_LIST_SUCCESS, true)
      },
      (errors) => {
        commit(USERS_GET_USER_LIST_FAILED, false)
        commit(SET_ERROR, errors)
      },
      params
    )
    dispatch(ACTION_SET_LOADING, false)
  },

  async [ACTION_DELETE_USER_BY_ID]({ state, dispatch, commit, }) {
    await apiDeleteUser(
      state.userDelete.id,
      (users) => {
        if (users) {
          commit(USERS_DELETE_USER_BY_ID_SUCCESS, true)
          dispatch(ACTION_GET_USER_LIST)
          commit(USERS_USER_DELETE_BY_ID, null)
        }
      },
      (errors) => {
        commit(USERS_DELETE_USER_BY_ID_FAILED, false)
        commit(SET_ERROR, errors)
      }
    )
  },

  [ACTION_SET_USER_DELETE_BY_ID]({ commit, }, userId) {
    apiGetUserById(userId, (result) => {
      commit(USERS_USER_DELETE_BY_ID, result.data)
      commit(USERS_DELETE_USER_BY_ID_SUCCESS, false)
    })
  },

  [ACTION_RELOAD_GET_USER_LIST]: {
    root: true,
    handler(namespacedContext, payload) {
      namespacedContext.dispatch(ACTION_GET_USER_LIST, payload)
    },
  },

  [ACTION_SET_LOADING]({ commit, }, isLoading) {
    commit(USERS_SET_LOADING, isLoading)
  },

  [ACTION_SEARCH_ALL]({ dispatch, commit, }, query) {
    dispatch(ACTION_SET_LOADING, true)
    apiSearchAll(
      query,
      (result) => {
        if (result) {
          commit(USERS_GET_USER_LIST_SUCCESS, true)
          dispatch(ACTION_SET_LOADING, false)
        }
      },
      (errors) => {
        commit(USERS_GET_USER_LIST_FAILED, false)
        dispatch(ACTION_SET_LOADING, false)
        commit(SET_ERROR, errors)
      }
    )
  },
}
