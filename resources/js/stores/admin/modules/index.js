import CategoryIconSideBar from './category_icon_side_bars'
import CategoryLeftSideBar from './category_left_side_bars'
import HomeBanner from './home_banners'
import NoiBat from './noi_bats'
import SpecialInfoCarousel from './special_info_carousels'

import AppConfig from 'api@admin/constants/app-config'
import { apiGetSettingByCode, apiInsertSetting, } from 'api@admin/setting'
import {
  INFOS_FORM_SET_MAIN_IMAGE,
  MODULE_UPDATE_SET_LOADING,
  MODULE_UPDATE_SET_KEYS_DATA,
  MODULE_UPDATE_SETTING_SUCCESS,
  MODULE_UPDATE_SETTING_FAILED,
  SET_ERROR,
} from '../types/mutation-types'
import {
  ACTION_SET_LOADING,
  ACTION_SET_IMAGE,
  ACTION_GET_SETTING,
  ACTION_RESET_NOTIFICATION_INFO,
} from '../types/action-types'
import { fnCheckProp, } from '@app/common/util'

const defaultState = () => {
  return {
    logo_image: '',
    banner_image: '',
    phone: '',
    header_title: '',
    email: '',
    content_background_color: '',
    content_backgd_header_title: '',
    content_backgd_phone: '',
    content_backgd_logo: '',
    loading: false,
    updateSuccess: false,
    errors: [],
  }
}

export default {
  namespaced: true,
  state: defaultState(),
  getters: {
    system(state) {
      return state
    },
    updateSuccess(state) {
      return state.updateSuccess
    },
    texts() {
      return {
        module_noi_bat: {
          text: 'Module nổi bật',
          module_noi_bat_sach_nois: 'Sách nói',
          module_noi_bat_youtubes: 'Youtube',
          module_noi_bat_hanh_cac_thanhs: 'Hạnh các thánh',
          module_noi_bat_banners: 'Banner liên kết',
        },
        module_category_icon_side_bar: {
          text: 'Module Danh mục icon',
          module_category_icon_side_bar_categories: 'Danh mục',
        },
        module_category_left_side_bar: {
          text: 'Module danh mục trái',
          module_category_left_side_bar_categories: 'Danh mục',
        },
      }
    },
  },
  mutations: {
    SYSTEMS_SET_LOGO_IMAGE(state, payload) {
      state.logo_image = payload
    },
    [INFOS_FORM_SET_MAIN_IMAGE](state, payload) {
      state.banner_image = payload
    },
    [MODULE_UPDATE_SET_LOADING](state, payload) {
      state.loading = payload
    },
    [MODULE_UPDATE_SET_KEYS_DATA](state, payload) {
      if (fnCheckProp(payload, 'module_system_banners')) {
        state.banner_image = payload.module_system_banners.value.image
      }
      if (fnCheckProp(payload, 'module_system_con_background_colors')) {
        state.content_background_color =
                    payload.module_system_con_background_colors.value
      }
      if (fnCheckProp(payload, 'module_system_logos')) {
        state.logo_image = payload.module_system_logos.value
      }
      if (fnCheckProp(payload, 'module_system_logo_titles')) {
        state.logo_title = payload.module_system_logo_titles.value
      }
      if (fnCheckProp(payload, 'module_system_logo_title_1s')) {
        state.logo_title_1 = payload.module_system_logo_title_1s.value
      }
      if (fnCheckProp(payload, 'module_system_phones')) {
        state.phone = payload.module_system_phones.value
      }
      if (fnCheckProp(payload, 'module_system_emails')) {
        state.email = payload.module_system_emails.value
      }
      if (fnCheckProp(payload, 'module_system_header_titles')) {
        state.header_title = payload.module_system_header_titles.value
      }
      if (
        fnCheckProp(
          payload,
          'module_system_content_backgd_header_titles'
        )
      ) {
        state.content_backgd_header_title =
                    payload.module_system_content_backgd_header_titles.value
      }
      if (fnCheckProp(payload, 'module_system_content_backgd_phones')) {
        state.content_backgd_phone =
                    payload.module_system_content_backgd_phones.value
      }
      if (fnCheckProp(payload, 'module_system_content_backgd_logos')) {
        state.content_backgd_logo =
                    payload.module_system_content_backgd_logos.value
      }
    },
    [MODULE_UPDATE_SETTING_SUCCESS](state, payload) {
      state.updateSuccess = payload
    },
    [MODULE_UPDATE_SETTING_FAILED](state, payload) {
      state.updateSuccess = payload
    },
    [SET_ERROR](state, payload) {
      state.errors = payload
    },
  },
  actions: {
    [ACTION_GET_SETTING]({ dispatch, commit, }) {
      dispatch(ACTION_SET_LOADING, true)
      apiGetSettingByCode(
        'module_system',
        (res) => {
          if (Object.keys(res.data.results).length) {
            commit(MODULE_UPDATE_SET_KEYS_DATA, res.data.results)

            dispatch(ACTION_SET_LOADING, false)
          } else {
            dispatch(ACTION_SET_LOADING, false)
          }
        },
        (errors) => {
          dispatch(ACTION_SET_LOADING, false)
          commit(SET_ERROR, errors)
        }
      )
    },
    [ACTION_SET_IMAGE]({ commit, }, imgFile) {
      commit(INFOS_FORM_SET_MAIN_IMAGE, imgFile)
    },
    ACTION_UPDATE_LOGO({ commit, state, dispatch, }, logo) {
      if (logo) {
        commit('SYSTEMS_SET_LOGO_IMAGE', logo)
      } else {
        dispatch(ACTION_SET_LOADING, true)
        const data = {
          action: 'update',
          code: 'module_system',
          keys: [
            {
              key: 'module_system_logos',
              value: state.logo_image,
              serialize: false,
            },
            {
              key: 'module_system_logo_titles',
              value: state.logo_title,
              serialize: false,
            },
            {
              key: 'module_system_logo_title_1s',
              value: state.logo_title_1,
              serialize: false,
            },
            {
              key: 'module_system_phones',
              value: state.phone,
              serialize: false,
            },
            {
              key: 'module_system_emails',
              value: state.email,
              serialize: false,
            },
            {
              key: 'module_system_header_titles',
              value: state.header_title,
              serialize: false,
            }
          ],
        }

        apiInsertSetting(
          data,
          (result) => {
            if (result) {
              commit(
                MODULE_UPDATE_SETTING_SUCCESS,
                AppConfig.comInsertNoSuccess
              )
              commit(SET_ERROR, [])
            }

            dispatch(ACTION_SET_LOADING, false)
          },
          (errors) => {
            commit(
              MODULE_UPDATE_SETTING_FAILED,
              AppConfig.comInsertNoFail
            )
            commit(SET_ERROR, errors)

            dispatch(ACTION_SET_LOADING, false)
          }
        )
      }
    },
    ACTION_UPDATE_BANNER({ commit, state, dispatch, }) {
      dispatch(ACTION_SET_LOADING, true)
      const data = {
        action: 'update',
        code: 'module_system',
        keys: [
          {
            key: 'module_system_banners',
            value: {
              image: state.banner_image,
            },
            serialize: true,
          },
          {
            key: 'module_system_con_background_colors',
            value: state.content_background_color,
            serialize: false,
          },
          {
            key: 'module_system_content_backgd_header_titles',
            value: state.content_backgd_header_title,
            serialize: false,
          },
          {
            key: 'module_system_content_backgd_logos',
            value: state.content_backgd_logo,
            serialize: false,
          },
          {
            key: 'module_system_content_backgd_phones',
            value: state.content_backgd_phone,
            serialize: false,
          }
        ],
      }

      apiInsertSetting(
        data,
        (result) => {
          if (result) {
            commit(
              MODULE_UPDATE_SETTING_SUCCESS,
              AppConfig.comInsertNoSuccess
            )
            commit(SET_ERROR, [])
          }

          dispatch(ACTION_SET_LOADING, false)
        },
        (errors) => {
          commit(
            MODULE_UPDATE_SETTING_FAILED,
            AppConfig.comInsertNoFail
          )
          commit(SET_ERROR, errors)

          dispatch(ACTION_SET_LOADING, false)
        }
      )
    },
    [ACTION_SET_LOADING]({ commit, }, isLoading) {
      commit(MODULE_UPDATE_SET_LOADING, isLoading)
    },
    [ACTION_RESET_NOTIFICATION_INFO]({ commit, }, values) {
      commit(MODULE_UPDATE_SETTING_SUCCESS, values)
    },
  },
  modules: {
    category_icon_side_bar: CategoryIconSideBar,
    category_left_side_bar: CategoryLeftSideBar,
    home_banner: HomeBanner,
    noi_bat: NoiBat,
    special_info_carousel: SpecialInfoCarousel,
  },
}
