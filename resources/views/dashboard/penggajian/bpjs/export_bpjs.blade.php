<table>
    <thead>
        <tr class="text-center">
            <th >No</th>
            <th >Departemen</th>
            <th >Sub Departemen</th>
            <th >Pos</th>
            <th >Grade</th>
            <th >Id Absen</th>
            <th >Username</th>
            <th >Nama</th>
            <th >Skema BPJS</th>
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
                <td>{{ $d->nama }}</td>
                
                @if($d->tipeBpjs==0)
                <td>Normal</td>
                @elseif($d->tipeBpjs==1)
                <td>Perusahaan</td>
                @elseif($d->tipeBpjs==2)
                <td>Tidak Ikut</td>
                @endif

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