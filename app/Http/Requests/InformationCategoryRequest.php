<?php

namespace App\Http\Requests;

use App\AppGlobals\ApiPermissionConstants as ApiPermission;
use Auth;
use App\Http\Common\Tables;
use App\Http\Common\BaseRequest;
use Illuminate\Support\Str;

class InformationCategoryRequest extends BaseRequest
{
    private $allow = ApiPermission::PREFIX_ALLOW_NEWS_GROUP . ':*';

    private $allowAdd = ApiPermission::PREFIX_ALLOW_NEWS_GROUP . ':add';

    private $allowEdit = ApiPermission::PREFIX_ALLOW_NEWS_GROUP . ':edit';

    private $allowDelete = ApiPermission::PREFIX_ALLOW_NEWS_GROUP . ':delete';

    private $allowList = ApiPermission::PREFIX_ALLOW_NEWS_GROUP . ':list';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $author = $this->_initAuthor(Tables::$categoryAccessName, $this->allow, $this->allowAdd, $this->allowEdit, $this->allowDelete, $this->allowList);

        return $author;
    }

    /**
     * @author : dtphi .
     * Get data to be validated from the request.
     *
     * @return array
     */
    public function validationData()
    {
        $formData = $this->all();
        $reqData = [];

        if ($this->isPutRequest() || $this->isPostRequest()) {
            $reqData['name'] = isset($formData['name']) ? $formData['name'] : '';
            if (empty($reqData['name'])) {
                $reqData['name'] = isset($formData['category_name']) ? $formData['category_name'] : '';
            }
            $reqData['name_slug']        = Str::slug($reqData['name']);
            $reqData['tag']              = isset($formData['tag']) ? $formData['tag'] : '';
            $reqData['parent_id']        = isset($formData['parent_id']) ? $formData['parent_id'] : null;
            $reqData['description']      = isset($formData['description']) ? htmlentities($formData['description']) : '';
            $reqData['meta_title']       = isset($formData['meta_title']) ? $formData['meta_title'] : '';
            $reqData['meta_description'] = isset($formData['meta_description']) ? $formData['meta_description'] : '';
            $reqData['meta_keyword']     = isset($formData['meta_keyword']) ? $formData['meta_keyword'] : '';
            $reqData['sort_order']       = isset($formData['sort_order']) ? $formData['sort_order'] : 0;
            $reqData['status']           = isset($formData['status']) ? $formData['status'] : 0;
            $reqData['layout_id']        = isset($formData['layout_id']) ? $formData['layout_id'] : null;
            $reqData['path']             = isset($formData['path']) ? $formData['path'] : null;
        }

        return $this->_formatToFormArray($reqData);
    }

    /**
     * @author : dtphi .
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->isMethod('get') || $this->isMethod('option'))
            return [];

        if ($this->isMethod('put')) {
            return [
                'f_name'       => 'required|min:3|max:255',
                'f_meta_title' => 'required|min:3|max:255'
            ];
        }

        return [
            'f_name'       => 'required|min:3|max:255',
            'f_meta_title' => 'required|min:3|max:255'
        ];
    }
}
