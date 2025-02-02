function showSidebar(){
  const sidebar = document.querySelector('.sidebar')
  const loginbutton = document.querySelector('.loginbutton')
  sidebar.style.display = 'flex'
  loginbutton.style.display = 'flex'
}
function closeSidebar(){
  const sidebar = document.querySelector('.sidebar')
  const loginbutton = document.querySelector('.loginbutton')
  sidebar.style.display = 'none'
  loginbutton.style.display = 'none'
}
