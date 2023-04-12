<?php

namespace App\Contacts\Apis\Admins\Repositories;

interface RestrictIp
{
  public function apiGetRestrictIps($data = array(), $limit = 5);

   public function apiGetDetail($id = null);

  public function apiUpdate($model, $data = []);

	public function apiDelete($model);
}
