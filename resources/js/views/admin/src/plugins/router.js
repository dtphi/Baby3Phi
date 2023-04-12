export default ({ app }) => {
  app.router.beforeEach((to, from, next) => {
    app.$axios.setHeader('X-Front-Route', to.fullPath)
    app.$axios.setHeader('X-Referer-Front-Route', from.fullPath)
    next()
  })
}
