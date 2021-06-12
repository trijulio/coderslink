<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Validator;
use GuzzleHttp\Exception\ConnectException;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //Snippet to return error message
    private function returnError($message){
        return response()->json([
            'status' => 'error',
            'error'  => $message
        ], 200);
    }

    //Return HTML View
    public function index(Request $request){
        return view('index');
    }

    // Function for the Api Route
    public function upload(Request $request){


        $rules = array(
          'image' => 'required|mimes:jpeg,jpg,png,gif|max:2048'
        );

        $validator = Validator::make($request->only('image'), $rules);

        if ($validator->fails()){
            return $this->returnError($validator->errors()->first());
        }

        //PREPARE API CALL
        //CONVERT TO BASE64
        //MAKE CALL
        //CONFIRM RESPONSE
        //RETRIEVE RESPONSE URL
        //
        //IN CASE OF ERROR RETURN ERROR MESSAGE
        try {

            $client = new \GuzzleHttp\Client();
            $image  = base64_encode(file_get_contents($request->file('image')->path()));

            //send request
            $response = $client->post("https://test.rxflodev.com",[
                'form_params' => [
                    'imageData' => $image
                ]
            ]);

            //formate response
            $resp = json_decode($response->getBody()->getContents(),true);

            //Check if the response has an error
            if(Arr::get($resp,'status') == 'error' && Arr::has($resp,'message')){
                return $this->returnError(Arr::get($resp,'message'));
            }

            //Confirm the response as expected
            if(Arr::get($resp,'status') == 'success' && Arr::has($resp,'url')){

                return response()->json([
                    'status' => 'success',
                    'data' => [
                        'image' => Arr::get($resp,'url')
                    ]
                ]);

            } else {
                return $this->returnError('Unexpected Response');
            }

        } catch (Exception | ServerException | ConnectException $e ) {
            return $this->returnError($e->getMessage());
        }
    }
}
