import AuthLayout from 'v@admin/layouts/auth'
import Login from 'v@admin/auth/Login'
import {
  config,
} from '../../common/b3p-admin-config'

export const rtsLogin = {
  path: config.adminRoute.login.path,
  component: Login,
  name: config.adminRoute.login.name,
  meta: {
    layout: AuthLayout,
    role: 'admin',
    show: {
      footer: true,
    },
    title: 'Login | ' + config.site_name,
  },
}
