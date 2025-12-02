@extends('layouts.admin.app')
@section('content')
        {{-- start main content --}}
        <div class="py-4">
            <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
                <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                    <li class="breadcrumb-item">
                        <a href="#">
                            <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                </path>
                            </svg>
                        </a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('user.index') }}">User</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit User</li>
                </ol>
            </nav>
            <div class="d-flex justify-content-between w-100 flex-wrap">
                <div class="mb-3 mb-lg-0">
                    <h1 class="h4">Edit User</h1>
                    <p class="mb-0">Form untuk mengedit data User.</p>
                </div>
                <div>
                    <a href="{{ route('user.index') }}" class="btn btn-primary"><i class="far fa-question-circle me-1"></i> Kembali</a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 mb-4">
                <div class="card border-0 shadow components-section">
                    <div class="card-body">
                        <form action="{{ route('user.update', $dataUser->id) }}" method="POST" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="row mb-4">
                                <div class="col-lg-4 col-sm-6">
                                    <!-- Profile Picture Preview -->
                                    <div class="mb-4 text-center">
                                        <label class="form-label d-block">Foto Profil Saat Ini</label>
                                        <img src="{{ $dataUser->profile_picture_url }}"
                                             id="profile-picture-preview"
                                             alt="Profile Picture"
                                             class="rounded-circle border"
                                             width="150"
                                             height="150"
                                             style="object-fit: cover;">
                                        <div class="mt-2">
                                            @if($dataUser->profile_picture)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="remove_profile_picture" id="remove_profile_picture" value="1">
                                                    <label class="form-check-label text-danger" for="remove_profile_picture">
                                                        Hapus Foto Profil
                                                    </label>
                                                </div>
                                            @else
                                                <span class="text-muted">Belum ada foto profil</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Profile Picture Upload -->
                                    <div class="mb-3">
                                        <label for="profile_picture" class="form-label">Upload Foto Profil Baru</label>
                                        <input type="file" id="profile_picture" name="profile_picture" class="form-control" accept="image/*" onchange="previewImage(this)">
                                        <div class="form-text">Format: JPG, PNG, GIF. Maksimal: 2MB</div>
                                        @error('profile_picture')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-4 col-sm-12">
                                    <!-- Name -->
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nama Lengkap</label>
                                        <input type="text" id="name" class="form-control" name="name"
                                            value="{{ old('name', $dataUser->name) }}" required>
                                        @error('name')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Email -->
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" id="email" class="form-control" name="email"
                                            value="{{ old('email', $dataUser->email) }}" required>
                                        @error('email')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Password -->
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password Baru</label>
                                        <input type="password" id="password" class="form-control" name="password"
                                            placeholder="Kosongkan jika tidak ingin mengubah">
                                        @error('password')
                                            <div class="text-danger small">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Role -->
                                    <div class="mb-3">
                                        <label for="role" class="form-label">role</label>
                                        <select id="role" name="role" class="form-select">
                                            <option value="">-- Pilih --</option>
                                            <option value="Admin" >Admin</option>
                                            <option value="Pelanggan">Pelanggan</option>
                                            <option value="Mitra">Mitra</option>
                                        </select>
                                    </div>

                                    <!-- Password Confirmation -->
                                    <div class="mb-3">
                                        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                                        <input type="password" id="password_confirmation" class="form-control" name="password_confirmation"
                                            placeholder="Kosongkan jika tidak ingin mengubah">
                                    </div>

                                    <!-- Buttons -->
                                    <div class="">
                                        <button type="submit" class="btn btn-info">Simpan Perubahan</button>
                                        <a href="{{ route('user.index') }}"
                                            class="btn btn-outline-secondary ms-2">Batal</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
        function previewImage(input) {
            const preview = document.getElementById('profile-picture-preview');
            const file = input.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                // Uncheck remove profile picture when new image is selected
                document.getElementById('remove_profile_picture').checked = false;
            }

            if (file) {
                reader.readAsDataURL(file);
            }
        }

        // Handle remove profile picture checkbox
        document.getElementById('remove_profile_picture')?.addEventListener('change', function() {
            const preview = document.getElementById('profile-picture-preview');
            if (this.checked) {
                preview.src = '{{ asset("assets/images/default-avatar.png") }}';
                document.getElementById('profile_picture').value = '';
            } else {
                preview.src = '{{ $dataUser->profile_picture_url }}';
            }
        });
        </script>
        {{-- end main content --}}
@endsection
