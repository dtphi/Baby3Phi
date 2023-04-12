<?php

/**
 * The base api controller.
 */

namespace App\Http\Controllers\Apis\Admin\Base;

use App\Contacts\Apis\Admins\Controllers\Base\ApiController as BaseApiController;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\File;
use Illuminate\Http\Response as IlluminateResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Http\FormRequest;
use Image;
use Storage;

class ApiController extends Controller implements BaseApiController
{
    use AuthorizesRequests;

    /**
     * @var int
     *
     * Thumb size default .
     */
    public static $thumSize = 40;

    /**
     * @var string
     */
    public static $tmbThumbDir = '.tmb';

    /**
     * @var string
     *
     * Drive file default.
     */
    public static $disk = 'public';

    protected $requestName = '';

    protected $resourceName = '';

    /**
     * @var int
     */
    protected $statusCode = IlluminateResponse::HTTP_OK;

    /**
     * @var string
     */
    public static $perPageText = 'perPage';

    /**
     * @var null
     */
    protected $resource = null;

    protected $returnCode = RESPONSE_OK;

    /**
     * @author: dtphi .
     * ApiController constructor.
     * @param array $middleware
     */
    public function __construct($middleware = [])
    {
        parent::__construct($middleware);

        $requestAuthor = "\\App\\Http\\Requests\\{$this->requestName}";
        $this->_initAuthor(new $requestAuthor);
    }

    protected function _initAuthor(FormRequest $request)
    {
        return $request;
    }

    /**
     * @param $imgOrigin
     * @param int $thumbSize
     * @param int $thumbHeight
     * @param bool $force
     * @return mixed
     */
    public function getThumbnail($imgOrigin, $thumbSize = 0, $thumbHeight = 0, $force = false)
    {
        $imgThumUrl = '';
        if ($thumbSize <= 0) {
            $thumbSize = self::$thumSize;
        }

        $staticThumImg = rawurldecode(trim($imgOrigin, '/'));
        if (!file_exists(public_path('/' . $staticThumImg))) {
            $staticThumImg = trim(NO_THUMB_IMG, '/');
        }

        if ($force) {
            return $this->forceThumbnail($staticThumImg, $thumbSize, $thumbHeight);
        }

        if ((int)$thumbHeight > 0) {
            $thumbDir = self::$tmbThumbDir . '/thumb_' . $thumbSize . 'x' . $thumbHeight . '/' . $staticThumImg;
            if (file_exists(public_path('/' . 'storage/' . $thumbDir))) {
                return Storage::url($thumbDir);
            }

            return $this->forceThumbnail($staticThumImg, $thumbSize, $thumbHeight);
        } else {
            $thumbDir = self::$tmbThumbDir . '/' . $staticThumImg;
            if (file_exists(public_path('/' . 'storage/' . $thumbDir))) {
                return Storage::url($thumbDir);
            }

            return $this->forceThumbnail($staticThumImg, $thumbSize);
        }
    }

    /**
     * @param $staticThumImg
     * @param int $thumbSize
     * @param int $thumbHeight
     * @return mixed
     */
    public function forceThumbnail($staticThumImg, $thumbSize = 200, $thumbHeight = 0)
    {
        $fileResize = new File(public_path($staticThumImg));
        $extension  = $fileResize->extension();
        $thumbDir   = self::$tmbThumbDir . '/' . $staticThumImg;
        if ((int)$thumbHeight > 0) {
            $thumbDir = self::$tmbThumbDir . '/thumb_' . $thumbSize . 'x' . $thumbHeight . '/' . $staticThumImg;
            $resize   = Image::make($fileResize)->resize($thumbSize, $thumbHeight)->encode($extension);
        } else {
            $resize = Image::make($fileResize)->resize($thumbSize, null, function ($constraint) {
                $constraint->aspectRatio();
            })->encode($extension);
        }

        Storage::disk(self::$disk)->put($thumbDir, $resize->__toString());

        return Storage::url($thumbDir);
    }

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param mixed $statusCode
     *
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * @author : dtphi .
     * @return null
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * @return mixed
     */
    public function getReturnCode()
    {
        return $this->returnCode;
    }

    /**
     * @param mixed $returnCode
     *
     * @return $this
     */
    public function setReturnCode($returnCode)
    {
        $this->returnCode = $returnCode;

        return $this;
    }

    /**
     * @param $data
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    private function respond($data, $headers = [])
    {
        $data['code'] = $this->getReturnCode();

        return response()->json($data, $this->getStatusCode(), $headers);
    }

    /**
     * @param $message
     * @param $newId
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondCreated($message, $newId)
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_CREATED)
            ->setReturnCode(RESPONSE_CREATED)
            ->respond([
                'result' => [
                    'message' => $message,
                    'id'      => $newId,
                ],
            ]);
    }

    /**
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondDeleted($message = 'Deleted')
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_OK)
            ->setReturnCode(RESPONSE_DELETED)
            ->respond([
                'message' => $message,
            ]);
    }

    /**
     * @param string $message
     * @param int $returnCode
     * @param array|null $data | An optional associative array of data to be returned
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondBadRequest(
        $message = 'Invalid request',
        array $data = null
    ) {
        return $this->setStatusCode(IlluminateResponse::HTTP_BAD_REQUEST)
            ->setReturnCode(RESPONSE_BAD_REQUEST)
            ->respondWithError($message, $data);
    }

    /**
     * @author : dtphi .
     * @param null $resource
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondUpdated($resource = null, $message = 'Updated')
    {
        $this->resource = $resource;

        return $this->setStatusCode(IlluminateResponse::HTTP_OK)
            ->setReturnCode(RESPONSE_UPDATED)
            ->respond([
                'message' => $message,
            ]);
    }

    /**
     * @param $data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithData($data)
    {
        return $this->setStatusCode(IlluminateResponse::HTTP_OK)
            ->setReturnCode(RESPONSE_OK)
            ->respond([
                'data' => $data,
            ]);
    }

    /**
     * @author : dtphi .
     * @param $data
     * @return mixed
     */
    public function respondWithCollectionPagination(array $data, $pagination = [], $page = 1, int $code = 0)
    {
        $json = [
            'success' => true,
            'status'  => ($code) ? $code : $this->getStatusCode(),
            'data' => [
                'results'    => $data,
                'pagination' => $pagination,
                'page'       => $page
            ]
        ];

        return $json;
    }

    /**
     * @param string $message
     * @param array|null $data An optional associative array of data to be returned
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithError($message, array $data = null)
    {
        if ($this->getReturnCode() === RESPONSE_OK) {
            // this really should not happen as the
            // return code should be set when responding
            $this->setReturnCode(RESPONSE_SERVER_ERROR);
        }

        $payload = [
            'message'     => $message,
            'status_code' => $this->getStatusCode(),
        ];

        if (is_array($data)) {
            $payload = array_merge($payload, $data);
        }

        return $this->respond([
            'error' => $payload,
        ]);
    }

    /**
     * @author: dtphi .
     * @return int
     */
    protected function _getPerPage()
    {
        return (int)request()->query(self::$perPageText, B3P_ADMIN_LIMIT);
    }

    /**
     * @author : dtphi .
     * @param LengthAwarePaginator $paginator
     * @return array
     */
    protected function _getTextPagination(LengthAwarePaginator $paginator)
    {
        $data = [];

        if ($paginator instanceof LengthAwarePaginator && $paginator->count()) {
            $data = $paginator->toArray();

            unset($data['data']);
        }

        return $data;
    }
}
