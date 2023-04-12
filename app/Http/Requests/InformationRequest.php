<?php

namespace App\Http\Requests;

use Auth;
use App\AppGlobals\ApiPermissionConstants as ApiPermission;
use App\Http\Common\Tables;
use App\Http\Common\BaseRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class InformationRequest extends BaseRequest
{
    private $allow = ApiPermission::PREFIX_ALLOW_TIN_TUC . ':*';

    private $allowAdd = ApiPermission::PREFIX_ALLOW_TIN_TUC . ':add';

    private $allowEdit = ApiPermission::PREFIX_ALLOW_TIN_TUC . ':edit';

    private $allowDelete = ApiPermission::PREFIX_ALLOW_TIN_TUC . ':delete';

    private $allowList = ApiPermission::PREFIX_ALLOW_TIN_TUC . ':list';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $author = $this->_initAuthor(Tables::$tinTucAccessName, $this->allow, $this->allowAdd, $this->allowEdit, $this->allowDelete, $this->allowList);

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

            /*informations*/
            $reqData['image'] = isset($formData['image']) ? $formData['image'] : '';

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
                $reqData['image']           = null;
            }

            $reqData['date_available']   = isset($formData['date_available']) ? $formData['date_available'] : '';
            if (!empty($reqData['date_available'])) {
                $reqData['date_available'] = new Carbon($formData['date_available']);
            } else {
                $reqData['date_available'] = now();
            }

            $reqData['sort_order']       = isset($formData['sort_order']) ? $formData['sort_order'] : 0;
            $reqData['status']           = isset($formData['status']) ? $formData['status'] : 0;
            $reqData['create_user']      = isset($formData['create_user']) ? $formData['create_user'] : 0;
            $reqData['sort_description'] = isset($formData['sort_description']) ? $formData['sort_description'] : '';
            $reqData['info_type']        = isset($formData['info_type']) ? $formData['info_type'] : 1;

            /*information descriptions*/
            $reqData['name']             = isset($formData['name']) ? $formData['name'] : '';
            $reqData['name_slug']        = Str::slug($formData['name']);
            $reqData['meta_title']       = isset($formData['meta_title']) ? $formData['meta_title'] : '';
            $reqData['description']      = isset($formData['description']) ? $formData['description'] : '';
            $reqData['tag']              = isset($formData['tag']) ? $formData['tag'] : '';
            $reqData['meta_description'] = isset($formData['meta_description']) ? $formData['meta_description'] : '';
            $reqData['meta_keyword']     = isset($formData['meta_keyword']) ? $formData['meta_keyword'] : '';

            /*information images*/
            $reqData['info_images']  = [];
            $reqData['multi_images'] = isset($formData['multi_images']) ? $formData['multi_images'] : '';
            if (!empty($reqData['multi_images'])) {
                foreach ($reqData['multi_images'] as $key => $image) {
                    $reqData['info_images'][] = [
                        'image'      => $image['image'],
                        'sort_order' => $image['sort_order']
                    ];
                }

                $reqData['multi_images'] = null;
            }
            $reqData['album'] = isset($formData['album']) ? $formData['album'] : '';

            /*information relateds*/
            $reqData['relateds'] = isset($formData['relateds']) ? $formData['relateds'] : '';

            /*information categorys*/
            $reqData['categorys'] = isset($formData['categorys']) ? $formData['categorys'] : '';

            /*information downloads*/
            $reqData['downloads'] = isset($formData['downloads']) ? $formData['downloads'] : '';

            /*information carousel*/
            $reqData['special_carousels'] = isset($formData['special_carousels']) ? $formData['special_carousels'] : '';
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

        return [
            'name'       => 'required|max:200',
            'meta_title' => 'required|max:255'
        ];
    }
}
