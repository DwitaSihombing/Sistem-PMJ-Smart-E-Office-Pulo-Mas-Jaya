<x-auth title="E Office | Detail E-Memo">
    <!-- Page Title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Detail E-Memo</h4>
            </div>
        </div>
    </div>
    <!-- /Page Title -->

    <div class="row">
        <div class="col-md-5">
            <div class="card">
                <form action="{{ route('memos.updatestatus', ['id' => $letter->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                <div class="card-body">
                    <div class="header-title mb-3">Detail E-Memo</div>
                    <table class="table table-centered text-xs mb-0">
                        <tbody>
                            {{-- <tr>
                                <td class="font-semibold whitespace-nowrap">Nomor Surat</td>
                                <td>{{ $letter->letter_number ?? "Belum Digenerate" }}</td>
                            </tr> --}}
                            <td class="font-semibold whitespace-nowrap">Status</td>
                            <td><select type="text" class="field" name="status">
                                <option selected disabled>Pilih Jenis Surat</option>
                                <option value="Draft">Draft</option>
                                <option value="Completed">Completed</option>
                            </select>
                            </td>

                            <tr>
                                <td class="font-semibold whitespace-nowrap">Jenis Surat</td>
                                <td>{{ $letter->type->name }}</td>
                            </tr>
                            <tr>
                                <td class="font-semibold whitespace-nowrap">Tujuan</td>
                                <td>{{ $letter->destination ? $letter->destination->user->name : "Tidak Ada" }}</td>
                            </tr>
                            <tr>
                                <td class="font-semibold whitespace-nowrap">Pengirim</td>
                                <td>{{ $letter->creator ? $letter->creator->user->name : "Tidak Ada" }}</td>
                            </tr>
                            <tr>
                                <td class="font-semibold whitespace-nowrap">Tanggal Memo</td>
                                <td>{{ $letter->date_of_letter }}</td>
                            </tr>
                            {{-- <tr>
                                <td class="font-semibold whitespace-nowrap">Status Memo</td>
                                <td>{{ $letter->status }}</td>
                            </tr> --}}
                        </tbody>
                    </table>
                    <button type="submit" class="button bg-blue-500 text-white p-2 m-2">Submit</button>
                </form>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card h-[calc(100%-1.5rem)]">
                <div class="card-body">
                    <div class="header-title">Tembusan</div>
                    <div class="table-responsive">
                        <table class="table table-centered mb-0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Jabatan</th>
                                </tr>
                            </thead>
                            <tbody class="text-xs">
                                <tr>
                                    <td>1</td>
                                    <td>{{ $letter->carbonCopy ? $letter->carbonCopy->user->name : "Tidak Ada" }}</td>
                                    <td>{{ $letter->carbonCopy ? $letter->carbonCopy->job->name : "Tidak Ada" }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="header-title">Lampiran / Referensi</div>
                    <div class="table-responsive">
                        <table class="table table-centered mb-0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Lampiran / Referensi</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($letter->references as $reference)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $reference->label ? $reference->label : $reference->reference->letter_number . ' | ' . $reference->reference->regarding }}</td>
                                        @if ($reference->file)
                                            <td><a class="text-blue-600" href="{{ route('preview', [
                                                'path' => $reference->file
                                            ]) }}">Lihat Lampiran</a></td>
                                        @else
                                            <td>
                                                <a class="text-blue-600" href="{{ route($reference->reference_route, [
                                                    'id' => $reference->reference->id,
                                                ]) }}">Lihat Lampiran</a>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="flex items-center border-b uppercase px-3 pt-3 pb-[1.1rem]">
                    <h1 class="text-base font-semibold">Isi Memo</h1>
                </div>
                <div class="card-body">
                    <div class="p-3">
                        {!! $letter->message !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-auth>
