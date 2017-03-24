<?php
namespace Violin;

class Language{

  /**
   * Language rules saver.
   *
   * @var array
   */
  protected static $language = [];

  /**
   * Language choose saver.
   *
   * @var string
   */
  protected static $choose = 'en';

  /**
   * Array with available languages.
   *
   * @var array
   */
  protected static $available = [
    'en',
    'nl',
    'sv',
  ];

  /**
   * Load language rules.
   *
   * @param  string  $language default 'en'
   */
  protected static function loadRules($language='en'){

    // Check input
    if(!empty($language) && in_array($language, self::$available))

      // Set the language chooser
      self::$choose = $language;

      // Save the language rules
      self::$language[0][self::$choose] = require __dir__."/../language/{$language}.php";
  }

  /**
   * Set the language
   *
   * @param  string  $language default 'en'
   *
   * @return bool
   */
  public static function setLanguage($language='en'){

    // Default return value saver
    $return = false;

    // Check if not empty and available.
    if(!empty($language) && in_array($language, self::$available)){

      // Setting the success return bool
      $return = true;
    }

    // If language is not availble. Set language to english
    else $language = 'en';

    // Load language rules
    self::loadRules($language);

    // Fallback return bool
    return $return;
  }

  /**
   * Get the error string
   *
   * @param  string  $key default ''
   * @param  interger  $which default 0
   *
   * @return string
   */
  public static function get($key='', $which=0){

    // check if $key is in language saver
    if(isset(self::$language[$which][self::$choose][$key]))

      // return string
      return self::$language[$which][self::$choose][$key];

    // fallback return
    return '';
  }

  /**
   * Set a error string
   *
   * @param  string  $key default ''
   * @param  string/array  $set default ''
   * @param  interger  $which default 0
   */
  public static function set($key='', $set='', $which=0){

    // Check is values are set
    if(empty($key) || empty($set)) return;

    // Check if is not an array
    if(!is_array($set)) $set = array(self::$choose=>$set);

    // Insert rules
    foreach($set as $lang => $string){

      // Save in language saver
      self::$language[$which][$lang][$key] = $string;
    }
  }
}
