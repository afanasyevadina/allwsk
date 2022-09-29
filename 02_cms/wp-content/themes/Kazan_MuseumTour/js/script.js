const setListeners = () => {
    document.querySelectorAll('a').forEach(a => a.onclick = e => {
        if (a.closest('#wpadminbar')) return
        e.preventDefault()
        document.body.classList.add('loading')
        fetch(a.href)
            .then(response => response.text())
            .then(text => {
                const parser = new DOMParser()
                const doc = parser.parseFromString(text, 'text/html')
                document.body.innerHTML = doc.body.innerHTML
                document.title = doc.title
                history.pushState({}, null, a.href)
                setTimeout(() => window.scrollTo({top: 0, behavior: 'smooth'}), 50)
                setListeners()
                setTimeout(() => document.body.classList.remove('loading'), 400)
            })
    })
}
setListeners()