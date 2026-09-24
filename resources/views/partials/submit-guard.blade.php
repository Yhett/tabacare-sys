<style>
    button[aria-busy="true"], input[type="submit"][aria-busy="true"] { cursor: wait !important; opacity: .72; }
    button[aria-busy="true"]::after { content: ''; display: inline-block; width: 12px; height: 12px; margin-left: 9px; vertical-align: -2px; border: 2px solid currentColor; border-right-color: transparent; border-radius: 50%; animation: tabacare-submit-spin .7s linear infinite; }
    .submit-status { display: block; margin-top: 8px; color: #087f55; font: 12px Arial, sans-serif; }
    @keyframes tabacare-submit-spin { to { transform: rotate(360deg); } }
</style>
<script>
    document.addEventListener('submit', function (event) {
        const form = event.target;
        if (!(form instanceof HTMLFormElement)) return;
        if (form.dataset.submitting === 'true') {
            event.preventDefault();
            return;
        }

        if (form.method.toUpperCase() === 'POST' && new URL(form.action, window.location.href).pathname.endsWith('/reports/download')) {
            event.preventDefault();
            form.dataset.submitting = 'true';
            const buttons = Array.from(form.querySelectorAll('button[type="submit"], button:not([type]), input[type="submit"]'));
            buttons.forEach(function (button) {
                button.disabled = true;
                button.setAttribute('aria-busy', 'true');
            });

            let status = form.querySelector('.submit-status');
            if (!status) {
                status = document.createElement('span');
                status.className = 'submit-status';
                status.setAttribute('role', 'status');
                status.setAttribute('aria-live', 'polite');
                form.appendChild(status);
            }
            status.textContent = 'Preparing your download…';

            fetch(form.action, { method: 'POST', body: new FormData(form), credentials: 'same-origin' })
                .then(function (response) {
                    const disposition = response.headers.get('Content-Disposition') || '';
                    if (!response.ok || !/attachment/i.test(disposition)) throw new Error('Download response was not an attachment.');
                    const match = disposition.match(/filename\*?=(?:UTF-8''|\")?([^\";]+)/i);
                    return response.blob().then(function (blob) {
                        return { blob: blob, filename: match ? decodeURIComponent(match[1].replace(/\"/g, '').trim()) : 'disease-report.xls' };
                    });
                })
                .then(function (download) {
                    const url = URL.createObjectURL(download.blob);
                    const link = document.createElement('a');
                    link.href = url;
                    link.download = download.filename;
                    document.body.appendChild(link);
                    link.click();
                    link.remove();
                    window.setTimeout(function () { URL.revokeObjectURL(url); }, 1000);
                    status.textContent = 'File already downloaded.';
                })
                .catch(function () {
                    status.textContent = 'Download failed. Please try again.';
                })
                .finally(function () {
                    form.dataset.submitting = 'false';
                    buttons.forEach(function (button) {
                        button.disabled = false;
                        button.removeAttribute('aria-busy');
                    });
                });
            return;
        }

        form.dataset.submitting = 'true';
        form.querySelectorAll('button[type="submit"], button:not([type]), input[type="submit"]').forEach(function (button) {
            button.disabled = true;
            button.setAttribute('aria-busy', 'true');
        });
    }, true);
</script>
