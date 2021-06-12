# Backend

- [App\Http\Controllers\Controller@upload](#section-1)
- [App\Http\Controllers\Controller@returnError](#section-2)
- [routes/web.php](#section-3)
- [routes/api.php](#section-4)


Here you can find the main files used to create this project

---

<a name="section-1"></a>
### App\Http\Controllers\Controller@upload
Main controller to receive the image and connect to the external API
```php
public function upload(Request $request){


    $rules = array(
      'image' => 'required|mimes:jpeg,jpg,png,gif|max:10240'
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
```

---
<a name="section-2"></a>
### App\Http\Controllers\Controller@returnError
Small code to return error in the same format everytime
```php
//Snippet to return error message
private function returnError($message){
    return response()->json([
        'status' => 'error',
        'error'  => $message
    ], 200);
}
```

---

<a name="section-3"></a>
### routes/web.php
Frontend route
```php
//Snippet to return error message
Route::get('/', [App\Http\Controllers\Controller::class, 'index'])->name('index');
```

---

<a name="section-4"></a>
### routes/api.php
Backend local API route
```php
//Snippet to return error message
Route::post('/upload', [App\Http\Controllers\Controller::class, 'upload']);
```