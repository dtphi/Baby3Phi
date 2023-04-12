import { getAuth, onAuthStateChanged } from 'firebase/auth'
import { initializeApp, getApps } from 'firebase/app'
// import createPersistedState from 'vuex-persistedstate'

const firebaseConfig = {
  apiKey: process.env.fbApiKey,
  authDomain: process.env.fbAuthDomain,
  projectId: process.env.fbProjectId,
  storageBucket: process.env.fbStorageBucket,
  messagingSenderId: process.env.fbMessagingSenderId,
  appId: process.env.fbAppId
}
const apps = getApps()
if (!apps.length) {
  initializeApp(firebaseConfig)
}

const firebaseAuth = getAuth()
// Check user login
export default function ({ store, route, redirect }) {
  const values = Object.keys(route.query)
  console.log('auth:middleware:route_query', values)
  onAuthStateChanged(firebaseAuth, (user) => {
    console.log('auth:middleware:firebase_auth_user', user)
  })
}
