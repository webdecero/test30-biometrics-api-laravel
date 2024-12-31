<?php
namespace App\Http\Services\MatcherService;

//TODO: debe de ser una clase abstracta con interface o abstract, se recomienda una interface
//sotore, update, update, show y matcher

use Exception;
use Webdecero\Package\Core\Traits\ResponseApi;

use Webdecero\Package\Core\Services\SocketIO\SocketIOClient;
abstract class AbstractMatcherClientService implements InterfaceMatcherClientService
{
    use ResponseApi;
    protected $table;
    protected $dsn;
    protected $socketMatcher;

    // Constructor de la clase abstracta
    public function __construct( $dsn, $table)
    {
        $this->dsn = $dsn;
        $this->table = $table;
        $this->socketMatcher = new SocketIOClient('matcher');
    }

}
