<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace Project;

use Composer\Script\Event;

/**
 * Class Composer
 *
 * @package Script
 */
class Composer
{
    /**
     * @param Event $event
     */
    public static function postUpdate(Event $event)
    {
        $baseDir = getcwd() . '/public/assets/vendor';

        self::deleteDir($baseDir, 1);

        echo "Deleted files in " . $baseDir . "\n";
    }

    /**
     * @param $baseDir
     */
    public static function deleteDir($baseDir, $level)
    {
        $dirList = scandir($baseDir);

        foreach ($dirList as $currentDir) {
            $ignoreList = $level == 1
                ? ['.', '..', '.gitignore']
                : ['.', '..'];

            if (in_array($currentDir, $ignoreList)) {
                continue;
            }

            if (is_dir($baseDir . '/' . $currentDir)) {
                self::deleteDir($baseDir . '/' . $currentDir, $level + 1);

                rmdir($baseDir . '/' . $currentDir);
            } else {
                unlink($baseDir . '/' . $currentDir);
            }
        }
    }
}