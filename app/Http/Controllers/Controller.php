<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * @OA\Info(
     *      version="1.0.0",
     *      title=" OpenApi Documentation",
     *      description="L5 Swagger description",
     *      @OA\Contact(
     *          email="admin@admin.com"
     *      ),
     *      @OA\License(
     *          name="Apache 2.0",
     *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
     *      )
     * )
     *
     *
     * @OA\Server(
     *      url="https://gci-db.com/api/",
     *      description="Demo API Server"
     * )

     *
     * @OA\Tag(
     *     name="Data Release",
     *     description="API Endpoints of Projects"
     * )
     */

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    function __construct()
    {
        $static_values = config('constants');
        foreach ($static_values as $key => $value) {
            $this->{$key} = $value;
            if (!is_array($value)) {
                $this->{$key} = strtolower($value);
            }
        }
    }

    function pre($data, $shouldDie = false)
    {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        if ($shouldDie) {
            die;
        }
    }

    function returnAjaxData($data, $count)
    {
        return array(
            'page' => $data['pagination']['page'] ?? 1,
            'pages' => $data['pagination']['pages'] ?? 1,
            'perpage' => $data['pagination']['perpage'] ?? 10,
            'total' => $count,
            'sort' => $data['sort']['sort'] ?? 'asc',
            'field' => $data['sort']['field'] ?? '_id',
        );
    }

    /**
     * Prepare response for api in json.
     *
     * @param  boolean $status
     * @param  \Illuminate\Database\Eloquent\Collection|array $data
     * @param string $msg
     * @param mixed $errors
     * @param mixed $extra
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    protected function jsonResponse($status, $data = null, $msg, $errors = null, $extra = null)
    {
        return ['status' => $status, 'data' => $data, 'message' => $msg, 'errors' => $errors, 'extra' => $extra];
    }

}
