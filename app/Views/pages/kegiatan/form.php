<?= $this->extend('layouts/template') ?>
<?= $this->section('title') ?>Form Kegiatan Siswa<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="w-full flex justify-center">
  <div class="w-full max-w-5xl bg-white rounded-2xl border border-gray-200 shadow-md px-8 py-8">

    <!-- JUDUL -->
    <div class="text-center mb-8">
      <h2 class="text-2xl font-semibold text-gray-800">
        <?= isset($activity) ? 'Form Edit Kegiatan' : 'Form Catat Kegiatan' ?>
      </h2>
      <p class="text-sm text-gray-500 mt-1">
        Silakan lengkapi data kegiatan siswa dengan benar
      </p>
    </div>

    <?php if (session('errors')): ?>
      <div class="mb-6 rounded-lg bg-red-50 border border-red-300 p-4 text-red-700">
        <strong class="block mb-1">Terdapat kesalahan:</strong>
        <ul class="list-disc list-inside text-sm">
          <?php foreach (session('errors') as $error): ?>
            <li><?= esc($error) ?></li>
          <?php endforeach ?>
        </ul>
      </div>
    <?php endif; ?>

    <form action="<?= isset($activity) ? site_url('admin/kegiatan/'.$activity['id']) : site_url('admin/kegiatan') ?>"
          method="post"
          class="grid grid-cols-1 md:grid-cols-2 gap-6">

      <?= csrf_field() ?>
      <?php if (isset($activity)) : ?>
        <input type="hidden" name="_method" value="PUT">
      <?php endif; ?>

      <?php if (session()->get('role') === 'Admin'): ?>
      <div class="md:col-span-2">
        <label class="block mb-1 text-sm font-medium text-gray-700">Filter Siswa per Kelas</label>
        <select id="class_filter"
                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
          <option value="">-- Tampilkan Semua Siswa Aktif --</option>
          <?php foreach ($classes as $class): ?>
            <option value="<?= $class['id'] ?>"><?= esc($class['name']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <?php endif; ?>

      <div>
        <label class="block mb-1 text-sm font-medium text-gray-700">Siswa</label>
        <select name="student_id" id="student_id" required
                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
          <option value="">-- Pilih Siswa --</option>
          <?php $selectedStudent = old('student_id', $activity['student_id'] ?? ''); ?>
          <?php foreach ($students as $student): ?>
            <option value="<?= $student['id'] ?>"
                    data-class-id="<?= $student['class_id'] ?? '' ?>"
                    <?= $selectedStudent == $student['id'] ? 'selected' : '' ?>>
              <?= esc($student['full_name']) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div>
        <label class="block mb-1 text-sm font-medium text-gray-700">Jenis Kegiatan</label>
        <select name="activity_name_id" required
                class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
          <option value="">-- Pilih Kegiatan --</option>
          <?php $selectedActivity = old('activity_name_id', $activity['activity_name_id'] ?? ''); ?>
          <?php foreach ($activity_names as $item): ?>
            <option value="<?= $item['id'] ?>"
              <?= $selectedActivity == $item['id'] ? 'selected' : '' ?>>
              <?= esc($item['name']) ?> (<?= esc($item['type']) ?>)
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div>
        <label class="block mb-1 text-sm font-medium text-gray-700">Tanggal Kegiatan</label>
        <input type="date"
               name="activity_date"
               value="<?= old('activity_date', $activity['activity_date'] ?? date('Y-m-d')) ?>"
               class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm"
               required>
      </div>

      <div class="md:col-span-2">
        <label class="block mb-1 text-sm font-medium text-gray-700">Deskripsi / Catatan</label>
        <textarea name="description" rows="4"
                  class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm"><?= old('description', $activity['description'] ?? '') ?></textarea>
      </div>

      <!-- BUTTON -->
      <div class="md:col-span-2 flex justify-end gap-3 pt-6 border-t">
        <a href="<?= site_url('admin/kegiatan') ?>"
           class="px-5 py-2 text-sm rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-700">
          Batal
        </a>
        <button type="submit"
                class="px-5 py-2 text-sm rounded-lg bg-sky-600 hover:bg-sky-700 text-white">
          <?= isset($activity) ? 'Simpan Perubahan' : 'Simpan' ?>
        </button>
      </div>

    </form>
  </div>
</div>

<?= $this->endSection() ?>
