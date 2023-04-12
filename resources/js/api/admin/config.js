const envBuild = process.env.NODE_ENV
var pathArray = (envBuild === 'production')?process.env.MIX_APP_ADMIN_API_ROUTE_LOGIN.split(','):[]
var _adminPathName = (envBuild === 'production')?pathArray[0]:'admin'
let baseUrl = window.origin

const existStatus = {
  checking: 'checking',
  exist: 'exit',
  notExist: 'notExist',
}

export const config = {
  site_name: 'Babi-3-Phi',
  baseUrl: baseUrl,
  existStatus: existStatus,
  adminPrefix: _adminPathName,
}
