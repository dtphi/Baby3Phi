import AppConfig from 'api@admin/constants/app-config'
import { MODULE_INFO, } from '../../types/module-types'
import { apiInsertInfo, apiGetDropdownInfos, } from 'api@admin/information'
import {
  INFOS_MODAL_SET_LOADING,
  INFOS_MODAL_INSERT_INFO_SUCCESS,
  INFOS_MODAL_INSERT_INFO_FAILED,
  SET_ERROR,
  INFOS_FORM_ADD_INFO_TO_CATEGORY_LIST,
  INFOS_FORM_ADD_INFO_TO_CATEGORY_DISPLAY_LIST,
  INFOS_FORM_ADD_INFO_TO_RELATED_LIST,
  INFOS_FORM_ADD_INFO_TO_RELATED_DISPLAY_LIST,
  INFOS_FORM_SET_MAIN_IMAGE,
  INFOS_FORM_SET_DROPDOWN_RELATED_LIST,
  INFOS_FORM_GET_DROPDOWN_RELATED_FAILED,
  INFOS_FORM_SELECT_DROPDOWN_INFO_TO_RELATED,
} from '../../types/mutation-types'
import {
  ACTION_SET_LOADING,
  ACTION_INSERT_INFO,
  ACTION_RELOAD_GET_INFO_LIST,
  ACTION_ADD_INFO_TO_CATEGORY_LIST,
  ACTION_REMOVE_INFO_TO_CATEGORY_LIST,
  ACTION_ADD_INFO_TO_RELATED_LIST,
  ACTION_REMOVE_INFO_TO_RELATED_LIST,
  ACTION_INSERT_INFO_BACK,
  ACTION_SET_IMAGE,
  ACTION_GET_DROPDOWN_RELATED_LIST,
  ACTION_SELECT_DROPDOWN_RELATED_INFO,
} from '../../types/action-types'

export const ACTIONS = {
  update_special_carousel({ state, }, specialCarousel) {
    state.info.special_carousels = specialCarousel
  },

  [ACTION_SET_LOADING]({ commit, }, isLoading) {
    commit(INFOS_MODAL_SET_LOADING, isLoading)
  },

  [ACTION_INSERT_INFO]({ dispatch, commit, }, info) {
    apiInsertInfo(
      info,
      (result) => {
        if (result) {
          commit(
            INFOS_MODAL_INSERT_INFO_SUCCESS,
            AppConfig.comInsertNoSuccess
          )
          commit(SET_ERROR, [])
        }

        dispatch(ACTION_SET_LOADING, false)
        window.location.reload()
      },
      (errors) => {
        commit(
          INFOS_MODAL_INSERT_INFO_FAILED,
          AppConfig.comInsertNoFail
        )
        commit(SET_ERROR, errors)

        dispatch(ACTION_SET_LOADING, false)
      }
    )
  },

  [ACTION_INSERT_INFO_BACK]({ dispatch, commit, }, info) {
    apiInsertInfo(
      info,
      (result) => {
        if (result) {
          commit(
            INFOS_MODAL_INSERT_INFO_SUCCESS,
            AppConfig.comInsertNoSuccess
          )
          dispatch(`${MODULE_INFO}_${ACTION_RELOAD_GET_INFO_LIST}`,
            'page', { root: true, }
          )
        }
      },
      (errors) => {
        commit(
          INFOS_MODAL_INSERT_INFO_FAILED,
          AppConfig.comInsertNoFail
        )
        commit(SET_ERROR, errors)

        dispatch(ACTION_SET_LOADING, false)
      }
    )
  },

  [ACTION_ADD_INFO_TO_CATEGORY_LIST]({ commit, state, }, category) {
    const categorys = state.info.categorys

    if (typeof category === 'object' && Object.keys(category).length) {
      if (
        categorys.indexOf(category.category_id) === -1 &&
                  parseInt(category.category_id) > 0
      ) {
        commit('INFOS_FORM_ADD_INFO_PUSH_UPDATE_CATEGORY_LIST', category)
      }
    }
  },

  [ACTION_REMOVE_INFO_TO_CATEGORY_LIST]({ state, commit, }, category) {
    const categorys = state.info.categorys
    const listCateShow = state.listCategorysDisplay

    commit(
      INFOS_FORM_ADD_INFO_TO_CATEGORY_LIST,
      _.remove(categorys, function(cateId) {
        return cateId - category.category_id !== 0
      })
    )
    commit(
      INFOS_FORM_ADD_INFO_TO_CATEGORY_DISPLAY_LIST,
      _.remove(listCateShow, function(item) {
        return item.category_id - category.category_id !== 0
      })
    )
  },

  [ACTION_SET_IMAGE]({ commit, }, imgFile) {
    commit(INFOS_FORM_SET_MAIN_IMAGE, imgFile)
  },

  [ACTION_ADD_INFO_TO_RELATED_LIST]({ state, commit, }, related) {
    const relateds = state.info.relateds

    if (typeof related === 'object' && Object.keys(related).length) {
      if (
        relateds.indexOf(related.information_id) === -1 &&
                  parseInt(related.information_id) > 0
      ) {
        commit('INFOS_FORM_ADD_INFO_PUSH_UPDATE_RELATED_LIST', related)
      }
    }
  },

  [ACTION_REMOVE_INFO_TO_RELATED_LIST]({ state, commit, }, related) {
    const relateds = state.info.relateds
    const listRelatedShow = state.listRelatedsDisplay

    commit(
      INFOS_FORM_ADD_INFO_TO_RELATED_LIST,
      _.remove(relateds, function(infoId) {
        return infoId - related.information_id !== 0
      })
    )
    commit(
      INFOS_FORM_ADD_INFO_TO_RELATED_DISPLAY_LIST,
      _.remove(listRelatedShow, function(item) {
        return item.information_id - related.information_id !== 0
      })
    )
  },

  [ACTION_GET_DROPDOWN_RELATED_LIST]({ commit, }, filterName) {
    const params = {
      filter_name: filterName,
    }
    apiGetDropdownInfos(
      (result) => {
        commit(INFOS_FORM_SET_DROPDOWN_RELATED_LIST, result)
      },
      (errors) => {
        commit(SET_ERROR, errors)
      },
      params
    )
  },

  ACTION_GET_DROPDOWN_ALBUM_LIST({ commit, }, filters) {
    const params = {
      ...filters,
    }
    apiGetDropdownInfos(
      (result) => {
        commit('INFOS_FORM_SET_DROPDOWN_ALBUMS_LIST', result)
      },
      (errors) => {
        commit(SET_ERROR, errors)
      },
      params
    )
  },

  [ACTION_SELECT_DROPDOWN_RELATED_INFO]({ commit, }, information) {
    commit(INFOS_FORM_SELECT_DROPDOWN_INFO_TO_RELATED, information)
  },
}
