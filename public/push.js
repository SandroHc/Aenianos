//console.log('Started', self);
self.addEventListener('install', function(event) {
	//self.skipWaiting();
	//console.log('Installed', event);
});
self.addEventListener('activate', function(event) {
	//console.log('Activated', event);
});
self.addEventListener('push', function(event) {
	console.log('Push message', event);
	var title = 'Aenianos';
	event.waitUntil(
		self.registration.showNotification(title, {
			body: 'Novo lançamento!',
			icon: 'img/upload/Shigatsu wa Kimi no Uso.png',
			tag: 'new-release'
		})
	);
});
self.addEventListener('notificationclick', function(event) {
	console.log('Notification click: tag ', event.notification.tag);
	var url = 'https://aenianos.sandrohc.me';
	event.notification.close();
	event.waitUntil(
		clients.matchAll({
			type: 'window'
		}).then(function(windowClients) {
			for(var i = 0; i < windowClients.length; i++) {
				var client = windowClients[i];
				if (client.url === url && 'focus' in client)
					return client.focus();
			}
			if (clients.openWindow) {
				return clients.openWindow(url);
			}
		})
	);
});