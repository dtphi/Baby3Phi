
export default class BaseCRUD {
  constructor(url, defaultParam) {
    this.state = {
      prefix: url,
      url: '/v1/' + url,
      defaultParam,
      list: [],
      pagination: {
        total: 0,
        per: 30,
        last: 1,
        current: 1,
      },
      data: {},
      setting: {},
      other: {},
    }
    this.mutations = {
      getModels(state, { data, headers }) {
        state.list = data
        state.pagination.total = parseInt(headers['x-total'])
        state.pagination.per = parseInt(headers['x-per-page'])
        state.pagination.last = parseInt(headers['x-last-page'])
        state.pagination.current = parseInt(headers['x-current-page'])
      },
      getModel(state, data) {
        state.data = data
      },
      postModel(state, data) {
        state.list.push(data)
      },
      putModel(state, data) {
        state.list.map((e) => {
          if (e.id !== data.id) {
            e = data
          }
          return e
        })
      },
      deleteModel(state, data) {
        state.list.filter((e) => {
          return e.id !== data.id
        })
      },
      getSetting(state, data) {
        state.setting = data
      },
      puttSetting(state, data) {
        state.setting = data
      },
    }
    this.actions = {
      async getModels({ state, commit }, params = {}) {
        if (state.defaultParam) {
          Object.keys(state.defaultParam).forEach((key) => {
            params[key] = state.defaultParam[key]
          })
        }
        await this.$axios({
          method: 'get',
          url: state.url,
          params,
        }).then((response) => {
          commit('getModels', response)
        })
        return Promise
      },
      async getModel({ state, commit }, { key, params = {} }) {
        await this.$axios({
          method: 'get',
          url: state.url + '/' + key,
          params,
        }).then((response) => {
          commit('getModel', response.data)
        })
        return Promise
      },
      async postModel({ state, commit }, { key, data }) {
        if (state.defaultParam) {
          Object.keys(state.defaultParam).forEach((key) => {
            data[key] = state.defaultParam[key]
          })
        }
        await this.$axios({
          method: 'post',
          url: state.url,
          data,
        }).then((response) => {
          commit('postModel', response.data)
          commit('page/resetPage', {}, { root: true })
        })
        return Promise
      },
      async putModel({ state, commit }, { key, data }) {
        await this.$axios({
          method: 'put',
          url: state.url + '/' + key,
          data,
        }).then((response) => {
          commit('putModel', response.data)
          commit('page/resetPage', {}, { root: true })
        })
        return Promise
      },
      async patchModel({ state, commit }, { key, data }) {
        await this.$axios({
          method: 'patch',
          url: state.url + '/' + key,
          data,
        }).then((response) => {
          commit('putModel', response.data)
          commit('page/resetPage', {}, { root: true })
        })
        return Promise
      },
      async patchModelSort({ state, commit }, { key, data }) {
        await this.$axios({
          method: 'patch',
          url: state.url + '/' + key + '/sort',
          data,
        }).then((response) => {})
        return Promise
      },
      async deleteModel({ state, commit }, { key, data }) {
        await this.$axios({
          method: 'delete',
          url: state.url + '/' + key,
        }).then((response) => {
          commit('postModel', response.data)
          commit('page/resetPage', {}, { root: true })
        })
        return Promise
      },
      async copyModel({ state, commit }, key) {
        await this.$axios({
          method: 'post',
          url: state.url + '/' + key + '/copy',
        }).then((response) => {
          commit('postModel', response.data)
          commit('page/resetPage', {}, { root: true })
        })
        return Promise
      },
      async getSetting({ state, commit }, { params = {} }) {
        await this.$axios({
          method: 'get',
          url: '/v1/settings/' + state.prefix,
          params,
        }).then((response) => {
          commit('getSetting', response.data)
        })
        return Promise
      },
      async putSetting({ state, commit }, { data }) {
        await this.$axios({
          method: 'put',
          url: '/v1/settings/' + state.prefix,
          data,
        }).then((response) => {
          commit('putSetting', response.data)
        })
        return Promise
      },
      async importModels({ state, commit }, { file, params = {} }) {
        const formData = new FormData()
        formData.append('file', file)
        const addUrl = params.add_url !== undefined ? params.add_url : ''
        await this.$axios({
          method: 'post',
          url: state.url + '/import' + addUrl,
          data: formData,
        }).then((response) => {
          // eslint-disable-next-line
          console.log(response)
        })
        return Promise
      },
    }
  }
}
