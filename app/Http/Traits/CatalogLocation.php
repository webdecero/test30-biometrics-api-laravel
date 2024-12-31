<?php
namespace App\Http\Traits;

use App\Models\Group;
use Exception;

use App\Models\Location;
use Illuminate\Http\Request;

trait CatalogLocation
{

    public function locations(Request $request)
    {
        try {

            $this->validateScopes(__FUNCTION__);

            $input = $request->all();

            $validator =  $this->validateByKey($input, __FUNCTION__);

            if (!empty($validator) && $validator->fails()) return $this->sendError('error_validation', $validator->errors()->all(), 422);

            $locations = Location::all();

            $data = [];

            foreach ($locations as $key => $item) {

                $tmp =[];
                $tmp['name'] =  $item->name;
                $tmp['key'] =  $item->key;
                $tmp['status'] =  $item->status;

                $data [] = $tmp;
            }

            return $this->sendResponse($data, __FUNCTION__);
        } catch (Exception $th) {
            return $this->sendApiException($th, __FUNCTION__);
        }
    }

    public function groups(Request $request)
    {
        try {

            $this->validateScopes(__FUNCTION__);

            $input = $request->all();

            $validator =  $this->validateByKey($input, __FUNCTION__);

            if (!empty($validator) && $validator->fails()) return $this->sendError('error_validation', $validator->errors()->all(), 422);

            $groups = Group::all();

            $data = [];

            foreach ($groups as $key => $item) {

                $tmp =[];
                $tmp['name'] =  $item->title;
                $tmp['key'] =  $item->key;
                $tmp['status'] =  $item->status;

                $data [] = $tmp;
            }

            return $this->sendResponse($data, __FUNCTION__);
        } catch (Exception $th) {
            return $this->sendApiException($th, __FUNCTION__);
        }
    }
}
