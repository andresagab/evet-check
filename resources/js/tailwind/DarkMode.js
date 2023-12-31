/**
 * Set the base theme between 'dark' or 'light'
 * @param theme => 'dark' or 'light'
 */
export const toggle_dark_mode = () => {

    // load the theme from local storage or default light
    let theme = localStorage.theme
    // set theme in local storage
    localStorage.theme = theme === 'dark' ? 'light' : 'dark'

    // On page load or when changing themes, best to add inline in `head` to avoid FOUC
    if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        document.documentElement.classList.add('dark')
    } else {
        document.documentElement.classList.remove('dark')
    }

}
