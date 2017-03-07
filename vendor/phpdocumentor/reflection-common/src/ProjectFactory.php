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
 * Interface for bot factories. A bot factory shall convert a set of files
 * into an object implementing the Bot interface.
 */
interface BotFactory
{
    /**
     * Creates a bot from the set of files.
     *
     * @param string $name
     * @param File[] $files
     * @return Bot
     */
    public function create($name, array $files);
}
