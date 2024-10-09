<?php

/**
 * Check if pagination is available for the given data.
 *
 * @param mixed $data The data to check for pagination.
 * @return bool
 */
if (!function_exists('HasPagination')) {
    function HasPagination($data)
    {
        try {
            return $data->total() >= 0;
        } catch (\Throwable $th) {
            return  false;
        }
    }
}

/**
 * Handle the API response based on the input data.
 *
 * @param mixed $input The input data.
 * @return array The handled API response.
 */
if (!function_exists('handleApiResponse')) {
    function handleApiResponse($input)
    {
        return is_array($input) ? successResponse($input) : failMessageResponse($input);
    }
}

/**
 * Returns a success response array.
 *
 * @param mixed $data The response data.
 * @return \Illuminate\Http\Response
 */
if (!function_exists('successResponse')) {
    function successResponse($data, $message = null)
    {
        $response = [
            'success'       => true,
            'data'          => $data,
            'pagination' => HasPagination($data) ? [
                'total' => $data->total(),
                'per_page' => $data->perPage(),
                'current_page' => $data->currentPage(),
                'last_page' => $data->lastPage(),
            ] : null
        ];
        if ($message)
            $response['message'] =  $message;
        return response($response, 200);
    }
}

/**
 * Returns a success response message.
 *
 * @param mixed $message The message to be included in the response.
 * @return \Illuminate\Http\Response
 */
if (!function_exists('successMessageResponse')) {
    function successMessageResponse($message, $data = null)
    {
        $response = [
            'success' => true,
            'message' => $message
        ];
        if ($data)  $response['data'] =  $data;
        return response($response, 200);
    }
}

/**
 * Returns a failure response message.
 *
 * @param mixed $message The message to be included in the response.
 * @return \Illuminate\Http\Response
 */
if (!function_exists('failMessageResponse')) {
    function failMessageResponse($message, $data = null)
    {
        $response = [
            'success' => false,
            'message' => $message
        ];
        if ($data)  $response['data'] =  $data;
        return response($response, 400);
    }
}

/**
 * Returns a not found response message.
 *
 * @param mixed $message The message to be included in the response.
 * @return \Illuminate\Http\Response
 */
if (!function_exists('notFoundMessageResponse')) {
    function notFoundMessageResponse($message)
    {
        return response([
            'success' => false,
            'message' => $message
        ], 404);
    }
}

/**
 * Returns a response indicating not being logged in.
 *
 * @param mixed $message The message to be included in the response.
 * @return \Illuminate\Http\Response
 */
if (!function_exists('notLoggedResponse')) {
    function notLoggedResponse($message)
    {
        return response([
            'success' => false,
            'message' => $message
        ], 403);
    }
}
