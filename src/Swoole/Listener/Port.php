<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/11/14
 * Time: 16:01
 */

namespace One\Swoole\Listener;


use One\Facades\Log;
use One\Swoole\Server;

/**
 * Class Port
 * @package One\Swoole\Listener
 * @mixin Server
 */
class Port
{
    protected $conf = [];

    /**
     * @var Server
     */
    protected $server;

    /**
     * @var ProtocolAbstract
     */
    protected $protocol = null;


    public function __construct($server, $conf)
    {
        $this->server = $server;
        $this->conf = $conf;
        if (isset($conf['protocol'])) {
            $this->protocol = $conf['protocol'];
        }
    }

    public function send($fd, $data, $from_id = 0)
    {
        if ($this->protocol) {
            $data = $this->protocol::encode($data);
        }
        $this->server->send($fd, $data, $from_id, false);
    }


    public function onClose(\swoole_server $server, $fd, $reactor_id)
    {
        if ($this->server->globalData && $this->server->globalData->connected === 1) {
            $this->server->unBindFd($fd);
        }
    }

    public function __call($name, $arguments)
    {
        return $this->server->$name(...$arguments);
    }
}