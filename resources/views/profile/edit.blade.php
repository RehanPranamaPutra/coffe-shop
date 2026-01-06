@extends('layouts.app') {{-- Pastikan nama file layout utama Anda adalah app.blade.php di folder layouts --}}

@section('title', 'Edit Profil - Access Coffee')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">

    <!-- Bagian Atas: Header Halaman -->
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Pengaturan Profil</h2>
        <p class="text-gray-600">Update informasi akun dan kata sandi Anda.</p>
    </div>

    <!-- Update Profile Information -->
    <div class="p-4 sm:p-8 bg-white shadow-sm border border-gray-100 sm:rounded-2xl">
        <div class="max-w-xl">
            @include('profile.partials.update-profile-information-form')
        </div>
    </div>

    <!-- Update Password -->
    <div class="p-4 sm:p-8 bg-white shadow-sm border border-gray-100 sm:rounded-2xl">
        <div class="max-w-xl">
            @include('profile.partials.update-password-form')
        </div>
    </div>

    <!-- Delete User -->
    <div class="p-4 sm:p-8 bg-white shadow-sm border border-gray-100 sm:rounded-2xl">
        <div class="max-w-xl">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</div>
@endsection
