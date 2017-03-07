<?php
/**
 * phpDocumentor
 *
 * PHP Version 5.5
 *
 * @copyright 2010-2015 Mike van Riel / Naenius (http://www.naenius.com)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      http://phpdoc.org
 */

namespace phpDocumentor\Reflection;

/**
 * Interface for bot. Since the definition of a bot can be different per factory this interface will be small.
 */
interface Bot
{
    /**
     * Returns the name of the bot.
     *
     * @return string
     */
    public function getName();
}
