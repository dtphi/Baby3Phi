import {
  fn_get_base_api_url,
  fn_get_base_api_detail_url,
} from '@app/api/utils/fn-helper'
import {
  API_NEWS_GROUPS_RESOURCE,
} from 'store@admin/types/api-paths'


/**
 * [description]
 * @param  {[type]} newsGroupId [description]
 * @param  {[type]} resolve     [description]
 * @param  {[type]} errResole   [description]
 * @return {[type]}             [description]
 */
export const apiGetNewsGroupById = (newsGroupId, resolve, errResole) => {
  axios.get(fn_get_base_api_detail_url(API_NEWS_GROUPS_RESOURCE, newsGroupId))
    .then((response) => {
      if (response.status === 200) {
        var json = {}
        json['data'] = response.data.InformationCategory
        json['status'] = 1000
        resolve(json)
      } else {
        errResole([{
          status: response.status,
          msg: 'error test',
        }])
      }
    })
    .catch(errors => {
      errResole(errors)
    })
}

/**
 * [description]
 * @param  {[type]} resolve   [description]
 * @param  {[type]} errResole [description]
 * @param  {[type]} params    [description]
 * @return {[type]}           [description]
 */
export const apiGetNewsGroups = (resolve, errResole, params) => {
  return axios.get(fn_get_base_api_url(API_NEWS_GROUPS_RESOURCE), {
    params: params,
  })
    .then((response) => {
      if (response.status === 200) {
        resolve({
          newsgroupname: 'Danh Mục :',
          id: 0,
          children: [],
          data: response.data.data,
        })
      } else {
        errResole([{
          status: response.status,
          msg: 'error test',
        }])
      }
    })
    .catch(errors => {
      if (errors.response) {
        errResole([{
          status: errors.response.status,
          messageCommon: errors.response.data.message,
          messages: errors.response.data.errors,
        }])
      }
    })
}

/**
 * [description]
 * @param  {[type]} newsGroup [description]
 * @param  {[type]} resolve   [description]
 * @param  {[type]} errResole [description]
 * @return {[type]}           [description]
 */
export const apiUpdateNewsGroup = (categoryId, newsGroup, resolve, errResole) => {
  return axios.put(fn_get_base_api_detail_url(API_NEWS_GROUPS_RESOURCE, categoryId), newsGroup)
    .then((response) => {
      if (response.status === 200) {
        var json = {}
        json['data'] = response.data
        json['status'] = 1000
        resolve(json)
      } else {
        errResole([{
          status: response.status,
          msg: 'error test',
        }])
      }
    })
    .catch(errors => errResole([{
      status: errors.response.status,
      messageCommon: errors.response.data.message,
      messages: errors.response.data.errors,
    }]))
}

/**
 * [description]
 * @param  {[type]} newsGroup [description]
 * @param  {[type]} resolve   [description]
 * @param  {[type]} errResole [description]
 * @return {[type]}           [description]
 */
export const apiInsertNewsGroup = (newsGroup, resolve, errResole) => {
  return axios.post(fn_get_base_api_url(API_NEWS_GROUPS_RESOURCE), newsGroup)
    .then((response) => {
      if (response.status === 201) {
        var json = {}
        json['data'] = response.data.result
        json['code'] = response.data.code
        resolve(json)
      } else {
        errResole([{
          status: response.status,
          msg: 'error test',
        }])
      }
    })
    .catch(errors => errResole([{
      status: errors.response.status,
      messageCommon: errors.response.data.message,
      messages: errors.response.data.errors,
    }]))
}

/**
 * [description]
 * @param  {[type]} newsGroupId [description]
 * @param  {[type]} resolve     [description]
 * @param  {[type]} errResole   [description]
 * @return {[type]}             [description]
 */
export const apiDeleteNewsGroup = (newsGroupId, resolve, errResole) => {
  return axios.delete(fn_get_base_api_detail_url(API_NEWS_GROUPS_RESOURCE, newsGroupId))
    .then((response) => {
      if (response.status === 200) {
        var json = {}
        json['data'] = response.data
        json['status'] = 1000
        resolve(json)
      } else {
        errResole([{
          status: response.status,
          msg: 'error test',
        }])
      }
    })
    .catch(errors => errResole([{
      status: errors.response.status,
      messageCommon: errors.response.data.message,
      messages: errors.response.data.errors,
    }]))
}

/**
 * [description]
 * @param  {[type]} resolve   [description]
 * @param  {[type]} errResole [description]
 * @param  {[type]} params    [description]
 * @return {[type]}           [description]
 */
export const apiSearchAll = (query, resolve, errResole) => {
  let params = {
    query,
  }

  return axios.get(fn_get_base_api_url('/api/search-news-group'), {
    params,
  })
    .then((response) => {
      if (response.status === 200) {
        resolve(response.data)
      } else {
        errResole([{
          status: response.status,
          msg: 'error test',
        }])
      }
    })
    .catch(errors => errResole([{
      status: errors.response.status,
      messageCommon: errors.response.data.message,
      messages: errors.response.data.errors,
    }]))
}

export const apiGetDropdownCategories = (resolve, errResole, params) => {
  return axios.get(fn_get_base_api_url('/api/news-categories/dropdowns'), {
    params: params,
  })
    .then((response) => {
      if (response.status === 200) {
        resolve(response.data)
      } else {
        errResole([{
          status: response.status,
          msg: 'error test',
        }])
      }
    })
    .catch(errors => errResole(errors))
}

export const apiGetCategoryByIds = (resolve, errResole, params) => {
  return axios.get(fn_get_base_api_url('/api/news-categories/dropdowns'), {
    params: params,
  })
    .then((response) => {
      if (response.status === 200) {
        resolve(response.data)
      } else {
        errResole([{
          status: response.status,
          msg: 'error test',
        }])
      }
    })
    .catch(errors => errResole(errors))
}
