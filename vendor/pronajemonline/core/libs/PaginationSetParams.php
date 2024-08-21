<?php

namespace pronajem\libs;

class PaginationSetParams
{
    /**
     * @var int $currentPage The number of the current page being viewed. This value is determined based on the input
     * parameter and validated to ensure it falls within the available range of pages.
     */
    public $currentPage;

    /**
     * @var int $perpage The number of items to display on each page. This value is used to calculate the total
     * number of pages and determine the SQL LIMIT clause for fetching paginated results.
     */
    public $perpage;

    /**
     * @var int $total The total number of items across all pages. This is used in conjunction with $perpage
     * to calculate the total number of pages ($countPages).
     */
    public $total;

    /**
     * @var int $countPages The total number of pages available, calculated based on $total and $perpage.
     * This value is used to generate the pagination links and to validate $currentPage.
     */
    public $countPages;

    /**
     * @var string $uri The base URI used for generating pagination links. This URI includes any existing
     * query parameters, excluding the 'page' parameter, to ensure that pagination links correctly
     * preserve other parameters in the URL.
     */
    public $uri;


    public function __construct(){



    }

    /**
     * Sets the pagination parameters including the number of records per page,
     * total number of records, total number of pages, and the current page.
     *
     * @param int $perpage The number of records to display per page.
     * @param int $total The total number of records.
     * @return void
     */
    public function setPaginationParams($perpage, $total) {

        $this->perpage = $perpage;
        $this->total = $total;
        $this->countPages = $this->getCountPages();
        $this->currentPage = $this->getCurrentPage();
        $this->uri = $this->getParams();

    }

    /**
     * Converts the pagination object to its HTML representation.
     *
     * @return string The HTML for the pagination links.
     */
    public function __toString()
    {
        return $this->getHtml();
    }

    /**
     * Generates the HTML for pagination links.
     *
     * @return string The HTML for the pagination navigation.
     */
    public function getHtml(){

        $back = null; // link BACK
        $forward = null; // link FORWARD
        $startPage = null; //link STRAT PAGE
        $endPage = null; // link LAST PAGE
        $page2left = null; // link PREVIOS PREVIOS PAGE
        $page1left = null; // link PREVIOS PAGE
        $page2right = null; // link NEXT NEXT PAGE
        $page1right = null; // link NEXT PAGE

        if($this->currentPage > 1){
            $back = "<li><a class='nav-link' href='{$this->uri}page=" . ($this->currentPage - 1) ."'>&lt;</a></li>";
        }

        if($this->currentPage < $this->countPages){
            $forward = "<li><a class='nav-link' href='{$this->uri}page=" . ($this->currentPage + 1) ."'>&gt;</a></li>";

        }

        if ($this->currentPage > 3){
            $startPage = "<li><a class='nav-link' href='{$this->uri}page=1'>&laquo;</a></li>";
        }

        if($this->currentPage < ($this->countPages - 2)){
            $endPage = "<li><a class='nav-link' href='{$this->uri}page={$this->countPages}'>&raquo;</a></li>";
        }

        if($this->currentPage - 2 > 0){
            $page2left = "<li><a class='nav-link' href='{$this->uri}page=" . ($this->currentPage - 2) ."'>" . ($this->currentPage - 2) . "</a></li>";
        }

        if($this->currentPage - 1 > 0){
            $page1left = "<li><a class='nav-link' href='{$this->uri}page=" . ($this->currentPage - 1) ."'>" . ($this->currentPage - 1) . "</a></li>";
        }

        if($this->currentPage + 2 <= $this->countPages){
            $page2right = "<li><a class='nav-link' href='{$this->uri}page=" . ($this->currentPage + 2) ."'>" . ($this->currentPage + 2) . "</a></li>";
        }

        if($this->currentPage + 1 <= $this->countPages){
            $page1right = "<li><a class='nav-link' href='{$this->uri}page=" . ($this->currentPage + 1) ."'>" . ($this->currentPage + 1) . "</a></li>";
        }

        return '<ul class="pagination">' . $startPage.$back.$page2left.$page1left.'<li class="active"><a>' . $this->currentPage . '</a></li>'.$page1right.$page2right.$forward.$endPage . '</ul>';

    }

    /**
     * Calculates the total number of pages based on total items and items per page.
     *
     * @return int The total number of pages.
     */
    public function getCountPages(){
        return ceil($this->total / $this->perpage) ? : 1;
    }

    /**
     * Determines the current page number for pagination.
     *
     * This method retrieves the current page number from the query string (`$_GET['page']`).
     * If the page number is not set, less than 1, or invalid, it defaults to 1.
     * If the page number exceeds the total number of pages (`countPages`), it sets the current page to the last page.
     *
     * @return int The current page number.
     */
    public function getCurrentPage() : int
    {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if(!$page || $page < 1) $page = 1;
        if($page > $this->countPages) $page = $this->countPages;
        return $page;
    }


    /**
     * Calculates the offset for the items to be displayed on the current page.
     *
     * @return int The offset for the items query.
     */
    public function getStart(){
        return ($this->currentPage - 1) * $this->perpage;

    }

    /**
     * Parses the current URI and constructs a base URI for pagination links,
     * ensuring existing query parameters are preserved, excluding the page parameter.
     *
     * @return string The base URI for pagination links.
     */
    public function getParams(){
        $url = $_SERVER['REQUEST_URI'];
        //empty GET
        if(preg_match("~\?$~", $url)){
            $url = rtrim($url, '?');
        }

        if(preg_match("~\?~", $url)) {
            $url = explode('?', $url);
            $uri = $url[0] . '?';
            if(isset($url[1]) && $url[1] != ''){
                $params = explode('&', $url[1]);
                foreach ($params as $param) {
                    if(!preg_match("~page=~", $param)) $uri .= "{$param}&amp;";
                }
                return $uri;
            }

        }

        return $url.'?';

    }
}