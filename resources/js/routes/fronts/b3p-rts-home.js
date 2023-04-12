const network = ['facebook', 'twitter', 'linkedin', 'whatsapp']
import MainLayout from 'v@front/layouts/main'

export const rtsHome = {
  path: '/',
  component: {
    render: c => c('router-view'),
  },
  children: [{
    path: '',
    component: () => import('v@front/page_news'),
    name: 'home-page',
    meta: {
      auth: false,
      header: 'Trang chủ',
      layout: MainLayout,
      role: 'guest',
      layout_content: {},
    },
  }],
}
