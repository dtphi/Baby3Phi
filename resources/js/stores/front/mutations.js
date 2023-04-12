import { fnIsObject, } from '@app/common/util'

export const MUTATIONS = {
  initOptions(state, payload) {
    state.options = payload
  },
  initSetting(state, payload) {
    state.cfApp.setting = payload
  },
  appSetError(state, payload) {
    state.errors = payload
  },
  configApp(state, configs) {
    if (fnIsObject(configs.links)) {
      state.paginationRoot.links = configs.links
    }
    if (fnIsObject(configs.meta)) {
      state.paginationRoot.meta = configs.meta
    }
    if (fnIsObject(configs.moduleActive)) {
      state.paginationRoot.moduleActive = configs.moduleActive
    }
    if (fnIsObject(configs.collectionData)) {
      state.paginationRoot.collectionData = configs.collectionData
    }
  },
}
