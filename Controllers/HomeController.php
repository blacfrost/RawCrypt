<?php

class HomeController extends BaseController {

	public function GET_index()
	{
        $theme = Theme::uses('notebook')->layout('landing');
        $theme->setMenu('home.index');

        $theme->asset()->usePath()->add('landing', 'css/landing.css');

        $theme->asset()->container('post-scripts')->usePath()->add('laravel1', 'js/app.plugin.js');
        $theme->asset()->container('post-scripts')->usePath()->add('laravel2', 'js/scroll/smoothscroll.js');
        $theme->asset()->container('post-scripts')->usePath()->add('laravel3', 'js/landing.js');
        $theme->asset()->container('post-scripts')->usePath()->add('laravel4', 'js/jquery.base64.min.js');

        $site_content = DB::table('site_content')
            ->where('type','=','side_info')
            ->orderBy('id')
            ->get();

        $params = array("site_contents"=>$site_content);
        return $theme->scope('home.encrypt', $params)->render();
	}

    public function GET_how_to()
	{
        $theme = Theme::uses('notebook')->layout('landing');
        $theme->setMenu('home.index');

        $theme->asset()->usePath()->add('landing', 'css/landing.css');

        $theme->asset()->container('post-scripts')->usePath()->add('laravel1', 'js/app.plugin.js');
        $theme->asset()->container('post-scripts')->usePath()->add('laravel2', 'js/scroll/smoothscroll.js');
        $theme->asset()->container('post-scripts')->usePath()->add('laravel3', 'js/landing.js');
        $theme->asset()->container('post-scripts')->usePath()->add('laravel4', 'js/jquery.base64.min.js');

        $how_tos = DB::table('site_content')
            ->where('type','=','how-to')
            ->orderBy('id')
            ->get();

        $snippets = DB::table('site_content')
            ->where('type','=','side_info')
            ->orderBy('id')
            ->get();

        $params = array("how_tos"=>$how_tos, "snippets"=>$snippets);
        return $theme->scope('home.instructions', $params)->render();
	}


    public function send(Request $request)
    {
        //https://scotch.io/tutorials/ultimate-guide-on-sending-email-in-laravel
        $title = $request->input('title');
        $content = $request->input('content');

        Mail::send('emails.send', ['title' => $title, 'content' => $content], function ($message)
        {

            $message->from('me@gmail.com', 'Christian Nwamba');

            $message->to('chrisn@scotch.io');

        });


        return response()->json(['message' => 'Request completed']);
    }


    public function GET_encrypt()
    {
        $theme = Theme::uses('notebook')->layout('landing');
        $theme->setMenu('home.index');

        $theme->asset()->usePath()->add('landing', 'css/landing.css');

        $theme->asset()->container('post-scripts')->usePath()->add('laravel1', 'js/app.plugin.js');
        $theme->asset()->container('post-scripts')->usePath()->add('laravel2', 'js/scroll/smoothscroll.js');
        $theme->asset()->container('post-scripts')->usePath()->add('laravel3', 'js/landing.js');
        $theme->asset()->container('post-scripts')->usePath()->add('laravel4', 'js/jquery.base64.min.js');

        $site_content = DB::table('site_content')
            ->where('type','=','tidbit')
            ->orderBy('id')
            ->get();

        $params = array("site_contents"=>$site_content);
        return $theme->scope('home.index', $params)->render();
    }

    public function POST_encrypt_it()
    {
        $encrypted_content[]=null;
        $email[]=null;
        $message[]=null;
        $time = time();
        $passkey = $_POST['pk'];
        $content = $_POST['content'];
        //$email = $_POST['email'];
        $url = substr(md5($time + (rand(8,15))), -8);

        if(($content == TRUE) && ($passkey == TRUE)){

            $method = "AES-256-CBC";
            $key = hash('sha256', $passkey, true);
            $iv = openssl_random_pseudo_bytes(16);

            $ciphertext = openssl_encrypt($content, $method, $key, OPENSSL_RAW_DATA, $iv);
            $hash = hash_hmac('sha256', $ciphertext, $key, true);

            $encrypted_content = base64_encode($iv . $hash . $ciphertext);

            DB::table('encrypted')->insert(
                ['url_link' => $url, 'content' => $encrypted_content, 'access_count' => 0]
            );

        } else {
            $encrypted_content = 'ERROR: Incomplete Data. Please Resubmit.';
        }

        //$content = array($encrypted_content,$url);


        $params = array($encrypted_content,$url);
        return json_encode($params);

    }

    public function GET_decrypt($url){

        $theme = Theme::uses('notebook')->layout('landing');
        $theme->setMenu('home.index');

        $theme->asset()->usePath()->add('landing', 'css/landing.css');

        $theme->asset()->container('post-scripts')->usePath()->add('laravel1', 'js/app.plugin.js');
        $theme->asset()->container('post-scripts')->usePath()->add('laravel2', 'js/scroll/smoothscroll.js');
        $theme->asset()->container('post-scripts')->usePath()->add('laravel3', 'js/landing.js');
        $theme->asset()->container('post-scripts')->usePath()->add('laravel4', 'js/jquery.base64.min.js');

        $site_content = DB::table('site_content')
            ->orderBy('id')
            ->get();

        $params = array("site_contents"=>$site_content, "url"=>$url);
        return $theme->scope('home.decrypt', $params)->render();
    }

    public function POST_decrypt_it()
    {
        // http://files.aw20.net/jquery-linedtextarea/jquery-linedtextarea.html

        $url = $_POST['data_url'];
        $passkey = $_POST['pk'];

        if(($passkey == TRUE) && ($url == TRUE)){

            $query = DB::table('encrypted')
                ->select('content', 'TIMESTAMP')
                ->where('url_link','=', $url)
                ->first();

            $encoded_content = $query->content;
            $timestamp = $query->TIMESTAMP;

            $method = "AES-256-CBC";
            $decoded = base64_decode($encoded_content);
            $iv = substr($decoded, 0, 16);
            $hash = substr($decoded, 16, 32);
            $ciphertext = substr($decoded, 48);
            $key = hash('sha256', $passkey, true);

            if (hash_hmac('sha256', $ciphertext, $key, true) !== $hash)
            {
                $decrypted_data = 'ERROR: No Data Found. Please check URL & Passkey.';

            } else {
                //https://laravel.com/docs/5.0/queries#updates
                DB::table('encrypted')->where('url_link', '=', $url)->increment('access_count'); // increments the accessed count by one upon being accessed.
                $decrypted_data = openssl_decrypt($ciphertext, $method, $key, OPENSSL_RAW_DATA, $iv);
            }

        } else {
            $decrypted_data = 'ERROR: Incomplete Data. Please Resubmit.';
        }


        $params = array($decrypted_data,$timestamp);
        return json_encode($params);

    }



}
