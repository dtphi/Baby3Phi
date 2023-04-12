import CategoryListPage from 'v@admin/categorys'
import {
  config,
} from '../../common/b3p-admin-config'

export const rstInformationCategory = {
  path: 'news-categories',
  component: {
    render: c => c('router-view'),
  },
  children: [{
    path: '',
    component: CategoryListPage,
    name: 'admin.category.list',
    meta: {
      layout: config.defaultLayout,
      auth: true,
      breadcrumbs: [{
        name: 'Quản trị',
        linkName: 'admin.dashboards',
        linkPath: '/dashboards',
      }, {
        name: 'Danh mục tin',
      }],
      header: 'Danh sách danh mục tin',
      role: 'admin',
      title: 'Danh mục tin | ' + config.site_name,
      show: {
        footer: true,
      },
    },
  }, {
    path: 'add',
    component: () =>
      import('v@admin/categorys/add'),
    name: 'admin.category.add',
    meta: {
      layout: config.defaultLayout,
      auth: true,
      breadcrumbs: [{
        name: 'Quản trị',
        linkName: 'admin.dashboards',
        linkPath: '/dashboards',
      }, {
        name: 'Danh mục tin',
        linkName: 'admin.category.list',
        linkPath: '/news-categories',
      }, {
        name: 'Thêm danh mục',
      }],
      header: 'Thêm danh mục tin tức',
      role: 'admin',
      title: 'Thêm danh mục | ' + config.site_name,
      show: {
        footer: true,
      },
    },
  }, {
    path: 'edit/:categoryId',
    component: () =>
      import('v@admin/categorys/edit'),
    name: 'admin.category.edit',
    meta: {
      layout: config.defaultLayout,
      auth: true,
      breadcrumbs: [{
        name: 'Quản trị',
        linkName: 'admin.dashboards.list',
        linkPath: '/dashboards',
      }, {
        name: 'Danh mục tin',
        linkName: 'admin.category',
        linkPath: '/news-categories',
      }, {
        name: 'Cập nhật danh mục',
      }],
      header: 'CategoryEdit',
      role: 'admin',
      title: 'Edit category | ' + config.site_name,
      show: {
        footer: true,
      },
    },
  }],
}
