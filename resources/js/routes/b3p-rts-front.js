import { rtsHome } from './fronts/b3p-rts-home'

let routeEnv = {}
routeEnv = {
  path: '',
  component: {
    render: c => c('router-view'),
  },
  children: [
    rtsHome,
  ],
}

export default [routeEnv]
