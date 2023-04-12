import { apiGetInfos, } from 'api@admin/information'
import { apiGetNewsGroups, } from 'api@admin/category'
import { apiGetUsers, } from 'api@admin/user'

import {
  INFOS_SET_INFO_LIST,
  INFOS_GET_INFO_LIST_SUCCESS,
  INFOS_SET_LOADING,
  SET_ERROR,
  NEWSGROUPS_GET_NEWS_GROUP_LIST_SUCCESS,
  NEWSGROUPS_GET_NEWS_GROUP_LIST_FAILED,
  USERS_GET_USER_LIST_SUCCESS,
  USERS_GET_USER_LIST_FAILED,
} from './types/mutation-types'
import {
  ACTION_GET_INFO_LIST,
  ACTION_SET_LOADING,
  ACTION_GET_NEWS_GROUP_LIST,
  ACTION_GET_USER_LIST,
} from './types/action-types'
import { fnCheckProp, } from '@app/common/util'

const defaultState = () => {
  return {
    infos: [],
    isGetInfoList: null,
    infoTotal: 0,
    isGetCategoryList: null,
    categoryTotal: 0,
    userTotal: 0,
    isGetUserList: null,
    giaoPhanTotal: 0,
    linhMucTotal: 0,
    loading: false,
    errors: [],
  }
}

export default {
  namespaced: true,
  state: defaultState(),
  mutations: {
    [INFOS_SET_INFO_LIST](state, payload) {
      state.infos = payload
    },
    [INFOS_GET_INFO_LIST_SUCCESS](state, payload) {
      state.isGetInfoList = payload
    },

    [INFOS_SET_LOADING](state, payload) {
      state.loading = payload
    },

    [SET_ERROR](state, payload) {
      state.errors = payload
    },

    [NEWSGROUPS_GET_NEWS_GROUP_LIST_SUCCESS](state, payload) {
      state.isGetCategoryList = payload
    },

    [NEWSGROUPS_GET_NEWS_GROUP_LIST_FAILED](state, payload) {
      state.isGetCategoryList = payload
    },

    [USERS_GET_USER_LIST_SUCCESS](state, payload) {
      state.isGetUserList = payload
    },

    [USERS_GET_USER_LIST_FAILED](state, payload) {
      state.isGetUserList = payload
    },

    setInfoTotal(state, payload) {
      state.infoTotal = payload
    },

    setCategoryTotal(state, payload) {
      state.categoryTotal = payload
    },

    setUserTotal(state, payload) {
      state.userTotal = payload
    },

    setGiaoPhanTotal(state, payload) {
      state.giaoPhanTotal = payload
    },

    setLinhMucTotal(state, payload) {
      state.linhMucTotal = payload
    },
  },
  actions: {
    ACTION_GET_INFO_GIAO_PHAN_LIST({ commit, }, params) {
    },

    ACTION_GET_INFO_LINH_MUC_LIST({ commit, }, params) {
    },

    [ACTION_GET_USER_LIST]({ commit, }, params) {
      apiGetUsers(
        (users) => {
          if (fnCheckProp(users.meta, 'total')) {
            if (parseInt(users.meta.total)) {
              commit('setUserTotal', users.meta.total)
            }
          }

          commit(USERS_GET_USER_LIST_SUCCESS, true)
        },
        (errors) => {
          commit(USERS_GET_USER_LIST_FAILED, false)
          commit(SET_ERROR, errors)
        },
        params
      )
    },

    [ACTION_GET_NEWS_GROUP_LIST]({ commit, }, params) {
      apiGetNewsGroups(
        (newsGroups) => {
          commit(NEWSGROUPS_GET_NEWS_GROUP_LIST_SUCCESS, true)

          if (fnCheckProp(newsGroups.data, 'pagination')) {
            if (parseInt(newsGroups.data.pagination.total)) {
              commit(
                'setCategoryTotal',
                newsGroups.data.pagination.total
              )
            }
          }
        },
        (errors) => {
          commit(NEWSGROUPS_GET_NEWS_GROUP_LIST_FAILED, false)
          commit(SET_ERROR, errors)
        },
        params
      )
    },

    [ACTION_GET_INFO_LIST]({ dispatch, commit, }, params) {
      dispatch(ACTION_SET_LOADING, true)
      apiGetInfos(
        (infos) => {
          commit(INFOS_SET_INFO_LIST, infos.data.results)
          commit(INFOS_GET_INFO_LIST_SUCCESS, true)

          if (fnCheckProp(infos.data, 'pagination')) {
            if (parseInt(infos.data.pagination.total)) {
              commit('setInfoTotal', infos.data.pagination.total)
            }
          }

          dispatch(ACTION_SET_LOADING, false)
        },
        (errors) => {
          commit(SET_ERROR, errors)

          dispatch(ACTION_SET_LOADING, false)
        },
        params
      )
    },
    [ACTION_SET_LOADING]({ commit, }, isLoading) {
      commit(INFOS_SET_LOADING, isLoading)
    },
  },
}
