
<table>
        <thead>
        <tr class="text-center">
            <th >No</th>
        
            <th >ID DEPARTEMEN</th>
            <th >ID DEPARTEMEN SUB</th>
            <th >POS</th>
            <th >GRADE</th>
            <th >ID_ABSEN</th>
            <th >USERNAME</th>
            <th >NAMA</th>
            <th >MASA KERJA</th>
            <th >TANGGAL BERGABUNG</th>
            <th >TIPE KONTRAK</th>
            <th >NO REKENING</th>
            <th >TIPE BPJS</th>
            <th >STATUS KARYAWAN</th>
            <th >TIPE PENGGAJIAN</th>
        </tr>
        </thead>
      
        <tbody>

        @php($i=1)
        @php($ii=1)
        @foreach($karyawan as $d)
  
            <tr>
                <td>{{ $i }}</td>
                <td>{{ $d->departemen }}</td>
                <td>{{ $d->sub_departemen }}</td>
                <td>{{ $d->pos }}</td>
                <td>{{ $d->grade }}</td>
                <td>{{ $d->idAbsen }}</td>
                <td>{{ $d->username }}</td>
                <td>{{ $d->nama }}</td>
                <td>{{ $d->masaKerja }}</td>
                <td bgcolor="#d9ead3" >{{ $d->doj }}</td>
                <td bgcolor="#d9ead3" >{{ $d->tipeKontrak }}</td>
                <td bgcolor="#d9ead3" >{{ $d->noRekening }}</td>
                <td bgcolor="#d9ead3" >{{ $d->tipeBpjs }}</td>             
                <td bgcolor="#d9ead3" >{{ $d->statusSkemaGaji }}</td>
                <td bgcolor="#d9ead3" >{{ $d->skema_gaji }}</td>
            </tr>
     
        @php($i++) 
             
        @endforeach

        </tbody>

       
    </table>