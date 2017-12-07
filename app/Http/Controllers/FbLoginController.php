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
            try {
                $response = $fb->get('/me?fields=id,name', $accessToken);
                //$posts = $fb->get('/me/posts?limit=5', $accessToken);
                $posts = $fb->get('/me?fields=albums.limit(5),posts.limit(5)', $accessToken);
            } catch(\Facebook\Exceptions\FacebookResponseException $e) {
                echo 'Graph returned an error: ' . $e->getMessage();
                exit;
            } catch(\Facebook\Exceptions\FacebookSDKException $e) {
                echo 'Facebook SDK returned an error: ' . $e->getMessage();
                exit;
            }
            $user = $response->getGraphUser();

            var_dump($posts);

            $feedEdges = $posts->getGraphEdge();
            $i = 0;
            $post = [];
            foreach ($feedEdges as $feedEdge) {
                try {
                    $postResponse = $fb->get(
                        '/'.$feedEdge['id'].'',
                        $accessToken
                    );
                } catch(\Facebook\Exceptions\FacebookResponseException $e) {
                    echo 'Graph returned an error: ' . $e->getMessage();
                    exit;
                } catch(\Facebook\Exceptions\FacebookSDKException $e) {
                    echo 'Facebook SDK returned an error: ' . $e->getMessage();
                    exit;
                }
                $postGraphNode = $postResponse->getGraphNode();
                $post[$i]['id'] = $postGraphNode->getField('id');
                $post[$i]['created_time'] = $postGraphNode->getField('created_time');
                $post[$i]['caption'] = $postGraphNode->getField('caption');
                $post[$i]['description'] = $postGraphNode->getField('description');
                $i++;
            }


            return view('fbposts', ['userName' => $user->getName(), 'userPosts' => $post]);
        }


    }
}