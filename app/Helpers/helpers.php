<?php

use App\AppGlobals\ApiPermissionConstants as ApiPermission;
use App\Models\Setting;
use Illuminate\Support\Str;
use Illuminate\Http\Response;

if (!function_exists('fn_is_prod_env')) {
    /**
     * @return boolean|mixed
     */
    function fn_is_prod_env()
    {
        return (config('app.env') === B3P_PRODUCTION_ENV) ?? false;
    }
}

if (!function_exists('fn_is_stg_env')) {
    /**
     * @return boolean|mixed
     */
    function fn_is_stg_env()
    {
        return (config('app.env') === 'stg') ?? false;
    }
}

if (!function_exists('fn_is_internal_admin_login')) {
    /**
     * @return boolean|mixed
     */
    function fn_is_internal_admin_login()
    {
        $request = request();
        return ($request->is(B3P_ADMIN_LOGIN_PATH) || $request->is(B3P_ADMIN_PREFIX));
    }
}

if (!function_exists('fn_mysql_escape')) {
    /**
     * @param $inp
     * @return array|mixed
     */
    function fn_mysql_escape($inp)
    {
        if (is_array($inp)) {
            return array_map(__METHOD__, $inp);
        }

        if (!empty($inp) && is_string($inp)) {
            return str_replace(
                array('\\', "\0", "\n", "\r", "'", '"', "\x1a"),
                array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'),
                $inp
            );
        }

        return $inp;
    }
}

if (!function_exists('fn_is_admin_permission')) {
    /**
     * @return bool
     */
    function fn_is_admin_permission()
    {
        $admin        = \Illuminate\Support\Facades\Auth::user();
        $isPermission = false;

        if (fn_is_admin_token_permission($admin->tokens())) {
            $isPermission = true;
        }

        return $isPermission;
    }
}

if (!function_exists('fn_is_update_permission')) {
    /**
     * @param $uId
     * @return bool
     */
    function fn_is_update_permission($uId)
    {
        $user         = \App\Models\Admin::find($uId);
        $isPermission = true;

        if (fn_is_admin_token_permission($user->tokens())) {
            $isPermission = false;
        }

        return $isPermission;
    }
}

if (!function_exists('fn_is_admin_token_permission')) {
    /**
     * @param $tokens
     * @return bool
     */
    function fn_is_admin_token_permission($tokens)
    {
        $adminToken = false;

        if ($tokens) {
            $permissions = $tokens->getResults();
            //test
            if (isset($permissions[0]) && $permissions[0]->tokenable_id == 9) {
                return true;
            }
            if ($permissions->count() == 1) {
                if (($permissions[0]->name == 'allow.all')
                    && (count($permissions[0]->abilities) == 1)
                    && (in_array('*', $permissions[0]->abilities))
                ) {
                    $adminToken = true;
                }
            }
        }

        return $adminToken;
    }
}

if (!function_exists('fn_is_user_rule_permission')) {
    /**
     * @param $ruleSelects
     * @param $permission
     * @return mixed
     */
    function fn_is_user_rule_permission(&$ruleSelects, $permission)
    {
        $keyNameIgnore = trim(Str::replace(ApiPermission::PREFIX_ACCESS_NAME, ' ', $permission->name));
        $keyName       = Str::replace('.', '_', $keyNameIgnore);
        $abilities     = $permission->abilities;
        foreach ($abilities as $ability) {
            $action = trim(Str::replace($keyNameIgnore . ':', ' ', $ability));

            if ($action == '*') {
                if (array_key_exists($keyName, $ruleSelects)) {
                    $ruleSelects[$keyName]['all']                 = true;
                    $ruleSelects[$keyName]['abilities']['list']   = true;
                    $ruleSelects[$keyName]['abilities']['add']    = true;
                    $ruleSelects[$keyName]['abilities']['edit']   = true;
                    $ruleSelects[$keyName]['abilities']['delete'] = true;
                }
            } else {
                if (array_key_exists($action, $ruleSelects[$keyName]['abilities'])) {
                    $ruleSelects[$keyName]['abilities'][$action] = true;
                }
            }
        }

        return $ruleSelects;
    }
}

if (!function_exists('fn_get_user_rule')) {
    function fn_get_user_rule(&$user)
    {
        $user->isAdmin = fn_is_admin_permission();
        if (!$user->isAdmin) {
            $setting = new Setting();
            $result = $setting->filterCode(ApiPermission::RULE_SETTING_CODE)
                ->filterKey(ApiPermission::RULE_SETTING_KEY_DATA)->first();
            $ruleSelects = unserialize($result->value);

            $res = $user->tokens()->getResults();
            if ($res) {
                foreach ($res as $permission) {
                    fn_is_user_rule_permission($ruleSelects, $permission);
                }
                $user->ruleSelect = serialize($ruleSelects);
            }
        }
    }
}


function fn_success_response(array $data = [], int $status = Response::HTTP_OK)
{
    $response = [
        'success' => true,
        'status'  => $status,
        'data'    => $data
    ];

    return response()->json($response);
}

function   fn_error_response(array $errors = [], int $status = Response::HTTP_NOT_FOUND)
{
    $response = [
        'success' => false,
        'status'  => $status,
        'errors'  => $errors
    ];

    return response()->json($response);
}
