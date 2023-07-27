<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class FacebookSalesController extends Controller
{
    public function postSalesToFacebook(Request $request)
    {
        $accessToken = config('app.facebook_access_token'); // Access token from .env or configuration

        $client = new Client([
            'base_uri' => 'https://graph.facebook.com/',
        ]);

        // Prepare the sales data as a message to be posted on Facebook
        $message = "New sale: Customer Name - " . $request->customer_name . ", Product Name - " . $request->product_name . ", Quantity - " . $request->quantity . ", Amount - " . $request->amount;

        try {
            // Make a POST request to post the sales data as a Facebook post
            $response = $client->post('me/feed', [
                'query' => ['access_token' => $accessToken],
                'form_params' => ['message' => $message],
            ]);

            // Check if the request was successful (status code 200)
            if ($response->getStatusCode() === 200) {
                // Handle success response
                return response()->json(['message' => 'Sales data posted to Facebook successfully.']);
            } else {
                // Handle other response statuses
                return response()->json(['error' => 'Failed to post sales data to Facebook.'], $response->getStatusCode());
            }
        } catch (\Exception $e) {
            // Handle exceptions, such as network errors, API errors, etc.
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
