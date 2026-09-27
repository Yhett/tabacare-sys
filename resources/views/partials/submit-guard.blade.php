<style>
    button[aria-busy="true"], input[type="submit"][aria-busy="true"] { cursor: wait !important; opacity: .72; }
    button[aria-busy="true"] { display: inline-flex; align-items: center; justify-content: center; gap: 8px; }
    button[aria-busy="true"]::after { content: ''; flex: 0 0 auto; width: 12px; height: 12px; border: 2px solid currentColor; border-right-color: transparent; border-radius: 50%; animation: tabacare-submit-spin .7s linear infinite; }
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

        // Only show loading on the button that was actually clicked,
        // not on every button inside the same form.
        let submitter = event.submitter || document.activeElement;
        if (!(submitter instanceof HTMLElement) || !form.contains(submitter)) {
            submitter = form.querySelector('button[type="submit"], button:not([type]), input[type="submit"]');
        }
        const busyButtons = submitter ? [submitter] : [];
        const markBusy = function () {
            busyButtons.forEach(function (button) {
                button.disabled = true;
                button.setAttribute('aria-busy', 'true');
                button.classList.add('is-loading');
            });
        };
        const clearBusy = function () {
            form.dataset.submitting = 'false';
            busyButtons.forEach(function (button) {
                button.disabled = false;
                button.removeAttribute('aria-busy');
                button.classList.remove('is-loading');
            });
        };

        if (form.method.toUpperCase() === 'POST' && new URL(form.action, window.location.href).pathname.endsWith('/reports/download')) {
            event.preventDefault();
            form.dataset.submitting = 'true';
            markBusy();

            let status = form.querySelector('.submit-status');
            if (!status) {
                status = document.createElement('span');
                status.className = 'submit-status';
                status.setAttribute('role', 'status');
                status.setAttribute('aria-live', 'polite');
                form.appendChild(status);
            }
            status.textContent = 'Preparing your download…';

            var token = form.querySelector('input[name="_token"]');
            var params = new URLSearchParams(new FormData(form)).toString();

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': token ? token.value : ''
                },
                body: params,
                credentials: 'same-origin'
            })
                .then(function (response) {
                    if (response.status === 419) throw new Error('Session expired (419). Refresh and sign in again.');
                    if (!response.ok) throw new Error('Server returned HTTP ' + response.status + '.');
                    const disposition = response.headers.get('Content-Disposition') || '';
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
                    clearBusy();
                });
            return;
        }

        // Export forms that download into a hidden iframe stay on the page:
        // spin only the clicked Export button, then reset it once the
        // iframe finishes (with a safety timeout so it never sticks).
        if (form.target === 'exportFrame' || (submitter && submitter.getAttribute('formtarget') === 'exportFrame')) {
            form.dataset.submitting = 'true';
            markBusy();

            const resetTimer = window.setTimeout(function () {
                clearBusy();
            }, 2500);

            const exportFrame = document.getElementById('exportFrame');
            if (exportFrame) {
                exportFrame.addEventListener('load', function onExportLoad() {
                    window.clearTimeout(resetTimer);
                    clearBusy();
                    exportFrame.removeEventListener('load', onExportLoad);
                });
            } else {
                window.setTimeout(function () { clearBusy(); }, 800);
            }
            // Let the native iframe-targeted submit proceed.
            return;
        }

        // Normal GET search forms navigate away: only spin the clicked Search
        // button and leave it enabled (no disable, so Back/restore keeps working).
        if (form.method.toUpperCase() === 'GET') {
            form.dataset.submitting = 'true';
            busyButtons.forEach(function (button) {
                button.setAttribute('aria-busy', 'true');
                button.classList.add('is-loading');
            });
            return;
        }

        form.dataset.submitting = 'true';
        markBusy();
    }, true);
</script>
