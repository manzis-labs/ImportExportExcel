<form action="/update/{{ $data->id }}" method="POST">
    @csrf

    <input type="text" name="nama_tukang" value="{{ $data->nama_tukang }}">
    <input type="text" name="jabatan" value="{{ $data->jabatan }}">
    <input type="text" name="proyek" value="{{ $data->proyek }}">
    <input type="number" name="upah_harian" value="{{ $data->upah_harian }}">

    <button class="btn btn-success">Update</button>
</form>