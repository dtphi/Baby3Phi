import { apiGetSettings, } from '@app/api/front/apps'
import { fnCheckProp, } from '@app/common/util'

export const ACTIONS = {
  setParams({ commit, }, params) {
    commit('initOptions', params)
  },
  appSettings({ commit, }, options) {
    apiGetSettings((responses) => {
      commit('initSetting', responses)
      commit('appSetError', [])
    }, (errors) => {
      commit('appSetError', errors)
    }, options)
  },
  setConfigApp({ commit, }, configs) {
    const links = (fnCheckProp(configs, 'links')) ? configs.links : undefined
    const meta = (fnCheckProp(configs, 'meta')) ? configs.meta : undefined
    const moduleActive = (fnCheckProp(configs, 'moduleActive')) ? configs.moduleActive : undefined
    let defaultState = initPaginationState()
    if (typeof links !== 'undefined') {
      defaultState.links = links
    }
    if (typeof meta != 'undefined') {
      defaultState.meta = meta
    }
    if (typeof moduleActive != 'undefined') {
      if (fnCheckProp(moduleActive, 'name')) {
        defaultState.moduleActive.name = moduleActive.name
      }
      if (fnCheckProp(moduleActive, 'actionList')) {
        defaultState.moduleActive.actionList = moduleActive.actionList
      }
      if (fnCheckProp(moduleActive, 'params')) {
        defaultState.moduleActive.params = moduleActive.params
      }
    }
    let collectionPg = (fnCheckProp(configs, 'collectionData')) ? configs.collectionData : undefined
    if (collectionPg.length == 0) {
      collectionPg = defaultState.collectionData
    }
    defaultState.collectionData = collectionPg
    commit('configApp', defaultState)
  },
  winWidth({ state, }) {
    var w = window.innerWidth
    state.clientsTestimonialsPage = 4
    if (w < 1200) {
      state.clientsTestimonialsPage = 3
    }
    if (w < 960) {
      state.clientsTestimonialsPage = 2
    }
    if (w < 769) {
      state.clientsTestimonialsPage = 1
    }
    if (w < 500) {
      state.clientsTestimonialsPage = 414
    }
  },
}
