import {
  config,
} from '../../common/b3p-admin-config'

export const rtsFilemanager = {
  path: 'filemanagers',
  component: {
    render: c => c('router-view'),
  },
  children: [{
    path: '',
    component: () =>
      import('v@admin/filemanagers'),
    name: 'admin.filemanagers.list',
    meta: {
      auth: true,
      breadcrumbs: [{
        name: 'Quản trị',
        linkName: 'admin.dashboards',
        linkPath: '/dashboards',
      }, {
        name: 'Hình ảnh tin tức',
      }],
      header: 'Danh sách hình ảnh',
      layout: config.defaultLayout,
      role: 'admin',
      title: 'Danh sách hình ảnh | ' + config.site_name,
    },
  }],
}
