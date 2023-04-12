import adds from './adds'
import modals from './modal'
import edits from './edits'
import {
  apiGetAllAlbums,
  apiDeleteAlbums,
  apiSearchAlbums,
  apiChangeStatus,
} from 'api@admin/albums'
import { MODULE_MODULE_ALBUMS, } from '../types/module-types'
import {
  INFOS_SET_LOADING,
  INFOS_GET_INFO_LIST_SUCCESS,
  INFOS_GET_INFO_LIST_FAILED,
  INFOS_DELETE_INFO_BY_ID_SUCCESS,
  INFOS_DELETE_INFO_BY_ID_FAILED,
  INFOS_SET_INFO_LIST,
  INFOS_SET_INFO_DELETE_BY_ID_FAILED,
  INFOS_SET_INFO_DELETE_BY_ID_SUCCESS,
  SET_ERROR,
  MODULE_UPDATE_SETTING_SUCCESS,
  MODULE_UPDATE_SETTING_FAILED,
  INFOS_INFO_DELETE_BY_ID,
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

const defaultState = () => {
  return {
    infos: [],
    total: 0,
    isDelete: false,
    isList: false,
    loading: false,
    updateSuccess: false,
    infoDelete: null,
    errors: [],
  }
}

export default {
  namespaced: true,
  state: defaultState(),
  getters: {
    infos(state) {
      return state.infos
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
  },

  mutations: {
    [MODULE_UPDATE_SETTING_SUCCESS](state, payload) {
      state.updateSuccess = payload
    },
    [MODULE_UPDATE_SETTING_FAILED](state, payload) {
      state.updateSuccess = payload
    },
    [INFOS_SET_INFO_LIST](state, payload) {
      state.infos = payload
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

    [INFOS_INFO_DELETE_BY_ID](state, payload) {
      state.infoDelete = payload
    },
  },

  actions: {
    /* ACTION GET ALL ALBUMS */
    async [ACTION_GET_INFO_LIST]({ dispatch, commit, }, params) {
      dispatch(ACTION_SET_LOADING, true)
      await apiGetAllAlbums(
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
              name: MODULE_MODULE_ALBUMS,
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
      await apiDeleteAlbums(
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

    [ACTION_CHANGE_STATUS]({ dispatch, }, info) {
      apiChangeStatus(
        info,
        (result) => {
          if (result) {
            dispatch(ACTION_GET_INFO_LIST)
          }
        },
        () => {}
      )
    },

    [`${MODULE_MODULE_ALBUMS}_${ACTION_RELOAD_GET_INFO_LIST}`]: {
      root: true,
      handler(namespacedContext, payload) {
        if (isNaN(payload)) {
          return fn_redirect_url(`/${config.adminPrefix}/albums`)
        } else {
          namespacedContext.dispatch(ACTION_GET_INFO_LIST)
        }
      },
    },
    /* ACTION SEARCH ALBUMS */
    [ACTION_SEARCH_ITEMS]({ commit, }, query) {
      apiSearchAlbums(
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
  },

  modules: {
    add: adds,
    edit: edits,
    modal: modals,
  },
}
