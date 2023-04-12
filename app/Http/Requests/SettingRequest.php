<?php

namespace App\Http\Requests;

use App\AppGlobals\ApiPermissionConstants as ApiPermission;
use App\Http\Common\Tables;
use App\Http\Common\BaseRequest;

class SettingRequest extends BaseRequest
{
    private $allow = ApiPermission::PREFIX_SETTING . ':*';

    private $allowAdd = ApiPermission::PREFIX_SETTING . ':add';

    private $allowEdit = ApiPermission::PREFIX_SETTING . ':edit';

    private $allowDelete = ApiPermission::PREFIX_SETTING . ':delete';

    private $allowList = ApiPermission::PREFIX_SETTING . ':list';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $author = $this->_initAuthor(Tables::$settingAccessName, $this->allow, $this->allowAdd, $this->allowEdit, $this->allowDelete, $this->allowList);

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
            $reqData['settings'] = [];
            $reqData['code']     = isset($formData['code']) ? $formData['code'] : '';
            $reqData['keys']     = isset($formData['keys']) ? $formData['keys'] : [];

            if (!empty($reqData['keys']) && is_array($formData['keys'])) {
                foreach ($reqData['keys'] as $setting) {
                    $serialized = ($setting['serialize']) ? 1 : 0;
                    $value      = ($serialized) ? serialize($setting['value']) : $setting['value'];

                    $reqData['settings'][] = [
                        'key'        => $setting['key'],
                        'serialized' => $serialized,
                        'value'      => $value
                    ];
                }
            }
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
        if ($this->isMethod('get')) {
            return [];
        }

        return [
            'code'     => 'required|min:5|max:128',
            'settings' => 'required'
        ];
    }
}
