import UserListPage from 'v@admin/users'
import {
  config,
} from '../../common/b3p-admin-config'

export const rtsUser = {
  path: 'users',
  component: {
    render: c => c('router-view'),
  },
  children: [{
    path: '',
    component: UserListPage,
    name: 'admin.users.list',
    meta: {
      auth: true,
      breadcrumbs: [{
        name: 'Quản trị',
        linkName: 'admin.dashboards',
        linkPath: '/dashboards',
      }, {
        name: 'Người dùng',
      }],
      header: 'Danh sách người dùng',
      layout: config.defaultLayout,
      role: 'admin',
      title: 'Users | ' + config.site_name,
    },
  }],
}
