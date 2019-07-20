<?php
namespace App\Services\Paginator;

/**
 * reprezentacja podstron
 * @author lukasz7221@gmail.com
 */

class Page {

  protected $current = false;

  protected $page = 1;

  protected $route = '';

  public function __construct(int $page)
  {
    $this -> setPage($page);
  }

  public function getRoute(): ?string
  {
    return $this -> route;
  }

  public function setRoute(string $route): self
  {
    $this -> route = $route;
    return $this;
  }

  public function setPage(int $page): self
  {
    $this -> page = $page;
    return $this;
  }

  public function getPage(): int
  {
    return $this -> page;
  }

  public function setCurrent(bool $isCurrent): self
  {
    $this -> current = $isCurrent;
    return $this;
  }

  public function getCurrent(): bool
  {
    return $this -> current;
  }

  public function toArray(): array
  {
    return [
      'current' => $this -> getCurrent(),
      'route' => $this -> getRoute(),
      'page' => $this -> getPage()
    ];
  }

  public function __toString() : string
  {
    return (string)$this -> getPage();
  }

}
