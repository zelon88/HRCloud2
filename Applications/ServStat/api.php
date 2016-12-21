<?php
    function getStatus($ip, $port) {
        $socket = @fsockopen($ip, $port, $errorNo, $errorStr, 2);
        if (!$socket) return false;
        else return true;
    }

    function parser() {
        $servers = simplexml_load_file("servers.xml");
        foreach ($servers as $server) {
            if (getStatus((string)$server->ip, (string)$server->port)) {
                $server->online = "true";
            }
            else {
                $server->online = "false";
            }
        }
        return $servers;
    }
    echo json_encode(parser(), JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
?>
