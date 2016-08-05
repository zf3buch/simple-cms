<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

/**
 * ZF3 book Zend Framework Center Example Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/zendframework-center
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 */

namespace CategoryModel\Filter;

use Zend\Filter\File\RenameUpload;

/**
 * Class ImageFileUpload
 *
 * @package CategoryModel\Filter
 */
class ImageFileUpload extends RenameUpload
{
    /**
     * @var string
     */
    private $targetPath;

    /**
     * @var string
     */
    private $targetFile;

    /**
     * Constructor
     *
     * @param string $targetPath
     * @param string $targetFile
     */
    public function __construct($targetPath, $targetFile)
    {
        $this->targetPath = $targetPath;
        $this->targetFile = $targetFile;

        $options = [
            'overwrite' => true,
            'target'    => $targetPath . $targetFile,
        ];

        parent::__construct($options);
    }

    /**
     * @param array|string $value
     *
     * @return array|string
     */
    public function filter($value)
    {
        parent::filter($value);

        return $this->targetFile;
    }
}
