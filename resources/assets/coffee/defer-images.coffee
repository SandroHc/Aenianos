deferImages = () ->
  imgList = document.getElementsByTagName('img')
  for element in imgList
    if(element.getAttribute('data-src'))
      element.setAttribute('src', element.getAttribute('data-src'))

window.addEventListener('load', deferImages)