import {
  config,
} from '../../common/b3p-admin-config'

export const rtsModuleList = {
  path: 'module-*',
  component: () =>
    import('v@admin/modules'),
  name: 'admin.module.list',
  meta: {
    layout: config.defaultLayout,
    auth: true,
    breadcrumbs: [{
      name: 'Quản trị',
      linkName: 'admin.dashboards',
      linkPath: '/dashboards',
    }, {
      name: 'Phần mở rộng',
    }],
    header: 'Phần mở rộng',
    role: 'admin',
    title: 'Danh mục tin | ' + config.site_name,
    show: {
      footer: true,
    },
  },
}
