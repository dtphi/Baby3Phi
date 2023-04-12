<?php

namespace App\Repositories\Apis\Fronts;

use App\Contacts\Apis\Fronts\Repositories\EmailSubscribe as EmailSubRepo;
use App\Http\Resources\EmailSubscribes\EmailCollection;
use App\Models\EmailSubscribe;
use App\Http\Common\Tables;
use DB;

final class EmailSubscribeRepository implements EmailSubRepo
{
  private $model = null;


  public function __construct()
  {
    $this->model = new EmailSubscribe();
  }

  public function apiInsert(array $data = [])
  {
    $this->model->fill($data);
    $data['email'];
    $this->model->save();
    return $this->model;
  }
}
