import InformationListPage from 'v@admin/informations'
import {
  config,
} from '../../common/b3p-admin-config'

export const rtsInformation = {
  path: 'informations',
  component: {
    render: c => c('router-view'),
  },
  children: [{
    path: '',
    component: InformationListPage,
    name: 'admin.informations.list',
    meta: {
      auth: true,
      breadcrumbs: [{
        name: 'Quản trị',
        linkName: 'admin.dashboards',
        linkPath: '/dashboards',
      }, {
        name: 'Tin Tức',
      }],
      header: 'Danh sách tin tức',
      layout: config.defaultLayout,
      role: 'admin',
      title: 'Tin tức | ' + config.site_name,
    },
  }, {
    path: 'add',
    component: () =>
      import('v@admin/informations/add'),
    name: 'admin.informations.add',
    meta: {
      auth: true,
      breadcrumbs: [{
        name: 'Quản trị',
        linkName: 'admin.dashboards',
        linkPath: '/dashboards',
      }, {
        name: 'Tin Tức',
        linkName: 'admin.informations.list',
        linkPath: '/informations',
      }, {
        name: 'Thêm tin tức',
      }],
      header: 'Thêm tin tức',
      layout: config.defaultLayout,
      role: 'admin',
      title: 'Thêm tin tức | ' + config.site_name,
    },
  }, {
    path: 'edit/:infoId',
    component: () =>
      import('v@admin/informations/edit'),
    name: 'admin.informations.edit',
    meta: {
      auth: true,
      breadcrumbs: [{
        name: 'Quản trị',
        linkName: 'admin.dashboards',
        linkPath: '/dashboards',
      }, {
        name: 'Tin Tức',
        linkName: 'admin.informations.list',
        linkPath: '/informations',
      }, {
        name: 'Cập nhật tin tức',
      }],
      header: 'Cập nhật tin tức',
      layout: config.defaultLayout,
      role: 'admin',
      title: 'Cập nhật tin tức | ' + config.site_name,
    },
  }],
}
