import SystemPage from 'v@admin/systems'
import {
  config,
} from '../../common/b3p-admin-config'

export const rtsSystem = {
  path: 'system',
  component: {
    render: c => c('router-view'),
  },
  children: [{
    path: '',
    component: SystemPage,
    name: 'admin.system.setting',
    meta: {
      layout: config.defaultLayout,
      auth: true,
      breadcrumbs: [{
        name: 'Quản trị',
        linkName: 'admin.dashboards',
        linkPath: '/dashboards',
      }, {
        name: 'Cài đặt',
      }],
      header: 'Danh sách cài đặt',
      role: 'admin',
      title: 'Cài đặt chung | ' + config.site_name,
      show: {
        footer: true,
      },
    },
  }],
}
