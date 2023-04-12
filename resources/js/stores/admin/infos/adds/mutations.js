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
import { getField, updateField } from 'vuex-map-fields'

export const MUTATIONS = {
  INFOS_FORM_SET_DROPDOWN_ALBUMS_LIST(state, payload) {
    state.albumDropdowns = payload
  },
  [INFOS_FORM_SELECT_DROPDOWN_INFO_TO_RELATED](state, payload) {
    state.infoRelated = payload
  },

  [INFOS_FORM_SET_DROPDOWN_RELATED_LIST](state, payload) {
    state.dropdownsRelateds = payload
  },

  [INFOS_MODAL_SET_LOADING](state, payload) {
    state.loading = payload
  },

  [INFOS_MODAL_INSERT_INFO_SUCCESS](state, payload) {
    state.updateSuccess = payload
  },

  [INFOS_MODAL_INSERT_INFO_FAILED](state, payload) {
    state.updateSuccess = payload
  },

  [SET_ERROR](state, payload) {
    state.errors = payload
  },

  [INFOS_FORM_ADD_INFO_TO_CATEGORY_LIST](state, payload) {
    state.info.categorys = payload
  },

  [INFOS_FORM_ADD_INFO_TO_CATEGORY_DISPLAY_LIST](state, payload) {
    state.listCategorysDisplay = payload
  },

  [INFOS_FORM_ADD_INFO_TO_RELATED_LIST](state, payload) {
    state.info.relateds = payload
  },

  [INFOS_FORM_ADD_INFO_TO_RELATED_DISPLAY_LIST](state, payload) {
    state.listRelatedsDisplay = payload
  },

  [INFOS_FORM_SET_MAIN_IMAGE](state, payload) {
    state.info.image = payload
    state.isImgChange = true
  },

  INFOS_FORM_ADD_INFO_PUSH_UPDATE_CATEGORY_LIST(state, payload) {
    state.info.categorys.push(payload.category_id)
    state.listCategorysDisplay.push(payload)
  },
  INFOS_FORM_ADD_INFO_PUSH_UPDATE_RELATED_LIST(state, payload) {
    state.info.relateds.push(payload.information_id)
    state.listRelatedsDisplay.push(payload)
  },

  updateInfoField(state, field) {
    return updateField(state.info, field)
  },
}
