<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/10/9
 * Time: 11:05
 */

namespace One\Swoole;

use One\Facades\Log;

class WsController
{
    /**
     * @var \swoole_websocket_frame
     */
    protected $frame;

    /**
     * @var WebSocket
     */
    protected $server;

    /**
     * @var Session
     */
    protected $session;

    public function __construct($frame, $server, $session = null)
    {
        $this->frame = $frame;
        $this->server = $server;
        $this->session = $session;
    }

    public function __destruct()
    {
        Log::flushTraceId();
    }

}