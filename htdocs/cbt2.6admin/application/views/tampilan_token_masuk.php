<div class="alert alert-success" role="alert">
    <h4 class="text-center font-weight-bold">TOKEN MASUK</h4>
</div>

<div class="row">
    <div class="col-md">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <div class="mb-2">
                        <button id="btn-reload-page" class="btn btn-secondary btn-sm" hidden>Reload Page (F5)</button>
                    </div>
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th scope="col">
                                    <h6 class="font-weight-bold" style="text-transform: uppercase;">#</h6>
                                </th>
                                <th scope="col">
                                    <h6 class="font-weight-bold" style="text-transform: uppercase;">ID TOKEN</h6>
                                </th>
                                <th scope="col">
                                    <h6 class="font-weight-bold" style="text-transform: uppercase;">TOEKN KELUAR</h6>
                                </th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <?php
                                $no = 1;
                                foreach ($token as $row) {
                                ?>
                                    <td class="text-centers">
                                        <h6><?php echo $no++; ?></h6>
                                    </td>
                                    <td>
                                        <h6 class="text-uppercase text-center">
                                            <?= $row['id']; ?>
                                        </h6>
                                    </td>
                                    <td>
                                        <h6 class="text-uppercase text-center">
                                            <?= $row['token_masuk']; ?>
                                        </h6>
                                    </td>
                                    <td>
                                        <form class="form-refresh-token"
                                            action="<?= base_url() ?>Dashboard/refresh_token_masuk" method="post">
                                            <input type="text" value="<?= $row['id']; ?>" name="id" hidden>
                                            <input type="text" value="<?= $row['token_masuk']; ?>" name="token_masuk"
                                                hidden>
                                            <h5 class="text-center">
                                                <span class="badge badge-warning token-countdown"
                                                    data-expiry="<?= strtotime($row['token_expired_at']) * 1000 ?>"></span>
                                                <button type="submit"
                                                    class="btn btn-primary btn-sm text-uppercase font-weight-bolder btn-refresh-token"
                                                    hidden>refresh
                                                    token</button>
                                            </h5>

                                        </form>
                                    </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const reloadBtn = document.getElementById('btn-reload-page');
                const forms = document.querySelectorAll('.form-refresh-token');

                if (reloadBtn) {
                    reloadBtn.addEventListener('click', function() {
                        location.reload();
                    });
                }

                if (!forms.length) return;

                function refreshToken(form) {
                    const url = form.action;
                    const data = new FormData(form);
                    const countdown = form.querySelector('.token-countdown');
                    countdown.dataset.refreshing = 'true';
                    fetch(url, {
                        method: 'POST',
                        body: data,
                        credentials: 'same-origin'
                    }).then(function(response) {
                        return response.text();
                    }).then(function() {
                        location.reload();
                    }).catch(function(err) {
                        console.error('Refresh failed', err);
                    });
                }

                forms.forEach(function(form) {
                    const countdown = form.querySelector('.token-countdown');
                    const serverExpiry = Number(countdown.dataset.expiry);
                    const expiry = Math.min(serverExpiry, Date.now() + 60000);
                    let timer;

                    function updateCountdown() {
                        const remaining = Math.max(0, Math.ceil((expiry - Date.now()) / 1000));
                        const minutes = String(Math.floor(remaining / 60)).padStart(2, '0');
                        const seconds = String(remaining % 60).padStart(2, '0');
                        countdown.textContent = minutes + ':' + seconds;

                        if (remaining <= 0) {
                            clearInterval(timer);
                            if (!countdown.dataset.refreshing) {
                                refreshToken(form);
                            }
                        }
                    }

                    updateCountdown();
                    timer = setInterval(updateCountdown, 1000);
                });
            });
        </script>
    </div>
</div>