<?php
/**
 * Created by PhpStorm.
 * User: Rux
 * Date: 31/12/2557
 * Time: 21:39 น.
 */

class Search
{
    private $wpdb;
    public $countValue = 0;
    public $classPagination = null;

    public function __construct($wpdb)
    {
        $this->wpdb = $wpdb;
    }
    public function search($data) {
        extract($data);
        $strSearch = empty($s)? null: $s;

    }
}