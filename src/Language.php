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
   * Array with available languages.
   *
   * @var array
   */
  protected static $available = [
    'en',
    'nl'
  ];

  /**
   * Load language rules.
   *
   * @param  string  $language default 'en'
   */
  protected static function loadRules($language='en'){

    // Check input
    if(!empty($language) && in_array($language, self::$available))

      // Save the language rules
      self::$language = require __dir__."/../language/{$language}.php";
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
    if(!empty($language) && in_array($language, self::$language)){

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
   *
   * @return string
   */
  public static function get($key=''){

    // check if $key is in language saver
    if(isset(self::$language[$key]))

      // return string
      return self::$language[$key];

    // fallback return
    return '';
  }
}
