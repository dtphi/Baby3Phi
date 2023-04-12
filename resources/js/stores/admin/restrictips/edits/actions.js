import AppConfig from 'api@admin/constants/app-config'
import { apiUpdateResIp, apiGetResIpById, } from 'api@admin/restrictip'
import {
  INFOS_MODAL_SET_INFO_ID,
  INFOS_MODAL_SET_INFO_ID_FAILED,
  INFOS_MODAL_SET_LOADING,
  INFOS_MODAL_UPDATE_INFO_SUCCESS,
  INFOS_MODAL_UPDATE_INFO_FAILED,
  SET_ERROR,
} from '../../types/mutation-types'
import {
  ACTION_GET_INFO_BY_ID,
  ACTION_SET_LOADING,
  ACTION_SHOW_MODAL_EDIT,
  ACTION_UPDATE_INFO,
  ACTION_RESET_NOTIFICATION_INFO,
  ACTION_UPDATE_INFO_BACK,
} from '../../types/action-types'

export const ACTIONS = {
  [ACTION_SHOW_MODAL_EDIT]({ dispatch, }, infoId) {
    dispatch(ACTION_GET_INFO_BY_ID, infoId)
  },
  // GET ID
  [ACTION_GET_INFO_BY_ID]({ dispatch, commit, }, infoId) {
    dispatch(ACTION_SET_LOADING, true)
    apiGetResIpById(
      infoId,
      (result) => {
        commit(INFOS_MODAL_SET_INFO_ID, infoId)
        commit('RESTRICT_IP_SET_INFO', result.data)
        dispatch(ACTION_SET_LOADING, false)
      },
      (errors) => {
        commit(
          INFOS_MODAL_SET_INFO_ID_FAILED,
          Object.values(errors)
        )
        dispatch(ACTION_SET_LOADING, false)
      }
    )
  },

  [ACTION_SET_LOADING]({ commit, }, isLoading) {
    commit(INFOS_MODAL_SET_LOADING, isLoading)
  },

  [ACTION_UPDATE_INFO]({ dispatch, commit, }, info) {
    commit(INFOS_MODAL_UPDATE_INFO_SUCCESS, '')
    apiUpdateResIp(
      info,
      (result) => {
        if (result) {
          commit(SET_ERROR, [])
          commit(
            INFOS_MODAL_UPDATE_INFO_SUCCESS,
            AppConfig.comUpdateNoSuccess
          )
        }
        dispatch(ACTION_SET_LOADING, false)
      },
      (errors) => {
        commit(
          INFOS_MODAL_UPDATE_INFO_FAILED,
          AppConfig.comUpdateNoFail
        )
        commit(SET_ERROR, errors)
        dispatch(ACTION_SET_LOADING, false)
      }
    )
  },
  [ACTION_UPDATE_INFO_BACK]({ dispatch, commit, }, info) {
    apiUpdateResIp(
      info,
      (result) => {
        if (result) {
          commit(
            INFOS_MODAL_UPDATE_INFO_SUCCESS,
            AppConfig.comUpdateNoSuccess
          )
          dispatch(ACTION_GET_INFO_BY_ID, info.data.id)
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
          INFOS_MODAL_UPDATE_INFO_FAILED,
          AppConfig.comUpdateNoFail
        )
        commit(SET_ERROR, errors)
        dispatch(ACTION_SET_LOADING, false)
      }
    )
  },

  [ACTION_RESET_NOTIFICATION_INFO]({ commit, }, values) {
    commit(INFOS_MODAL_UPDATE_INFO_SUCCESS, values)
  },
}
