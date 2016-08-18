$('.has-dl').click((e) ->
  $('#' + this.id + '-dl').toggleClass('hidden')
)

dialog = document.querySelector('#modal-official-cover');
if(!dialog.showModal)
  dialogPolyfill.registerDialog(dialog);

showButton = document.querySelector('#show-modal-cover');
showButton.addEventListener('click', (e) -> dialog.showModal())
closeButton = dialog;
closeButton.addEventListener('click', (e) -> dialog.close())