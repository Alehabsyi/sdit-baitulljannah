<?= $this->extend('layouts/template') ?>
<?= $this->section('title') ?>Form Kelas<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- WRAPPER: AGAR FORM DI TENGAH AREA MENU -->
<div class="w-full flex justify-center">

    <!-- CARD FORM -->
    <div class="w-full max-w-4xl bg-white rounded-2xl shadow-md border border-gray-200">

        <!-- HEADER -->
        <div class="px-6 py-4 border-b">
            <h2 class="text-xl font-semibold text-gray-800">
                <?= isset($classData) ? 'Edit Kelas' : 'Tambah Kelas' ?>
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                Lengkapi data kelas dengan benar
            </p>
        </div>

        <!-- BODY -->
        <div class="p-6">

            <?php if (session('errors')) : ?>
                <div class="mb-6 rounded-lg bg-red-50 border border-red-200 p-4 text-sm text-red-700">
                    <?= validation_list_errors('my_list') ?>
                </div>
            <?php endif; ?>

            <form action="<?= isset($classData)
                    ? site_url('admin/kelas/' . $classData['id'])
                    : site_url('admin/kelas') ?>"
                  method="post"
                  class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <?= csrf_field() ?>
                <?php if (isset($classData)) : ?>
                    <input type="hidden" name="_method" value="PUT">
                <?php endif; ?>

                <!-- NAMA KELAS -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Nama Kelas
                    </label>
                    <input type="text"
                           name="name"
                           value="<?= old('name', $classData['name'] ?? '') ?>"
                           class="w-full rounded-lg border-gray-300 bg-gray-50 text-sm focus:border-purple-500 focus:ring focus:ring-purple-200"
                           required>
                </div>

                <!-- TAHUN AJARAN -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Tahun Ajaran
                    </label>
                    <select name="academic_year_id"
                            class="w-full rounded-lg border-gray-300 bg-gray-50 text-sm focus:border-purple-500 focus:ring focus:ring-purple-200"
                            required>
                        <option value="">-- Pilih Tahun Ajaran --</option>
                        <?php $selectedYear = old('academic_year_id', $classData['academic_year_id'] ?? ''); ?>
                        <?php foreach ($academicYears as $year) : ?>
                            <option value="<?= $year['id'] ?>"
                                <?= $selectedYear == $year['id'] ? 'selected' : '' ?>>
                                <?= esc($year['year']) ?> (<?= esc($year['status']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- WALI KELAS -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Wali Kelas (Opsional)
                    </label>
                    <select name="teacher_id"
                            class="w-full rounded-lg border-gray-300 bg-gray-50 text-sm focus:border-purple-500 focus:ring focus:ring-purple-200">
                        <option value="">-- Tidak Ada Wali Kelas --</option>
                        <?php $selectedTeacher = old('teacher_id', $classData['teacher_id'] ?? ''); ?>
                        <?php foreach ($teachers as $teacher) : ?>
                            <option value="<?= $teacher['id'] ?>"
                                <?= $selectedTeacher == $teacher['id'] ? 'selected' : '' ?>>
                                <?= esc($teacher['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- FOOTER -->
                <div class="md:col-span-2 flex justify-end gap-3 pt-4 border-t">
                    <a href="<?= site_url('admin/kelas') ?>"
                       class="px-4 py-2 text-sm font-medium bg-gray-100 rounded-lg hover:bg-gray-200">
                        Batal
                    </a>
                    <button type="submit"
                            class="px-5 py-2 text-sm font-medium text-white bg-purple-600 rounded-lg hover:bg-purple-700">
                        <?= isset($classData) ? 'Simpan Perubahan' : 'Simpan' ?>
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
