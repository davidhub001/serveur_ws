<?php

// Création du socket TCP/IP
$socket = stream_socket_server("tcp://127.0.0.1:3000", $errno, $errstr);

if (!$socket) {
    die("$errstr ($errno)\n");
}

echo "Server listening on 127.0.0.1:3000...\n";

$clients = [];
while (true) {
    // Accepter une connexion
    $client = stream_socket_accept($socket, -1);

    if ($client) {
        echo "Client connected\n";
        $clients[] = $client;
    }

    // Lire les données des clients
    foreach ($clients as $client) {
        $data = fread($client, 1024);
        var_dump($data);
        if ($data) {
            echo "Received: $data\n";

            // Envoyer le message à tous les clients connectés
            foreach ($clients as $otherClient) {
                if ($otherClient !== $client) {
                    fwrite($otherClient, $data);
                }
            }
        }
    }
}

// Fermer le socket
fclose($socket);

?>
