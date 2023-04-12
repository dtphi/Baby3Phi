import {
  INFOS_MODAL_SET_INFO_ID,
  INFOS_MODAL_SET_INFO_ID_FAILED,
  INFOS_MODAL_SET_INFO,
  INFOS_MODAL_SET_LOADING,
  INFOS_MODAL_UPDATE_INFO_SUCCESS,
  INFOS_MODAL_UPDATE_INFO_FAILED,
  SET_ERROR,
  INFOS_FORM_SET_MAIN_IMAGE,
} from '../../types/mutation-types'
import { config, } from '@app/api/admin/config'

export const MUTATIONS = {
  [INFOS_MODAL_SET_INFO_ID](state, payload) {
    if (payload) {
      state.infoId = payload
      state.isExistInfo = config.existStatus.exist
    }
  },

  [INFOS_MODAL_SET_INFO_ID_FAILED](state, payload) {
    state.errors = payload
  },

  [INFOS_MODAL_SET_INFO](state, payload) {
    state.info = payload
  },

  [INFOS_MODAL_SET_LOADING](state, payload) {
    state.loading = payload
  },

  [INFOS_MODAL_UPDATE_INFO_SUCCESS](state, payload) {
    state.updateSuccess = payload
  },

  [INFOS_MODAL_UPDATE_INFO_FAILED](state, payload) {
    state.updateSuccess = payload
  },

  [SET_ERROR](state, payload) {
    state.errors = payload
  },

  [INFOS_FORM_SET_MAIN_IMAGE](state, payload) {
    state.info.image = payload
    state.isImgChange = true
  },
  GROUP_ALBUMS_SET_INFO(state, payload) {
    state.info = payload
  },
}
