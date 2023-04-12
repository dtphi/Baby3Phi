import AppConfig from 'api@admin/constants/app-config'
import { apiInsertResIp, } from 'api@admin/restrictip'
import {
  INFOS_MODAL_SET_LOADING,
  INFOS_MODAL_INSERT_INFO_SUCCESS,
  INFOS_MODAL_INSERT_INFO_FAILED,
  SET_ERROR,
} from '../../types/mutation-types'
import {
  ACTION_SET_LOADING,
  ACTION_INSERT_INFO,
  ACTION_INSERT_INFO_BACK,
  ACTION_RESET_NOTIFICATION_INFO,
} from '../../types/action-types'

export const ACTIONS = {
  [ACTION_SET_LOADING]({ commit, }, isLoading) {
    commit(INFOS_MODAL_SET_LOADING, isLoading)
  },

  [ACTION_INSERT_INFO]({ dispatch, commit, }, info) {
    dispatch(ACTION_SET_LOADING, true)
    apiInsertResIp(
      info,
      (result) => {
        if (result) {
          commit(
            INFOS_MODAL_INSERT_INFO_SUCCESS,
            AppConfig.comInsertNoSuccess
          )
          commit(SET_ERROR, [])
          dispatch(ACTION_SET_LOADING, false)
        }
      },
      (errors) => {
        commit(
          INFOS_MODAL_INSERT_INFO_FAILED,
          AppConfig.comUpdateNoFail
        )
        commit(SET_ERROR, errors)
        dispatch(ACTION_SET_LOADING, false)
      }
    )
  },

  [ACTION_INSERT_INFO_BACK]({ dispatch, commit, }, info) {
    apiInsertResIp(
      info,
      (result) => {
        if (result) {
          commit(
            INFOS_MODAL_INSERT_INFO_SUCCESS,
            AppConfig.comInsertNoSuccess
          )
          dispatch(
            'ACTION_RELOAD_GET_INFO_LIST_RESTRICT_IP',
            'page',
            {
              root: true,
            }
          )
        }
      },
      (errors) => {
        commit(
          INFOS_MODAL_INSERT_INFO_FAILED,
          AppConfig.comUpdateNoFail
        )
        commit(SET_ERROR, errors)
        dispatch(ACTION_SET_LOADING, false)
      }
    )
  },
  [ACTION_RESET_NOTIFICATION_INFO]({ commit, }, values) {
    commit(INFOS_MODAL_INSERT_INFO_SUCCESS, values)
  },
}
