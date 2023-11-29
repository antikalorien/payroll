<table>
        <thead>
            <tr class="text-center">
                <th >No</th>
                <th >STATUS</th>
                <th >ID DEPARTEMEN</th>
                <th >DEPARTEMEN</th>
                <th >ID DEPARTEMEN SUB</th>
                <th >DEPARTEMEN SUB</th>
                <th >POS</th>
                <th >GRADE</th>
                <th >ID ABSEN</th>
                <th >NIP</th>
                <th >NAMA</th>
                <th >EMAIL</th>
                <th >ID SKEMA HARI KERJA</th>
                <th >SKEMA HARI KERJA</th>
                <th >NO HP</th>
                <th >TANGGAL BERGABUNG</th>
                <th >MASA KERJA (bulan)</th>
                <th >TANGGAL LAHIR</th>
                <th >USIA</th>
                <th >PIN ACCOUNT</th>
            </tr>
        </thead>
      
        <tbody>

        @php($i=0)
        @php($ii=1)
        @foreach($karyawan as $d)
            <tr>
                <td>{{ $i }}</td>
                @if($d->status == '1')     
                <td >Aktif</td>
                @elseif($d->status=='2')
                <td>Non Aktif</td>
                @endif                                                              
                <td>{{ $d->idDepartemen }}</td>
                <td>{{ $d->departemen }}</td>
                <td>{{ $d->idDepartemenSub }}</td>
                <td>{{ $d->subDepartemen }}</td>
                <td>{{ $d->pos }}</td>
                <td>{{ $d->grade }}</td>
                <td>{{ $d->idAbsen }}</td>
                <td>{{ $d->username }}</td>
                <td>{{ $d->nama }}</td>
                <td>{{ $d->email }}</td>
                <td>{{ $d->idSkemaHarikerja }}</td>
                <td>{{ $d->skema }}</td>
                <td>{{ $d->noHp }}</td>
                <td>{{ $d->doj }}</td>
                <td>{{ $d->masaKerja }}</td>
                <td>{{ $d->dob }}</td>
                <td>{{ $d->usia }}</td>
                <td>{{ $userLogin[$i] }}</td>
            </tr>
        @php($i++) 
        @endforeach
    </tbody>       
</table>