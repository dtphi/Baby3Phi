export default ({ $axios, app, store }) => {
  let retryCount = 0
  $axios.onResponse(() => {
    retryCount = 0
  })
  $axios.onError((error) => {
    if (error.message === 'Network Error') {
      // eslint-disable-next-line
      console.log('通信エラーが発生しました')
      throw error
    } else if (error.message.includes('timeout of')) {
      // eslint-disable-next-line
      console.log('通信がタイムアウトしました')
      throw error
    } else if (error.response) {
      const code = parseInt(error.response && error.response.status)
      if (code === 503) {
        store.dispatch('base/setMaintenance', error.response.data)
        app.router.replace('/maintenance')
        return
      }
      if (code !== 401) {
        store.dispatch('base/setErrors', error.response.data)
        throw error
      }
      if (!error.config.headers.Authorization) {
        throw error
      }
      if (error.config.url === '/v1/auth/logout') {
        throw error
      }
      if (retryCount < 1) {
        retryCount++
        return store
          .dispatch('auth/checkLogin')
          .then(() => {
            error.config.headers.Authorization =
              'Bearer ' + store.state.auth.accessToken
            return new Promise((resolve, reject) => {
              $axios
                .request(error.config)
                .then((response) => {
                  resolve(response)
                })
                .catch((error) => {
                  reject(error)
                })
            }).catch((error) => {
              throw error
            })
          })
          .catch((error) => {
            throw error
          })
      }
    }
    throw error
  })
}
