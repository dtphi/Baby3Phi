import AppConfig from 'api@admin/constants/app-config'
import {
  apiGetAllGroupAlbums,
  apiDeleteGroupAlbums,
  apiSearchGroupAlbums,
  apiChangeStatus,
} from 'api@admin/groupalbums'
import { MODULE_MODULE_GROUP_ALBUMS, } from '../types/module-types'
import {
  INFOS_SET_LOADING,
  INFOS_GET_INFO_LIST_SUCCESS,
  INFOS_GET_INFO_LIST_FAILED,
  INFOS_SET_INFO_LIST,
  INFOS_SET_INFO_DELETE_BY_ID_FAILED,
  INFOS_SET_INFO_DELETE_BY_ID_SUCCESS,
  SET_ERROR,
  MODULE_UPDATE_SETTING_SUCCESS,
} from '../types/mutation-types'
import {
  ACTION_GET_INFO_LIST,
  ACTION_DELETE_INFO_BY_ID,
  ACTION_SET_LOADING,
  ACTION_RESET_NOTIFICATION_INFO,
  ACTION_SEARCH_ITEMS,
  ACTION_CHANGE_STATUS,
  ACTION_RELOAD_GET_INFO_LIST,
} from '../types/action-types'
import { fn_redirect_url, } from '@app/api/utils/fn-helper'
import { config, } from '@app/common/b3p-admin-config'
import { fnCheckProp, } from '@app/common/util'

export const ACTIONS = {
  async [ACTION_GET_INFO_LIST]({ dispatch, commit, }, params) {
    dispatch(ACTION_SET_LOADING, true)
    await apiGetAllGroupAlbums(
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
            name: MODULE_MODULE_GROUP_ALBUMS,
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
  async [ACTION_DELETE_INFO_BY_ID]({ commit, }, infoId) {
    await apiDeleteGroupAlbums(
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
    apiChangeStatus(
      info,
      (result) => {
        if (result) {
          commit(
            MODULE_UPDATE_SETTING_SUCCESS,
            AppConfig.comUpdateNoSuccess
          )
        }
      },
      () => {}
    )
  },

  [`${MODULE_MODULE_GROUP_ALBUMS}_${ACTION_RELOAD_GET_INFO_LIST}`]: {
    root: true,
    handler(namespacedContext, payload) {
      if (isNaN(payload)) {
        return fn_redirect_url(
          `/${config.adminPrefix}/group-albums`
        )
      } else {
        namespacedContext.dispatch(ACTION_GET_INFO_LIST)
      }
    },
  },

  [ACTION_SEARCH_ITEMS]({ commit, }, query) {
    apiSearchGroupAlbums(
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
