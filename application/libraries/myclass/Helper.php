<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Helper
{
  /**
   * Absolute Path
   * @var string
   */
  private static $ABS_PATH = '';

  /**
   * App Name
   * @var string
   */
  public static $APP_NAME = 'Aplikasi Faktur';
  public static $APP_FULLNAME = '';

  /**
   * Token Access
   * @var string
   */
  public static $token = 'CI3_Faktur';

  /**
   * Get and Set Absolute Path
   * @return string
   */
  public static function init_abs_path($absPath = '')
  {
    if(empty(self::$ABS_PATH)) {
      self::$ABS_PATH = empty($absPath)
       ? $_SERVER['DOCUMENT_ROOT']
       : $absPath;
    }

    return self::$ABS_PATH;
  }

  /**
   * File Auto Version
   * @param string $filePath | Example: /assets/css/file.css
   * @return string
   */
  public static function file_version($filePath)
  {
    // if file doesn't exist
    if(! file_exists(self::init_abs_path() . $filePath)) return $filePath;

    $mTime = filemtime(self::init_abs_path() . $filePath);
    return sprintf('%s?v=%d', $filePath, $mTime);
  }

  /**
   * Search array by key
   * @return array | NULL
   */
  public static function search_array($value, $key, $array)
  {
    foreach ($array as $k => $val) {
      $val = (array) $val;
      if($val[ $key ] == $value) return $val;
    }

    return NULL;
  }

  public static function init_dir($path)
  {
    // create dir
    if(! is_dir($path)) {
      mkdir($path, 0777, true);
    }
    // create file index.html
    self::create_file(
      $path."index.html",
      "<!DOCTYPE html><html><head><title>403 Forbidden</title></head><body><p>Directory access is forbidden.</p></body></html>"
    );
  }

  public static function create_file($filePath, $template = '')
  {
    if(file_exists($filePath)) return false;

    $file = fopen($filePath, "w");
    fwrite($file, $template);
    fclose($file);
    return true;
  }

  public static function error_handler($error)
  {
    $errorCode = is_int($error->getCode()) && $error->getCode() != 0 
      ? $error->getCode()
      : 500;

    $CI =& get_instance();
    $CI->output->set_status_header($errorCode);
    echo json_encode(array(
      'message' => $error->getMessage(),
    ));
  }

  public static function send_401_response($message)
  {
    $CI =& get_instance();
    $CI->output->set_status_header(401);
    echo json_encode(array('title' => 'Unauthorize User', 'message' => $message));
    exit;
  }

  public static function send_405_response($message = 'Method not allowed')
  {
    $CI =& get_instance();
    $CI->output->set_status_header(405);
    echo json_encode(array('title' => 'Invalid Method', 'message' => $message));
    exit;
  }

  public static function send_404_response($message, $title = 'Info')
  {
    $CI =& get_instance();
    $CI->output->set_status_header(404);
    echo json_encode(array('title' => $title, 'message' => $message));
    exit;
  }

  public static function send_422_response($error_data)
  {
    $CI =& get_instance();
    $CI->output->set_status_header(422);
    $response['form_errors'] = $error_data;
    echo json_encode($response);
    exit;
  }
}
