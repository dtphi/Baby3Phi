<?php

/**
 * Init css for Backend.
 */

namespace App\ViewDatas;

use Request;

class BaseAdminData
{
  /**
   * all my css filename and path is store in here
   * @var array
   */
  public $css = [];

  /**
   * @var array
   */
  public $cssSetting = [];

  /**
   * CSS constructor.
   */
  public function __construct()
  {
    $request = request();

    $this->pathInfo     = trim($request->getPathInfo(), '/');
    $this->pathPlugin   = asset('vendor/plugins');
    $this->pathAdminCss = asset('vendor/dist/css');

    $this->cssSetting['authentication'] = false;
    if ($request->is('admin/login*')) {
      $this->cssSetting['authentication'] = true;
    }
    list($css, $script, $bodyClass) = $this->init();
    $this->cssSetting['mapCss']    = $css;
    $this->cssSetting['mapScript'] = $script;
    $this->cssSetting['bodyClass'] = $bodyClass;

    $this->cssSetting['pageDir'] = config('app.is_mix') ? mix("js" . config('app.cms.routeServiceProvider.admin.scriptJsBuildDir') . "/b3p-app-admin.js") : asset('js' . config('app.cms.routeServiceProvider.admin.scriptJsBuildDir') . '/b3p-app-admin.js');
  }

  /**
   * @param $path
   * @param $filename
   * @return array
   */
  public function add($path, $filename)
  {
    $path                 = asset($path);
    $this->css[$filename] = $path;

    return $this->css;
  }

  /**
   * remove css
   * @param $filename
   */
  public function remove($filename)
  {
    if (array_key_exists($filename, $this->css)) {
      unset($this->css[$filename]);
    }
  }

  /**
   * print css
   */
  public function printCss()
  {
    $output = '';
    if (count($this->css)) {
      foreach ($this->css as $filename => $path) {
        $output .= "<link rel='stylesheet' href='{$path}/{$filename}'>\n";
      }
    }
    echo $output;
  }

  /**
   * @return array
   */
  public function init()
  {
    $request = request();
    if ($request->is('admin/filemanagers*') || $request->is('adminlocal/filemanagers*')) {
      $scripts     = $this->mapScriptFileManager();
      $scripts     .= "<script src='/vendor/plugins/jquery-ui/jquery-ui.min.js'></script>\n";
      $scripts     .= "<script src='/vendor/javascript/bootstrap/js/bootstrap.min.js'></script>\n";

      return [
        '',
        $scripts,
        ''
      ];
    }

    return [
      '',
      $this->mapScript(),
      ''
    ];
  }

  /**
   * @return string
   */
  public function mapScript()
  {
    $output = '';
    /*<!-- jQuery -->*/
    $output .= "<script src='/vendor/javascript/jquery/jquery-2.1.1.min.js'></script>\n";
    $output .= "    <script src='/vendor/plugins/jquery-ui/jquery-ui.min.js'></script>\n";
    $output .= "    <script src='/vendor/javascript/bootstrap/js/bootstrap.min.js'></script>\n";

    return $output;
  }

  /**
   * @return string
   */
  public function mapCss()
  {
    $output = '';
    /*Font Awesome*/
    $output .= "<link rel='stylesheet' href='/vendor/plugins/fontawesome-free/css/all.min.css'>\n";
    /*Theme style*/
    $output .= "<link rel='stylesheet' href='/vendor/dist/css/adminlte.min.css'>\n";
    /*Google Font: Source Sans Pro*/
    $output .= "<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700' rel='stylesheet'>\n";

    $output .= "<link rel='stylesheet' href='/vendor/dist/css/custom.css'>\n";

    return $output;
  }

  /**
   * @return string
   */
  public function mapScriptFileManager()
  {
    $output = '';
    /*<!-- jQuery and jQuery UI (REQUIRED) -->*/
    $output .= "<script src='/packages/barryvdh/elfinder/jquery-1.11.0/jquery.min.js'></script>\n";
    $output .= "<script src='/packages/barryvdh/elfinder/jqueryui-1.10.4/jquery-ui.min.js'></script>\n";
    /*<!-- elFinder CSS (REQUIRED) -->*/

    /*<!-- elFinder JS (REQUIRED) -->*/
    $output .= "<script src='/packages/barryvdh/elfinder/js/elfinder.min.js'></script>\n";
    $output .= "<script src='/packages/barryvdh/elfinder/js/i18n/elfinder.vi.js'></script>\n";

    return $output;
  }
}
