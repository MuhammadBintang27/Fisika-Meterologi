@extends('admin.layouts.app')

@section('title', 'Peminjaman Pending')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Peminjaman Pending</h1>
            <p class="text-gray-600">Kelola permintaan peminjaman yang menunggu persetujuan</p>
        </div>
        <div class="flex items-center space-x-2">
            <a href="{{ route('admin.loans.index') }}" 
               class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-list mr-2"></i>
                Semua Peminjaman
            </a>
        </div>
    </div>

    <!-- Status Filter -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.loans.index') }}" 
               class="px-4 py-2 rounded-lg font-medium text-gray-600 hover:bg-gray-100">
                Semua
            </a>
            <a href="{{ route('admin.loans.pending') }}" 
               class="px-4 py-2 rounded-lg font-medium bg-yellow-100 text-yellow-700">
                Pending
            </a>
            <a href="{{ route('admin.loans.approved') }}" 
               class="px-4 py-2 rounded-lg font-medium text-gray-600 hover:bg-gray-100">
                Disetujui
            </a>
            <a href="{{ route('admin.loans.completed') }}" 
               class="px-4 py-2 rounded-lg font-medium text-gray-600 hover:bg-gray-100">
                Selesai
            </a>
            <a href="{{ route('admin.loans.rejected') }}" 
               class="px-4 py-2 rounded-lg font-medium text-gray-600 hover:bg-gray-100">
                Ditolak
            </a>
        </div>
    </div>

    <!-- Pending Loans List -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6">
            @if($loans->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Peminjam
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Alat yang Dipinjam
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Periode Peminjaman
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tanggal Request
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($loans as $loan)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $loan->namaPeminjam }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $loan->noHp }}
                                            </div>
                                            @if($loan->tujuanPeminjaman)
                                                <div class="text-sm text-gray-500 line-clamp-1">
                                                    {{ Str::limit($loan->tujuanPeminjaman, 50) }}
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">
                                            @foreach($loan->items as $item)
                                                <div class="flex items-center space-x-2">
                                                    <span class="font-medium">{{ $item->alat->namaAlat }}</span>
                                                    <span class="text-gray-500">({{ $item->jumlah }})</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">
                                            <div>{{ \Carbon\Carbon::parse($loan->tanggal_pinjam)->format('d M Y') }}</div>
                                            <div class="text-gray-500">s/d</div>
                                            <div>{{ \Carbon\Carbon::parse($loan->tanggal_pengembalian)->format('d M Y') }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $loan->created_at->format('d M Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('admin.loans.show', $loan->id) }}" 
                                               class="text-blue-600 hover:text-blue-900">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <form method="POST" action="{{ route('admin.loans.destroy', $loan->id) }}" 
                                                  class="inline" 
                                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus data peminjaman ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $loans->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-check-circle text-green-400 text-4xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada peminjaman pending</h3>
                    <p class="text-gray-500">Semua permintaan peminjaman telah diproses</p>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.line-clamp-1 {
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection 
 