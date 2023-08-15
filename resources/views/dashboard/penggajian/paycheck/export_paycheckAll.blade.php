    <table>
        <thead>
        <tr class="text-center">
            <th >No</th>
            <th >Departemen</th>
            <th >Sub Departemen</th>
            <th >Pos</th>
            <th >Grade</th>
            <th >Id Absen</th>
            <th >Nik</th>
            <th >Nama</th>
            <th >Tipe Kontrak</th>
            <th >Tanggal Bergabung</th>
            <th >Masa Kerja</th>
            <th >No Rekening</th>
            <th >Tipe BPJS</th>
            <th >Take Home Pay (THP)</th>
            @php($i=1)
            @foreach($komponenGaji as $x)      
            <th >{{ $x->variable }}</th>
            @php($i++) 
            @endforeach
        </tr>
        </thead>
        <tbody>
        @php($i=1)
        @php($ii=1)
        @foreach($karyawan as $d)
  
            <tr>
                <td>{{ $i }}</td>
                <td>{{ $d->departemen }}</td>
                <td>{{ $d->subDepartemen }}</td>
                <td>{{ $d->pos }}</td>
                <td>{{ $d->grade }}</td>
                <td>{{ $d->idAbsen }}</td>
                <td>{{ $d->nik }}</td>
                <td>{{ $d->name }}</td>
                <td>{{ $d->tipeKontrak }}</td>
                <td>{{ $d->doj }}</td>
                <td>{{ $d->masaKerja }}</td>
                <td>{{ $d->noRekening }}</td>
                <td>{{ $d->tipeBpjs }}</td>
                <td>{{ $d->thp }}</td>
                @php($ii=1)
                @foreach($karyawan_gaji as $c)
                  
                    @if($d->idAbsen==$c->id_karyawan)
                        <td>{{ $c->nominal }}</td>
                        @php($ii++) 
                    @endif
               
                @endforeach
      
            </tr>
     
        @php($i++) 
             
        @endforeach

        </tbody>

       
    </table>