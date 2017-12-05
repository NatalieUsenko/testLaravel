<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class FbLoginController extends Controller
{
    /**
     * Показать профиль данного пользователя.
     *
     * @return Response
     */
    public function __invoke()
    {
        $fb = new \Facebook\Facebook([
            'app_id' => '544198599279163',
            'app_secret' => 'c0bd5261a1796f7fe63dcaf8ec703ee5',
            'default_graph_version' => 'v2.2',
        ]);

        $helper = $fb->getJavaScriptHelper();

        try {
            $accessToken = $helper->getAccessToken();
        } catch(\Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            return view('fblogin');
        } catch(\Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            return view('fblogin');
        }

        if (! isset($accessToken)) {
            return view('fblogin');
        } else {
            $_SESSION['fb_access_token'] = (string) $accessToken;
            return view('fbposts');
        }


    }
}