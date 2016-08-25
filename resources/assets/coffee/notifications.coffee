if('serviceWorker' in navigator)
  navigator.serviceWorker.register('/js/push.js').then((reg) ->
    reg.pushManager.subscribe({
      userVisibleOnly: true
    }).then((sub) -> console.log('endpoint:', JSON.stringify(sub)));
  ).catch((err) -> console.log(err));