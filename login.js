
// customer login
function showlogin(){
    const popUp = document.querySelector('.popUp')
    popUp.style.display = 'flex'
}
function closelogin(){
    const popUp = document.querySelector('.popUp')
    popUp.style.display = 'none'
}

// admin login
function showADlogin(){
    const ADpopUp = document.querySelector('.ADpopUp')
    ADpopUp.style.display = 'flex'
}
function closeADlogin(){
    const ADpopUp = document.querySelector('.ADpopUp')
    const popUp = document.querySelector('.popUp')
    ADpopUp.style.display = 'none'
    popUp.style.display = 'flex'
    
}

// sign up
function showSignup(){
    const SPpopUp = document.querySelector('.SPpopUp')
    SPpopUp.style.display = 'flex'
}
function closeSignup(){
    const SPpopUp = document.querySelector('.SPpopUp')
    const popUp = document.querySelector('.popUp')
    SPpopUp.style.display = 'none'
    popUp.style.display = 'flex'
}
function cancelSignup(){
    const SPpopUp = document.querySelector('.SPpopUp')
    const popUp = document.querySelector('.popUp')
    SPpopUp.style.display = 'none'
    popUp.style.display = 'none'
}


function showSignup2(){
    const SPloginPopup2 = document.querySelector('#SPloginPopup2')
    SPloginPopup2.style.display = 'flex'
}
function closeSignup2(){
    const SPloginPopup2 = document.querySelector('#SPloginPopup2')
    SPloginPopup2.style.display = 'none'
}


