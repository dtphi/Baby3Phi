<?php

namespace App\Http\Requests;

use App\AppGlobals\ApiPermissionConstants as ApiPermission;
use App\Http\Common\Tables;
use App\Http\Common\BaseRequest;
use Auth;

class AlbumsRequest extends BaseRequest
{
    private $allow = ApiPermission::PREFIX_ALLOW_ALBUMS . ':*';

    private $allowAdd = ApiPermission::PREFIX_ALLOW_ALBUMS . ':add';

    private $allowEdit = ApiPermission::PREFIX_ALLOW_ALBUMS . ':edit';

    private $allowDelete = ApiPermission::PREFIX_ALLOW_ALBUMS . ':delete';

    private $allowList = ApiPermission::PREFIX_ALLOW_ALBUMS . ':list';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $author = $this->_initAuthor(Tables::$albumsAccessName, $this->allow, $this->allowAdd, $this->allowEdit, $this->allowDelete, $this->allowList);

        return $author;
    }

    public function validationData()
    {
        $formData = $this->all();
        $reqData = [];

        if ($this->isPutRequest() || $this->isPostRequest()) {
            $reqData['albums_name']     = isset($formData['albums_name']) ? $formData['albums_name'] : null;
            $reqData['group_albums_id'] = isset($formData['group_albums_id']) ? $formData['group_albums_id'] : null;
            $reqData['status']          = isset($formData['status']) ? $formData['status'] : null;
            $reqData['sort_id']         = isset($formData['sort_id']) ? $formData['sort_id'] : null;
            $reqData['image']           = isset($formData['image']) ? $formData['image'] : null;
            $reqData['albums_images']   = isset($formData['albums_images']) ? $formData['albums_images'] : '';

            if (!empty($reqData['image']) && is_array($reqData['image'])) {

                $reqData['image_type']  = $formData['image']['type'];
                $reqData['image_size']  = $formData['image']['size'];
                $reqData['image_path']  = $formData['image']['path'];
                $reqData['image_thumb'] = $formData['image']['thumb'];
                if ((int)$reqData['image_size'] > 1) {
                    $reqData['image_path']  = '/Image/NewPicture/' . $formData['image']['path'];
                    $reqData['image_thumb'] = $formData['image']['dirname'] . '/' . $formData['image']['filename'] . '_150x150.' . $formData['image']['extension'];
                }

                $reqData['image_timestamp'] = $formData['image']['timestamp'];
                $reqData['image_extension'] = $formData['image']['extension'];
                $reqData['image_filename']  = $formData['image']['filename'];
                $reqData['image_origin']    = null;
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
        return [
            //
        ];
    }
}
