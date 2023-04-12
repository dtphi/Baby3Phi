import AlbumsPage from 'v@admin/albums'
import {
  config,
} from '../../common/b3p-admin-config'

export const rtsAlbum = {
  path: 'albums',
  component: {
    render: c => c('router-view'),
  },
  children: [{
    path: '',
    component: AlbumsPage,
    name: 'admin.albums',
    meta: {
      layout: config.defaultLayout,
      auth: true,
      breadcrumbs: [{
        name: 'Quản trị',
        linkName: 'admin.dashboards',
        linkPath: '/dashboards',
      }, {
        name: 'Albums',
      }],
      header: 'Danh sách Albums',
      role: 'admin',
      title: 'Albums | ' + config.site_name,
      show: {
        footer: true,
      },
    },
  }, {
    path: 'add',
    component: () =>
      import('v@admin/albums/add'),
    name: 'admin.albums.add',
    meta: {
      layout: config.defaultLayout,
      auth: true,
      breadcrumbs: [{
        name: 'Quản trị',
        linkName: 'admin.dashboards',
        linkPath: '/dashboards',
      }, {
        name: 'Danh mục Albums',
        linkName: 'admin.Albums.list',
        linkPath: '/albums',
      }, {
        name: 'Thêm Albums',
      }],
      header: 'Thêm Albums',
      role: 'admin',
      title: 'Thêm Albums | ' + config.site_name,
      show: {
        footer: true,
      },
    },
  }, {
    path: 'edit/:infoId',
    component: () => import('v@admin/albums/edit'),
    name: 'admin.albums.edit',
    meta: {
      layout: config.defaultLayout,
      auth: true,
      breadcrumbs: [{
        name: 'Quản trị',
        linkName: 'admin.dashboards',
        linkPath: '/dashboards',
      }, {
        name: 'Danh sách Albums',
        linkName: 'admin.albums.list',
        linkPath: '/albums',
      }, {
        name: 'Sửa Albums',
      }],
      header: 'Sửa Albums',
      role: 'admin',
      title: 'Sửa Albums | ' + config.site_name,
      show: {
        footer: true,
      },
    },
  }],
}
