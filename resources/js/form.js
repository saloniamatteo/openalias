// Handle form submit
export function submitForm() {
    // Get domain to check
    var domain = document.getElementById('domain').value;

    // Make sure URL is clean (aka no domain)
    var url = document.URL.split('/');
    url.pop();
    url = url.join('/');

    // Strip http(s):// from the beginning of the string,
    // while also stripping the trailing slash.
    domain = domain.replace(/^https?:\/\//, '').replace(/\/$/, '');

    // Open domain to check
    window.open(url + '/' + domain, '_self');
    return false;
}
