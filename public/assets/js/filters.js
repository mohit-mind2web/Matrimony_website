document.addEventListener('DOMContentLoaded', function () {
    const filterForms = document.querySelectorAll('.ajax-filter-form');

    filterForms.forEach(form => {
        const targetId = form.getAttribute('data-target');
        const tableContainer = document.getElementById(targetId);

        if (!tableContainer) return;
        form.addEventListener('submit', function (e) {
            const submitter = e.submitter;
            if (submitter && submitter.name === 'export') {
                return;
            }

            e.preventDefault();

            if (submitter && submitter.name === 'reset_filters') {
                resetForm(form);
                const formData = new FormData(form);
                formData.set('reset_filters', '1');
                fetchData(form, tableContainer, formData);
                return;
            }

            const page = (e.detail && e.detail.page) ? e.detail.page : 1;
            fetchData(form, tableContainer, new FormData(form), page);
        });

        const inputs = form.querySelectorAll('input, select');
        inputs.forEach(input => {
            if (input.type === 'text') {
                let timeout = null;
                input.addEventListener('input', function () {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => {
                        fetchData(form, tableContainer, new FormData(form));
                    }, 500);
                });
            } else if (input.tagName === 'SELECT') {
                input.addEventListener('change', function () {
                    fetchData(form, tableContainer, new FormData(form));
                });
            }
        });
        if (typeof flatpickr !== 'undefined') {
            const dateInputs = form.querySelectorAll('.flatpickr-input, #date_range');
            dateInputs.forEach(input => {
                if (input.id === 'date_range' && !input._flatpickr) {
                    flatpickr(input, {
                        mode: "range",
                        dateFormat: "Y-m-d",
                        onClose: function (selectedDates, dateStr, instance) {
                            fetchData(form, tableContainer, new FormData(form));
                        }
                    });
                }
            });
        }
    });

    function resetForm(form) {
        form.reset();
        const inputs = form.querySelectorAll('input[type="text"], input[type="hidden"], select');
        inputs.forEach(input => {
            if (input.name !== 'csrf_token') input.value = '';
        });
        const dateInputs = form.querySelectorAll('#date_range');
        dateInputs.forEach(input => {
            if (input._flatpickr) input._flatpickr.clear();
        });
    }

    function fetchData(form, container, formData, page = 1) {
        let url = form.getAttribute('action');

        if (page > 1) {
            url += (url.includes('?') ? '&' : '?') + 'page=' + page;
        }

        fetch(url, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(response => response.text())
            .then(html => {
                container.innerHTML = html;
            })
            .catch(error => console.error('Error:', error));
    }

    document.body.addEventListener('change', function (e) {
        if (e.target.classList.contains('ajax-status-select')) {
            const form = e.target.closest('form');
            if (form) {
                e.preventDefault();
                const formData = new FormData(form);
                const url = form.getAttribute('action');

                fetch(url, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            const filterForm = document.querySelector('.ajax-filter-form');
                            if (filterForm) {
                                const targetId = filterForm.getAttribute('data-target');
                                const container = document.getElementById(targetId);
                                let page = 1;
                                if (container) {
                                    const activeLink = container.querySelector('.pagination .active');
                                    if (activeLink) {
                                        page = parseInt(activeLink.textContent.trim()) || 1;
                                    }
                                }

                                const event = new CustomEvent('submit', {
                                    cancelable: true,
                                    detail: { page: page }
                                });
                                filterForm.dispatchEvent(event);
                            }
                        } else {
                            alert('Failed to update status');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        }
    });

    document.body.addEventListener('submit', function (e) {
        if (e.target.classList.contains('ajax-action-button-form')) {
            e.preventDefault();
            const form = e.target;
            const formData = new FormData(form);
            const url = form.getAttribute('action');

            fetch(url, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        const filterForm = document.querySelector('.ajax-filter-form');
                        if (filterForm) {
                            const targetId = filterForm.getAttribute('data-target');
                            const container = document.getElementById(targetId);
                            let page = 1;
                            if (container) {
                                const activeLink = container.querySelector('.pagination .active');
                                if (activeLink) {
                                    page = parseInt(activeLink.textContent.trim()) || 1;
                                }
                            }

                            const event = new CustomEvent('submit', {
                                cancelable: true,
                                detail: { page: page }
                            });
                            filterForm.dispatchEvent(event);
                        }
                    } else {
                        alert('Failed to update status');
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    });

    // Handle Pagination Clicks
    document.body.addEventListener('click', function (e) {
        if (e.target.classList.contains('ajax-pagination-link')) {
            e.preventDefault();
            const link = e.target;
            const url = link.getAttribute('href');
            const container = link.closest('[id$="-table-container"]');

            if (container && url) {
                fetch(url, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                    .then(response => response.text())
                    .then(html => {
                        container.innerHTML = html;
                    })
                    .catch(error => console.error('Error fetching page:', error));
            }
        }
    });
});
