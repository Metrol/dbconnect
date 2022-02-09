<?php
/**
 * @author        "Michael Collette" <metrol@metrol.net>
 * @package       Metrol/DBConnect
 * @version       1.0
 * @copyright (c) 2016, Michael Collette
 */

namespace Metrol\DBConnect;

use PDO;

/**
 * Provides some basic management for adding and fetching both PDO and driver
 * specific connection options
 *
 */
trait Options
{
    /**
     * Options that are generic to all PDO database types.
     *
     * @var array
     */
    protected array $options = [];

    /**
     * Allowed generic options for the PDO connection along with their allowed
     * values.  If values are empty, then it's a free form input.
     *
     * @var array
     */
    protected array $allowedOptions = [
        // Force column names to a specific case.
        'columnCase' =>
        [
            'value'   => PDO::ATTR_CASE,
            'options' =>
            [
                'lower'   => PDO::CASE_LOWER,   // Force column names to lower case.
                'natural' => PDO::CASE_NATURAL, // Leave column names as returned by the database driver.
                'upper'   => PDO::CASE_UPPER    // Force column names to upper case.
            ]
        ],

        // Error reporting
        'errorMode' =>
        [
            'value'   => PDO::ATTR_ERRMODE,
            'options' =>
            [
                'silent'    => PDO::ERRMODE_SILENT,   // Just set error codes.
                'warning'   => PDO::ERRMODE_WARNING,  // Raise E_WARNING.
                'exception' => PDO::ERRMODE_EXCEPTION // Throw execeptions.
            ]
        ],

        // Oracle nulls (available with all drivers, not just Oracle):
        // Conversion of NULL and empty strings.
        'nullConversion' =>
        [
            'value' => PDO::ATTR_ORACLE_NULLS,
            'options' =>
            [
                'natural'           => PDO::NULL_NATURAL,      // No conversion.
                'emptyStringToNull' => PDO::NULL_EMPTY_STRING, // Empty string is converted to NULL.
                'nullToString'      => PDO::NULL_TO_STRING     // NULL is converted to an empty string.
            ]
        ],

        // Convert numeric values to strings when fetching.
        'stringify' =>
        [
            'value' => PDO::ATTR_STRINGIFY_FETCHES,
            'options' =>
            [
                'true'  => true,
                'false' => false
            ]
        ],

        // Enables or disables emulation of prepared statements. Some drivers
        // do not support native prepared statements or have limited support
        // for them. Use this setting to force PDO to either always emulate
        // prepared statements (if TRUE), or to try to use native prepared
        // statements (if FALSE). It will always fall back to emulating the
        // prepared statement if the driver cannot successfully prepare the
        // current query.
        'emulatePrepare' =>
        [
            'value' => PDO::ATTR_EMULATE_PREPARES,
            'options' =>
            [
                'true'  => true,
                'false' => false
            ]
        ],

        // Set default fetch mode.
        'fetchMode' => [
            'value' => PDO::ATTR_DEFAULT_FETCH_MODE,
            'options' =>
            [
                // Returns an array indexed by column name as returned in your
                // result set.
                'associated' => PDO::FETCH_ASSOC,

                // (default): Returns an array indexed by both column name and
                // 0-indexed column number returned in your result set
                'both' => PDO::FETCH_BOTH,

                // Returns TRUE and assigns the values of the columns in your
                // result set to the PHP variables to which they were bound with
                // the PDOStatement::bindColumn() method.
                'bound' => PDO::FETCH_BOUND,

                // Returns a new instance of the requested class, mapping the
                // columns of the result set to named properties in the class. If
                // fetch_style includes PDO::FETCH_CLASSTYPE
                // (e.g. PDO::FETCH_CLASS | PDO::FETCH_CLASSTYPE) then the name of
                // the class is determined from a value of the first column.
                'class' => PDO::FETCH_CLASS,

                // Updates an existing instance of the requested class, mapping the
                // columns of the result set to named properties in the class.
                'into' => PDO::FETCH_INTO,

                // Combines PDO::FETCH_BOTH and PDO::FETCH_OBJ, creating the object
                // variable names as they are accessed.
                'lazy' => PDO::FETCH_LAZY,

                // Returns an array with the same form as PDO::FETCH_ASSOC, except
                // that if there are multiple columns with the same name, the value
                // referred to by that key will be an array of all the values in
                // the row that had that column name.
                'named' => PDO::FETCH_NAMED,

                // Returns an array indexed by column number returned in your
                // result set, starting at column 0.
                'numbered' => PDO::FETCH_NUM,

                // Returns an anonymous object with property names that correspond
                // to the column names returned in your result set.
                'object' => PDO::FETCH_OBJ
            ]
        ]
    ];

    /**
     * Database driver specific options
     *
     * @var array
     */
    protected array $driverOptions = [];

    /**
     * Allowed Database specific options.  Needs to be populated by the class
     * implementing this trait.
     *
     * @var array
     */
    protected array $allowedDriverOptions = [];

    /**
     * Set a generic PDO conection option.  Must use the strings defined in the
     * allowedOptions array in this trait.
     *
     * If the option can not be found in the regular allowed options, the
     * request will automatically be passed to the setDriverOption() to see if
     * it will fit there.
     *
     * @param string $option Option to be set
     * @param string $value  Value to assign to that option
     */
    public function setOption(string $option, string $value): static
    {
        if ( $this->validateOption($option, $value) )
        {
            $optionValue = $this->getOptionValue($option);
            $this->options[$optionValue] = $this->allowedOptions[$option]['options'][$value];
        }
        else
        {
            $this->setDriverOption($option, $value);
        }

        return $this;
    }

    /**
     * Provide the options that have been set.
     *
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * Provide the PDO value of an option string
     *
     * @param string $option String in the allowed options array
     */
    private function getOptionValue(string $option): mixed
    {
        $rtn = null;

        if ( isset($this->allowedOptions[$option]) )
        {
            $rtn = $this->allowedOptions[$option]['value'];
        }

        return $rtn;
    }

    /**
     * Checks to see if the option/value pair are valid.
     *
     * @param string $option
     * @param string $value
     *
     * @return boolean
     */
    private function validateOption(string $option, string $value): bool
    {
        $rtn = false;

        if ( isset($this->allowedOptions[$option]) )
        {
            // Only check for allowed options if any are specified
            if ( isset($this->allowedOptions[$option]['options']) )
            {
                if ( array_key_exists($value, $this->allowedOptions[$option]['options'] ) )
                {
                    // Specified allowed options, and the value is in there.
                    $rtn = true;
                }
            }
            else
            {
                // No specified values for the option, so take whatever is
                // passed in.
                $rtn = true;
            }
        }

        return $rtn;
    }

    /**
     * Set a database driver specific conection option.  The option and an
     * allowed value must be set by the specific database connector.
     *
     * @param string $option Option to be set
     * @param mixed  $value  Value to assign to that option
     *
     * @return $this
     */
    public function setDriverOption(string $option, mixed $value): static
    {
        if ( $this->validateDriverOption($option, $value) )
        {
            $optionValue = $this->getOptionDriverValue($option);
            $this->driverOptions[$optionValue] = $value;
        }

        return $this;
    }

    /**
     * Provide the PDO value of an option string for a driver specific option
     *
     * @param string $option String in the allowed options array
     *
     * @return mixed|null The value that needs to be passed to PDO
     */
    private function getOptionDriverValue(string $option): mixed
    {
        $rtn = null;

        if ( isset($this->allowedDriverOptions[$option]) )
        {
            $rtn = $this->allowedDriverOptions[$option]['value'];
        }

        return $rtn;
    }

    /**
     * Checks to see if the option/value pair are valid for a driver specific
     * option.
     *
     * @param string $option
     * @param string $value
     *
     * @return boolean
     */
    private function validateDriverOption(string $option, string $value): bool
    {
        $rtn = false;

        if ( isset($this->allowedDriverOptions[$option]) )
        {
            // Only check for allowed options if any are specified
            if ( isset($this->allowedDriverOptions[$option]['options']) )
            {
                if ( in_array($value, $this->allowedDriverOptions[$option]['options'] ) )
                {
                    // Specified allowed options, and the value is in there.
                    $rtn = true;
                }
            }
            else
            {
                // No specified values for the option, so take whatever is
                // passed in.
                $rtn = true;
            }
        }

        return $rtn;
    }
}
