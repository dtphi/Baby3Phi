import Vue from 'vue'
import Vuex from 'vuex'
import home from './homes'
import subscribe from './subscribes'
import appModule from './modules'
// import createLogger from '../../plugins/logger'
import { GET_INFORMATION_LIST_TO_CATEGORY, } from '@app/stores/front/types/action-types'
import { MODULE_INFO, } from '@app/stores/front/types/module-types'
const debug = process.env.NODE_ENV === 'debuger'
import { fnIsObject, fnCheckProp, } from '@app/common/util'
const Actions = require('./actions');
const Mutations = require('./mutations');
Vue.use(Vuex)
const defaultState = () => {
  return {
    logo: '/front/img/logo.png',
    banner: '/Image/NewPicture/home_banners/banner_image.png',
    iconBookUrl: '/',
    navMainLists: [],
    pageLists: [],
    appLists: [],
    infoLasteds: [],
    infoPopulars: [],
    pages: {},
  }
}
const initPaginationState = () => {
  return {
    links: {},
    meta: {},
    perPage: 20,
    moduleActive: {
      name: MODULE_INFO,
      actionList: GET_INFORMATION_LIST_TO_CATEGORY,
      params: {},
    },
    collectionData: {
      current_page: 1,
      from: 0,
      to: 0,
      total: 0,
    },
  }
}
export default new Vuex.Store({
  state: {
    cfApp: {
      setting: defaultState(),
    },
    paginationRoot: initPaginationState(),
    errors: [],
    clientsTestimonialsPage: 4,
  },
  getters: {
    cfApp(state) {
      return state.cfApp
    },
    bannerUrl(state) {
      return state.cfApp.setting.banner
    },
    logoUrl(state) {
      return state.cfApp.setting.logo
    },
    navMainLists(state) {
      let menus = { id: 0, newsgroupname: 'Home', children: [], }
      if (fnIsObject(state.cfApp.setting) && fnCheckProp(state.cfApp.setting, 'navMainLists') &&
        Array.isArray(state.cfApp.setting.navMainLists)) {
        menus.children = { ...state.cfApp.setting.navMainLists, }
      }

      return menus
    },
    pageLists(state) {
      return state.cfApp.setting.pageLists
    },
    resourcePaginationData(state) {
      return {
        links: state.paginationRoot.links,
        meta: state.paginationRoot.meta,
      }
    },
    collectionPaginationData(state) {
      const colData = { current_page: 1, from: 0, to: 0, total: 0, }
      if (fnIsObject(state.paginationRoot.collectionData)) {
        return state.paginationRoot.collectionData
      }

      return colData
    },
    isNotEmptyList(state) {
      if (fnIsObject(state.paginationRoot.meta) &&
        fnCheckProp(state.paginationRoot.meta, 'total')) {
        return (parseInt(state.paginationRoot.meta.total) > 0)
      }

      return false
    },
    moduleNameActive(state) {
      let mName = ''
      if (fnIsObject(state.paginationRoot.moduleActive) &&
        fnCheckProp(state.paginationRoot.moduleActive, 'name')) {
        mName = state.paginationRoot.moduleActive.name
      }

      return mName
    },
    moduleActionListActive(state) {
      let mAction = ''
      if (fnIsObject(state.paginationRoot.moduleActive) && fnCheckProp(state.paginationRoot.moduleActive, 'actionList')) {
        mAction = state.paginationRoot.moduleActive.actionList
      }

      return mAction
    },
    isScreen414(state) {
      return state.clientsTestimonialsPage == 414
    },
    isScreen767(state) {
      return state.clientsTestimonialsPage == 1
    },
    isScreen1200(state) {
      return state.clientsTestimonialsPage <= 3
    },
    isScreen960(state) {
      return state.clientsTestimonialsPage <= 2
    },
  },
  mutations: Mutations.MUTATIONS,
  actions: Actions.ACTIONS,
  modules: {
    home,
    subscribe,
    appModule,
  },
  // strict: debug,
  // plugins: debug ? [createLogger()] : []
})
