<?php

namespace App\Http\Controllers\API\v01;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

use App\Models\DeviceCode;

class DeviceCodeApiController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request): Response
    {
        $request->validate([
            'android_id' => [
                'bail',
                'required',
                'min:16',
                'max:16',
            ]
        ]);
        $androidId = $request->get('android_id');
        $deviceModelId=$request->get('device_model_id');
        $appVersion=$request->get('app_version');

        $deviceCodes = new DeviceCode();
        $deviceCode = DB::table($deviceCodes->getTable())
            ->where('android_id', '=', $androidId);
        if (!$deviceCode->exists()) {
            $deviceCodeId = DB::table($deviceCodes->getTable())->insertGetId([
                'android_id' => $androidId,
                'device_model_id' => $deviceModelId,
                'app_version'=>$appVersion
            ]);
            $code = DB::table($deviceCodes->getTable())
                ->where('id', '=', $deviceCodeId)
                ->value('device_code');
            return response([
                'device_code_id' => $deviceCodeId,
                'device_code' => $code
            ], 201);
        }
        return response([
            'device_code_id' => $deviceCode->value('id'),
            'device_code' => $deviceCode->value('device_code')
        ], 200);
    }

}
