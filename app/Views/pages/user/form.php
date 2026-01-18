<?= $this->extend('layouts/template') ?>
<?= $this->section('title') ?>Form User Akun<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="w-full flex justify-center">
  <div class="w-full max-w-5xl bg-white rounded-2xl border border-gray-200 shadow-md px-8 py-8">

    <!-- HEADER -->
    <div class="text-center mb-8">
      <h2 class="text-2xl font-semibold text-gray-800">
        <?= isset($user) ? 'Edit User' : 'Tambah User' ?>
      </h2>
      <p class="text-sm text-gray-500 mt-1">
        Kelola data akun pengguna sistem
      </p>
    </div>

    <?php if (session('errors')) : ?>
      <div class="mb-6 rounded-lg bg-red-50 border border-red-300 p-4 text-red-700">
        <?= validation_list_errors('my_list') ?>
      </div>
    <?php endif; ?>

    <form action="<?= isset($user) ? site_url('admin/user/' . $user['id']) : site_url('admin/user') ?>"
          method="post"
          enctype="multipart/form-data"
          class="space-y-6">

      <?= csrf_field() ?>
      <?php if (isset($user)) : ?>
        <input type="hidden" name="_method" value="PUT">
      <?php endif; ?>

      <div>
        <label class="block mb-1 text-sm font-medium text-gray-700">Nama Lengkap</label>
        <input type="text"
               name="name"
               value="<?= old('name', $user['name'] ?? '') ?>"
               required
               class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2.5 text-sm
                      focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
      </div>

      <div>
        <label class="block mb-1 text-sm font-medium text-gray-700">Username</label>
        <input type="text"
               name="username"
               value="<?= old('username', $user['username'] ?? '') ?>"
               required
               class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2.5 text-sm
                      focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
      </div>

      <div>
        <label class="block mb-1 text-sm font-medium text-gray-700">Role</label>
        <?php $selectedRole = old('role', $user['role'] ?? ''); ?>
        <select name="role" required
                class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2.5 text-sm
                       focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
          <option value="">-- Pilih Role --</option>
          <option value="Admin" <?= $selectedRole == 'Admin' ? 'selected' : '' ?>>Admin</option>
          <option value="Guru" <?= $selectedRole == 'Guru' ? 'selected' : '' ?>>Guru</option>
          <option value="Wali Murid" <?= $selectedRole == 'Wali Murid' ? 'selected' : '' ?>>Wali Murid</option>
        </select>
      </div>

      <div>
        <label class="block mb-1 text-sm font-medium text-gray-700">Password</label>
        <input type="password"
               name="password"
               autocomplete="new-password"
               placeholder="<?= isset($user) ? 'Kosongkan jika tidak ingin mengubah' : '' ?>"
               class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2.5 text-sm
                      focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        <?php if (isset($user)): ?>
          <p class="mt-1 text-xs text-gray-500">Minimal 8 karakter.</p>
        <?php endif; ?>
      </div>

      <div>
        <label class="block mb-1 text-sm font-medium text-gray-700">Konfirmasi Password</label>
        <input type="password"
               name="pass_confirm"
               autocomplete="new-password"
               class="w-full rounded-lg border border-gray-300 bg-gray-50 px-4 py-2.5 text-sm
                      focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
      </div>

      <div>
        <label class="block mb-2 text-sm font-medium text-gray-700">Foto</label>
        <?php if (isset($user) && $user['photo']): ?>
          <img src="<?= base_url('Uploads/photos/' . $user['photo']) ?>"
               class="h-20 w-20 rounded-full object-cover border mb-3">
        <?php endif; ?>

        <input type="file"
               name="photo"
               accept="image/png, image/jpeg, image/jpg"
               class="w-full text-sm border border-gray-300 rounded-lg bg-gray-50
                      file:mr-4 file:py-2 file:px-4
                      file:rounded-lg file:border-0
                      file:text-sm file:font-semibold
                      file:bg-blue-50 file:text-blue-700
                      hover:file:bg-blue-100">
        <p class="mt-1 text-xs text-gray-500">PNG, JPG atau JPEG (maks. 1MB)</p>
      </div>

      <!-- BUTTON -->
      <div class="flex justify-end gap-3 pt-6 border-t">
        <a href="<?= site_url('admin/user') ?>"
           class="px-5 py-2.5 text-sm rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-700">
          Batal
        </a>
        <button type="submit"
                class="px-5 py-2.5 text-sm rounded-lg bg-blue-600 hover:bg-blue-700 text-white">
          <?= isset($user) ? 'Simpan Perubahan' : 'Simpan' ?>
        </button>
      </div>

    </form>
  </div>
</div>

<?= $this->endSection() ?>
