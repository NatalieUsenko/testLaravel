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
        if (PHP_SESSION_ACTIVE!=session_status()) session_start();
        $fb = new \Facebook\Facebook([
            'app_id' => '544198599279163',
            'app_secret' => 'c0bd5261a1796f7fe63dcaf8ec703ee5',
            'default_graph_version' => 'v2.2',
        ]);

        $helper = $fb->getJavaScriptHelper();

        if (!isset($_SESSION['fb_access_token'])) {
            try {
                $accessToken = $helper->getAccessToken();
                $_SESSION['fb_accessToken'] = $accessToken;
            } catch (\Facebook\Exceptions\FacebookResponseException $e) {
                // When Graph returns an error
                echo '1111Graph returned an error: ' . $e->getMessage();
                return view('fblogin');
            } catch (\Facebook\Exceptions\FacebookSDKException $e) {
                // When validation fails or other local issues
                echo 'Facebook SDK returned an error: ' . $e->getMessage();
                return view('fblogin');
            }
        } else {
            $accessToken = $_SESSION['fb_access_token'];
        }

        if (! isset($accessToken)) {
            return view('fblogin');
        } else {
            $_SESSION['fb_access_token'] = (string) $accessToken;
            try {
                $response = $fb->get('/me?fields=id,name,posts.limit(5){created_time,caption,description,name,permalink_url,picture,shares,likes,story}', $accessToken);
            } catch(\Facebook\Exceptions\FacebookResponseException $e) {
                echo '2222Graph returned an error: ' . $e->getMessage();
                exit;
            } catch(\Facebook\Exceptions\FacebookSDKException $e) {
                echo 'Facebook SDK returned an error: ' . $e->getMessage();
                exit;
            }
            $user = $response->getGraphUser();

            $feedEdges = $user['posts'];
            $posts = [];
            foreach ($feedEdges as $feedEdge) {
                $posts[] = $feedEdge->asArray();
            }

            return view('fbposts', ['userName' => $user->getName(),'userPosts'=>$posts]);
        }


    }
}