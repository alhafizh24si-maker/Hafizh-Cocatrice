@extends('layouts.admin.app')

@section('content')
    {{-- main content --}}
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
                <li class="breadcrumb-item"><a href="#">User</a></li>
            </ol>
        </nav>
        <div class="d-flex justify-content-between w-100 flex-wrap">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">Data User</h1>
                <p class="mb-0">List data seluruh User</p>
            </div>

            <div>
                <a href="{{ route('user.create') }}" class="btn btn-success text-white">
                    <i class="fas fa-plus me-1"></i> Tambah User
                </a>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            {!! session('success') !!}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-12 mb-4">
            <div class="card border-0 shadow mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table-user" class="table table-centered table-nowrap mb-0 rounded">
                            <thead class="thead-light">
                                <tr>
                                    <th class="border-0">No</th>
                                    <th class="border-0">Foto Profil</th>
                                    <th class="border-0">Nama Lengkap</th>
                                    <th class="border-0">Email</th>
                                    <th class="border-0">Role</th>
                                    <th class="border-0 rounded-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataUser as $index => $item)
                                    <tr>
                                        <td>{{ ($dataUser->currentPage() - 1) * $dataUser->perPage() + $loop->iteration }}</td>
                                        <td>
                                            @if($item->profile_picture_url)
                                                <img src="{{ $item->profile_picture_url }}" alt="Profile Picture"
                                                    class="rounded-circle" width="50" height="50"
                                                    style="object-fit: cover;">
                                            @else
                                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center"
                                                    style="width: 50px; height: 50px;">
                                                    <i class="fas fa-user text-secondary"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->role }}</td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <!-- Edit Button -->
                                                <a href="{{ route('user.edit', $item->id) }}"
                                                   class="btn btn-warning btn-sm d-flex align-items-center">
                                                    <i class="fas fa-edit me-1"></i>
                                                    <span>Edit</span>
                                                </a>

                                                <!-- Hapus Button -->
                                                @if($item->role != 'superadmin' || auth()->user()->role == 'superadmin')
                                                <form action="{{ route('user.destroy', $item->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm d-flex align-items-center"
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                                        <i class="fas fa-trash me-1"></i>
                                                        <span>Hapus</span>
                                                    </button>
                                                </form>
                                                @endif

                                                <!-- File/Dokumen Button -->
                                                <a href="{{ route('user.documents', $item->id) }}"
                                                    class="btn btn-info btn-sm d-flex align-items-center">
                                                    <i class="fas fa-file me-1"></i>
                                                    <span>File</span>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($dataUser->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $dataUser->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }

    .btn-sm i {
        font-size: 0.875rem;
    }

    .gap-2 > * {
        margin-right: 0.5rem;
    }

    .gap-2 > *:last-child {
        margin-right: 0;
    }
</style>
@endpush

@push('scripts')
<script>
    // Inisialisasi tooltip jika diperlukan
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>
@endpush
