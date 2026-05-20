function debounce(fn, delay = 400) {
    let timer;
    return function (...args) {
        clearTimeout(timer);
        timer = setTimeout(() => fn.apply(this, args), delay);
    };
}

function resetTable() {
    // reset your table state here
   fetch(aimConfig.ajaxUrl, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({
            action: 'search_measures', // must match your add_action suffix
            nonce:   aimConfig.security,
            search: '',
        }),
    })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                document.querySelector('.js-measure-list').innerHTML = data.data.html;
                const rowCount = document.querySelector('.js-measure-list').rows.length;
                $('.js-count').text(rowCount);
            }
        });
}

function handleSearch(value) {
    // trigger your AJAX call here
    fetch(aimConfig.ajaxUrl, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({
            action: 'search_measures', // must match your add_action suffix
            nonce:   aimConfig.security,
            search: value,
        }),
    })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                document.querySelector('.js-measure-list').innerHTML = data.data.html;
                const rowCount = document.querySelector('.js-measure-list').rows.length;
                $('.js-count').text(rowCount);
            }
        });
}

document.querySelectorAll('.js-measure-search').forEach(input => {
    input.addEventListener('input', function () {
        if (this.value.length === 0) {
            resetTable();
        } else if (this.value.length > 3) {
            handleSearch(this.value);
        }
    });
});
