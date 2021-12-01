<?php
namespace Modules\Business\Traits;


trait ApiResponseHandler
{
    
    /**
     * Sends a success response
     *
     * @param  array $response
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendSuccessResponse(array $response)
    {
        return response()->json(
            [
                'status'=> $response['status'], 
                'message'=> $response['message'], 
                'data'=> $response['data']?? [],
            ], $response['httpcode'] ?? 200
        );
    }


     /**
     * Sends a validation exception
     *
     * @param  \Exception $exception
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendValidationException($exception)
    {
        return response()->json(
            [
                'status'=> false, 
                'message'=> $exception->errors()->first(), 
                'errors'=> $exception->errors()->toArray(),
                'data'=> $response['data']?? [],
            ], $response['httpcode'] ?? 422
        );
    }


      /**
     * Sends a generic exception
     *
     * @param  \Exception $exception
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendGenericException(\Exception $exception)
    {
        return response()->json(
            [
                'status'=> false, 
                'message'=> $exception->getMessage(), 
                'data'=> $response['data']?? [],
            ], $response['httpcode'] ?? 500
        );
    }
}