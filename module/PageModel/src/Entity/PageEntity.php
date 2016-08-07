<?php
/**
 * ZF3 book Simple CMS Training Application
 *
 * @author     Ralf Eggert <ralf@travello.de>
 * @link       https://github.com/zf3buch/simple-cms
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 *
 */

namespace PageModel\Entity;

use CategoryModel\Entity\CategoryEntity;
use DateTime;

/**
 * Class PageEntity
 *
 * @package PageModel\Entity
 */
class PageEntity
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var DateTime
     */
    private $created;

    /**
     * @var DateTime
     */
    private $updated;

    /**
     * @var string
     */
    private $status;

    /**
     * @var CategoryEntity
     */
    private $category;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $text;

    /**
     * @var string
     */
    private $author;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = (integer) $id;
    }

    /**
     * @return DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param DateTime $created
     */
    public function setCreated(DateTime $created)
    {
        $this->created = $created;
    }

    /**
     * @return DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @param DateTime $updated
     */
    public function setUpdated(DateTime $updated)
    {
        $this->updated = $updated;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        if (!in_array($status, ['new', 'approved', 'blocked'])) {
            $status = 'new';
        }

        $this->status = trim($status);
    }

    /**
     * @return CategoryEntity
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param CategoryEntity $category
     */
    public function setCategory(CategoryEntity $category)
    {
        $this->category = $category;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = trim($title);
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText($text)
    {
        $this->text = trim($text);
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param string $author
     */
    public function setAuthor($author)
    {
        $this->author = trim($author);
    }

    /**
     * Update page
     */
    public function update()
    {
        $this->setUpdated(new DateTime());
    }

    /**
     * Approve page
     */
    public function approve()
    {
        $this->setStatus('approved');
        $this->setUpdated(new DateTime());
    }

    /**
     * Block page
     */
    public function block()
    {
        $this->setStatus('blocked');
        $this->setUpdated(new DateTime());
    }
}
