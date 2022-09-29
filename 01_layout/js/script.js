const nav = document.querySelector('nav')
window.onscroll = () => {
    nav.style.background = nav.getBoundingClientRect().y ? '#ffffff' : '#eeeeee'
    processScroll()
}

const processScroll = () => {
    document.querySelectorAll('.animable').forEach(animable => {
        console.log(animable.getBoundingClientRect().y)
        if (animable.getBoundingClientRect().y >= 0 && animable.getBoundingClientRect().y <= window.innerHeight / 1.15) {
            if (!animable.classList.contains('init')) animable.classList.add('init')
        }
    })
}

processScroll()