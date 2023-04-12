import {
  apiGetInfoById,
  apiGetInfos,
  apiDeleteInfo,
  apiSearchAll,
  apiGetSlideSpecialInfos,
} from 'api@admin/information'
import { apiGetSettingByCode, apiInsertSetting, } from 'api@admin/setting'
import { MODULE_INFO, } from '../types/module-types'
import {
  INFOS_SET_LOADING,
  INFOS_GET_INFO_LIST_SUCCESS,
  INFOS_GET_INFO_LIST_FAILED,
  INFOS_DELETE_INFO_BY_ID_SUCCESS,
  INFOS_DELETE_INFO_BY_ID_FAILED,
  INFOS_SET_INFO_LIST,
  INFOS_INFO_DELETE_BY_ID,
  INFOS_SET_INFO_DELETE_BY_ID_FAILED,
  INFOS_SET_INFO_DELETE_BY_ID_SUCCESS,
  SET_ERROR,
  MODULE_UPDATE_SETTING_SUCCESS,
  MODULE_UPDATE_SETTING_FAILED,
} from '../types/mutation-types'
import {
  ACTION_GET_INFO_LIST,
  ACTION_DELETE_INFO_BY_ID,
  ACTION_SET_INFO_DELETE_BY_ID,
  ACTION_RELOAD_GET_INFO_LIST,
  ACTION_SET_LOADING,
  ACTION_SEARCH_ALL,
  ACTION_RESET_NOTIFICATION_INFO,
} from '../types/action-types'
import { fn_redirect_url, } from '@app/api/utils/fn-helper'
import _ from 'lodash'
import { config, } from '@app/common/b3p-admin-config'
import { fnCheckProp, } from '@app/common/util'

export const ACTIONS = {
  addSpecial({ commit, state, }, data) {
    let infos = state.module_special_info_ids
    let values = state.module_special_infos
    if (typeof values === 'boolean') values = []

    if (data.isChecked) {
      infos.push(data.info.information_id)

      values.push({
        id: data.info.information_id,
        img: data.info.image.path,
      })
    } else {
      _.remove(infos, function(itemId) {
        return !(
          parseInt(itemId) - parseInt(data.info.information_id)
        )
      })
      _.remove(values, function(item) {
        return !(
          parseInt(item.id) - parseInt(data.info.information_id)
        )
      })
    }

    commit('addSpecialInfoId', infos)
    commit('addSepecialModuleData', values)
  },
  get_module_special_info_ids({ dispatch, commit, state, }) {
    dispatch(ACTION_SET_LOADING, true)
    apiGetSettingByCode(
      state.moduleSpecialData.code,
      (res) => {
        if (Object.keys(res.data.results).length) {
          commit('updateSpecialInfoData', res.data.results)

          dispatch(ACTION_SET_LOADING, false)
        }
      },
      (errors) => {
        dispatch(ACTION_SET_LOADING, false)
        commit(SET_ERROR, errors)
      }
    )
  },
  get_module_special_info_and_info_ids({ dispatch, commit, state, }) {
    dispatch(ACTION_SET_LOADING, true)
    apiGetSettingByCode(
      state.moduleSpecialData.code,
      (res) => {
        if (Object.keys(res.data.results).length) {
          commit('updateSpecialInfoData', res.data.results)

          dispatch('ACTION_GET_SLIDE_SPECIAL_INFO_LIST', {
            infoType: 'module_special_info',
            infoIds:
                              res.data.results.module_special_info_ids.value,
          })
        } else {
          dispatch(ACTION_SET_LOADING, false)
        }
      },
      (errors) => {
        dispatch(ACTION_SET_LOADING, false)
        commit(SET_ERROR, errors)
      }
    )
  },
  module_special_info_ids({ dispatch, commit, state, }) {
    let infos = state.module_special_infos
    var asorts = _.orderBy(infos, (o) => o.id, 'desc')
    let values = []
    _.forEach(asorts, function(item, idx) {
      if (idx < 20) {
        values.push(item)
      } else {
        return
      }
    })
    const moduleData = {
      code: 'module_special_info',
      keys: [
        {
          key: 'module_special_info_ids',
          value: values,
          serialize: true,
        }
      ],
    }
    if (state.module_special_infos.length) {
      dispatch(ACTION_SET_LOADING, true)
      apiInsertSetting(
        moduleData,
        (result) => {
          if (result) {
            commit(
              MODULE_UPDATE_SETTING_SUCCESS,
              AppConfig.comInsertNoSuccess
            )
            commit(SET_ERROR, [])
          }
          dispatch(ACTION_SET_LOADING, false)
        },
        (errors) => {
          commit(
            MODULE_UPDATE_SETTING_FAILED,
            AppConfig.comInsertNoFail
          )
          commit(SET_ERROR, errors)

          dispatch(ACTION_SET_LOADING, false)
        }
      )
    }
  },
  async [ACTION_GET_INFO_LIST]({ dispatch, commit, }, params) {
    dispatch(ACTION_SET_LOADING, true)
    await apiGetInfos(
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
            name: MODULE_INFO,
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

  async [ACTION_DELETE_INFO_BY_ID]({ state, dispatch, commit, }, infoId) {
    let getId = null
    if (typeof state.infoDelete === 'object') {
      if (fnCheckProp(state.infoDelete, 'information_id')) {
        getId = parseInt(state.infoDelete.information_id)
      }
    }
    const deleteId = parseInt(infoId)

    if (getId === deleteId) {
      await apiDeleteInfo(
        deleteId,
        (infos) => {
          if (infos) {
            commit(INFOS_DELETE_INFO_BY_ID_SUCCESS, true)
            dispatch(ACTION_GET_INFO_LIST)
            commit(INFOS_INFO_DELETE_BY_ID, null)
          }
        },
        (errors) => {
          commit(INFOS_DELETE_INFO_BY_ID_FAILED, false)
          if (errors) {
            commit(SET_ERROR, errors)
          }
        }
      )
    }
  },

  [ACTION_SET_INFO_DELETE_BY_ID]({ commit, }, infoId) {
    apiGetInfoById(
      infoId,
      (result) => {
        commit(INFOS_INFO_DELETE_BY_ID, result.data)
        commit(INFOS_SET_INFO_DELETE_BY_ID_SUCCESS, true)
      },
      (errors) => {
        commit(INFOS_SET_INFO_DELETE_BY_ID_FAILED, false)
        if (errors) {
          commit(SET_ERROR, errors)
        }
      }
    )
  },

  [`${MODULE_INFO}_${ACTION_RELOAD_GET_INFO_LIST}`]: {
    root: true,
    handler(namespacedContext, payload) {
      if (isNaN(payload)) {
        return fn_redirect_url(
          `/${config.adminPrefix}/informations`
        )
      } else {
        namespacedContext.dispatch(ACTION_GET_INFO_LIST)
      }
    },
  },

  [ACTION_SET_LOADING]({ commit, }, isLoading) {
    commit(INFOS_SET_LOADING, isLoading)
  },

  [ACTION_SEARCH_ALL]({ dispatch, commit, }, query) {
    dispatch(ACTION_SET_LOADING, true)
    apiSearchAll(
      query,
      (result) => {
        if (result) {
          commit(INFOS_GET_INFO_LIST_SUCCESS, true)
        }
        dispatch(ACTION_SET_LOADING, false)
      },
      (errors) => {
        commit(INFOS_GET_INFO_LIST_FAILED, false)
        dispatch(ACTION_SET_LOADING, false)
        commit(SET_ERROR, errors)
      }
    )
  },
  [ACTION_RESET_NOTIFICATION_INFO]({ commit, }, values) {
    commit(MODULE_UPDATE_SETTING_SUCCESS, values)
  },

  ACTION_GET_SLIDE_SPECIAL_INFO_LIST({ dispatch, commit, }, params) {
    dispatch(ACTION_SET_LOADING, true)
    apiGetSlideSpecialInfos(
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
            name: MODULE_INFO,
            actionList: ACTION_GET_INFO_LIST,
          },
          collectionData: pagination,
        }

        dispatch('setConfigApp', configs, {
          root: true,
        })

        dispatch(ACTION_SET_LOADING, false)
      },
      (errors) => {
        commit(INFOS_GET_INFO_LIST_FAILED, errors)
        commit(SET_ERROR, errors)
        dispatch(ACTION_SET_LOADING, false)
      },
      params
    )
  },
}
