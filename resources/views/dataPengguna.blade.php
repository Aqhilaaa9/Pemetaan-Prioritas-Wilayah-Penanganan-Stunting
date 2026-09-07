@extends('layouts.app')

@section('title','Data Pengguna')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/user.css') }}">
@endpush

@section('content')

<div class="content">

    <div class="header-content">

        <h1 class="judul">
            Data Pengguna
        </h1>

        <a href="{{ route('createPengguna') }}" class="btn-tambah">
            + Tambah Pengguna
        </a>

    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <!-- TABEL 1: PENGGUNA TERDAFTAR (AKTIF) -->
    <div class="section-box">
        <h2 class="sub-judul">Daftar Pengguna Terdaftar</h2>

        <table class="table-users">

            <thead>

                <tr>

                    <th>No</th>
                    <th>Nama Depan</th>
                    <th>Nama Belakang</th>
                    <th>Username</th>
                    <th>Instansi</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Aksi</th>

                </tr>

            </thead>

            <tbody>

            @forelse($users as $item)

                <tr>

                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->nama_depan }}</td>
                    <td>{{ $item->nama_belakang }}</td>
                    <td>{{ $item->username }}</td>
                    <td>{{ $item->instansi }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ ucfirst($item->role) }}</td>
                    
                    <td class="aksi">
                        <a href="{{ route('editPengguna', $item->id) }}"
                            class="btn-edit">
                            Edit
                        </a>

                        <form action="{{ route('dataPengguna.destroy',$item->id) }}"
                              method="POST">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="btn-delete"
                                    onclick="return confirm('Yakin ingin menghapus pengguna ini?')">
                                Hapus
                            </button>

                        </form>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="8" style="text-align:center">
                        Belum ada data pengguna terdaftar.
                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>
    </div>

    <!-- TABEL 2: VERIFIKASI PENDAFTARAN PENGGUNA BARU (PENDING) -->
    <div class="section-box" style="margin-top: 45px;">
        <div class="pending-header">
            <h2 class="sub-judul">Verifikasi Pendaftaran Pengguna Baru</h2>
            @if(count($pendingUsers) > 0)
                <span class="badge-count">{{ count($pendingUsers) }} Pendaftaran Menunggu</span>
            @endif
        </div>

        <table class="table-users">

            <thead>

                <tr>

                    <th>No</th>
                    <th>Nama Depan</th>
                    <th>Nama Belakang</th>
                    <th>Username</th>
                    <th>Instansi</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Aksi Verifikasi</th>

                </tr>

            </thead>

            <tbody>

            @forelse($pendingUsers as $item)

                <tr>

                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->nama_depan }}</td>
                    <td>{{ $item->nama_belakang }}</td>
                    <td>{{ $item->username }}</td>
                    <td>{{ $item->instansi }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ ucfirst($item->role) }}</td>
                    
                    <td class="aksi">
                        <form action="{{ route('dataPengguna.approve', $item->id) }}"
                              method="POST">
                            @csrf
                            <button type="submit"
                                    class="btn-approve"
                                    onclick="return confirm('Apakah Anda yakin ingin menyetujui pendaftaran pengguna ini?')">
                                Terima
                            </button>
                        </form>

                        <form action="{{ route('dataPengguna.reject', $item->id) }}"
                              method="POST">
                            @csrf
                            <button type="submit"
                                    class="btn-reject"
                                    onclick="return confirm('Apakah Anda yakin ingin menolak pendaftaran pengguna ini?')">
                                Tolak
                            </button>
                        </form>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="8" style="text-align:center">
                        Tidak ada pendaftaran pengguna baru yang menunggu verifikasi.
                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>
    </div>

</div>

@endsection