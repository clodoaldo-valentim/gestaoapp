importScripts('https://storage.googleapis.com/workbox-cdn/releases/5.1.2/workbox-sw.js');

const CACHE = "pwabuilder-offline";

// Configuração existente do Service Worker
self.addEventListener("message", (event) => {
    if (event.data && event.data.type === "SKIP_WAITING") {
        self.skipWaiting();
    }
});

// Adicionar manipulador de eventos push
self.addEventListener('push', function(event) {
    const options = {
        body: event.data ? event.data.text() : 'Notificação de tarefa',
        icon: '/assets/logos/192x192.png', // Ajuste para o caminho do seu ícone
        badge: '/assets/logos/badge-72x72.png',  // Ajuste para o caminho do seu badge
        vibrate: [100, 50, 100],
        data: {
            dateOfArrival: Date.now(),
            primaryKey: 1
        },
        actions: [
            {
                action: 'explore',
                title: 'Ver tarefa',
                icon: '/assets/logos/checkmark.png' // Ícone para a ação
            },
            {
                action: 'close',
                title: 'Fechar',
                icon: '/assets/logos/xmark.png' // Ícone para a ação
            }
        ]
    };

    event.waitUntil(
        self.registration.showNotification('Lembrete de Tarefa', options)
    );
});

// Manipulador de clique na notificação
self.addEventListener('notificationclick', function(event) {
    event.notification.close();

    if (event.action === 'explore') {
        // Abrir a página de tarefas quando clicar em "Ver tarefa"
        event.waitUntil(
            clients.openWindow('/lista_tarefas.php')
        );
    }
});

// Configuração do Workbox
workbox.routing.registerRoute(
    new RegExp('.*'),
    new workbox.strategies.StaleWhileRevalidate({
        cacheName: CACHE
    })
);

workbox.core.skipWaiting();
workbox.core.clientsClaim();
