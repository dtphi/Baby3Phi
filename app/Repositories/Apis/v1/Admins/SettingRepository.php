<?php

namespace App\Repositories\Apis\Admins;

use App\Contacts\Apis\Admins\Repositories\Setting as SettingRepo;
use App\Contacts\Apis\Admins\Repositories\Base as BaseRepo;
use App\Http\Resources\Admins\AdminResource;
use App\Http\Resources\Settings\SettingCollection;
use App\Models\Setting;
use DB;

final class SettingRepository implements BaseRepo, SettingRepo
{
    /**
     * @var Setting|null
     */
    private $model = null;

    /**
     * @author : dtphi .
     * SettingService constructor.
     */
    public function __construct()
    {
        $this->model = new Setting();
    }

    public function apiGetList(array $options = [], $limit = 15)
    {
        $query = $this->model->where('code', $options['code']);

        if ($limit) {
            $query->limit($limit);
        }

        return $query->get();
    }

    public function apiGetResourceCollection(array $options = [], $limit = 15)
    {
        return new SettingCollection($this->apiGetList($options, $limit));
    }

    public function apiGetDetail($id = null)
    {
        $this->model = $this->model->where('key', $id)->get();

        return $this->model;
    }

    public function apiGetResourceDetail($id = null)
    {
        return new AdminResource($this->apiGetDetail($id));
    }

    public function apiInsertOrUpdate(array $data = [])
    {
        // TODO: Implement apiInsertOrUpdate() method.

        /**
         * Save setting with transaction to make sure all data stored correctly
         */
        DB::beginTransaction();
        try {
            foreach ($data['settings'] as $setting) {
                Setting::updateOrCreate(
                    ['code' => $data['code'], 'key_data' => $setting['key']],
                    [
                        'value'      => $setting['value'],
                        'serialized' => (int)$setting['serialized']
                    ]
                );
            }
        } catch (\Exceptions $e) {

            DB::rollBack();

            return false;
        }

        DB::commit();

        return $data['code'];
    }
}
