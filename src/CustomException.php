<?php
/**
 * Google Natural Language API Exception
 *
 * @category Exception
 * @package  GoogleNaturalLanguagePhp
 * @author   Darryn Ten <darrynten@github.com>
 * @license  MIT <https://github.com/darrynten/google-natural-language-php/LICENSE>
 * @link     https://github.com/darrynten/google-natural-language-php
 */

namespace DarrynTen\GoogleNaturalLanguagePhp;

use \Exception;

/**
 * Custom exception for GoogleNaturalLanguage Client
 *
 * @package GoogleNaturalLanguagePhp
 */
class CustomException extends Exception
{

    /**
     * @inheritdoc
     *
     * @param string    $message  The message to throw
     * @param integer   $code     The error code to throw
     * @param Exception $previous The previous exception
     */
    public function __construct($message = "", $code = 0, Exception $previous = null)
    {
        // Construct message from JSON if required.
        if (preg_match('/^[\[\{]\"/', $message)) {
            $messageObject = json_decode($message);
            $message = sprintf(
                '%s: %s - %s',
                $messageObject->status,
                $messageObject->title,
                $messageObject->detail
            );
            if (!empty($messageObject->errors)) {
                $message .= ' ' . serialize($messageObject->errors);
            }
        }

        parent::__construct($message, $code, $previous);
    }
}
