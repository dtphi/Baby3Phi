<?php

namespace App\Http\Requests;

use App\AppGlobals\ApiPermissionConstants as ApiPermission;
use App\Http\Common\Tables;
use App\Http\Common\BaseRequest;

class RestrictIpRequest extends BaseRequest
{
    private $allow = ApiPermission::PREFIX_ALLOW_RESTRICT_IP . ':*';

    private $allowAdd = ApiPermission::PREFIX_ALLOW_RESTRICT_IP . ':add';

    private $allowEdit = ApiPermission::PREFIX_ALLOW_RESTRICT_IP . ':edit';

    private $allowDelete = ApiPermission::PREFIX_ALLOW_RESTRICT_IP . ':delete';

    private $allowList = ApiPermission::PREFIX_ALLOW_RESTRICT_IP . ':list';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $author = $this->_initAuthor(Tables::$restrictIpAccessName, $this->allow, $this->allowAdd, $this->allowEdit, $this->allowDelete, $this->allowList);

        return $author;
    }

    public function validationData()
    {
        $formData = $this->all();
        $reqData = [];

        if ($this->isPutRequest() || $this->isPostRequest()) {
            $reqData['ip'] = isset($formData['ip']) ? $formData['ip'] : null;
            $reqData['active'] = isset($formData['active']) ? $formData['active'] : null;
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
