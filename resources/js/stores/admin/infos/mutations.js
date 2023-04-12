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
import _ from 'lodash'

export const MUTATIONS = {
  addSpecialInfoId(state, payload) {
    state.module_special_info_ids = payload
  },
  addSepecialModuleData(state, payload) {
    state.module_special_infos = payload
  },
  updateSpecialInfoData(state, payload) {
    state.module_special_infos = []
    state.module_special_info_ids = []
    state.module_special_infos = payload.module_special_info_ids.value
    _.forEach(state.module_special_infos, function(item) {
      state.module_special_info_ids.push(item.id)
    })
    state.moduleSpecialData.keys = []
    state.moduleSpecialData.keys.push(payload.module_special_info_ids)
  },
  [MODULE_UPDATE_SETTING_SUCCESS](state, payload) {
    state.updateSuccess = payload
  },
  [MODULE_UPDATE_SETTING_FAILED](state, payload) {
    state.updateSuccess = payload
  },
  [INFOS_SET_INFO_LIST](state, payload) {
    state.infos = payload
  },

  [INFOS_INFO_DELETE_BY_ID](state, payload) {
    state.infoDelete = payload
  },

  [INFOS_SET_INFO_DELETE_BY_ID_FAILED](state, payload) {
    state.isDelete = payload
  },

  [INFOS_SET_INFO_DELETE_BY_ID_SUCCESS](state, payload) {
    state.isDelete = payload
  },

  [INFOS_GET_INFO_LIST_SUCCESS](state, payload) {
    state.isList = payload
  },

  [INFOS_GET_INFO_LIST_FAILED](state, payload) {
    state.isList = payload
  },

  [INFOS_DELETE_INFO_BY_ID_SUCCESS](state, payload) {
    state.isDelete = payload
  },

  [INFOS_DELETE_INFO_BY_ID_FAILED](state, payload) {
    state.isDelete = false
    state.errors = payload
  },

  [INFOS_SET_LOADING](state, payload) {
    state.loading = payload
  },

  [SET_ERROR](state, payload) {
    state.errors = payload
  },
}
