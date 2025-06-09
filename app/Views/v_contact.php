<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
        <!-- nambah sendiri pakai boostrap -->
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Nama email</label>
            <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="nama123@contoh.com">
        </div>
            <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Pesan</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Trimakasih sudah membantu..."></textarea>
        </div>
        <div class="text">
            <button type="submit" class="btn btn-primary">Kirim</button>
        </div>
<?= $this->endSection() ?>