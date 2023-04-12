import AppConfig from 'api@admin/constants/app-config'
import { v4 as uuidv4, } from 'uuid'
import { apiInsertInfoAlbums, } from 'api@admin/albums'
import { apiGetAllGroupAlbums, } from 'api@admin/groupalbums'
import { MODULE_MODULE_ALBUMS, } from '../../types/module-types'
import {
  INFOS_MODAL_SET_LOADING,
  INFOS_MODAL_INSERT_INFO_SUCCESS,
  INFOS_MODAL_INSERT_INFO_FAILED,
  SET_ERROR,
  INFOS_FORM_SET_MAIN_IMAGE,
  MODULE_UPDATE_SET_KEYS_DATA,
} from '../../types/mutation-types'
import {
  ACTION_SET_LOADING,
  ACTION_INSERT_INFO,
  ACTION_INSERT_INFO_BACK,
  ACTION_SET_IMAGE,
  ACTION_RESET_NOTIFICATION_INFO,
  ACTION_GET_SETTING,
  ACTION_RELOAD_GET_INFO_LIST,
} from '../../types/action-types'

export const ACTIONS = {
  pushInfoAlbumsImage({ state, }, value) {
    const data = {
      id: uuidv4(),
      status: 1,
      open: 0,
      image: value.filePath,
      width: 0,
      height: 450,
    }
    state.infoAlbumsImage.value.push(data)
  },

  removeInfoAlbumsImage({ state, }, banner) {
    let banners = state.infoAlbumsImage.value
    if (state.infoAlbumsImage.value.length > 0) {
      state.infoAlbumsImage.value = _.remove(
        banners,
        function(item) {
          return !(item.id == banner.id)
        }
      )
    }
  },

  update_info_albums_image({ state, }, albumsImage) {
    state.info.albums_images = albumsImage
  },

  [ACTION_GET_SETTING]({ commit, }, albumsImage) {
    if (albumsImage.length) {
      commit(MODULE_UPDATE_SET_KEYS_DATA, albumsImage)
    }
  },

  // GET LIST GROUP ALBUMS
  ACTION_GET_LIST_GROUP_ALBUMS({ commit, }, params) {
    apiGetAllGroupAlbums(
      (infos) => {
        commit('INFO_GROUP_ALBUMS', infos.data.results)
      },
      (errors) => {
        commit(SET_ERROR, errors)
      },
      params
    )
  },

  [ACTION_SET_LOADING]({ commit, }, isLoading) {
    commit(INFOS_MODAL_SET_LOADING, isLoading)
  },

  // ACTION INSERT ALBUMS
  [ACTION_INSERT_INFO]({ dispatch, commit, }, info) {
    apiInsertInfoAlbums(
      info,
      (result) => {
        if (result) {
          commit(
            INFOS_MODAL_INSERT_INFO_SUCCESS,
            AppConfig.comInsertNoSuccess
          )
        }
        dispatch(ACTION_SET_LOADING, false)
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
    apiInsertInfoAlbums(
      info,
      (result) => {
        if (result) {
          commit(
            INFOS_MODAL_INSERT_INFO_SUCCESS,
            AppConfig.comInsertNoSuccess
          )
          dispatch(
            `${MODULE_MODULE_ALBUMS}_${ACTION_RELOAD_GET_INFO_LIST}`,
            'page',
            {
              root: true,
            }
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

  [ACTION_SET_IMAGE]({ commit, }, imgFile) {
    commit(INFOS_FORM_SET_MAIN_IMAGE, imgFile)
  },

  [ACTION_RESET_NOTIFICATION_INFO]({ commit, }, values) {
    commit(INFOS_MODAL_INSERT_INFO_SUCCESS, values)
  },
}
