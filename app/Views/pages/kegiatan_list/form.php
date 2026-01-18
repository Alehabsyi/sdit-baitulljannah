<?= $this->extend('layouts/template') ?>
<?= $this->section('title') ?>Form Nama Kegiatan<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- WRAPPER agar memenuhi area menu & center -->
<div class="flex justify-center">
    <div class="w-full max-w-4xl bg-white rounded-2xl border border-gray-300 shadow-lg px-6 py-8">

        <h2 class="text-2xl font-semibold text-gray-700 mb-6">
            <?= isset($activityName) ? 'Form Edit Nama Kegiatan' : 'Form Tambah Nama Kegiatan' ?>
        </h2>

        <?php if (session('errors')): ?>
            <div class="px-4 py-3 mb-6 text-red-800 bg-red-100 border border-red-400 rounded-lg">
                <strong class="font-bold">Terdapat kesalahan:</strong>
                <ul class="mt-2 list-disc list-inside text-sm">
                    <?php foreach (session('errors') as $error): ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach ?>
                </ul>
            </div>
        <?php endif; ?>

        <form
            action="<?= isset($activityName) ? site_url('admin/nama-kegiatan/' . $activityName['id']) : site_url('admin/nama-kegiatan') ?>"
            method="post">

            <?= csrf_field() ?>
            <?php if (isset($activityName)): ?>
                <input type="hidden" name="_method" value="PUT">
            <?php endif; ?>

            <!-- Nama Kegiatan -->
            <div class="mb-5">
                <label class="block mb-2 text-sm font-medium text-gray-900">
                    Nama Kegiatan
                </label>
                <input type="text" name="name"
                    value="<?= old('name', $activityName['name'] ?? '') ?>"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-sky-200"
                    placeholder="Contoh: Sholat Dhuha"
                    required>
            </div>

            <!-- Tipe -->
            <div class="mb-5">
                <label class="block mb-2 text-sm font-medium text-gray-900">
                    Tipe Kegiatan
                </label>
                <?php $selectedType = old('type', $activityName['type'] ?? 'Sekolah'); ?>
                <select name="type" id="type_selector"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-sky-200"
                    required>
                    <option value="Sekolah" <?= $selectedType == 'Sekolah' ? 'selected' : '' ?>>Sekolah (Terjadwal)</option>
                    <option value="Rumah" <?= $selectedType == 'Rumah' ? 'selected' : '' ?>>Rumah (Tidak Terjadwal)</option>
                    <option value="Masuk" <?= $selectedType == 'Masuk' ? 'selected' : '' ?>>Presensi Masuk</option>
                    <option value="Pulang" <?= $selectedType == 'Pulang' ? 'selected' : '' ?>>Presensi Pulang</option>
                </select>
            </div>

            <!-- Jadwal -->
            <div id="schedule-fields" class="hidden">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900">
                            Waktu Mulai
                        </label>
                        <?php $startTime = old('start_time', $activityName['start_time'] ?? ''); ?>
                        <input type="time" name="start_time"
                            value="<?= !empty($startTime) ? substr($startTime, 0, 5) : '' ?>"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-sky-200">
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900">
                            Waktu Selesai
                        </label>
                        <?php $endTime = old('end_time', $activityName['end_time'] ?? ''); ?>
                        <input type="time" name="end_time"
                            value="<?= !empty($endTime) ? substr($endTime, 0, 5) : '' ?>"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-sky-200">
                    </div>
                </div>
            </div>

            <!-- ACTION -->
            <div class="flex justify-end gap-2 border-t pt-4">
                <a href="<?= site_url('admin/nama-kegiatan') ?>"
                    class="px-4 py-2 text-sm font-medium bg-gray-200 rounded-lg hover:bg-gray-300">
                    Batal
                </a>
                <button type="submit"
                    class="px-4 py-2 text-sm font-medium text-white bg-sky-600 rounded-lg hover:bg-sky-700">
                    <?= isset($activityName) ? 'Simpan Perubahan' : 'Simpan' ?>
                </button>
            </div>

        </form>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function () {
        const typeSelector = $('#type_selector');
        const scheduleFields = $('#schedule-fields');

        function toggleScheduleFields() {
            if (typeSelector.val() !== 'Rumah') {
                scheduleFields.show();
            } else {
                scheduleFields.hide();
            }
        }

        toggleScheduleFields();
        typeSelector.on('change', toggleScheduleFields);
    });
</script>
<?= $this->endSection() ?>
