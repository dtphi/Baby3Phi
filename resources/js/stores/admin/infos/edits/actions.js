import AppConfig from 'api@admin/constants/app-config'
import { apiGetInfoById, apiUpdateInfo, apiGetDropdownInfos, } from 'api@admin/information'
import {
  INFOS_MODAL_SET_INFO_ID,
  INFOS_MODAL_SET_INFO_ID_FAILED,
  INFOS_MODAL_SET_INFO,
  INFOS_MODAL_SET_LOADING,
  INFOS_MODAL_UPDATE_INFO_SUCCESS,
  INFOS_MODAL_UPDATE_INFO_FAILED,
  SET_ERROR,
  INFOS_FORM_ADD_INFO_TO_CATEGORY_LIST,
  INFOS_FORM_ADD_INFO_TO_CATEGORY_DISPLAY_LIST,
  INFOS_FORM_ADD_INFO_TO_RELATED_LIST,
  INFOS_FORM_ADD_INFO_TO_RELATED_DISPLAY_LIST,
  INFOS_FORM_SET_MAIN_IMAGE,
} from '../../types/mutation-types'
import {
  ACTION_GET_INFO_BY_ID,
  ACTION_SET_LOADING,
  ACTION_SHOW_MODAL_EDIT,
  ACTION_UPDATE_INFO,
  ACTION_RESET_NOTIFICATION_INFO,
  ACTION_ADD_INFO_TO_CATEGORY_LIST,
  ACTION_REMOVE_INFO_TO_CATEGORY_LIST,
  ACTION_SET_IMAGE,
  ACTION_ADD_INFO_TO_RELATED_LIST,
  ACTION_REMOVE_INFO_TO_RELATED_LIST,
} from '../../types/action-types'

export const ACTIONS = {
  update_special_carousel({ state, }, specialCarousel) {
    state.info.special_carousels = specialCarousel
  },

  [ACTION_SHOW_MODAL_EDIT]({ dispatch, }, infoId) {
    dispatch(ACTION_GET_INFO_BY_ID, infoId)
  },

  [ACTION_GET_INFO_BY_ID]({ dispatch, commit, }, infoId) {
    dispatch(ACTION_SET_LOADING, true)
    apiGetInfoById(
      infoId,
      (result) => {
        commit(INFOS_MODAL_SET_INFO_ID, infoId)
        commit(INFOS_MODAL_SET_INFO, result.data)
        commit(
          INFOS_FORM_ADD_INFO_TO_CATEGORY_DISPLAY_LIST,
          result.data.category_display_list
        )

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
    apiUpdateInfo(
      info,
      (result) => {
        if (result) {
          commit(
            INFOS_MODAL_UPDATE_INFO_SUCCESS,
            AppConfig.comUpdateNoSuccess
          )
        }
        dispatch(ACTION_SET_LOADING, false)
        dispatch(ACTION_GET_INFO_BY_ID, info.information_id)
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
      _.remove(categorys, (cateId) => {
        return cateId - category.category_id !== 0
      })
    )
    commit(
      INFOS_FORM_ADD_INFO_TO_CATEGORY_DISPLAY_LIST,
      _.remove(listCateShow, (item) => {
        return item.category_id - category.category_id !== 0
      })
    )
  },

  [ACTION_SET_IMAGE]({ commit, }, imgFile) {
    commit(INFOS_FORM_SET_MAIN_IMAGE, imgFile)
  },

  [ACTION_ADD_INFO_TO_RELATED_LIST]({ state, commit, }, related) {
    const relateds = { ...state.info.relateds, }

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
      _.remove(relateds, (infoId) => {
        return infoId - related.information_id !== 0
      })
    )
    commit(
      INFOS_FORM_ADD_INFO_TO_RELATED_DISPLAY_LIST,
      _.remove(listRelatedShow, (item) => {
        return item.information_id - related.information_id !== 0
      })
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
}
