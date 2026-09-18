<div class="row">

    <div class="col-md">
        <div class="alert alert-success" role="alert">
            <h4 class="text-center font-weight-bold">TOKEN MASUK</h4>
        </div>

        <div class="row">
            <div class="col-md">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <div class="mb-2">
                                <button id="btn-reload-page" class="btn btn-secondary btn-sm" hidden>Reload Page
                                    (F5)</button>
                            </div>
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr class="text-center">
                                        <th scope="col">
                                            <h6 class="font-weight-bold" style="text-transform: uppercase;">#</h6>
                                        </th>
                                        <th scope="col">
                                            <h6 class="font-weight-bold" style="text-transform: uppercase;">ID TOKEN
                                            </h6>
                                        </th>
                                        <th scope="col">
                                            <h6 class="font-weight-bold" style="text-transform: uppercase;">TOKEN MASUK
                                            </h6>
                                        </th>
                                        <th scope="col">
                                            <h6 class="font-weight-bold" style="text-transform: uppercase;">AKSI
                                            </h6>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <?php
                                        $no = 1;
                                        foreach ($token_masuk as $row) {
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
                                                    <input type="text" value="<?= $row['token_masuk']; ?>"
                                                        name="token_masuk" hidden>
                                                    <h5 class="text-center">
                                                       <span class="badge badge-warning token-countdown"
      														 data-remaining="<?= (int)$row['remaining_seconds']; ?>">
													   </span>
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
document.addEventListener('DOMContentLoaded', function () {

    const forms = document.querySelectorAll('.form-refresh-token');

    if (!forms.length) return;

    forms.forEach(function (form) {

        const countdown = form.querySelector('.token-countdown');

        // Ambil waktu expired dari database
        const initialRemaining = Number(countdown.dataset.remaining);
		const expiry = Date.now() + (initialRemaining * 1000);

        let timer;
        let refreshing = false;

        function tampilkanWaktu() {

            const now = Date.now();

            let remaining = Math.ceil((expiry - now) / 1000);

            if (remaining < 0) {
                remaining = 0;
            }

            const minutes = Math.floor(remaining / 60);
            const seconds = remaining % 60;

            countdown.textContent =
                String(minutes).padStart(2, '0') +
                ':' +
                String(seconds).padStart(2, '0');

            if (remaining <= 0) {

                clearInterval(timer);

                if (refreshing) {
                    return;
                }

                refreshing = true;

                const data = new FormData(form);

                fetch(form.action, {
                    method: 'POST',
                    body: data,
                    credentials: 'same-origin'
                })
                .then(function () {

                    window.location.href =
                        '<?= base_url("Dashboard/token") ?>';

                })
                .catch(function (error) {

                    console.error('Gagal refresh token:', error);

                    refreshing = false;

                });
            }
        }

        tampilkanWaktu();

        timer = setInterval(tampilkanWaktu, 1000);

    });

});
</script>

            </div>
        </div>
    </div>
    <div class="col-md">
        <div class="alert alert-success" role="alert">
            <h4 class="text-center font-weight-bold text-uppercase">TOKEN keluar</h4>
        </div>
        <div class="row">
            <div class="col-md">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr class="text-center">
                                        <th scope="col">
                                            <h6 class="font-weight-bold" style="text-transform: uppercase;">#</h6>
                                        </th>
                                        <th scope="col">
                                            <h6 class="font-weight-bold" style="text-transform: uppercase;">ID TOKEN
                                            </h6>
                                        </th>
                                        <th scope="col">
                                            <h6 class="font-weight-bold" style="text-transform: uppercase;">TOKEN keluar
                                            </h6>
                                        </th>
                                        <th scope="col">
                                            <h6 class="font-weight-bold" style="text-transform: uppercase;">AKSI</h6>
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
                                                    <?= $row['token_keluar']; ?>
                                                </h6>
                                            </td>
                                            <td>
                                                <div class="row">
                                                    <div class="col-md">
                                                        <form action="<?= base_url() ?>Dashboard/refresh_token"
                                                            method="post">
                                                            <input type="text" value="<?= $row['id']; ?>" name="id" hidden>
                                                            <input type="text" value="<?= $row['token_keluar']; ?>"
                                                                name="token_keluar" hidden>
                                                            <h5 class="text-center">
                                                                <button type="submit"
                                                                    class="btn btn-primary btn-sm text-uppercase font-weight-bolder">refresh
                                                                </button>
                                                            </h5>
                                                        </form>
                                                    </div>
                                                    <div class="col-md">
                                                        <form action="<?= base_url() ?>Dashboard/hapus_token_keluar"
                                                            method="post">
                                                            <input type="text" value="<?= $row['id']; ?>" name="id" hidden>
                                                            <input type="text" value="<?= $row['token_keluar']; ?>"
                                                                name="token_keluar" hidden>
                                                            <h5 class="text-center">
                                                                <button type="submit"
                                                                    class="btn btn-danger btn-sm text-uppercase font-weight-bolder">hapus
                                                                </button>
                                                            </h5>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>