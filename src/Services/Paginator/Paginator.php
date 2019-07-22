<?php
namespace App\Services\Paginator;

class Paginator implements PaginatorInterface {

	public const OBJECT_PAGE = 1;
	public const ARRAY_PAGE = 2;


	protected $nResult = 0;
	protected $maxPage = 1;
	protected $currentPage = 1;
	protected $limit = 10;
	protected $firstResult = 0;
	protected $limitR = 3;

	protected function setMaxPage(int $maxPage): PaginatorInterface
	{
		if($maxPage <= 0) {
			return $this;
		}

		$this -> maxPage = $maxPage;
		return $this;
	}

	protected function setFirstResult(int $iFirstResult = 0): PaginatorInterface
	{
		if($iFirstResult <= 0){
				return $this;
		}

		$this -> firstResult = $iFirstResult;
		return $this;
	}

	public function __construct(int $nResult, int $limit = 10, int $currentPage = 1)
	{

		$this -> nResult = $nResult;
		$this -> limit = $limit;
		$this -> currentPage = $currentPage;

		$this -> calculate();
	}

	public function setLimitR(int $limit): PaginatorInterface
	{
		$this -> limitR = $limit;
		$this -> calculate();
		return $this;
	}

	public function getLimitR(): int
	{
		return $this -> limitR;
	}

	public function setNResult($nResult): PaginatorInterface
	{
		$this -> nResult = $nResult;
		$this -> calculate();
		return $this;
	}

	public function getNResult(): int
	{
		return $this -> nResult;
	}


	public function getFirstResult(): int
	{
		return $this -> firstResult;
	}


	public function getMaxPage(): int
	{
		return $this -> maxPage;
	}


	public function getLimit(): int
	{

		return $this -> limit;
	}

	public function setLimit(int $limit): PaginatorInterface
	{
		$this -> limit = $limit;
		$this -> calculate();
		return $this;
	}

	public function getCurrentPage(): int
	{
		return $this -> currentPage;
	}

	public function setCurrentPage(int $currentPage): PaginatorInterface
	{
		$this -> currentPage = $currentPagerPage;
		$this -> calculate();
		return $this;
	}

	public function calculate() : PaginatorInterface
	{
		if($this -> getNResult() <= 0) {
			return $this;
		}

		$iMaxPage = (int)ceil($this -> getNResult() / $this -> getLimit());
		$iFirstResult = (int)$this -> getCurrentPage() * $this -> getLimit()  - $this -> getLimit();

		$this -> setFirstResult($iFirstResult);
		$this -> setMaxPage($iMaxPage);
		return $this;
	}


	/**
	 * sprawdzam czy numer podstrony jest poprawny
	 * @return bool
	 */
	public function validate() : bool
	{

		if($this -> getMaxPage() < $this -> getCurrentPage() OR $this -> getCurrentPage() <= 0) {
			return false;
		}

		return true;
	}

	public function getPages(int $iType = 1): array
	{

		$aPages = [];
		$iFrom = $this -> getCurrentPage() - $this -> getLimitR();

		if($iFrom <= 0){
			$iFrom = 1;
		}
		
		$iTo = $this -> getCurrentPagerPage() + $this -> getLimitR();

		if($iTo > $this -> getMaxPage()){
			 $iTo = $this -> getMaxPage();
		}

		$aRangePage = range($iFrom, $iTo);

		foreach ($aRangePage as $k => $page){
			$p = new Page($page);

			if($page == $this -> getCurrentPage()){
				$p -> setCurrent(true);
			}

			if($iType == PaginatorInterface::OBJECT_PAGE){
				$aPages[] = $p;
				continue;
			}

			$aPages[] = $p -> toArray();
		}

		return $aPages;
	}

}
