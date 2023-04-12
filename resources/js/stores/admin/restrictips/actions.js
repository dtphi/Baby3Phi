import {
  apiGetAllRestrictIp,
  apiDeleteResIp,
  apiSearchResIp,
  apiChangeStatus,
} from 'api@admin/restrictip'
import { MODULE_MODULE_RESTRICT_IP, } from '../types/module-types'
import {
  INFOS_SET_LOADING,
  INFOS_GET_INFO_LIST_SUCCESS,
  INFOS_GET_INFO_LIST_FAILED,
  INFOS_DELETE_INFO_BY_ID_SUCCESS,
  INFOS_DELETE_INFO_BY_ID_FAILED,
  INFOS_SET_INFO_LIST,
  INFOS_SET_INFO_DELETE_BY_ID_FAILED,
  INFOS_SET_INFO_DELETE_BY_ID_SUCCESS,
  MODULE_UPDATE_SETTING_SUCCESS,
  MODULE_UPDATE_SETTING_FAILED,
  SET_ERROR,
} from '../types/mutation-types'
import {
  ACTION_GET_INFO_LIST,
  ACTION_DELETE_RESTRICT_IP_BY_ID,
  ACTION_SET_LOADING,
  ACTION_RESET_NOTIFICATION_INFO,
  ACTION_SEARCH_ITEMS,
  ACTION_CHANGE_STATUS,
} from '../types/action-types'
import { fn_redirect_url, } from '@app/api/utils/fn-helper'
import { config, } from '@app/common/b3p-admin-config'
import { fnCheckProp, } from '@app/common/util'

export const ACTIONS = {
  /* ACTION GET ALL IP */
  async [ACTION_GET_INFO_LIST]({ dispatch, commit, }, params) {
    dispatch(ACTION_SET_LOADING, true)
    await apiGetAllRestrictIp(
      (infos) => {
        commit(INFOS_SET_INFO_LIST, infos.data.results)
        commit(INFOS_GET_INFO_LIST_SUCCESS, true)
        var pagination = {
          current_page: 1,
          total: 0,
        }

        if (fnCheckProp(infos.data, 'pagination')) {
          pagination = infos.data.pagination
        }
        var configs = {
          moduleActive: {
            name: MODULE_MODULE_RESTRICT_IP,
            actionList: ACTION_GET_INFO_LIST,
          },
          collectionData: pagination,
        }

        dispatch('setConfigApp', configs, {
          root: true,
        })
      },
      (errors) => {
        commit(INFOS_GET_INFO_LIST_FAILED, errors)
      },
      params
    )
    dispatch(ACTION_SET_LOADING, false)
  },

  /* ACTION DELETE */
  async [ACTION_DELETE_RESTRICT_IP_BY_ID]({ commit, }, infoId) {
    await apiDeleteResIp(
      infoId,
      (results) => {
        if (results) {
          commit(INFOS_SET_INFO_DELETE_BY_ID_SUCCESS, true)
        }
      },
      (errors) => {
        commit(INFOS_SET_INFO_DELETE_BY_ID_FAILED, false)
        commit(SET_ERROR, errors)
      }
    )
  },

  [ACTION_CHANGE_STATUS]({ commit, }, info) {
    apiChangeStatus(info, (errors) => {
      commit(SET_ERROR, errors)
    })
  },

  ACTION_RELOAD_GET_INFO_LIST_RESTRICT_IP: {
    root: true,
    handler(namespacedContext, payload) {
      if (isNaN(payload)) {
        return fn_redirect_url(
          `/${config.adminPrefix}/restrict-ips`
        )
      } else {
        namespacedContext.dispatch(ACTION_GET_INFO_LIST)
      }
    },
  },
  /* ACTION SEARCH IP */
  [ACTION_SEARCH_ITEMS]({ commit, }, query) {
    apiSearchResIp(
      (response) => {
        commit(INFOS_SET_INFO_LIST, response.data.results)
      },
      (errors) => {
        commit(INFOS_GET_INFO_LIST_FAILED, errors)
      },
      query
    )
  },

  [ACTION_SET_LOADING]({ commit, }, isLoading) {
    commit(INFOS_SET_LOADING, isLoading)
  },

  [ACTION_RESET_NOTIFICATION_INFO]({ commit, }, values) {
    commit(MODULE_UPDATE_SETTING_SUCCESS, values)
  },
}
