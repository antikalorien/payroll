<table>
        <thead>
        <tr class="text-center">
            <th >No</th>
            <th >ID Periode</th>
            <th >Departemen</th>
            <th >Sub Departemen</th>
            <th >Pos</th>
            <th >NIK</th>
            <th >Nama</th>
            <th >Masa Kerja</th>
            <th >No Rekening</th>
            <th >Tipe THR</th>
            <th >THR</th>
            <th >Reff</th>
        </tr>
        </thead>
      
        <tbody>
        @php($i=1)
        @php($ii=1)
        @foreach($dataTHR as $d)
            <tr>
                <td>{{ $i }}</td>
                <td>{{ $d->id_periode }}</td>
                <td>{{ $d->departemen }}</td>
                <td>{{ $d->sub_departemen }}</td>
                <td>{{ $d->pos }}</td>
                <td>{{ $d->nik }}</td>
                <td>{{ $d->name }}</td>
                <td>{{ $d->masa_kerja }}</td>
                <td>{{ $d->no_rekening }}</td>
                <td>{{ $d->tipe_thr }}</td>
                <td>{{ $d->thr }}</td>
                <td>{{ $d->reff }}</td>
            </tr>
        @php($i++)       
        @endforeach

        </tbody>
</table>