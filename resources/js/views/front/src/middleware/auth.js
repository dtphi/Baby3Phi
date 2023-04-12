// import createPersistedState from 'vuex-persistedstate'

// Check user login
export default function ({ store, route, redirect }) {
  const values = Object.keys(route.query)
  console.log('auth:middleware:route_query', values)
}
