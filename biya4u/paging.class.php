<?php
/**
 * PAGING CLASS
 * =============================================================
 * this class implements paging of results, similar to google
 * also database independent. 
 *
 * @author Erik St Martin <alakriti@gmail.com>
 * @version 1.0.0
 * @access public
 * @copyright 2005 Erik St Martin 
 * 
 */
 
 
final class pager {
	/**
	* Contains the current page number.
	* @var       int
	* @access    private
	*/
	private $page = 0;
	private $page10 = 10;
	
	/**
	* Contains the number of records to return per page.
	* @var       int
	* @access    private
	*/
	private $limit = 0;
	
	/**
	* Contains the number of rows total for a query before
	* being split between pages.
	* @var       int
	* @access    private
	*/
	private $rows = 0;
	
	/**
	* Number of links for class to return. This number is
	* excluding the next and previous links.
	* @var       int
	* @access    private
	*/
	private $max_num_links = 10;
	
	/**
	* Total number of pages for the result set.
	* @var       int
	* @access    private
	*/
	private $total_pages = 0;
	
	/**
	* Class constructor. Requires three paramaters, and has one optional parameter
	* The first parameter is the current page. The Second is the number of records
	* to be returned per page. The Third is the total number of rows that are
	* returned before broken up into pages. The Fourth parameter is optional, this
	* is the number of page links for the class to return excluding next and previous
	* @param     $page         int containing current page number
	* @param     $limit        int containing number of rows to be returned per page
	* @param     $rows         int containing total rows returned
	* @param     $num_links    int number of links to be returned, excluding next and prev.
	* @access    public
	* @return    void
	*/
	public function __construct($page, $limit, $rows, $num_links = 10){
		if($page < 1){
			$this->page = 1;
		}else{
			$this->page = $page;
		}
		
		$this->limit = $limit;
		$this->rows = $rows;
		
		$this->max_num_links = ($num_links % 2) ? $num_links : $num_links+1;
		
		
		$this->set_total_pages();
	}
	
	/**
	* Returns the start offset for the current page to be used in SQL query. This
	* function takes no parameters.
	* @access    public
	* @return    int
	*/
	public function get_start_offset(){
		$start = ($this->page - 1) * $this->limit;
		return($start);
	}
	
	/**
	* Takes the script name and query string and modifies it with the new page
	* number
	* @param     $page         int page number to change to
	* @access    private
	* @return    string
	*/
	
    private function make_link_url($page){
        $pos_start = strpos($_SERVER['QUERY_STRING'], "p=");
 
        if($pos_start === FALSE){
            $location = $_SERVER['PHP_SELF'] . "?p=" . $page;
            if($_SERVER['QUERY_STRING']){
                $location .= "&" . $_SERVER['QUERY_STRING'];
            }
 
            return($location);
 
        } else {
            $page_arg = "p=" . $this->page;
            $query_string = str_replace($page_arg, "p=" . $page, $_SERVER['QUERY_STRING']);
 
            $location = $_SERVER['PHP_SELF'] . "?" . $query_string;
 
            return($location);
        }
    }
	
	/**
	* Determines the total number of pages for the result set based on the limit
	* per page and the number of rows returned. Then sets member variable
	* @access    private
	* @return    void
	*/
	private function set_total_pages(){
		$this->total_pages = (($this->rows % $this->limit) == 0) ? $this->rows / $this->limit : floor($this->rows / $this->limit) + 1;
	}
	
	/**
	* Returns the total number of pages for the result set
	* @access    private
	* @return    int
	*/
	private function get_total_pages(){
		return($this->total_pages);
	}
	
	/**
	* Returns a string of the html for the page links
	* @access    public
	* @return    string
	*/
	public function get_links(){
	
	
		$next_html    = "&nbsp;&nbsp;<a href=\"%s\" class=\"pagnextprev\">Next</a>";
		$next10_html    = "&nbsp;&nbsp;<a href=\"%s\" class=\"pagnextprev\">Next10</a>";
		$last_html    = "&nbsp;<a href=\"%s\" class=\"pagnextprev\">Last</a>";
		$first_html    = "&nbsp;<a href=\"%s\" class=\"pagnextprev\">First</a>";
		
		
		
		$prev_html    = "<a href=\"%s\" class=\"pagnextprev\">Prev</a>&nbsp;";
		
		//$current_html = "<span class=\"pager_active\"><b>>%d<</b></span>";
		//$max_num_links;
		//$current_html = "<span class=\"paginbox\"><b>%d</b></span>";
		$current_html = "<span class=\"paginbox\"><b>%d</b></span>";
		//$prev10_html    = "&nbsp;<a href=\"%s\" class=\"pagnextprev\"><< Prev 10</a>&nbsp;";
		$other_html   = "<a href=\"%s\" class=\"pagingreybox\">%d</a>";
		
		
		if($this->page != 1){
			$links = sprintf($prev_html, $this->make_link_url($this->page-1));
		}
		
		
		
		
		$num_links = ($this->get_total_pages() > $this->max_num_links) ? $this->max_num_links : $this->get_total_pages();
		
		if($this->page <= floor($this->max_num_links / 2)){
			
			$link_page_start = 1;
			$link_page_end = $num_links;
		} else {
			
			if($this->page <= ($this->get_total_pages()  - floor($this->max_num_links / 2))){
				$link_page_end = $this->page + floor($this->max_num_links / 2);
				$link_page_start = $this->page - floor($this->max_num_links / 2);
			} else {
				$link_page_end = $this->get_total_pages();
				$link_page_start = ($link_page_end - $this->max_num_links) < 1 ? 1 : $link_page_end - $this->max_num_links;
			}
			
		}
		 
		$link_page = $link_page_start;
		
		while($link_page <= $link_page_end){
			$links .= " ";
			if($link_page == $this->page){
				$links .= sprintf($current_html, $link_page);
			} else {
				$links .= sprintf($other_html, $this->make_link_url($link_page), $link_page);
			}
			$link_page++;
		}
		$links .= " ";
		
		
		
		
		
		
		if($this->page != $this->get_total_pages())
		{
			$links .= sprintf($next_html, $this->make_link_url($this->page+1));
		}
	
	
		
		
	
		//if($this->page10 <> $this->get_total_pages())
		//{
		//	$links .= sprintf($next10_html, $this->make_link_url($this->page+10));
		//}
		
		//////////////////////////////////////////////////////////////////////////////////////////
		
		//$selva = ceil($this->get_total_pages()/ 10);
		//$raja = ($this->get_total_pages() - $selva);
		$kanna = ceil($this->get_total_pages()- 10);
		if( ($kanna) > $this->page)
		{
		$links .= sprintf($next10_html, $this->make_link_url($this->page+10));
		} 
		else
		{
		//$links .= sprintf($prev10_html, $this->make_link_url($this->page-10));
		}
		//////////////////////////////////////////////////////////////////////////////////////////
		
		
		
		if($this->page <> $this->get_total_pages())
		{
		$links .= sprintf($last_html, $this->make_link_url($this->get_total_pages()));
		}
		
		if($this->page == $this->get_total_pages())
		{
		$links .= sprintf($first_html, $this->make_link_url($this->get_total_pages()-$this->page+1));
		}
		
			
		if($this->rows == 0 ){
			$links = sprintf($current_html, $link_page);	
		}
		
		return($links);
		
	}
}
?>
