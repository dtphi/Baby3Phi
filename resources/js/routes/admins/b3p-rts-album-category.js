import GroupAlbumsPage from 'v@admin/groupalbums'
import {
  config,
} from '../../common/b3p-admin-config'

export const rtsAlbumCategory = {
  path: 'group-albums',
  component: {
    render: c => c('router-view'),
  },
  children: [{
    path: '',
    component: GroupAlbumsPage,
    name: 'admin.group.albums',
    meta: {
      layout: config.defaultLayout,
      auth: true,
      breadcrumbs: [{
        name: 'Quản trị',
        linkName: 'admin.dashboards',
        linkPath: '/dashboards',
      }, {
        name: 'Group Albums',
      }],
      header: 'Danh sách Group albums',
      role: 'admin',
      title: 'Group albums | ' + config.site_name,
      show: {
        footer: true,
      },
    },
  }, {
    path: 'add',
    component: () =>
      import('v@admin/groupalbums/add'),
    name: 'admin.group.albums.add',
    meta: {
      layout: config.defaultLayout,
      auth: true,
      breadcrumbs: [{
        name: 'Quản trị',
        linkName: 'admin.dashboards',
        linkPath: '/dashboards',
      }, {
        name: 'Danh mục Group albums',
        linkName: 'admin.group.albums.list',
        linkPath: '/group-albums',
      }, {
        name: 'Thêm Group albums',
      }],
      header: 'Thêm Group albums',
      role: 'admin',
      title: 'Thêm Group albums | ' + config.site_name,
      show: {
        footer: true,
      },
    },
  }, {
    path: 'edit/:infoId',
    component: () => import('v@admin/groupalbums/edit'),
    name: 'admin.group.albums.edit',
    meta: {
      layout: config.defaultLayout,
      auth: true,
      breadcrumbs: [{
        name: 'Quản trị',
        linkName: 'admin.dashboards',
        linkPath: '/dashboards',
      }, {
        name: 'Danh sách group albums',
        linkName: 'admin.group.albums.list',
        linkPath: '/group-albums',
      }, {
        name: 'Group albums',
      }],
      header: 'Sửa Group albums',
      role: 'admin',
      title: 'Group albums | ' + config.site_name,
      show: {
        footer: true,
      },
    },
  }],
}
