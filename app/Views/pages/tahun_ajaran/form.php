<?= $this->extend('layouts/template') ?>
<?= $this->section('title') ?>Form Tahun Ajaran<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- WRAPPER AGAR FORM DI TENGAH AREA MENU -->
<div class="w-full flex justify-center">

    <!-- CARD FORM -->
    <div class="w-full max-w-4xl bg-white rounded-2xl shadow-md border border-gray-200">

        <!-- HEADER -->
        <div class="px-6 py-4 border-b">
            <h2 class="text-xl font-semibold text-gray-800">
                <?= isset($academicYear) ? 'Edit Tahun Ajaran' : 'Tambah Tahun Ajaran' ?>
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                Atur periode tahun ajaran sekolah
            </p>
        </div>

        <!-- BODY -->
        <div class="p-6">

            <?php if (session('errors')) : ?>
                <div class="mb-6 rounded-lg bg-red-50 border border-red-200 p-4 text-sm text-red-700">
                    <strong class="block mb-1">Terjadi kesalahan:</strong>
                    <ul class="list-disc list-inside">
                        <?php foreach (session('errors') as $error) : ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?= isset($academicYear)
                    ? site_url('admin/tahun-ajaran/' . $academicYear['id'])
                    : site_url('admin/tahun-ajaran') ?>"
                  method="post"
                  class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <?= csrf_field() ?>
                <?php if (isset($academicYear)) : ?>
                    <input type="hidden" name="_method" value="PUT">
                <?php endif; ?>

                <!-- TAHUN AJARAN -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Tahun Ajaran
                    </label>
                    <input type="text"
                           name="year"
                           value="<?= old('year', $academicYear['year'] ?? '') ?>"
                           placeholder="Contoh: 2026/2027"
                           class="w-full rounded-lg border-gray-300 bg-gray-50 text-sm focus:border-sky-500 focus:ring focus:ring-sky-200"
                           required>
                </div>

                <!-- TANGGAL MULAI -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Tanggal Mulai
                    </label>
                    <input type="date"
                           name="start_date"
                           value="<?= old('start_date', $academicYear['start_date'] ?? '') ?>"
                           class="w-full rounded-lg border-gray-300 bg-gray-50 text-sm focus:border-sky-500 focus:ring focus:ring-sky-200"
                           required>
                </div>

                <!-- TANGGAL SELESAI -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Tanggal Selesai
                    </label>
                    <input type="date"
                           name="end_date"
                           value="<?= old('end_date', $academicYear['end_date'] ?? '') ?>"
                           class="w-full rounded-lg border-gray-300 bg-gray-50 text-sm focus:border-sky-500 focus:ring focus:ring-sky-200"
                           required>
                </div>

                <!-- STATUS -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Status Tahun Ajaran
                    </label>
                    <?php $statusValue = old('status', $academicYear['status'] ?? 'Tidak Aktif'); ?>
                    <div class="flex items-center gap-6">
                        <label class="flex items-center gap-2 text-sm">
                            <input type="radio"
                                   name="status"
                                   value="Aktif"
                                   class="text-sky-600 focus:ring-sky-500"
                                   <?= $statusValue === 'Aktif' ? 'checked' : '' ?>>
                            Aktif
                        </label>
                        <label class="flex items-center gap-2 text-sm">
                            <input type="radio"
                                   name="status"
                                   value="Tidak Aktif"
                                   class="text-sky-600 focus:ring-sky-500"
                                   <?= $statusValue === 'Tidak Aktif' ? 'checked' : '' ?>>
                            Tidak Aktif
                        </label>
                    </div>
                </div>

                <!-- FOOTER -->
                <div class="md:col-span-2 flex justify-end gap-3 pt-4 border-t">
                    <a href="<?= site_url('admin/tahun-ajaran') ?>"
                       class="px-4 py-2 text-sm font-medium bg-gray-100 rounded-lg hover:bg-gray-200">
                        Batal
                    </a>
                    <button type="submit"
                            class="px-5 py-2 text-sm font-medium text-white bg-sky-600 rounded-lg hover:bg-sky-700">
                        Simpan
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
