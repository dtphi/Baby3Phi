import AppConfig from 'api@admin/constants/app-config'
import { apiGetAlbumsById, apiUpdateAlbums, } from 'api@admin/albums'
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
import {
  ACTION_GET_INFO_BY_ID,
  ACTION_SET_LOADING,
  ACTION_SHOW_MODAL_EDIT,
  ACTION_UPDATE_INFO,
  ACTION_RESET_NOTIFICATION_INFO,
  ACTION_SET_IMAGE,
} from '../../types/action-types'

export const ACTIONS = {
  update_albums_images({ state, }, albums_images) {
    state.info.group_images = albums_images
  },

  [ACTION_SHOW_MODAL_EDIT]({ dispatch, }, infoId) {
    dispatch(ACTION_GET_INFO_BY_ID, infoId)
  },

  [ACTION_GET_INFO_BY_ID]({ dispatch, commit, }, infoId) {
    dispatch(ACTION_SET_LOADING, true)
    apiGetAlbumsById(
      infoId,
      (result) => {
        commit(INFOS_MODAL_SET_INFO_ID, infoId)
        commit(INFOS_MODAL_SET_INFO, result.data.data)

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
    apiUpdateAlbums(
      info,
      (result) => {
        if (result) {
          commit(
            INFOS_MODAL_UPDATE_INFO_SUCCESS,
            AppConfig.comUpdateNoSuccess
          )
          dispatch(ACTION_SET_LOADING, false)
          dispatch(ACTION_GET_INFO_BY_ID, info.id)
        }
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

  [ACTION_SET_IMAGE]({ commit, }, imgFile) {
    commit(INFOS_FORM_SET_MAIN_IMAGE, imgFile)
  },
}
