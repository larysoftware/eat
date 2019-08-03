<?php
namespace App\Security\Jwt;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use RedisClient\RedisClient;
use App\Services\Customers\CustomersStorageInterface;
use App\Services\Customers\CustomersInterface;
use App\Entity\Customers;

class ApiKeyUserProvider implements UserProviderInterface
{

    protected $redisClient;

    protected $storage;

    public function __construct(RedisClient $redisClient, CustomersStorageInterface $storage) {
      $this -> redisClient = $redisClient;
      $this -> storage = $storage;
    }

    /**
     * pobieram wartos z redisa na podstawie klucza
     * @param  [type] $apiKey [description]
     * @return [type]         [description]
     */
    public function getUsernameForApiKey($apiKey)
    {
        return $this -> redisClient -> get($apiKey);
    }

    /**
     * pobieram login 
     * @param  [type] $userName [description]
     * @return [type]           [description]
     */
    public function loadUserByUsername($userName)
    {
        return $this -> storage -> findOneByQuery([
          'login' => $userName
        ]);
    }

    /**
     * metoda niewykonywana dla bezstanowej autentykacji
     * @param  UserInterface $user [description]
     * @return [type]              [description]
     */
    public function refreshUser(UserInterface $user)
    {
        // this is used for storing authentication in the session
        // but in this example, the token is sent in each request,
        // so authentication can be stateless. Throwing this exception
        // is proper to make things stateless
        throw new UnsupportedUserException();
    }

    public function supportsClass($class)
    {
        return Customers::class === $class;
    }
}
