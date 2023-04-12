import {
  config,
} from '../common/b3p-admin-config'
import { rtsDefault } from './admins/b3p-rts-default'
import { rtsDashboard } from './admins/b3p-rts-dashboard'
import { rtsModuleList } from './admins/b3p-rts-module-list'
import { rstInformationCategory } from './admins/b3p-rts-information-category'
import { rtsInformation } from './admins/b3p-rts-information'
import { rtsUser } from './admins/b3p-rts-user'
import { rtsFilemanager } from './admins/b3p-rts-filemanager'
import { rtsSystem } from './admins/b3p-rts-system'
import { rtsRestrictIp } from './admins/b3p-rts-restrict-ip'
import { rtsAlbum } from './admins/b3p-rts-album'
import { rtsAlbumCategory } from './admins/b3p-rts-album-category'
import { rtsLogin } from './admins/b3p-rts-login'

export default [{
  path: '/'+config.adminPrefix,
  component: {
    render: c => c('router-view'),
  },
  children: [
    rtsDefault,
    rtsLogin,
    rtsDashboard,
    rtsModuleList,
    rstInformationCategory,
    rtsInformation,
    rtsUser,
    rtsFilemanager,
    rtsSystem,
    rtsRestrictIp,
    rtsAlbum,
    rtsAlbumCategory,
  ],
}]
