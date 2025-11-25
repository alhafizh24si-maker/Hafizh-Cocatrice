@extends('layouts.admin.app')

@section('content')
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
            <li class="breadcrumb-item"><a href="{{ route('user.edit', $user->id) }}">{{ $user->name }}</a></li>
            <li class="breadcrumb-item active">Dokumen</li>
        </ol>
    </nav>

    <div class="d-flex justify-content-between w-100 flex-wrap">
        <div class="mb-3 mb-lg-0">
            <h1 class="h4">Kelola Dokumen</h1>
            <p class="mb-0">Upload dan kelola dokumen untuk {{ $user->name }}</p>
        </div>
        <div>
            <a href="{{ route('user.edit', $user->id) }}" class="btn btn-primary">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke User
            </a>
        </div>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row">
    <!-- Upload Section -->
    <div class="col-lg-4 mb-4">
        <div class="card border-0 shadow">
            <div class="card-header bg-white">
                <h5 class="mb-0"><i class="fas fa-upload me-2"></i>Upload Dokumen</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('user.documents.store', $user->id) }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                    @csrf

                    <div class="mb-3">
                        <label for="documents" class="form-label">Pilih File</label>
                        <input type="file"
                               class="form-control @error('documents.*') is-invalid @enderror"
                               id="documents"
                               name="documents[]"
                               multiple
                               accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.xls,.xlsx,.txt"
                               required>
                        @error('documents.*')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            Format: JPG, PNG, PDF, DOC, DOCX, XLS, XLSX, TXT. Max 5MB per file.
                        </div>
                    </div>

                    <!-- File Preview -->
                    <div id="filePreview" class="mb-3"></div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi (Opsional)</label>
                        <input type="text"
                               class="form-control"
                               name="descriptions[]"
                               placeholder="Deskripsi untuk semua file">
                    </div>

                    <button type="submit" class="btn btn-success w-100">
                        <i class="fas fa-cloud-upload-alt me-2"></i>Upload Files
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Documents List -->
    <div class="col-lg-8">
        <div class="card border-0 shadow">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-files me-2"></i>Daftar Dokumen</h5>
                <span class="badge bg-primary">{{ $user->documents->count() }} Files</span>
            </div>
            <div class="card-body">
                @if($user->documents->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>File</th>
                                    <th>Deskripsi</th>
                                    <th>Ukuran</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user->documents as $document)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="fas {{ $document->file_icon }} fa-2x me-3"></i>
                                            <div>
                                                <div class="fw-bold">{{ $document->original_name }}</div>
                                                <small class="text-muted">{{ strtoupper(pathinfo($document->original_name, PATHINFO_EXTENSION)) }} File</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        {{ $document->description ?? '-' }}
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $document->formatted_file_size }}</span>
                                    </td>
                                    <td>
                                        <small>{{ $document->created_at->format('d/m/Y H:i') }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            @if(str_contains($document->mime_type, 'image') || str_contains($document->mime_type, 'pdf'))
                                            <a href="{{ route('documents.view', $document->id) }}"
                                               class="btn btn-outline-primary"
                                               target="_blank"
                                               data-bs-toggle="tooltip"
                                               title="Lihat File">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @endif

                                            <a href="{{ route('documents.download', $document->id) }}"
                                               class="btn btn-outline-success"
                                               data-bs-toggle="tooltip"
                                               title="Download">
                                                <i class="fas fa-download"></i>
                                            </a>

                                            <button type="button"
                                                    class="btn btn-outline-danger"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal{{ $document->id }}"
                                                    data-bs-toggle="tooltip"
                                                    title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>

                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="deleteModal{{ $document->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Hapus Dokumen</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Apakah Anda yakin ingin menghapus file <strong>{{ $document->original_name }}</strong>?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <form action="{{ route('documents.destroy', $document->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-folder-open fa-4x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum ada dokumen</h5>
                        <p class="text-muted">Upload file pertama Anda menggunakan form di samping.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .file-preview-item {
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
        padding: 0.75rem;
        margin-bottom: 0.5rem;
    }
    .file-preview-item:last-child {
        margin-bottom: 0;
    }
</style>
@endpush

@push('scripts')
<script>
    // File preview functionality
    document.getElementById('documents').addEventListener('change', function(e) {
        const files = e.target.files;
        const preview = document.getElementById('filePreview');
        preview.innerHTML = '';

        if (files.length > 0) {
            const fileList = document.createElement('div');
            fileList.className = 'list-group';

            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const listItem = document.createElement('div');
                listItem.className = 'file-preview-item';

                const fileInfo = document.createElement('div');
                fileInfo.className = 'd-flex justify-content-between align-items-center';

                const fileName = document.createElement('span');
                fileName.className = 'fw-bold';
                fileName.textContent = file.name;

                const fileSize = document.createElement('span');
                fileSize.className = 'text-muted small';
                fileSize.textContent = formatFileSize(file.size);

                fileInfo.appendChild(fileName);
                fileInfo.appendChild(fileSize);
                listItem.appendChild(fileInfo);
                fileList.appendChild(listItem);
            }

            preview.appendChild(fileList);
        }
    });

    // Format file size
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
</script>
@endpush
