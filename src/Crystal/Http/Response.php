<?php

namespace Crystal\Http;

class Response{

    // this list is provided by symfony
	private static $httpcodes_default_response = [
		100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing',
        103 => 'Early Hints',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        207 => 'Multi-Status',
        208 => 'Already Reported',
        226 => 'IM Used',
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        307 => 'Temporary Redirect',
        308 => 'Permanent Redirect',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Payload Too Large',
        414 => 'URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Range Not Satisfiable',
        417 => 'Expectation Failed',
        418 => 'I\'m a teapot',
        419 => 'Page Expired',
        421 => 'Misdirected Request',
        422 => 'Unprocessable Entity',
        423 => 'Locked',
        424 => 'Failed Dependency',
        425 => 'Too Early',
        426 => 'Upgrade Required',
        428 => 'Precondition Required',
        429 => 'Too Many Requests',
        431 => 'Request Header Fields Too Large',
        451 => 'Unavailable For Legal Reasons',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
        506 => 'Variant Also Negotiates',
        507 => 'Insufficient Storage',
        508 => 'Loop Detected',
        510 => 'Not Extended',
        511 => 'Network Authentication Required',
	];

    private static $forbiden_uris = [
        '/.htaccess',
    ];



	public static function make($content , $code=200){
		http_response_code($code);
		return $content;
	}

	public static function view($view , $code=200){
		http_response_code($code);
		return view($view);
	}


	public static function httpcode($code){
		http_response_code($code);
		$msg = $code . ' | ' . static::$httpcodes_default_response[$code];
		$res = "
		<style>
		body{
			margin: 0;
			padding: 0;
		}
		</style>
		<center style='height: 100%; width: 100%; background-color: rgb(200,200,210); box-sizing: border-box;'><div style='padding-top: 20%;'>{$msg}</div></center>
		";
		
                if( ! \Crystal\View\View::system_view($code , ['message' => $msg])){
                    return $res;
                }

                return '';

	}


	public static function download($path , $file_client_name=null){
		if($file_client_name == null){
			$file_client_name = basename($path);
		}
		return static::file($path , $file_client_name);
	}





	public static function file($path , $file_client_name=null){
		$type = mime_content_type($path);
		header('Content-type: ' . $type);
		if($file_client_name != null){
			header("Content-Disposition: attachment; filename=" . $file_client_name);
		}
		readfile($path);
		return;
	}





    public static function handle_file_request(){
        $path = $_SERVER['DOCUMENT_ROOT'] . $_SERVER['REQUEST_URI'];

        $uri = $_SERVER['REQUEST_URI'];
        if($uri == ''){
            $uri = '/';
        }

        $forbiden_uris = \Crystal\App\app::get_config('forbiden_uris');


        $tmb_bool = in_array($uri , static::$forbiden_uris) || in_array($uri , $forbiden_uris);
        if($tmb_bool){
            die(static::httpcode(403));
            return false;
        }

        if(is_file($path)){
            return true;
        }

        return false;
    }

}
