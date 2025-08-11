<form action="{{ $action }}" method="POST" style="display:inline;">
    @csrf
    @method('DELETE')
    <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('{{ $message ?? 'Yakin hapus data ini?' }}')">Hapus</button>
</form>