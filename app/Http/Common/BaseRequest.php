<?php

/**
 * The Base request class.
 */

namespace App\Http\Common;

use App\AppGlobals\ApiPermissionConstants as ApiPermission;
use App\Exceptions\AccessDeniedCommon;
use Auth;
use Illuminate\Foundation\Http\FormRequest;
use Log;

class BaseRequest extends FormRequest
{
    /**
     * @var string
     */
    private $__listPermission = 'all';

    protected $_filterData = [];

    /**
     * @return mixed
     *
     * Determine if the user is authorized to make this request.
     */
    public function isAllowAll()
    {
        $auth = Auth::user();
        $env = fn_is_prod_env();

        return $env ? $auth->actionCan(ApiPermission::PREFIX_ACCESS_NAME . $this->__listPermission, '*') : true;
    }

    public function isPutRequest()
    {
        return $this->isMethod('PUT');
    }

    public function isPostRequest()
    {
        return $this->isMethod('POST');
    }

    public function isGetRequest()
    {
        return $this->isMethod('GET');
    }

    public function isDeleteRequest()
    {
        return $this->isMethod('DELETE');
    }

    public function isOptionRequest()
    {
        return $this->isMethod('OPTION');
    }

    protected function _initAuthor($accessName, $allow, $allowAdd, $allowEdit, $allowDelete, $allowList)
    {
        $user = Auth::user();
        if ($this->isAllowAll())
            return true;

        if ($this->isMethod('options') || $user->actionCan($accessName, $allow)) {
            return true;
        } elseif ($this->isMethod('post')) {
            return $user->actionCan($accessName, $allowAdd);
        } elseif ($this->isMethod('put')) {
            return $user->actionCan($accessName, $allowEdit);
        } elseif ($this->isMethod('delete')) {
            return $user->actionCan($accessName, $allowDelete);
        } elseif ($this->isMethod('get')) {
            return $user->actionCan($accessName, $allowList);
        }

        return false;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    protected function _isIgnoreProdAuthorize()
    {
        $env = fn_is_prod_env();
        $ignoreAuthor = (bool)config('app.ignore_prod_authorize');

        return $env ? ($ignoreAuthor ? false : true) : true;
    }

    /**
     * @throws AccessDeniedCommon
     */
    protected function failedAuthorization()
    {
        http_response_code(500);
        exit;
    }

    protected function _formatToFormArray(array $reqData = []): array
    {
        $formData = [];
        $uAuth = Auth::user()->id ?? 0;

        if ($this->isMethod('POST')) {
            $this->_filterData['f_user_create']      = $uAuth;
        } elseif ($this->isMethod('POST') || $this->isMethod('PUT')) {
            $this->_filterData['f_update_user']      = $uAuth;
            $this->offsetUnset('update_user');
            $this->offsetUnset('user_create');
        }

        foreach ($reqData as $key => $value) {
            $formData["f_$key"] = $value;
            $this->_filterData[$key] = '';
            $this->offsetUnset($key);
        }

        $this->merge($formData);

        return $this->all();
    }

    public function extractToFormArray(): array
    {
        $formData = $this->all();
        foreach ($this->_filterData as $key => $value) {
            $this->_filterData[$key] = $formData["f_$key"];
        }

        return $this->_filterData;
    }
}
