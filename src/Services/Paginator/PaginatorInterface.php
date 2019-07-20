<?php
/**
 * interface opsiujacy klase do zarządzania paginacja
 * @author lukasz7221@gmail.com
 */

namespace App\Services\Paginator;

interface PaginatorInterface {
  /**
   *
   * @param int     $nResult liczba rekordow w bazie
   * @param integer $limit   limit na jednej stronie
   * @param integer $page    aktualna postrona
   */
  public function __construct(int $nResult, int $limit = 10, int $page = 1);

  /**
   * metoda przeliczajaca maxymalna ilosc stron oraz first result
   * @return PaginatorInterface [description]
   */
  public function calculate(): PaginatorInterface;

  /**
   * Zwraca maksymalny numer strony
   * @return int
   */
  public function getMaxPage(): int;

  /**
   * setter dla liczby rekordow wyzwala metode calculate
   * @param  int  $nResult
   * @return self
   */
  public function setNResult(int $nResult): PaginatorInterface;

  /**
   *  zwraca ilisc rekordow
   * @return int [description]
   */
  public function getNResult(): int;

  /**
   * zwraca numer poczatkowego rekordu po przeliczeniu
   * @return int
   */
  public function getFirstResult(): int;

  /**
   * zwraca limit
   * @return int
   */
  public function getLimit(): int;

  /**
   * setter dla limitu wyzwala metode calculate
   * @param  int                $limit [description]
   * @return PaginatorInterface        [description]
   */
  public function setLimit(int $limit): PaginatorInterface;

  /**
   * zwraca aktualna podstrone
   * @return int
   */
  public function getCurrentPage(): int;

  /**
   * setter dla aktualnej podstrony  wyzwala metode calculate
   * @param  int  $currentPage
   * @return self
   */
  public function setCurrentPage(int $currentPage): PaginatorInterface;

  /**
   * ustawia ilosc obiektow page z lewj i prawej wywoluje metode calculate
   * @param  int  $limit [descri ption]
   * @return self        [description]
   */
  public function setLimitR(int $limit): PaginatorInterface;

  /**
   * zwraca ilosc obiektow page z lewj i prawej
   * @return int [description]
   */
  public function getLimitR(): int;


  /**
   * sprawdza cz aktualna podstrona jest prawidlowa
   * @return bool
   */
  public function validate(): bool;

  /**
   * zwraca obiekty page
   * @return Page[]
   */
  public function getPages(int $iType): array;


}
