<?php
namespace App\Http\Traits;

use Exception;

use App\Models\Company;
use App\Models\Location;
use Illuminate\Http\Request;

trait CatalogCompany
{



    /**
     * catalog the companies
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function companies(Request $request)
    {
        try {

            $this->validateScopes(__FUNCTION__);
            $modelClass = $this->model;

            $input = $request->all();

            $validator =  $this->validateByKey($input, __FUNCTION__);

            if (!empty($validator) && $validator->fails()) return $this->sendError('error_validation', $validator->errors()->all(), 422);

            $companies = Company::all();

            $data = [];

            foreach ($companies as $key => $item) {

                $tmp =[];
                $tmp['name'] =  $item->name;
                $tmp['key'] =  $item->key;
                $tmp['status'] =  $item->status;
                $tmp['socket'] =  $item->notifyDomain['name']??null;
                $tmp['socketPort'] =  $item->notifyDomain['port']??null;

                $data [] = $tmp;
            }

            return $this->sendResponse($data, __FUNCTION__);
        } catch (Exception $th) {
            return $this->sendApiException($th, __FUNCTION__);
        }
    }


}
