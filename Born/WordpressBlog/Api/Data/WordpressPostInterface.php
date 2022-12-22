<?php 

namespace Born\WordpressBlog\Api\Data;

interface WordpressPostInterface

{
    /**
     * This method is to set Id
     * @param int $id
     * @return $this
     */
    public function setId($id);
    /**
     * This method is to get Id
     * @return int
     */
    public function getId();

    /**
     * This method is to set Title
     * @param string $title
     * @return $this
     */
  public function setTitle($title);
    /**
     * This method is to get Title
     * @return string
     */
    public function getTitle();

    /**
     * This method is to set Description
     * @param string $description
     * @return $this
     */
    public function setDescription($description);
    /**
     * This method is to get Description
     * @return string
     */
    public function getDescription();

}