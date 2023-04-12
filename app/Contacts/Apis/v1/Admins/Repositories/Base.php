<?php

namespace App\Contacts\Apis\Admins\Repositories;

interface Base
{
    /**
     * @author : dtphi .
     * @param array $options
     * @param int $limit
     * @return mixed
     */
    public function apiGetList(array $options = [], $limit = 15);

    /**
     * @author : dtphi .
     * @param array $options
     * @param int $limit
     * @return mixed
     */
    public function apiGetResourceCollection(array $options = [], $limit = 15);

    /**
     * @author : dtphi .
     * @param null $id
     * @return mixed
     */
    public function apiGetDetail($id = null);

    /**
     * @author : dtphi .
     * @param null $id
     * @return mixed
     */
    public function apiGetResourceDetail($id = null);

    /**
     * @author : dtphi .
     * @param array $data
     * @return mixed
     */
    public function apiInsertOrUpdate(array $data = []);
}
