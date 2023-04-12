import RestrictIpsPage from 'v@admin/restrictips'
import {
  config,
} from '../../common/b3p-admin-config'

export const rtsRestrictIp = {
  path: 'restrict-ips',
  component: {
    render: c => c('router-view'),
  },
  children: [{
    path: '',
    component: RestrictIpsPage,
    name: 'admin.restrict_ips',
    meta: {
      layout: config.defaultLayout,
      auth: true,
      breadcrumbs: [{
        name: 'Quản trị',
        linkName: 'admin.dashboards',
        linkPath: '/dashboards',
      }, {
        name: 'Restrict Ip',
      }],
      header: 'Danh sách Restrict Ip',
      role: 'admin',
      title: 'Restrict Ip | ' + config.site_name,
      show: {
        footer: true,
      },
    },
  }, {
    path: 'add',
    component: () =>
      import('v@admin/restrictips/add'),
    name: 'admin.restrict_ip.add',
    meta: {
      layout: config.defaultLayout,
      auth: true,
      breadcrumbs: [{
        name: 'Quản trị',
        linkName: 'admin.dashboards',
        linkPath: '/dashboards',
      }, {
        name: 'Danh mục IP',
        linkName: 'admin.restrict_ip.list',
        linkPath: '/restrict-ips',
      }, {
        name: 'Thêm IP',
      }],
      header: 'Thêm IP',
      role: 'admin',
      title: 'Thêm IP | ' + config.site_name,
      show: {
        footer: true,
      },
    },
  }, {
    path: 'edit/:infoId',
    component: () => import('v@admin/restrictips/edit'),
    name: 'admin.restrict_ip.edit',
    meta: {
      layout: config.defaultLayout,
      auth: true,
      breadcrumbs: [{
        name: 'Quản trị',
        linkName: 'admin.dashboards',
        linkPath: '/dashboards',
      }, {
        name: 'Danh sách IP',
        linkName: 'admin.restrict_ip.list',
        linkPath: '/restrict-ips',
      }, {
        name: 'Restrict Ip',
      }],
      header: 'Sửa restrict ip',
      role: 'admin',
      title: 'Restrict IP | ' + config.site_name,
      show: {
        footer: true,
      },
    },
  }],
}
