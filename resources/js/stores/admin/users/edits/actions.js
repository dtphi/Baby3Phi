import AppConfig from 'api@admin/constants/app-config'
import { apiGetUserById, apiUpdateUser, } from 'api@admin/user'
import {
  USERS_MODAL_SET_OPEN_MODAL,
  USERS_MODAL_SET_CLOSE_MODAL,
  USERS_MODAL_SET_IS_OPEN_MODAL,
  USERS_MODAL_SET_USER_ID,
  USERS_MODAL_SET_USER_ID_FAILED,
  USERS_MODAL_SET_USER,
  USERS_MODAL_SET_LOADING,
  USERS_MODAL_UPDATE_USER_SUCCESS,
  USERS_MODAL_UPDATE_USER_FAILED,
  USERS_MODAL_SET_ERROR,
} from '../../types/mutation-types'
import {
  ACTION_GET_USER_BY_ID,
  ACTION_SET_LOADING,
  ACTION_SHOW_MODAL,
  ACTION_CLOSE_MODAL,
  ACTION_IS_OPEN_MODAL,
  ACTION_UPDATE_USER,
  ACTION_RELOAD_GET_USER_LIST,
  ACTION_RESET_NOTIFICATION_INFO,
} from '../../types/action-types'

export const ACTIONS = {
  [ACTION_SHOW_MODAL]({ dispatch, commit, }, userId) {
    commit(USERS_MODAL_SET_USER_ID, userId)
    commit(USERS_MODAL_SET_OPEN_MODAL, 'edit')

    dispatch(ACTION_GET_USER_BY_ID, userId)
  },

  [ACTION_GET_USER_BY_ID]({ dispatch, commit, }, userId) {
    dispatch(ACTION_SET_LOADING, true)
    apiGetUserById(
      userId,
      (result) => {
        commit(USERS_MODAL_SET_USER, result.data)

        dispatch(ACTION_SET_LOADING, false)
        dispatch(ACTION_IS_OPEN_MODAL, true)
      },
      (errors) => {
        commit(USERS_MODAL_SET_USER_ID_FAILED, errors)

        dispatch(ACTION_SET_LOADING, false)
      }
    )
  },

  [ACTION_CLOSE_MODAL]({ dispatch, commit, }) {
    commit(USERS_MODAL_SET_CLOSE_MODAL)

    dispatch(ACTION_IS_OPEN_MODAL, false)
  },

  [ACTION_IS_OPEN_MODAL]({ commit, }, payload) {
    commit(USERS_MODAL_SET_IS_OPEN_MODAL, payload)
  },

  [ACTION_SET_LOADING]({ commit, }, isLoading) {
    commit(USERS_MODAL_SET_LOADING, isLoading)
  },

  [ACTION_UPDATE_USER]({ dispatch, commit, }, user) {
    dispatch(ACTION_SET_LOADING, true)
    apiUpdateUser(
      user,
      (result) => {
        if (result) {
          commit(
            USERS_MODAL_UPDATE_USER_SUCCESS,
            AppConfig.comUpdateNoSuccess
          )
          dispatch(ACTION_RELOAD_GET_USER_LIST, null, {
            root: true,
          })
          dispatch(ACTION_CLOSE_MODAL)
        }

        dispatch(ACTION_SET_LOADING, false)
      },
      (errors) => {
        commit(
          USERS_MODAL_UPDATE_USER_FAILED,
          AppConfig.comUpdateNoFail
        )
        dispatch(ACTION_SET_LOADING, false)
        commit(USERS_MODAL_SET_ERROR, errors)
      }
    )
  },

  [ACTION_RESET_NOTIFICATION_INFO]({ commit, }, values) {
    commit(USERS_MODAL_UPDATE_USER_SUCCESS, values)
  },
}
