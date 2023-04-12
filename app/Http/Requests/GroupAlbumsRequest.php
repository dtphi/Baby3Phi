<?php

namespace App\Http\Requests;

use App\AppGlobals\ApiPermissionConstants as ApiPermission;
use App\Http\Common\BaseRequest;
use Auth;
use App\Http\Common\Tables;

class GroupAlbumsRequest extends BaseRequest
{
    private $allow = ApiPermission::PREFIX_ALLOW_GROUP_ALBUMS . ':*';

    private $allowAdd = ApiPermission::PREFIX_ALLOW_GROUP_ALBUMS . ':add';

    private $allowEdit = ApiPermission::PREFIX_ALLOW_GROUP_ALBUMS . ':edit';

    private $allowDelete = ApiPermission::PREFIX_ALLOW_GROUP_ALBUMS . ':delete';

    private $allowList = ApiPermission::PREFIX_ALLOW_GROUP_ALBUMS . ':list';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $author = $this->_initAuthor(Tables::$groupAlbumsAccessName, $this->allow, $this->allowAdd, $this->allowEdit, $this->allowDelete, $this->allowList);

        return $author;
    }

    public function validationData()
    {
        $formData = $this->all();
        $reqData = [];

        if ($this->isPutRequest() || $this->isPostRequest()) {
            $reqData['group_name']  = isset($formData['group_name']) ? $formData['group_name'] : null;
            $reqData['status']      = isset($formData['status']) ? $formData['status'] : null;
            $reqData['sort_id']     = isset($formData['sort_id']) ? $formData['sort_id'] : null;
        }

        return $this->_formatToFormArray($reqData);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
