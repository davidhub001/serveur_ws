const WebSocket = require('ws');
const http = require('http');
const server = http.createServer();

const wss = new WebSocket.Server({ server });

wss.on('connection', (ws) => {
  // Gérer la réception de messages du client
  ws.on('message', (message) => {
    // Diffuser le message à tous les clients connectés
    wss.clients.forEach((client) => {
      if (client !== ws && client.readyState === WebSocket.OPEN) {
        client.send(message);
      }
    });
  });
});

server.listen(3000, () => {
  console.log('Serveur WebSocket en cours d\'exécution sur le port 3000');
});
