<?php
/**
 * Created by PhpStorm.
 * User: sergeykarakhanyan
 * Date: 12/23/18
 * Time: 13:51
 */

namespace Lionix\SeoManager;

use Lionix\SeoManager\Traits\SeoManagerTrait;

class SeoManager
{
    use SeoManagerTrait;

    /**
     * Get the array of the Seo meta data
     * @param $property
     * @return mixed
     */
    public function metaData($property = null)
    {
        return $this->getMetaData($property);
    }

    /**
     * Get Meta Keywords formatted
     * @return mixed
     */
    public function metaKeywords()
    {
        return $this->getMetaData('keywords');
    }

    /**
     * Get Title
     * @return mixed
     */
    public function metaTitle()
    {
        return $this->getMetaData('title');

    }

    /**
     * Get URL
     * @return mixed
     */
    public function metaUrl()
    {
        return $this->getMetaData('url');

    }

    /**
     * Get Meta Author
     * @return mixed
     */
    public function metaAuthor()
    {
        return $this->getMetaData('author');
    }

    /**
     * Get Meta Description
     * @return mixed
     */
    public function metaDescription()
    {
        return $this->getMetaData('description');
    }

    /**
     * Get dynamically generated title based on users mapping
     * @return mixed
     */
    public function metaTitleDynamic()
    {
        return $this->getMetaData('title_dynamic');
    }

    /**
     * Get Open Graph Data
     * @param $property
     * @return mixed
     */
    public function metaOpenGraph($property = null)
    {
        $og_data = $this->getMetaData('og_data');
        if (!is_null($property) && isset($og_data[$property])) {
            return $og_data[$property];
        }
        return $this->getMetaData('og_data');
    }
}
