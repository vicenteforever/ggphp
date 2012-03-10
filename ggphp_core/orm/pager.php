<?php

/**
 * 分页器
 * @package orm
 * @author goodzsq@gmail.com
 */
class orm_pager {

    protected $_mapper;
    protected $_query;
    protected $_page;
    protected $_itemsPerPage;
    protected $_itemCount;

    /**
     *
     */
    public function __construct(phpDataMapper_Query $query, $page = 1, $itemsPerPage = 30) {
        $this->_mapper = $query->mapper();
        $this->_query = $query;
        $this->setPage($page);
        $this->perPage($itemsPerPage);
    }

    public function setPage($page) {
        if (!is_int($page)) {
            $page = 1;
        } else if ($page < 1) {
            $page = 1;
        } else if ($page > $this->pages()) {
            $page = $this->pages();
        }
        $this->_page = $page;
        $this->_query->limit($this->perPage(), $this->offset());
        return $this;
    }

    /**
     * Get/Set current page
     * @param $page int
     */
    public function getPage($page = null) {
        return $this->_page;
    }

    /**
     * Get total number of pages page
     * @return $total int
     */
    public function pages() {
        return ceil($this->count() / $this->perPage());
    }

    /**
     * Set items per page limit
     * @param $itemsPerPage int
     */
    public function perPage($perPage = null) {
        if (null !== $perPage) {
            $this->_itemsPerPage = $perPage;
            $this->_query->limit($this->_itemsPerPage, $this->offset());
            return $this;
        }
        return $this->_itemsPerPage;
    }

    /**
     * Get row offset for SQL query
     *
     * @return int
     */
    public function offset() {
        $offset = ($this->getPage() - 1) * $this->perPage();
        return $offset;
    }

    /**
     * Get row offset for SQL query
     *
     * @return int
     */
    public function count() {
        if (!$this->_itemCount) {
            // @todo Fix this with aggregate functions on the query builder - this is a hack for SQL-only RDBMS
            $countSql = 'COUNT(*)';
            $countQuery = clone $this->_query; // Clone query object to not modify original query but keep all other options
            $countResult = $countQuery->select($countSql)->limit(null, null)->first();
            if ($countResult) {
                $this->_itemCount = (int) $countResult->{$countSql};
            } else {
                $this->_itemCount = 0;
            }
        }
        return $this->_itemCount;
    }

}