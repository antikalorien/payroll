
<table>
        <thead>
        <tr class="text-center">
            <th >No</th>
            <th >Departemen</th>
            <th >Sub Departemen</th>
            <th >Pos</th>
            <th >Grade</th>
            <th >Id Absen</th>
            <th >NIK</th>
            <th >Nama</th>
            <th >Tipe Kontrak</th>
            <th >Tanggal</th>
            <th >Jam Lembur</th>
            <th >Total Upah</th>
            <th >Total Jam</th>
            <th >Nominal</th>
            <th >Keterangan</th>
            <th >Pic</th>
        </tr>
        </thead>
      
        <tbody>

        @php($i=1)
        @php($ii=1)
        @foreach($dataLembur as $d)
            <tr>
                <td>{{ $i }}</td>
                <td>{{ $d->departemen }}</td>
                <td>{{ $d->subDepartemen }}</td>
                <td>{{ $d->pos }}</td>
                <td>{{ $d->grade }}</td>
                <td>{{ $d->idAbsen }}</td>
                <td>{{ $d->nip }}</td>
                <td>{{ $d->nama }}</td>
                <td>{{ $d->tipeKontrak }}</td>
                <td>{{ $d->tanggal }}</td>
                <td>{{ $d->jamLembur }}</td>
                <td>{{ $d->totalUpah }}</td>
                <td>{{ $d->totalJam }}</td>
                <td>{{ $d->nominal }}</td>
                <td>{{ $d->keterangan }}</td>
                <td>{{ $d->pic }}</td>
            </tr>
        @php($i++)       
        @endforeach

        </tbody>

       
    </table>