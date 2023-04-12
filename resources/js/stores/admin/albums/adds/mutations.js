import {
  INFOS_MODAL_SET_LOADING,
  INFOS_MODAL_INSERT_INFO_SUCCESS,
  INFOS_MODAL_INSERT_INFO_FAILED,
  SET_ERROR,
  INFOS_FORM_SET_MAIN_IMAGE,
  MODULE_UPDATE_SET_KEYS_DATA,
} from '../../types/mutation-types'

export const MUTATIONS = {
  [INFOS_MODAL_SET_LOADING](state, payload) {
    state.loading = payload
  },

  [INFOS_MODAL_INSERT_INFO_SUCCESS](state, payload) {
    state.insertSuccess = payload
  },

  [INFOS_MODAL_INSERT_INFO_FAILED](state, payload) {
    state.insertSuccess = payload
  },

  [SET_ERROR](state, payload) {
    state.errors = payload
  },

  [INFOS_FORM_SET_MAIN_IMAGE](state, payload) {
    state.info.image = payload
    state.isImgChange = true
  },
  INFO_GROUP_ALBUMS(state, payload) {
    state.list_group_albums = payload
  },
  [MODULE_UPDATE_SET_KEYS_DATA](state, payload) {
    state.infoAlbumsImage.value = payload
  },
}
