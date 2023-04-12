<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\URL;
use App\Models\PersonalAccessToken;
use Illuminate\Support\Facades\Response;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;

class AppServiceProvider extends ServiceProvider
{
  /**
   * @author : dtphi.
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
    if (config('app.env') !== 'production' && !empty(config('excel'))) {
      $this->__exportRegistry();
    }
  }

  private function __exportRegistry()
  {
    \Maatwebsite\Excel\Writer::macro('setCreator', function (\Maatwebsite\Excel\Writer $writer, string $creator) {
      $writer->getDelegate()->getProperties()->setCreator($creator);
    });
    \Maatwebsite\Excel\Sheet::macro('setOrientation', function (\Maatwebsite\Excel\Sheet $sheet, $orientation) {
        $sheet->getDelegate()->getPageSetup()->setOrientation($orientation);
    });
    \Maatwebsite\Excel\Sheet::macro('styleCells', function (\Maatwebsite\Excel\Sheet $sheet, string $cellRange, array $style) {
      //dd(get_class_methods($sheet->getDelegate()));
      $sheetDelegate = $sheet->getDelegate();
      $sheetDelegate->setCodeName('Log');
      //dd(get_class_methods($sheetDelegate->getDefaultColumnDimension()));
      $sheetDelegate->getDefaultRowDimension()->setRowHeight(18);
      $sheetDelegate->getDefaultColumnDimension()->setWidth(4);
      $sheetDelegate->getParent()->getDefaultStyle()->getBorders()->applyFromArray([
          'borders' => [
              'allBorders' => [
                  'borderStyle' =>  Border::BORDER_THIN,
                  'color' => ['argb' => Color::COLOR_RED]
              ]
          ]
      ]);
      //dd($sheetDelegate->getHighestRowAndColumn());
      $sheetDelegate->getStyle($cellRange)->applyFromArray($style);
    });
  }

  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot()
  {
    $scheme = (config('app.force_https') == 'http') ? 'http' : 'https';
    URL::forceScheme($scheme);

    /*use when auth bear token, create client_access_tokens table*/
    Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);

    Response::macro('js/appfirebasejs', function ($value) {
      return Response::make(strtoupper($value));
    });
  }
}
