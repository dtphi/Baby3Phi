import DashboardPage from 'v@admin/dashboards'
import {
  config,
} from '../../common/b3p-admin-config'

export const rtsDashboard = {
  path: config.adminRoute.dashboard.path,
  component: DashboardPage,
  name: config.adminRoute.dashboard.name,
  meta: {
    layout: config.defaultLayout,
    role: 'admin',
    show: {
      footer: true,
    },
    title: 'Quản trị | ' + config.site_name,
  },
}
