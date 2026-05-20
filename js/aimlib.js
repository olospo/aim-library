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

(function ($) {
    // Safe to use $ here, won't conflict with other libraries
    $(document).ready(function () {

        const searchInput    = document.getElementById('measure-search');
        const filterRow      = $('.filter-row');
        const allBtn         = filterRow.find('.respondent-filter .filter-pill').first();
        const respondentBtns = filterRow.find('.respondent-filter .filter-pill');
        const specificBtns   = respondentBtns.not(allBtn);
        const ageInputs      = filterRow.find('.age-selects input');
        const problemSelect  = filterRow.find('.js-filter-problem-area');

        $('.js-clear-filters').on('click', function () {
            searchInput.value = '';
            specificBtns.removeClass('is-active');
            allBtn.addClass('is-active');
            ageInputs.eq(0).val('');
            ageInputs.eq(1).val('');
            problemSelect.prop('selectedIndex', 0);
            resetTable();
        })

        // --- Pill clicks ---
        respondentBtns.on('click', function () {
            const btn = $(this);

            if (btn.is(allBtn)) {
                respondentBtns.removeClass('is-active');
                allBtn.addClass('is-active');
            } else {
                btn.toggleClass('is-active');
                const anyActive = specificBtns.filter('.is-active').length > 0;
                allBtn.toggleClass('is-active', !anyActive);
            }

            dispatchFilters();
        });

        // --- Age / select changes ---
        ageInputs.on('input', dispatchFilters);
        problemSelect.on('change', dispatchFilters);

        // --- Collect and fire ---
        function dispatchFilters() {
            searchInput.value = '';
            const respondents = respondentBtns.filter('.is-active')
                .map(function () { return $(this).text().trim(); })
                .get();

            // trigger your AJAX call here
            fetch(aimConfig.ajaxUrl, {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({
                    action:        'filter_measures', // must match your add_action suffix
                    nonce:          aimConfig.security,
                    respondents:    respondents,
                    age_min:         ageInputs.eq(0).val() !== '' ? Number(ageInputs.eq(0).val()) : null,
                    age_max:         ageInputs.eq(1).val() !== '' ? Number(ageInputs.eq(1).val()) : null,
                    problem_area:    problemSelect.val(),
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

    });
}(jQuery));
