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
    'en'
  ];

  /**
   * Load language rules.
   *
   * @param  string  $language default 'en'
   */
  protected static function loadRules($language='en'){

    // Check input
    if(!empty($language) && in_array($language, self::$language))

      // Save the language rules
      self::$language = require __dir__."/../language/{$language}.php";
  }

  /**
   * Checks if validation has passed.
   *
   * @param  string  $language default 'en'
   *
   * @return bool
   */
  public static function setLanguage($language='en'){

    // Default return value saver
    $return = false;

    // Check if not empty and available.
    if(empty($language) || !in_array($language, self::$language)){

      // Fallback language
      $language = 'en';

      // Setting the success return bool
      $return = true;
    }

    // Load language rules
    self::loadRules($language);

    // Bool return
    return $return;
  }
}
